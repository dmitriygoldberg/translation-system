<?php

namespace Model;

class KeyModel extends ModelCommon
{
    const TABLE_NAME = 'key';
    const REQUIRED_FIELDS = [
        'name'
    ];

    /**
     * @return array
     */
    public function getKeyList()
    {
        $stmt = $this->pdo->query('SELECT * FROM `' . self::TABLE_NAME . '`');

        $keyList = [];
        while ($row = $stmt->fetch()) {
            $keyList[] = $row;
        }

        return $keyList;
    }

    /**
     * @param array $params
     * @return array
     */
    public function insertKey($params)
    {
        $errors = $this->validate(self::REQUIRED_FIELDS, $params);

        if (!empty($errors)) {
            return $this->createResponse($errors, false);
        }

        $name = $params['name'];

        $sql = 'INSERT INTO `' . self::TABLE_NAME . '` (`name`) VALUES (:name)';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['name' => $name]);
        $id = $this->pdo->lastInsertId();
        return $this->createResponse(['id' => $id]);
    }

    /**
     * @param integer $id
     * @param array $params
     * @return array
     */
    public function updateKeyById($id, $params)
    {
        $errors = $this->validate(self::REQUIRED_FIELDS, $params);

        if (!empty($errors)) {
            return $this->createResponse($errors, false);
        }

        $name = $params['name'];

        $sql = 'UPDATE `' . self::TABLE_NAME . '` SET `name` = :name WHERE `id` = :id';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['id' => $id, 'name' => $name]);
        return $this->createResponse();
    }

    /**
     * @param integer $id
     * @return array
     */
    public function deleteKeyById($id)
    {
        $sql = 'DELETE FROM `' . self::TABLE_NAME . '` WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            $errors[] = $this->getPdoError();
            return $this->createResponse($errors, false);
        }

        $stmt->execute(['id' => $id]);
        return $this->createResponse();
    }
}