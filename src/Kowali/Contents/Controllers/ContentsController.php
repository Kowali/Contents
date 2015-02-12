<?php namespace Kowali\Contents\Controllers;

use Kowali\Contents\Models\Content;
use Kowali\Contents\ContentRepository;
use Kowali\Contents\ContentType;
use View;
use Request;
use Config;
use Input;

class ContentsController extends \Controller {

    public function __construct(ContentRepository $content)
    {
        $this->content = $content;
    }

    public function index($content_name = null)
    {
        $content_name = $content_name ?: Request::segment(1);
        $content_type = $this->content->getType($content_name, true);
        $model = $content_type->model;

        $query = (new $model)->orderBy('created_at', 'desc');

        $term = null;

        if(Input::has('filter') && Input::has(Input::get('filter')))
        {
            $taxonomy = Input::get('filter');
            $term = $this->content->getTaxonomyTerm($taxonomy, Input::get($taxonomy));
            $query->whereIn('id', function($query) use ($term){
                $query->select('content_id')->from('content_term')->where('term_id', $term->id);
            });
        }

        $contents = $query->paginate($this->getPagination());

        $view = $this->getView($contents, $content_type->name_plural, true);


        return View::make($view)->with([
            $content_type->name_plural  => $contents,
            'contents'                  => $contents,
            'taxonomies'                => $this->getFilteringTaxonomies($content_type),
            'term'                      => $term,
        ]);
    }

    public function getFilteringTaxonomies(ContentType $content_type)
    {
        $taxonomies = [];
        foreach((array)$content_type->taxonomies as $slug)
        {
            if($taxonomy = $this->content->getTaxonomy($slug))
            {
                $taxonomies[$slug] = $taxonomy;
            }
        }
        return $taxonomies;
    }

    public function show($id, $content_name = null)
    {
        $content_name = $content_name ?: Request::segment(1);
        $content_type = $this->content->getType($content_name, true);
        $model = $content_type->model;
        $content = (new $model)->find($id) or App::abord(404);

        $view = $this->getView($content, $content_type->name_plural);

        return View::make($view)->with([
            $content_type->name => $content,
            'content' => $content,
        ]);
    }

    public function getView($content, $base, $is_index = false)
    {
        $tries = [];
        if($is_index)
        {
            $tries[] = "{$base}.index";
            $tries[] = 'contents.index';
        }
        else
        {
            $tries[] = "{$base}.{$content->tid}.show";
            $tries[] = "{$base}.show";
            $tries[] = 'contents.show';
        }

        foreach($tries as $view)
        {
            if(View::exists($view))
            {
                return $view;
            }
        }
    }

    /**
     * Return the model associated with the content.
     *
     * @return string
     */
    public function getContenModel($content_type = null)
    {
        if(isset($this->contentModel))
        {
            return $this->contentModel;
        }
        elseif($content_type)
        {
            return Config::get("kowali.content_types.{$content_type}.model", studly_case($content_type));
        }
    }

    public function getPagination()
    {
        if(isset($this->pagination))
        {
            return $this->pagination;
        }

        return \Config::get('contents.paginate', 10);
    }
}
