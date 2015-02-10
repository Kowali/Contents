<?php namespace Kowali\Contents\Filters;

abstract class Filter {

    protected $name;

    /**
     * Return the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Determin if the filter can be applied to the content.
     *
     * @param  mixed $content
     * @param  array $attributes
     * @return bool
     */
    public function qualifiedFor($content, $attributes = null)
    {
        return true;
    }
    /**
     * Apply the filter to the content.
     *
     * @param  mixed $content
     * @param  array $attributes
     * @return bool
     */
    abstract public function apply($content, $attributes = null);

}
