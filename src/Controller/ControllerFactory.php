<?php

namespace Controller;

class ControllerFactory
{
    public static function factory($controller)
    {
        $className = "Controller\\{$controller}";

        if (class_exists($className)) {
            $instance = new $className();
        } else {
            $instance = null;
        }

        return $instance;
    }
}