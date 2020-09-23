<?php

namespace App\Controller\Admin;

use App\System\Classes\Controller;
use App\System\Classes\Facades\CSRF;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Services\Env;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class AdminController extends Controller
{
    public function index()
    {
        return $this->render('admin/top');
    }

}