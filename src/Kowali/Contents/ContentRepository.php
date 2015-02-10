<?php namespace Kowali\Contents;

use Kowali\Contents\Models\Content;
use Kowali\Contents\Models\Term;
use Kowali\Contents\Models\Taxonomy;
use Kowali\Contents\Models\Meta;

class ContentRepository {

    /**
     * A list of known content types.
     *
     * @var array
     */
    protected $types = [];

    /**
     * Add many types in one pass.
     *
     * @param  array $types
     * @return void
     */
    public function addTypes(array $types)
    {
        foreach($types as $name => $options)
        {
            $this->addType($name, $options);
        }
    }

    /**
     * Return an array containing the defined types.
     *
     * @return array
     */
    public function types()
    {
        return $this->types;
    }

    /**
     * Find a content type with its name.
     *
     * @param  string $name
     * @return ContentType
     */
    public function getType($name, $plural = false)
    {
        $name = $plural ? str_singular($name) : $name;

        if(array_key_exists($name, $this->types))
        {
            return $this->types[$name];
        }
    }

    /**
     * Add one content type.
     *
     * @param  string $name
     * @param  mixed  $options
     * @return ContentType
     */
    public function addType($name, $options)
    {
        if(is_array($options))
        {
            $content = new ContentType($name, $options);
        }
        elseif($options instanceof ContentType)
        {
            $content = $options;
        }
        else
        {
            throw new \Exception('Type not defined');
        }

        $this->types[$name] = $content;

        return $content;
    }

    /**
     * Find a content with its id.
     *
     * @param  string $id
     * @param  bool   $raw_query
     * @return Models\Content
     */
    public function getById($id, $raw_query = false)
    {
        $query = Content::where('id', '=', $id);

        return $raw_query ? $query : $query->first();
    }

    /**
     * Find a content with its tid.
     *
     * @param  string $tid
     * @param  bool   $raw_query
     * @return Models\Content
     */
    public function getByTid($tid, $raw_query = false)
    {
        $query = Content::where('tid', '=', $tid);

        return $raw_query ? $query : $query->first();
    }

    /**
     * Return the posts associated with a user ID.
     *
     * @param  string $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserID($id, $raw_query = false)
    {
        $query = Content::where('user_id', '=', $id);

        return $raw_query ? $query : $query->first();
    }

    /**
     * Find a content with its tid.
     *
     * @param  string $taxonomy
     * @param  string $term
     * @param  bool   $raw_query
     * @return Models\Term
     */
    public function getTaxonomyTerm($taxonomy, $term, $raw_query = false)
    {
        $query = Term::whereSlug($term)
            ->where('taxonomy_id', function($q) use ($taxonomy){
                $q->select('id')->from('taxonomies')->where('slug', '=', $taxonomy);
            });

        return $raw_query ? $query : $query->first();
    }

    /**
     * Find a content with its id.
     *
     * @param  Models\Content $content
     * @param  string         $locale
     * @param  bool           $raw_query
     * @return Models\Content
     */
    public function getTranslation($content, $locale, $raw_query = false)
    {
        $model = $content->getTranslationModelName();
        $query = (new $model)->newQuery()
            ->where('content_id', $content->id)
            ->where('locale', $locale);

        return $raw_query ? $query : $query->first();
    }

    /**
     * Update or create a content.
     *
     * @param  array $attributes
     * @return Models\Content
     */
    public function updateOrCreate($attributes)
    {
        if( ! array_key_exists('tid', $attributes))
        {
            dd($attributes);
        }

        return Content::updateOrCreate(['tid' => $attributes['tid']], $attributes);
    }


    public function addTerm($content, $taxonomy, $term = null)
    {
        if($taxonomy instanceof \Kowali\Contents\Models\Term)
        {
            $term = $taxonomy;
        }
        else
        {
            $term = $this->getTaxonomyTerm($taxonomy, $term);
        }

        if($term && ! $content->terms->contains($term))
        {
            $content->terms()->attach($term);
        }
    }
}
