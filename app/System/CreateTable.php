<?php

namespace App\System;

use App\System\Interfaces\CreateTableInterface;

abstract class CreateTable implements CreateTableInterface
{
    abstract public static function getCreateQuery(): string;

    public static function getDropQuery($table): string
    {
        return "drop table if exists {$table};";
    }
}