<?php


namespace App\Controller;


use App\Model\Follow;
use App\System\Classes\Facades\Auth;
use App\System\Classes\HTTP\JsonResponse;
use App\System\Interfaces\HTTP\RequestInterface;

class FollowController extends \App\System\Classes\Controller
{
    public function update(RequestInterface $request)
    {
        $user_id_followed = $request->getPost('user_id_followed');
        $user_id = Auth::id();

        if ($user_id == $user_id_followed) {
            $result = 'self_follow';
        } else {
            $follow = new Follow();

            $ifFollows = $follow->checkIfFollows($user_id,$user_id_followed);

            if ($ifFollows == 0){
                $follow->smartInsert([
                    'user_id_followed' => $user_id_followed,
                    'user_id' => $user_id,
                ]);
                $result = 'set';
            }else{
                $follow->deleteByFollows($user_id,$user_id_followed);
                $result = 'unset';
            }
        }

        $content = [
            'result' => $result,
        ];

        $response = new JsonResponse();

        $response->prepareJson($content);

        return $response;


    }
}