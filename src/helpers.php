<?php

if( ! function_exists('apply_filter'))
{
    /**
     * Apply a filter stack to some content.
     *
     * @param  string $filter
     * @param  mixed  $content
     * @param  mixed  $attributes
     * @return mixed
     */
    function apply_filter($name, $content, $attributes = null)
    {
        return \App::make('kowali.filter')->stack($name, true)
            ->apply($content, $attributes);
    }
}


if( ! function_exists('add_filter'))
{
    /**
     * Add a new filter.
     *
     * @param  string                           $name
     * @param  Kowali\Contents\Filtering\Filter $filter
     * @return void
     */
    function add_filter($name, $filter){
        return \App::make('kowali.filter')->stack($name, true)
            ->push($filter);
    }
}

