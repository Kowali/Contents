<?php namespace Kowali\Contents\Models;

class Term extends BaseModel {
	protected $fillable = [];

    use \Dimsav\Translatable\Translatable;

    /**
     * Dimsav\Translatable: list of translated fields
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'description'];

    /**
     * Dimsav\Translatable: allways look for a translation fallback
     *
     * @var boolean
     */
    public $useTranslationFallback = true;

    /**
     * Return the owner taxonomy
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function taxonomy()
    {
        return $this->belongsTo($this->taxonomyModel);
    }

    /**
     * Return taxonomable terms
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function contents()
    {
        return $this->belongsToMany($this->contentModel);
    }

    /**
     * Return taxonomable terms
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function children()
    {
        return $this->hasMany($this->getModel());
    }

    public function getPermalinkAttribute()
    {
        return route('taxonomy.term', [
            'taxonomy' => $this->taxonomy->slug,
            'term' => $this->slug,
        ]);
    }

    public function link($content)
    {
        $permalink = $this->getPermalinkAttribute();
        return "<a href=\"{$permalink}\" rel=\"bookmark\">{$content}</a>";
    }

}
