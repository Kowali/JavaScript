<?php namespace Kowali\JavaScript\Dumpers;

use Illuminate\Html\HtmlBuilder;

class VariableDumper {

    /**
     * The name of the JavaScript variable.
     *
     * @var string
     */
    protected $name;

    /**
     * The value of the JavaScript variable.
     *
     * @var string
     */
    protected $value;

    /**
     * The namespace of the JavaScript variable.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Return the value of the dumper as is without converting to JSon
     *
     * @var bool
     */
    protected $raw = false;

    /**
     * Initialize the dumper.
     *
     * @param  string $name
     * @param  mixed  $value
     * @param  string $namespace
     */
    public function __construct($name = null, $value = null, $namespace = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->namespace = $namespace;
    }

    /**
     * Forces raw output.
     *
     * @return self
     */
    public function raw()
    {
        $this->raw = true;

        return $this;
    }

    public function convertToJson($object)
    {
        return (is_object($object) && method_exists($object, 'toJson'))
            ? $object->toJson()
            : json_encode($object);
    }

    /**
     * Return the variable as a string.
     *
     * @param  array $attributes
     * @param  bool  $noTag
     * @return string
     */
    public function dump(array $attributes = [], $noTag = false)
    {
        $value = $this->raw
            ? $this->value
            : $this->convertToJson($this->value);

        $content = $this->namespace
            ? "{$this->namespace}.{$this->name} = {$value};"
            : "var {$this->name} = {$value};";

        if($noTag)
        {
            return $content;
        }

        $attrs = (new HtmlBuilder)->attributes($attributes);

        return "<script{$attrs}>{$content}</script>";

    }

    public function __toString()
    {
        return $this->dump([], false);
    }

}
