<?php namespace Kowali\JavaScript\Dumpers;

use Illuminate\Html\HtmlBuilder;

class ScriptDumper {

    /**
     * The source of the script, either the url or its location.
     *
     * @var string
     */
    protected $source;

    /**
     * Tells the dumper if the content of the script should be inlined.
     *
     * @var bool
     */
    protected $inline = false;

    /**
     * Tells the dumper if the script loading should be deffered.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Create a new script dumper.
     *
     * @param string $source
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Force the inlining of the script.
     *
     * @return void
     */
    public function inline()
    {
        $this->inline = true;

        return $this;
    }

    /**
     * Force the deffering of the script.
     *
     * @return void
     */
    public function defer()
    {
        $this->defer = true;

        return $this;
    }

    /**
     * Dump the content of the script or a link to it.
     *
     * @param  array $attributes
     * @return string
     */
    public function dump(array $attributes = [])
    {
        if($this->inline)
        {
            $content = trim(file_get_contents($this->source));
            return "<script>{$content}</script>";
        }
        else
        {
            $attrs = (new HtmlBuilder)->attributes(array_merge([
                'src'   => $this->source,
            ], $attributes));

            if($this->defer)
            {
                $attrs .= " defer";
            }

            return "<script{$attrs}></script>";
        }
    }

    /**
     * Convert the dumper to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->dump([]);
    }
}

