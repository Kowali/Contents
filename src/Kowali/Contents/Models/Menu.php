<?php namespace Kowali\Contents\Models;

class Menu extends Content {

    public function getContenAttribute()
    {
        foreach($this->children as $child)
        {
            $child->render();

        }
    }
}
