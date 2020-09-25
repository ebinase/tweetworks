<?php

namespace App\Controller\Trap;

use App\System\Classes\Controller;

class TrapController extends Controller
{
    public function csrf()
    {
        return $this->render('trap/csrf');
    }
}