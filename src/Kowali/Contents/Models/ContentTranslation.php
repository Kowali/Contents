<?php namespace Kowali\Contents\Models;

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
}
