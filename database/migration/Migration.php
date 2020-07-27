<?php

namespace Database\migration;

class Migration extends \App\System\Model
{
    public function _setTableName()
    {
    }

    public function up()
    {
        $sqls[] = CreateFavoritesTable::getQuerySentence();
        $sqls[] = CreateFollowsTable::getQuerySentence();
        $sqls[] = CreateRepliesTable::getQuerySentence();
        $sqls[] = CreateTweetsTable::getQuerySentence();
        $sqls[] = CreateUsersTable::getQuerySentence();

        foreach ($sqls as $sql) {
            $this->_db->query($sql);
        }
    }
}