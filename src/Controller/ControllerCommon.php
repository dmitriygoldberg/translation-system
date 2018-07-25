<?php

namespace Controller;

abstract class ControllerCommon
{
    private $rootPath;
    private $viewsPath;

    public function __construct()
    {
        $this->rootPath = $_SERVER['DOCUMENT_ROOT'];
        $this->viewsPath = $this->rootPath . '/src/Resources/views';
    }

    protected function render($fileName, $params = null)
    {
        include_once ($this->viewsPath . '/' . $fileName);
    }

    protected function ajaxResponse($data = [], $success = true)
    {
        $word = $success ? 'data' : 'errors';
        echo json_encode(['success' => $success, $word => $data], JSON_UNESCAPED_UNICODE);
    }
}