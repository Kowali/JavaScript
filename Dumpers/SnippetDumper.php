<?php namespace Kowali\JavaScript\Dumpers;

use Illuminate\Html\HtmlBuilder;

class SnippetDumper {

    /**
     * The value of the JavaScript variable.
     *
     * @var string
     */
    protected $content;

    /**
     * Initialize the dumper.
     *
     * @param  string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Return the snippet as a string.
     *
     * @param  array $attributes
     * @param  bool  $noTag
     * @return string
     */
    public function dump(array $attributes = [], $noTag = false)
    {
        if($noTag)
        {
            return $this->content;
        }

        $attrs = (new HtmlBuilder)->attributes($attributes);

        return "<script{$attrs}>{$this->content}</script>";

    }

    /**
     * Convert the dumper to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->dump([], false);
    }

}

