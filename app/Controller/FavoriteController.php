<?php

namespace App\Controller;

use App\System\Classes\Facades\Auth;
use App\System\Classes\Services\Service;

class FavoriteController extends \App\System\Classes\Controller
{
    public function update()
    {
        $user_id = Auth::id();

    }
}