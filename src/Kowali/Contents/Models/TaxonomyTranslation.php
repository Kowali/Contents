<?php namespace Kowali\Contents\Models;

class TaxonomyTranslation extends BaseModel{

    public $touches = ['taxonomy'];

    public function taxonomy()
    {
        return $this->belongsTo($this->taxonomyModel);
    }
}


