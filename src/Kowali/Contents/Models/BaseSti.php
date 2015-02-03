<?php namespace Kowali\Contents\Models;

class StiBase extends BaseModel {

    /**
     * The name of the database fields that indicates the class name of the object.
     *
     * @var string
     */
    protected $stiClassField = 'content_class';

    /**
     * Initialize the instance.
     *
     * @param  array $attributes
     * @return void
     */
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

        $this->setAttribute($this->stiClassField, get_class($this));
    }

    /**
     * Override a query with what's needed to provide STI facilities.
     *
     * @param  boolean $excludeDeleted
     * @return Illuminate\Database\Builder
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = parent::newQuery($excludeDeleted);

        // When making a new query using STI, we use the name of
        // the class to limitate the resulsts to the records that
        // have the same class as the one we make the query from
        if ($this->stiBaseClass && get_class(new $this->stiBaseClass) !== get_class($this)) {
            $builder->where($this->stiClassField, "=", get_class($this));
        }
        return $builder;
    }

    /**
     * Change the class after retreiving records from the builder.
     *
     * @param  array $attributes
     * @return mixed
     */
    public function newFromBuilder($attributes = array())
    {
        if ($attributes->{$this->stiClassField}) {
            $class = $attributes->{$this->stiClassField};
            $instance = new $class;
            $instance->exists = true;
            $instance->setRawAttributes((array) $attributes, true);
            return $instance;
        } else {
            return parent::newFromBuilder($attributes);
        }
    }
}

