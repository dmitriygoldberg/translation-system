<?php

use Controller\ControllerFactory;

class Application
{
    const DEFAULT_CONTROLLER = 'Translation';
    const DEFAULT_ACTION = 'showTranslationPage';
    const ERROR_ACTION = 'showErrorPage';

    public function handleHttp()
    {
        $controller = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : null;

        if (is_null($controller)) {
            $response = $this->defaultHandle();
        } else {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
            $params = isset($_REQUEST['params']) ? $_REQUEST['params'] : null;

            if (is_null($action)) {
                $response = $this->errorHandle('Action missed');
            } else {
                $response = $this->handle($controller, $action, $params);
            };
        }

        return $response;
    }

    private function handle($controller, $action, $params = null)
    {
        $controllerName = $controller . 'Controller';
        $controllerObj = ControllerFactory::factory($controllerName);
        if (is_null($controllerObj)) {
            $this->errorHandle('Controller initialization error!');
            return false;
        }

        $method = $action . 'Action';
        if (method_exists($controllerObj, $method)) {
            $controllerObj->$method($params);
        } else {
            $this->errorHandle('Action initialization error!');
            return false;
        }

        return true;
    }

    private function defaultHandle()
    {
        return $this->handle(self::DEFAULT_CONTROLLER, self::DEFAULT_ACTION);
    }

    private function errorHandle($errorMessage)
    {
        $params['error'] = $errorMessage;

        $controllerName = self::DEFAULT_CONTROLLER . 'Controller';
        $controllerObj = ControllerFactory::factory($controllerName);
        $method = self::ERROR_ACTION . 'Action';
        $controllerObj->$method($params);

        return true;
    }
}