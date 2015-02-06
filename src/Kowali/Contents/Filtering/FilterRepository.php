<?php namespace Kowali\Contents\Filtering;

class FilterRepository implements \ArrayAccess {

    /**
     * A list of filter stacks.
     *
     * @var array
     */
    protected $stacks = [];

    /**
     * Add a new stack to the list.
     *
     * @param  string      $name
     * @param  FilterStack $stack
     * @param  bool        $overwrite
     * @return void
     */
    public function addStack($name, FilterStack $stack = null, $overwrite = false)
    {
        if(is_null($stack))
        {
            $stack = new FilterStack;
        }

        if(isset($stacks[$name]) && ! $overwrite)
        {
            throw new \Exception('Trying to overwrite a filter stack');
        }

        $this->stacks[$name] = $stack;
    }

    /**
     * Get a stack by its name.
     *
     * @param  string $name
     * @return FilterStack
     */
    public function stack($name, $return_empty = false)
    {
        if( ! isset($this->stacks[$name]))
        {
            if( ! $return_empty)
            {
                return;
            }
            else
            {
                $this->stacks[$name] = new FilterStack;
            }
        }

        return $this->stacks[$name];
    }

    /**
     * ArrayAccess: does the offset exists.
     *
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->stacks[$offset]);
    }

    /**
     * ArrayAccess: get the value for an offset.
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->stack($offset);
    }

    /**
     * ArrayAccess: set the value for an offset.
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        return $this->addStack($value, null, true);
    }

    /**
     * ArrayAccess: unset an offset.
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->stacks[$offset]);
    }
}
