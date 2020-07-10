<?php

namespace App\System;

use App\System\Interfaces\ModelInterface;

abstract class Model implements ModelInterface
{
    protected $db;
    protected $dsn;
    protected $user;
    protected $password;

    public function __construct()
    {
        // FIXME: も少しうまい感じにかけそう
        $this->registerDbConfig();


    }

    protected function registerDbConfig()
    {

    }



    public function execute(string $sql, array $params)
    {
        // TODO: Implement execute() method.
    }

    public function fetch(string $sql, array $params)
    {
        // TODO: Implement fetch() method.
    }

    public function fetchAll(string $sql, array $params)
    {
        // TODO: Implement fetchAll() method.
    }
}