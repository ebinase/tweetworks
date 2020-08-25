<?php

namespace Database\migration;

class Migration extends \App\System\Classes\Model
{
    public function _setTableName()
    {

    }

    public function refresh()
    {
        $this->drop();
        $this->up();
    }

    public function up()
    {
        $sqls[] = CreateFavoritesTable::getCreateQuery();
        $sqls[] = CreateFollowsTable::getCreateQuery();
//        $sqls[] = CreateRepliesTable::getCreateQuery();
        $sqls[] = CreateTweetsTable::getCreateQuery();
        $sqls[] = CreateUsersTable::getCreateQuery();

        foreach ($sqls as $sql) {
            $this->_db->query($sql);
        }
    }

    public function drop()
    {
        // FIXME: スマートじゃない
        // テーブル名をクラスで保持して自動化したい
        $sqls[] = CreateFavoritesTable::getDropQuery('favorites');
        $sqls[] = CreateFollowsTable::getDropQuery('follows');
//        $sqls[] = CreateRepliesTable::getDropQuery('replies');
        $sqls[] = CreateTweetsTable::getDropQuery('tweets');
        $sqls[] = CreateUsersTable::getDropQuery('users');

        foreach ($sqls as $sql) {
            $this->_db->query($sql);
        }
    }
}