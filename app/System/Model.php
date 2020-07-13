<?php

namespace App\System;

use App\System\Interfaces\ModelInterface;

abstract class Model implements ModelInterface
{
    protected $db;

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct()
    {
        $this->registerDbConfig();
        $this->db = $this->getDbConnection();
        $this->setTableName();
    }

    protected function registerDbConfig()
    {
        // FIXME: 関数ではなくシンプルに配列として読み込めないものか・・・
        require_once  "../config/database.php";
        $dbConfig = getDbConfig();

        $this->dsn = $dbConfig['dsn'];
        $this->user = $dbConfig['user'];
        $this->password = $dbConfig['password'];
    }

    /**
     * @return object
     */
    public function getDbConnection()
    {

    }

    public abstract function setTableName();

    //==============================================================================
    //クエリ簡易実行メソッド
    //==============================================================================

    public function execute(string $sql, array $params)
    {
        // TODO: Implement execute() method.
    }

    public function fetch(string $sql, array $params)
    {
        // TODO: Implement fetch() method.
    }

    public function fetchAll(string $sql, array $params)
    {
        // TODO: Implement fetchAll() method.
    }
}