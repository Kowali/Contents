<?php namespace Kowali\Contents\Models;

class Meta extends BaseModel {

    public $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Return metaable fields
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function metaable()
    {
        return $this->morphTo();
    }
}
