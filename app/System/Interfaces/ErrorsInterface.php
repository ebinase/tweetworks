<?php

namespace App\System\Interfaces;

interface ErrorsInterface
{
    function getMessage($key, $default = null);
    function getAllErrors();
    function set($key, $message);

    function errorExists();
    function hasError($key);
}