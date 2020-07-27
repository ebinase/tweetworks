<?php

namespace App\System\Interfaces;

interface CreateTableInterface
{
    public static function getQuerySentence(): string;
}