<?php

namespace App\System;

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
        $this->_db = $this->_getDbConnection($this->_getConnectParam());
        if ($this->_db !== null) {
            //自作ログ関数
            consoleLogger('接続完了');
        }
        $this->_setTableName();
    }

    /**
     * データベース接続パラメータを格納した配列を取得
     * /config/database.phpから
     *
     * @return array
     */
    protected function _getConnectParam()
    {
        // FIXME: 関数ではなくシンプルに配列として読み込めないものか・・・
        $dir = str_replace('/app/System/Model.php', '', __FILE__) . '/config/database.php';
        require_once  $dir;

        return connectParam();
    }

    /**
     * データベースに接続
     *
     * @param array $param
     * @return object $db
     */
    protected function _getDbConnection(array $param)
    {
        $db = new \PDO($param['dsn'], $param['user'], $param['password']);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $db;
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