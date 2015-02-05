<?php namespace Kowali\Contents\Models\Traits;

trait MetaableTrait {

    /**
     * Return the objects meta
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function metas()
    {
        return $this->morphMany('Kowali\Contents\Models\Meta', 'metaable');
    }

    public function getMeta($key)
    {
        return $this->metas()->where('key', '=', $key)->first();
    }
}
