<?php

namespace App\Model;

use App\System\Model;

class Tweet extends Model
{
    //==============================================================================
    //コンストラクタ
    //==============================================================================
    protected function _setTableName()
    {
        $this->_tableName = 'tweets';
    }

    //==============================================================================
    //アクションごとのデータ操作メソッド
    //==============================================================================
    public function getAllTweet()
    {
        $sql = 'SELECT * FROM tweets';
        return $this->fetchAll($sql);
    }

    public function insert($user_id, $text)
    {
        $sql = 'INSERT INTO tweets (user_id, text) VALUES (:user_id, :text)';
        $stt = $this->smartExecute($sql, [
            ':user_id' =>  $user_id,
            ':text' => $text,
        ]);
    }

}