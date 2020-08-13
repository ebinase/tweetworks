<?php


namespace App\System\Interfaces\Facade;


use App\System\Application;

interface FacadeInterface
{
    public function __construct(Application $application);
}