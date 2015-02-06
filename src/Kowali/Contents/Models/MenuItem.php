<?php namespace Kowali\Contents\Models;

class MenuItem extends Content {


    public function render()
    {
        if(empty($this->attributes['_content']) || strpos($this->attributes['_content'], ':') === false )
        {
            return;
        }

        list($type, $target) = explode(':', $this->attributes['_content']);

        if($type == 'content')
        {
            if($content = (new Content)->newQuery()->whereTid($target)->first())
            {
                echo $content->link($content->title);
            }
        }
    }
}
