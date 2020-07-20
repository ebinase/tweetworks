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
        consoleLogger('接続完了');
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
        require_once  "../config/database.php";
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
        try {
            $db = new \PDO($param['dsn'], $param['user'], $param['password']);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (\PDOException $e) {
            //FIXME:エラーページに飛ばす
            exit($e->getMessage());
        }
    }

    //モデルで扱うテーブル名を継承先で登録する抽象クラス
    protected abstract function _setTableName();

    //==============================================================================
    //クエリ簡易実行メソッド
    //==============================================================================

    public function execute(string $sql, array $params = [])
    {
        $statement = $this->_db->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public function fetch(string $sql, array $params = [])
    {
        return $this->execute($sql, $params)->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAll(string $sql, array $params = [])
    {
        return $this->execute($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }
}