<?php

namespace Controller;

use Model\LanguageModel;

abstract class ControllerCommon
{
    private $rootPath;
    private $viewsPath;

    protected $langManager;

    public function __construct()
    {
        $this->rootPath = $_SERVER['DOCUMENT_ROOT'];
        $this->viewsPath = $this->rootPath . '/src/Resources/views';

        $this->langManager = new LanguageModel();
    }

    protected function render($fileName, $params = [])
    {
        foreach ($params as $key => $value) {
            ${$key} = $value;
        }

        include_once ($this->viewsPath . '/' . $fileName);
    }

    protected function ajaxResponse($data = [], $success = true)
    {
        $word = $success ? 'data' : 'errors';
        echo json_encode(['success' => $success, $word => $data], JSON_UNESCAPED_UNICODE);
    }
}