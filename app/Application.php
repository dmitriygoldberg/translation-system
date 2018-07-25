<?php

use Controller\ControllerFactory;

class Application
{
    const DEFAULT_CONTROLLER = 'Translation';
    const DEFAULT_ACTION = 'showPage';
    const ERROR_ACTION = 'showErrorPage';

    public function handleHttp()
    {
        $controller = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : null;

        if (is_null($controller)) {
            $response = $this->defaultHandle();
        } else {
            try {
                $action = $this->getAction();
                $response = $this->handle($controller, $action);
            } catch (Exception $e) {
                $response = $this->errorHandle($e->getMessage());
            }
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
            $controllerObj->$method();
        } else {
            $this->errorHandle('Action initialization error!');
            return false;
        }

        return true;

        /*    if (!isset($controller) || $controller == "")
                $controller = $this->defaultController;
        $val = $controller . '.php';
        $res = require_once($val);
        if ($res != 1) {
            echo("requested controller not found!");
            return 0;
        }
        $controlClass = new $controller();
        if ($controlClass == NULL) {
            echo("Controller initialization error!");
            return 0;
        }
        ob_start();
        $controlClass->dispatchAction($action, &$this);
        $this->dataBuf = ob_get_contents();
        ob_end_clean();
        echo($this->dataBuf);
        return 1;*/
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

    private function getAction()
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
        if (is_null($action)) {
            throw new \Exception('Action missed');
        }

        return $action;
    }
}