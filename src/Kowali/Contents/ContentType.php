<?php namespace Kowali\Contents;

class ContentType {

    /**
     * The name of the content type.
     *
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $taxonomies;

    protected $defaultOptions = [
        'model'      => 'Kowali\Contents\Models\Content',
        'controller' => 'Kowali\Contents\Controllers\ContentsController',
        'taxonomies' => '',
    ];

    /**
     * Initialize the instance.
     *
     * @param  string $name
     * @param  array  $options
     * @return void
     */
    public function __construct($name, array $options = [])
    {
        extract(
            array_intersect_key(
                array_merge($this->defaultOptions, $options),
                $this->defaultOptions
            )
        );

        $this->name = $name;
        $this->model = $model;
        $this->controller = $controller;
        $this->taxonomies = $taxonomies;
    }


    public function getNamePlural()
    {
        return str_plural($this->name);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getTaxonomies()
    {
        return $this->taxonomies;
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
