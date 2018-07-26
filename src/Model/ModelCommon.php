<?php

namespace Model;

use PDO;

abstract class ModelCommon
{
    protected $pdo = null;

    public function __construct()
    {
        if (is_null($this->pdo)) {
            $this->connect();
        };
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    private function connect()
    {
        if ($this->pdo) {
            $this->pdo;
        }

        $ini = $_SERVER['DOCUMENT_ROOT'] . '/app/config/config.ini';
        $parse = parse_ini_file($ini, true);

        $driver = $parse ["db_driver"];
        $dsn = "${driver}:";
        $user = $parse ["db_user"];
        $password = $parse ["db_password"];
        $options = $parse ["db_options"];
        $attributes = $parse ["db_attributes"];

        foreach ($parse ["dsn"] as $k => $v) {
            $dsn .= "${k}=${v};";
        }

        $this->pdo = new PDO ($dsn, $user, $password, $options);

        foreach ($attributes as $k => $v) {
            $this->pdo->setAttribute(constant("PDO::{$k}"),
                constant("PDO::{$v}"));
        }

        return $this->pdo;
    }

    protected function validate($fieldList, $params)
    {
        $errors = [];
        foreach ($fieldList as $field) {
            if (!isset($params[$field])) {
                $errors[] = 'Missing parameter "' . $field . '"';
            }
        }

        return $errors;
    }

    protected function createResponse($data = [], $success = true)
    {
        return ['success' => $success, 'data' => $data];
    }

    protected function getPdoError()
    {
        //Return only driver-specific error message
        $error = $this->pdo->errorInfo()[2];
        return $this->createResponse($error, false);
    }
}