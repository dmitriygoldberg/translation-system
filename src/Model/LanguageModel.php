<?php

namespace Model;

class LanguageModel extends ModelCommon
{
    const TABLE_NAME = 'language';
    const REQUIRED_FIELDS = [
        'name',
        'code'
    ];

    /**
     * @return array
     */
    public function getLanguageList()
    {
        $stmt = $this->pdo->query('SELECT * FROM ' . self::TABLE_NAME);

        $langList = [];
        while ($row = $stmt->fetch()) {
            $langList[] = $row;
        }

        return $langList;
    }

    /**
     * @param array $params
     * @return array
     */
    public function insertLanguage($params)
    {
        $errors = $this->validate(self::REQUIRED_FIELDS, $params);

        if (!empty($errors)) {
            return $this->createResponse($errors, false);
        }

        $name = $params['name'];
        $code = $params['code'];

        $sql = 'INSERT INTO ' . self::TABLE_NAME . ' (`name`, `code`) VALUES (:name, :code)';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['name' => $name, 'code' => $code]);

        $id = $this->pdo->lastInsertId();
        return $this->createResponse(['id' => $id]);
    }

    /**
     * @param integer $id
     * @param array $params
     * @return array
     */
    public function updateLanguageById($id, $params)
    {
        $errors = $this->validate(self::REQUIRED_FIELDS, $params);

        if (!empty($errors)) {
            return $this->createResponse($errors, false);
        }

        $name = $params['name'];
        $code = $params['code'];

        $sql = 'UPDATE ' . self::TABLE_NAME . ' SET `name` = :name, `code` = :code WHERE `id` = :id';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['id' => $id, 'name' => $name, 'code' => $code]);
        return $this->createResponse();
    }

    /**
     * @param integer $id
     * @return array
     */
    public function deleteLanguageById($id)
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