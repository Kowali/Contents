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
    function apply_filter($name, $content, $attributes = null, $skip_tests = false)
    {
        return \App::make('kowali.filter')->stack($name, true)
            ->apply($content, $attributes, $skip_tests);
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


if( ! function_exists('smart_str_limit'))
{
    /**
     * Limit a string without breaking words using regex.
     *
     * @param  string $input
     * @param  int    $length
     * @return string
     */
    function smart_str_limit($input, $length, $termination = '…')
    {
        if(mb_strlen($input) < $length)
        {
            return $input;
        }

        $match = [];
        if(preg_match('/^(.{0,' . $length . '})(?=\p{^L})/ums', $input, $match))
        {
            return $match[1] . $termination;
        }
    }
}
