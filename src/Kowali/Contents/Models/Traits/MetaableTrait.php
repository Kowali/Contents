<?php namespace Home\Models\Traits\Traits;

trait MetaableTrait {

    /**
     * Return the objects meta
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function metas()
    {
        return $this->morphMany('Home\Models\Meta', 'metaable');
    }

    public function getMeta($key)
    {
        return $this->metas()->where('key', '=', $key)->first();
    }
}
