<?php


namespace App\Controller;

use App\Model\Follow;
use App\System\Controller;

class FollowController extends Controller
{
    public function update($params){

        $followed_id = $params['user_id'];

        var_dump($followed_id);

//        $this->_session->isAuthenticated();


        //ユーザー入力値取得
//        $user_id = $this->_request->getPost('user_id');

        // DBからuser_idをキーにユーザーデータ取得(配列)
        $user = new Follow();

//        もしお気に入りにデータがなければInsert、データがあれがdelete
        $data =$user->fetchByFollowUserId($followed_id);

        if ( ! isset($data) ){
           $followed_id->smartInsert([
               'followed_user_id' => $this->_request->getPost('followed_id'),
           ]);
           return $this->_redirect('/home');
       }

       else{

           $followed_id->deleteById($followed_id);

           return  $this->_redirect('/home');
       }




    }
}
