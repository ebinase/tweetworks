<?php


namespace App\Controller;

use App\System\Cotroller;


class TweetController extends Cotroller
{
    public function tweet($params){
        print_r($params);
        return 'これはTweetControllerのtweetアクションだよ';
    }
}