<?php

use Controller\ControllerFactory;

class Application
{
    const DEFAULT_CONTROLLER = 'Translation';
    const DEFAULT_ACTION = 'showTranslationPage';
    const ERROR_ACTION = 'showErrorPage';

    /**
     * The entry point to the application. Accepts the incoming request and redirects the data.
     * @return boolean
     */
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

    /**
     * Checks for the existence of the controller and the called action.
     * If successful, it executes the controller action.
     * Otherwise, it redirects the data to the error page.
     * @param string $controller
     * @param string $action
     * @param array $params
     *
     * @return boolean
     */
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

    /**
     * It executes the action and controller by default.
     * @return boolean
     */
    private function defaultHandle()
    {
        return $this->handle(self::DEFAULT_CONTROLLER, self::DEFAULT_ACTION);
    }

    /**
     * In case of an error, redirects to 404 pages, displaying the contents of the error massage.
     * @param array $errorMessage
     *
     * @return boolean
     */
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