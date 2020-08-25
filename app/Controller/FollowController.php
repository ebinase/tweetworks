<?php


namespace App\Controller;


use App\Model\Follow;
use App\System\Classes\Facades\Auth;
use App\System\Interfaces\HTTP\RequestInterface;

class FollowController extends \App\System\Classes\Controller
{
    public function update(RequestInterface $request)
    {
        $user_id_followed = $request->getPost('user_id_followed');
        $user_id = Auth::id();

        $follow = new Follow();

         print_r($data = $follow->checkIfFollows($user_id,$user_id_followed));

        if (empty($data)){
            $follow->smartInsert([
                'user_id_followed' => $user_id_followed,
                'user_id' => $user_id,
            ]);
        }else{
            $follow->deleteByFollows($user_id,$user_id_followed);
        }

        return back();

    }
}