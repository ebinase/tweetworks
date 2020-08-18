<?php

namespace App\Model;

use App\System\Classes\Model;

class Follow extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'follows';
    }


}