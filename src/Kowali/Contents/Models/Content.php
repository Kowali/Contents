<?php namespace Kowali\Contents\Models;

use \Dimsav\Translatable\Translatable;

class Content extends StiBase {

    use Translatable,
        Traits\CreatedTimeTrait,
        Traits\MetaableTrait,
        Traits\FeatureImageTrait,
        \SoftDeletingTrait;

    /**
     * The name of the database fields that indicates the class name of the object.
     *
     * @var string
     */
    protected $stiClassField = 'content_model';

    /**
     * The name of the contents table
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['tid', 'user_id', 'content_id', 'order', '_content', 'content_model', 'status'];

    /**
     * Dimsav\Translatable: the name of the translation model.
     *
     * @var string
     */
    public $translationModel = 'Kowali\Contents\Models\ContentTranslation';

    /**
     * Dimsav\Translatable: Foreign key.
     *
     * @var string
     */
    public $translationForeignKey = 'content_id';

    /**
     * Dimsav\Translatable: list of translated fields.
     *
     * @var array
     */
    public $translatedAttributes = ['title','excerpt','content'];

    /**
     * Dimsav\Translatable: allways look for a translation fallback.
     *
     * @var boolean
     */
    public $useTranslationFallback = true;

    /**
     * STI: name of the base model.
     *
     * @var string
     */
    protected $stiBaseClass = 'Kowali\Contents\Models\Content';

	/*
	|--------------------------------------------------------------------------
	| Relations to other contents
	|--------------------------------------------------------------------------
	*/

    /**
     * Return the post's parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function parent()
    {
        return $this->belongsTo($this->stiBaseClass, 'content_id');
    }

    /**
     * Return the post’s children.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function children()
    {
        return $this->hasMany($this->stiBaseClass, 'content_id');
    }

    /**
     * Return the previous item with the same parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function siblings()
    {
        return $this->hasMany($this->stiBaseClass, 'content_id', 'content_id');
    }

    /**
     * Return the previous item with the same parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function prev()
    {
        return $this->hasOne($this->stiBaseClass, 'content_id', 'content_id')
            ->where('order', '<', $this->attributes['order'])
            ->orderBy('order', 'desc');
    }

    /**
     * Return the next item with the same parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function next()
    {
        return $this->hasOne($this->stiBaseClass, 'content_id', 'content_id')
            ->where('order', '>', $this->attributes['order'])
            ->orderBy('order', 'asc');
    }

	/*
	|--------------------------------------------------------------------------
	| Relations to other models
	|--------------------------------------------------------------------------
	*/

    /**
     * Return the author of the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function author()
    {
        return $this->belongsTo($this->getUserModel(), 'user_id');
    }

    /**
     * Return the comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function comments()
    {
        return $this->morphMany('Kowali\Contents\Models\Comment','commentable')->orderBy('created_at', 'ASC');
    }

    /**
     * Return the terms associated with the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function terms()
    {
        return $this->belongsToMany('Kowali\Contents\Models\Term', 'content_term', 'content_id');
    }

    public function getPermalinkAttribute()
    {
        $content = str_plural(snake_case(class_basename($this)));
        return route("{$content}.show", $this->id);
    }

    public function link($content)
    {
        $permalink = $this->getPermalinkAttribute();
        return "<a href=\"{$permalink}\" rel=\"bookmark\">{$content}</a>";
    }
}
