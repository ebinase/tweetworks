<?php

namespace App\System\Classes;

use App\System\Classes\Services\Service;
use App\System\Interfaces\ModelInterface;

abstract class Model implements ModelInterface
{
    protected $_db;
    protected $_tableName;

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct()
    {
        $connection = Service::call('connection');
        $this->_db = $connection->getDb();

        $this->_setTableName();
    }


    //モデルで扱うテーブル名を継承先で登録する抽象クラス
    protected abstract function _setTableName();

    //==============================================================================
    //クエリ簡易実行メソッド
    //==============================================================================

    public function smartExecute(string $sql, array $params = [])
    {
        $statement = $this->_db->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public function fetch(string $sql, array $params = [])
    {
        return $this->smartExecute($sql, $params)->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAll(string $sql, array $params = [])
    {
        return $this->smartExecute($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function smartInsert(array $params)
    {
        $culumns = '';
        $holders = '';
        // 配列をもとにSQL文の一部とbindValueで使用する配列を作成する。
        foreach ($params as $key => $param) {
            $culumns .= "{$key}, ";
            $holders .= ":{$key}, ";
            $bindValues[":{$key}"] = $param;
        }
        $culumns = rtrim($culumns, ', ');
        $holders = rtrim($holders, ', ');

        //例:  'INSERT INTO tweets (user_id, text) VALUES (:user_id, :text)';
        $sql = "INSERT INTO {$this->_tableName} ({$culumns}) VALUES ($holders)";
        return $this->smartExecute($sql, $bindValues);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM {$this->_tableName} WHERE id = {$id}";
        return $this->smartExecute($sql);
    }
}