<?php namespace Kowali\Contents\Models;

class TermTranslation extends BaseModel {

    public $touches = ['term'];

    public function term()
    {
        return $this->belongsTo($this->termModel, 'term_id');
    }
}


