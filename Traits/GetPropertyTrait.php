<?php

namespace BasicApp\Traits;

trait GetPropertyTrait
{

    public function getProperty($name, $default = null)
    {
        if (property_exists($this, $name))
        {
            return $this->{$name};
        }

        return $default;
    }

}