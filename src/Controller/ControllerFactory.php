<?php

namespace Controller;

class ControllerFactory
{
    /**
     * Creates an instance of the called class.
     * @param string $controller
     * @return mixed
     */
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