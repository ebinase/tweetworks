<?php


namespace App\Controller;

use App\System\Cotroller;


class TweetController extends Cotroller
{
    public function tweet($params){
        return 'これはTweetControllerのtweetアクションだよ';
    }
}