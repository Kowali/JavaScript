<?php namespace Kowali\JavaScript;

class ObjectStore {

    protected $dumpers = [];
    protected $scripts = [];
    protected $variables = [];

    public function pushScript($path, $inline = false)
    {
        $dumper = new ScriptDumper($path, $inline);

        array_push($this->dumpers, $dumper);
        array_push($this->scripts, $dumper);
    }

    public function unshiftScript()
    {
        $dumper = new ScriptDumper($path, $inline);

        array_unshift($this->dumpers, $dumper);
        array_unshift($this->scripts, $dumper);
    }

    public function pushVariable($name, $value)
    {
        $dumper = new VariableDumper($path, $inline);

        array_push($this->dumpers, $dumper);
        array_push($this->variables, $dumper);
    }

    public function unshiftVariable($name, $value)
    {
        $dumper = new VariableDumper($path, $inline);

        array_unshift($this->dumpers, $dumper);
        array_unshift($this->variables, $dumper);
    }


    public function flushVariables()
    {

    }

    public function flushScripts()
    {

    }

    public function flush()
    {

    }

    // public function enqueueVariable($name, $value)
    // {

    // }

    // /**
    //  * Ass a variable.
    //  *
    //  * @param  string $name
    //  * @param  mixed  $value
    //  * @return void
    //  */
    // public function addVariable($name, $value)
    // {
    //     $this->variables[$name] = $value;
    // }

    // /**
    //  * Return the variables as JS code.
    //  *
    //  * @param  string $scope
    //  * @param  boolean $output_tags
    //  * @return string
    //  */
    // public function getVariables($scope = 'window', $output_tags = true)
    // {
    //     if($scope != 'window')
    //     {
    //         $output = "var {$scope} = " . json_encode($this->variables);
    //     }
    //     else
    //     {
    //         $output = '';
    //         foreach($this->variables as $key => $value)
    //         {
    //             $converted = json_encode($value);
    //             $output .= "window.{$key} = {$converted};";
    //         }
    //     }

    //     if($output_tags && !empty($output))
    //     {
    //         return "<script>{$output}</script>";
    //     }

    //     return $output;
    // }

    // /**
    //  * Convert an object to json
    //  *
    //  * @param  mixed $object
    //  * @return string
    //  */
    // public function convertToJson($object)
    // {
    //     if(is_object($object) && method_exists($object, 'toJson'))
    //     {
    //         return $object->toJson();
    //     }

    //     return json_encode($object);
    // }

    // public function enqueueScript($path, )
}
