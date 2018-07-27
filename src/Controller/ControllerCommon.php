<?php

namespace Controller;

use Model\LanguageModel;
use Model\KeyModel;
use Model\TranslationModel;

abstract class ControllerCommon
{
    private $rootPath;
    private $viewsPath;

    protected $langManager;
    protected $keyManager;
    protected $translationManager;

    public function __construct()
    {
        $this->rootPath = $_SERVER['DOCUMENT_ROOT'];
        $this->viewsPath = $this->rootPath . '/src/Resources/views';

        $this->langManager = new LanguageModel();
        $this->keyManager = new KeyModel();
        $this->translationManager = new TranslationModel();
    }

    /**
     * Passes the parameters to the view and displays the page.
     * @param string $fileName
     * @param array $params
     */
    protected function render($fileName, $params = [])
    {
        foreach ($params as $key => $value) {
            ${$key} = $value;
        }

        include_once($this->viewsPath . '/' . $fileName);
    }

    /**
     * Generates a response to the ajax-request.
     * If the request is handled successfully, it returns an array:
     * [success => true, data => array]
     * Else:
     * [success => false, errors => array]
     * @param array $data
     * @param bool $success
     */
    protected function ajaxResponse($data = [], $success = true)
    {
        $word = $success ? 'data' : 'errors';
        echo json_encode(['success' => $success, $word => $data], JSON_UNESCAPED_UNICODE);
    }
}