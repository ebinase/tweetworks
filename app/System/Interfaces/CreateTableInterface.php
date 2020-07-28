<?php

namespace App\System\Interfaces;

interface CreateTableInterface
{
    public static function getCreateQuery(): string;

    public static function getDropQuery($table): string;
}