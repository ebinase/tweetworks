<?php

namespace App\Controller;

use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;

class TopController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect('/home');
        } else {
            return $this->render('top', []);
        }
    }
}