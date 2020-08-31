<?php

namespace App\Controller;

use App\Model\User;
use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class ProfileController extends Controller
{
    public function update(RequestInterface $request)
    {
        $name = $request->getPost('name');
        $bio = $request->getPost('bio');

        //TODO:バリデーション

        $user = new User();

        $user->smartUpdate([
            'name' => $name,
            'bio' => $bio,
        ], [
            'id' => Auth::id(),
        ]);

        $session = Service::call('session');
        $session->set('name' ,$name);

        return back('/home');
    }
}