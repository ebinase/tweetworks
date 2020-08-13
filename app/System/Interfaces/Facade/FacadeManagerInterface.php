<?php


namespace App\System\Interfaces\Facade;


use App\System\Application;

Interface FacadeManagerInterface
{

    function __construct(Application $application);

    function get($facade):FacadeInterface;
}