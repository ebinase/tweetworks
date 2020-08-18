<?php

namespace App\Model;

use App\System\Classes\Model;

class Favorite extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'favorites';
    }



}