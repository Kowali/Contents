<?php namespace Kowali\Contents\Models;

class Taxonomy extends BaseModel {

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
     * A list of elements that cannot be mass assigned.
     *
     * @var array
     */
	protected $fillable = ['slug'];

    /**
     * Return the terms associated with the taxonomy
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function terms()
    {
        return $this->hasMany($this->termModel);
    }

    /**
     * Return the terms associated with the taxonomy that are not children of another term
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function scopeRoot()
    {
        return $this->terms()->whereNull('term')->orderBy('slug','asc');
    }

}
