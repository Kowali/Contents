<?php namespace Kowali\Contents;

class ContentType {

    /**
     * The name of the content type.
     *
     * @var string
     */
    public $name;

    /**
     * Options specific to the content type.
     *
     * @var array
     */
    protected $options;

    /**
     * Initialize the instance.
     *
     * @param  string $name
     * @param  array  $options
     * @return void
     */
    public function __construct($name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
    }


    public function getNamePlural()
    {
        return str_plural($this->name);
    }

    public function getModel()
    {
        if(isset($this->options['model']))
        {
            return $this->options['model'];
        }
    }

    public function getController()
    {
        if(isset($this->options['controller']))
        {
            return $this->options['controller'];
        }
    }

    /**
     * @param  string $key
     * @return void
     */
    public function __get($key)
    {
        $method = camel_case("get_{$key}");
        if(method_exists($this, $method))
        {
            return $this->$method();
        }
    }
}
