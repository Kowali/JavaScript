<?php namespace Kowali\JavaScript;

use Kowali\JavaScript\Dumpers\ScriptDumper;
use Kowali\JavaScript\Dumpers\VariableDumper;
use Kowali\JavaScript\Dumpers\SnippetDumper;
use Illuminate\Html\HtmlBuilder;

class ObjectStore {

    /**
     * The default variable namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * The script.
     *
     * @var array
     */
    protected $scripts = [];

    /**
     * The variables.
     *
     * @var array
     */
    protected $variables = [];

    /**
     * A list of variable namespaces.
     *
     * @var array
     */
    protected $namespaces = [];

    /**
     * Initialize the store with a default namespace.
     *
     * @param  string $namespace
     */
    public function __construct($namespace = null)
    {
        $this->namespace = $namespace;
    }

    /**
     * Add a new script.
     *
     * @param  string $name
     * @param  string $source
     * @return \Kowali\JavaScript\Dumpers\ScriptDumper
     */
    public function addScript($name, $source)
    {
        $script = new ScriptDumper($source);

        $this->scripts[$name] = $script;

        return $script;
    }

    /**
     * Add a new snippet.
     *
     * @param  string $name
     * @param  string $content
     * @return \Kowali\JavaScript\Dumpers\SnippetDumper
     */
    public function addSnippet($name, $content)
    {
        $snippet = new SnippetDumper($content);

        $this->snippets[$name] = $snippet;

        return $snippet;
    }

    /**
     * Add a new variable.
     *
     * @param  string $name
     * @param  string $content
     * @return \Kowali\JavaScript\Dumpers\VariableDumper
     */
    public function addVariable($name, $value, $namespace = null)
    {
        $namespace = $namespace ?: $this->namespace;

        if( ! in_array($namespace, $this->namespaces))
        {
            $this->namespaces[] = $namespace;
        }

        $var = new VariableDumper($name, $value, $namespace);

        $this->variables[$name] = $var;

        return $var;
    }

    /**
     * Flush the namespaces to prevent them from not existing in the browser.
     *
     * @return string
     */
    public function flushNamespaces()
    {
        $init = [];

        foreach($this->namespaces as $namespace)
        {
            if($namespace == 'window')
            {
                'continue';
            }

            $init[] = "{$namespace} = window.{$namespace} || {};";
        }

        $this->namespaces = [];

        return implode("\n", $init);
    }

    /**
     * Flush the scripts.
     *
     * @param  array $attributes
     * @return string
     */
    public function flushScripts(array $attributes = [])
    {
        $scripts = [];

        foreach($this->scripts as $script)
        {
            $scripts[] = $script->dump($attributes);
        }

        $this->scripts = [];

        return implode("\n", $scripts);
    }

    /**
     * Flush the snippets.
     *
     * @param  array $attributes
     * @return string
     */
    public function flushSnippets(array $attributes = [])
    {
        $snippets = [];

        foreach($this->snippets as $snippet)
        {
            $snippets[] = $snippet->dump([], true);
        }

        $content = implode("\n", $snippets);

        return "<script>{$content}</script>";

    }

    /**
     * Flush the variables.
     *
     * @param  array $attributes
     * @return string
     */
    public function flushVariables(array $attributes = [])
    {
        $variables = [];

        foreach($this->variables as $variable)
        {
            $variables[] = $variable->dump($attributes, true);
        }

        $this->variables = [];

        $content = $this->flushNamespaces() . "\n" .implode("\n", $variables);

        return "<script>{$content}</script>";
    }

    /**
     * Flush everything.
     *
     * @param  array $attributes
     * @return string
     */
    public function flush()
    {
        $return = $this->flushScripts()
        . "\n" .  $this->flushVariables()
        . "\n" .  $this->flushSnippets();

        return $return;
    }


}
