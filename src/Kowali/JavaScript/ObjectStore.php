<?php namespace Kowali\JavaScript;

class ObjectStore {

    protected $variables = [];

    public function addVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }
    public function getVariables($scope = 'window', $output_tags = true)
    {
        if($scope != 'window')
        {
            $output = "var {$scope} = " . json_encode($this->variables);
        }
        else
        {
            $output = '';
            foreach($this->variables as $key => $value)
            {
                $converted = json_encode($value);
                $output .= "window.{$key} = {$converted};";
            }
        }

        if($output_tags && !empty($output))
        {
            return "<script>{$output}</script>";
        }

        return $output;
    }

    public function convertToJson($object)
    {
        if(is_object($object) && method_exists($object, 'toJson'))
        {
            return $object->toJson();
        }

        return json_encode($object);
    }
}
