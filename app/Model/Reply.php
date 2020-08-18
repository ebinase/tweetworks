<?php

namespace App\Model;

use App\System\Classes\Model;

class Reply extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'replies';
    }


}