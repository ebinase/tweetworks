<?php

namespace App\System;

use App\System\Interfaces\CreateTableInterface;

abstract class CreateTable implements CreateTableInterface
{
    abstract public static function getQuerySentence(): string;
}