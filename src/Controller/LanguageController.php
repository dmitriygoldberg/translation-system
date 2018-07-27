<?php

namespace Controller;

class LanguageController extends ControllerCommon
{
    public function showLanguagePageAction()
    {
        $langList = $this->langManager->getLanguageList();
        $this->render('language.php', ['langList' => $langList]);
    }

    public function showErrorPageAction($params = null)
    {
        $output['error'] = isset($params['error']) ? $params['error'] : null;
        $this->render('404.php', $output);
    }

    public function createLanguageAction($params)
    {
        $response = $this->langManager->insertLanguage($params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    public function editLanguageAction($params)
    {
        if (!isset($params['id'])) {
            $errors[] = 'Missing parameter "id"';
            $this->ajaxResponse($errors, false);
            return;
        }

        $id = $params['id'];
        $response = $this->langManager->updateLanguageById($id, $params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    public function deleteLanguageAction($params)
    {
        if (!isset($params['id'])) {
            $errors[] = 'Missing parameter "id"';
            $this->ajaxResponse($errors, false);
            return;
        }

        $response = $this->langManager->deleteLanguageById($params['id']);
        $this->ajaxResponse($response['data'], $response['success']);
    }
}
