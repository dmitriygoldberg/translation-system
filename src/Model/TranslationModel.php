<?php

namespace Model;

class TranslationModel extends ModelCommon
{
    const TABLE_NAME = 'translation';
    const REQUIRED_FIELDS = [
        'keyId',
        'langId',
        'content'
    ];

    /**
     * @return array
     */
    public function getTranslationList()
    {
        $stmt = $this->pdo->query('SELECT * FROM `' . self::TABLE_NAME . '`');

        $translationList = [];
        while ($row = $stmt->fetch()) {
            $translationList[] = $row;
        }

        return $translationList;
    }

    /**
     * @param array $params
     * @return array
     */
    public function insertTranslation($params)
    {
        $errors = $this->validate(self::REQUIRED_FIELDS, $params);

        if (!empty($errors)) {
            return $this->createResponse($errors, false);
        }

        $keyId = $params['keyId'];
        $langId = $params['langId'];
        $content = $params['content'];

        $sql = 'INSERT INTO ' . self::TABLE_NAME . ' (`key_id`, `lang_id`, `content`) 
            VALUES (:keyId, :langId, :content)';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['keyId' => $keyId, 'langId' => $langId, 'content' => $content]);

        $id = $this->pdo->lastInsertId();
        return $this->createResponse(['id' => $id]);
    }

    /**
     * @param integer $id
     * @param array $params
     * @return array
     */
    public function updateTranslationById($id, $params)
    {
        $errors = $this->validate(self::REQUIRED_FIELDS, $params);

        if (!empty($errors)) {
            return $this->createResponse($errors, false);
        }

        $keyId = $params['keyId'];
        $langId = $params['langId'];
        $content = $params['content'];

        $sql = 'UPDATE ' . self::TABLE_NAME . ' SET `key_id` = :keyId, `lang_id` = :langId, `content` = :content 
            WHERE `id` = :id';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['id' => $id, 'keyId' => $keyId, 'langId' => $langId, 'content' => $content]);
        return $this->createResponse();
    }

    /**
     * @param integer $id
     * @return array
     */
    public function deleteTranslationById($id)
    {
        $sql = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['id' => $id]);
        return $this->createResponse();
    }
}