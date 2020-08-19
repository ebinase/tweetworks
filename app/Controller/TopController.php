<?php

namespace App\Controller;

use App\System\Classes\Controller;

class TopController extends Controller
{
    public function index() {
        return $this->render('top', [], 'layouts/layout');
    }
}