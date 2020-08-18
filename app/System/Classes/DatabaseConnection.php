<?php

namespace App\System\Classes;

class DatabaseConnection
{
    private $_db;

    public function __construct()
    {
        $db = new \PDO(env('DB_DSN'), env('DB_USER'), env('DB_PASSWORD'));
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->_db = $db;
    }

    public function getDb()
    {
        return $this->_db;
    }

}