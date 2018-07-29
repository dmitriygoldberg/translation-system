<?php

namespace Controller;

class TranslationController extends ControllerCommon
{
    /**
     * Displays translation.php
     */
    public function showTranslationPageAction()
    {
        $langList = $this->langManager->getLanguageList();
        $keyList = $this->keyManager->getKeyList();
        $translationList = $this->translationManager->getTranslationList();

        $groupedTranslationList = [];
        foreach ($translationList as $translation) {
            $groupedTranslationList[$translation['key_id']][$translation['lang_id']] = $translation;
        }

        $output['langList'] = $langList;
        $output['keyList'] = $keyList;
        $output['translationList'] = $groupedTranslationList;
        $this->render('translation.php', $output);
    }

    /**
     * @param array $params
     */
    public function createKeyAction($params)
    {
        if (isset($params['name'])) {
            if (!$this->validateKeyByName($params['name'])) {
                $this->ajaxResponse(['Ключ ' . $params['name'] . ' уже существует'], false);
                return;
            }
        }

        $response = $this->keyManager->insertKey($params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    /**
     * @param array $params
     */
    public function editKeyAction($params)
    {
        if (!isset($params['id'])) {
            $errors[] = 'Missing parameter "id"';
            $this->ajaxResponse($errors, false);
            return;
        }

        if (isset($params['name'])) {
            if (!$this->validateKeyByName($params['name'], $params['id'])) {
                $this->ajaxResponse(['Ключ ' . $params['name'] . ' уже существует'], false);
                return;
            }
        }

        $id = $params['id'];
        $response = $this->keyManager->updateKeyById($id, $params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    /**
     * @param array $params
     */
    public function deleteKeyAction($params)
    {
        if (!isset($params['id'])) {
            $errors[] = 'Missing parameter "id"';
            $this->ajaxResponse($errors, false);
            return;
        }

        $response = $this->keyManager->deleteKeyById($params['id']);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    /**
     * @param array $params
     */
    public function createTranslationAction($params)
    {
        $response = $this->translationManager->insertTranslation($params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    /**
     * @param array $params
     */
    public function editTranslationAction($params)
    {
        if (!isset($params['id'])) {
            $errors[] = 'Missing parameter "id"';
            $this->ajaxResponse($errors, false);
            return;
        }

        $id = $params['id'];
        $response = $this->translationManager->updateTranslationById($id, $params);
        $this->ajaxResponse($response['data'], $response['success']);
    }

    /**
     * @param array $params
     */
    public function deleteTranslationAction($params)
    {
        if (!isset($params['id'])) {
            $errors[] = 'Missing parameter "id"';
            $this->ajaxResponse($errors, false);
            return;
        }

        $response = $this->translationManager->deleteTranslationById($params['id']);
        $this->ajaxResponse($response['data'], $response['success']);
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
     * Checks for uniqueness of the name
     * @param string $name
     * @param integer $keyId
     * @return bool
     */
    private function validateKeyByName($name, $keyId = null)
    {
        $keyList = $this->keyManager->getKeyListByCondition(['name' => $name]);
        if (!empty($keyList)) {
            if (!is_null($keyId)) {
                foreach ($keyList as $key) {
                    if ($key['id'] == $keyId) {
                        return true;
                    }
                }
            }
            return false;
        }
        return true;
    }
}
