<?php

namespace Model;

class DefaultLanguagesModel extends ModelCommon
{
    const TABLE_NAME = 'default_languages';
    const REQUIRED_FIELDS = [
        'name',
        'code'
    ];

    /**
     * @return array
     */
    public function getDefaultLanguageList()
    {
        $stmt = $this->pdo->query('SELECT * FROM ' . self::TABLE_NAME);

        $langList = [];
        while ($row = $stmt->fetch()) {
            $langList[] = $row;
        }

        return $langList;
    }
}