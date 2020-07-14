<?php


namespace App\System\Interfaces;


interface SessionInterface
{
    function set(string $name, string $value);
    function get(string $name);
    function remove(string $name);
    function clear(): void;
    function regenerate(): void;

    function setAuthenticated($bool);
    function isAuthenticated();

}