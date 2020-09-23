<?php


namespace App\System\Interfaces\HTTP;


interface SessionInterface
{
    function set($name, $value);
    function get($name);
    function remove(string $name);
    function clear(): void;
    function regenerate(): void;

    function setAuthenticated(bool $bool);
    function isAuthenticated();

    function setAdminAuthenticated(bool $bool);
    function isAdminAuthenticated();

}