<?php

namespace Database\migration;

class Migration extends \App\System\Model
{
    public function _setTableName()
    {
    }

    public function up()
    {
        $sqls[] = CreateTweetTable::getQuerySentence();

        foreach ($sqls as $sql) {
            $this->_db->query($sql);
        }
    }
}