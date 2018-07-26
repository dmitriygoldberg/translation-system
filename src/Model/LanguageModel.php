<?php

namespace Model;

class LanguageModel extends ModelCommon
{
    const TABLE_NAME = 'language';

    public function getLanguageList()
    {
        $stmt = $this->pdo->query('SELECT * FROM ' . self::TABLE_NAME);

        $langList = [];
        while ($row = $stmt->fetch()) {
            $langList[] = $row;
        }

        return $langList;
    }

    public function insertLanguage($params)
    {
        $requiredFields = ['name', 'code'];
        $errors = $this->validate($requiredFields, $params);

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

    public function updateLanguageById($id, $params)
    {
        $requiredFields = ['name', 'code'];
        $errors = $this->validate($requiredFields, $params);

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