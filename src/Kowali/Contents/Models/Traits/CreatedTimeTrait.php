<?php namespace Home\Models\Traits\Traits;

trait CreatedTimeTrait {

    /**
     * Return a time tag with a human readable diff
     *
     * @return string
     */
    public function getCreatedTimeAttribute ()
    {
        $date = \Date::make($this->created_at);
        return "<time datetime='{$date->toRfc3339String()}'>{$date->ago()}</time>";
    }

    public function getDateAttribute ()
    {
        $date = \Date::make($this->created_at);
        return $date->format('j F Y');
    }
}
