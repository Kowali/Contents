<?php namespace Kowali\Contents\Models;

use Filter;

class ContentTranslation extends BaseModel {

    /**
     * A list of attributes that cannot be mass assigned
     *
     * @param array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The name of the table to use for this model
     *
     * @param string
     */
    protected $table = 'content_translations';

    /**
     * Return the content translated by this model
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function content()
    {
        return $this->belongsTo($this->contentModel, 'content_id');
    }

    public function getContentAttribute()
    {
        return apply_filter('content', $this->attributes['content'], [$this]);
    }

    public function getTitleAttribute()
    {
        return apply_filter('title', $this->attributes['title'], [$this]);
    }

    public function getExcerptAttribute()
    {
        return apply_filter('excerpt', $this->attributes['excerpt'], [$this]);
    }

}
