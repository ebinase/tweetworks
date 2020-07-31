<?php

namespace App\Model;

use App\System\Model;

class Reply extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'replies';
    }


}