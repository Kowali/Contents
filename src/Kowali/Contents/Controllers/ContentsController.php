<?php namespace Kowali\Contents\Controllers;

use Kowali\Contents\Models\Content;
use \View;

class ContentsController extends \Controller {

    protected $contentModel = 'Kowali\Contents\Models\Content';

    public function index()
    {
        $model = $this->getContenModel();
        $content_type = $this->getContentType(true);
        $contents = (new $model)->newQuery()->orderBy('created_at', 'desc');

        return View::make("{$content_type}.index")->with([
            $content_type => $contents->paginate($this->getPagination()),
        ]);
    }

    public function show($id)
    {
        $model = $this->getContenModel();
        $content_type = $this->getContentType();
        $content = (new $model)->newQuery()->find($id) or App::abord(404);

        return \View::make(str_plural($content_type) . ".show")->with([
            $content_type => $content
        ]);
    }

    public function getContentType($plural = false, $model = null)
    {
        if(is_null($model))
        {
            $model = $this->getContenModel();
        }

        $type = snake_case(class_basename(new $model));

        return $plural ? str_plural($type) : $type;
    }

    /**
     * Return the model associated with the content.
     *
     * @return string
     */
    public function getContenModel()
    {
        if(isset($this->contentModel))
        {
            return $this->contentModel;
        }
        return $this->getModel();
    }

    public function getPagination()
    {
        if(isset($this->pagination))
        {
            return $this->pagination;
        }

        return Config::get('contents.paginate', 5);
    }
}
