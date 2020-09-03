<?php

namespace App\System\Classes;

use App\System\Classes\Facades\Auth;
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

    public function smartExecute(string $sql, array $params = [], $strict = false)
    {
        $statement = $this->_db->prepare($sql);

        if ($strict) {
            //配列内のデータの型を判定してPDOのパラメータ設定
            foreach ($params as $param_id => $value) {
                switch (gettype($value)) {
                    case 'boolean':
                        $param_type = \PDO::PARAM_BOOL;
                        break;

                    case 'integer':
                        $param_type = \PDO::PARAM_INT;
                        break;

                    case 'NULL':
                        $param_type = \PDO::PARAM_NULL;
                        break;

                    case 'double':
                    case 'string':
                    default:
                        $param_type = \PDO::PARAM_STR;
                }

                $statement->bindValue($param_id, $value, $param_type);
            }
            $statement->execute();
        } else {
            //一括で文字列型として処理
            $statement->execute($params);
        }
        return $statement;
    }

    public function fetch(string $sql, array $params = [], $strict = false)
    {
        return $this->smartExecute($sql, $params, $strict)->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAll(string $sql, array $params = [], $strict = false)
    {
        return $this->smartExecute($sql, $params, $strict)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function smartInsert(array $params)
    {
        //sql文で使いやすい形にparamsを変換
        $params = $this->_adaptParamsToInsertSql($params);

        //例:  'INSERT INTO tweets (user_id, text) VALUES (:user_id, :text)';
        $sql = "INSERT INTO {$this->_tableName} ({$params['columns']}) VALUES ({$params['holders']})";
        return $this->smartExecute($sql, $params['bindValues']);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM {$this->_tableName} WHERE id = :id";
        return $this->smartExecute($sql, [
            ':id' => $id,
        ]);
    }

    public function smartCount($colum_name, $value)
    {
        $sql = "SELECT count(*) FROM {$this->_tableName} WHERE {$colum_name} = :value;";

        //execute()->rowCount()が期待通り動作しなかったため、fetchを使用。
        $result = $this->fetch($sql, [':value' => $value]);
        return $result['count(*)'];
    }

    public function smartUpdate(array $params, array $cond)
    {
        //sql文で使いやすい形にparamsを変換
        $adapted = $this->_adaptParamsToUpdateSql($params, $cond);

        $sql = "UPDATE {$this->_tableName} SET {$adapted['set']} WHERE {$adapted['where']};";
        return $this->smartExecute($sql, $adapted['bindValues']);
    }

    //==============================================================================
    //プライベートメソッド
    //==============================================================================
    /**
     * 配列内の挿入するデータをインサート文に適した形に変換する
     *
     * @param array $params 挿入するデータの配列 ['id' => 1, 'name' => 'hoge']
     *
     * @return array $holders SQL文に埋め込むスペースホルダ
     */
    private function _adaptParamsToInsertSql(array $params)
    {
        $columns = '';
        $holders = '';
        $bindValues = [];
        // 配列をもとにSQL文の一部とbindValueで使用する配列を作成する。
        foreach ($params as $key => $param) {
            $columns .= "{$key}, ";
            $holders .= ":{$key}, ";
            $bindValues[":{$key}"] = $param;
        }
        $columns = rtrim($columns, ', ');
        $holders = rtrim($holders, ', ');

        return [
            'columns' => $columns,
            'holders' => $holders,
            'bindValues' => $bindValues,
        ];
    }

    /**
     * 配列内の挿入するデータをUPDATE文に適した形に変換する
     *
     * @param array $params 挿入するデータの配列 ['id' => 1, 'name' => 'hoge']
     * @param array $cond   where文で記述する条件を格納した配列
     *
     * @return array $holders SQL文に埋め込むスペースホルダ
     */
    private function _adaptParamsToUpdateSql(array $params, array $cond)
    {
        $set = '';
        $where = '';
        $bindValues = [];

        foreach ($params as $col => $value) {
            $set .= "{$col} = :{$col}, ";
            $bindValues[":{$col}"] = $value;
        }
        $set = rtrim($set, ', ');

        foreach ($cond as $col => $value) {
            $where .= "{$col} = :{$col}, ";
            $bindValues[":{$col}"] = $value;
        }
        $where = rtrim($where, ', ');

        return [
            'set' => $set,
            'where' => $where,
            'bindValues' => $bindValues,
        ];
    }
}