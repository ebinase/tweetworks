<?php


namespace App\System\Interfaces;


interface SessionInterface
{
    function set($name, $value);
    function get($name);
    function remove(string $name);
    function clear(): void;
    function regenerate(): void;

    function setAuthenticated($bool);
    function isAuthenticated();

}