<?php namespace Kowali\Contents\Filters;

class FilterStack {

    protected $filters = [];

    /**
     * Remove every filters from the stack.
     *
     * @return void
     */
    public function clear()
    {
        $this->filters = [];
    }

    /**
     * Add a filter a the begging of the stack.
     *
     * @return void
     */
    public function unshift($filter)
    {
        if(is_string($filter))
        {
            $filter = \App::make($filter);
        }
        array_unshift($this->filters, $filter);
    }

    /**
     * Add a filter a the end of the stack.
     *
     * @return void
     */
    public function push($filter)
    {
        if(is_string($filter))
        {
            $filter = \App::make($filter);
        }
        array_push($this->filters, $filter);
    }

    /**
     * Alias for push.
     *
     * @see    FilterStack::push()
     * @return void
     */
    public function add($filter)
    {
        return $this->push($filter);
    }

    /**
     * Remove the filter from the list.
     *
     * @param  string $name
     * @return void
     */
    public function remove($name)
    {
        $this->filters = array_filter($this->filters, function($filter) use ($name){
            return $filters->getName() != $name;
        });
    }

    /**
     * Apply every filters of the stack to the provided content
     *
     * @return mixed
     */
    public function apply($content, $attributes = null, $skip_tests = false)
    {
        foreach($this->filters as $filter)
        {
            if($skip_tests || $filter->qualifiedFor($content, $attributes))
            {
                $content = $filter->apply($content, $attributes);
            }
        }

        return $content;
    }
}
