<?php

namespace Controller;

class LanguageController extends ControllerCommon
{
    /**
     * Displays language.php
     */
    public function showLanguagePageAction()
    {
        $langList = $this->langManager->getLanguageList();
        $defaultLangList = $this->defaultLangManager->getDefaultLanguageList();
        $this->render('language.php', ['langList' => $langList, 'defaultLangList' => $defaultLangList]);
    }

    /**
     * Displays 404.php
     * @param array $params
     */
    public function showErrorPageAction($params = [])
    {
        $output['error'] = isset($params['error']) ? $params['error'] : null;
        $this->render('404.php', $output);
    }

    /**
     * @param array $params
     */
    public function createLanguageAction($params)
    {
        if (isset($params['code'])) {
            if (!$this->validateLanguageByCode($params['code'])) {
                $this->ajaxResponse(['Уже существует язык с кодом ' . $params['code']], false);
                return;
            }
        }

        $response = $this->langManager->insertLanguage($params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    /**
     * @param array $params
     */
    public function editLanguageAction($params)
    {
        if (!isset($params['id'])) {
            $errors[] = 'Missing parameter "id"';
            $this->ajaxResponse($errors, false);
            return;
        }

        if (isset($params['code'])) {
            if (!$this->validateLanguageByCode($params['code'], $params['id'])) {
                $this->ajaxResponse(['Уже существует язык с кодом ' . $params['code']], false);
                return;
            }
        }

        $id = $params['id'];
        $response = $this->langManager->updateLanguageById($id, $params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    /**
     * @param array $params
     */
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

    /**
     * Checks for uniqueness of the code
     * @param string $code
     * @param integer $langId
     * @return bool
     */
    private function validateLanguageByCode($code, $langId = null)
    {
        $langList = $this->langManager->getLanguageListByCondition(['code' => $code]);
        if (!empty($langList)) {
            if (!is_null($langId)) {
                foreach ($langList as $lang) {
                    if ($lang['id'] == $langId) {
                        return true;
                    }
                }
            }
            return false;
        }
        return true;
    }
}
