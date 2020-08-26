<?php

namespace App\Middleware;

use App\System\Classes\Services\Service;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class SessionReferer implements \App\System\Interfaces\Core\MiddlewareInterface
{
    //次のアクセスでどのページから来たのか認識できるようにする
    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        $session = Service::call('session');
        $prev = $session->get('referer_prev1_page');

        $request_method = strtoupper($request->getRequestMethod());

        //投稿アクションのような構成への対応
        //例) 入力フォーム(GET) →(送信)→ 登録ページ(POST)
        //          ↑ ← ← ←(リダイレクト)← ← ← ↓

        //TODO:改修(リダイレクトしたときなど、少し不安定)

        //入力ページなどのGETページだった場合だけ更新
        if ($request_method == 'GET') {

            $current = $request->getPathInfo();

            if ( $current ===  $prev) {
                //直前とおなじページ(再読み込み)だったらその一つ前を採用
                $back_to = $session->get('referer_prev2_page');
                //prevの更新はしない(再々読み込みされても同じ挙動になるように)
            } else {
                //直前と異なるページだったらprev1を戻り先にする
                $back_to = $prev;
                //prev1をprev2にずらしてから、現在のページをprevに登録
                $session->set('referer_prev2_page', $prev);
                $session->set('referer_prev1_page', $current);
            }

        } else {
            //登録アクションなどでPOSTなどでアクセスした場合はback_toも何も更新しない
            //(エラーが起きた際などに、戻り先をPOSTのページにしないため)
            $back_to = $prev;
        }

        $session->set('referer_back_to', $back_to);

//        print 'SessionReferer通過(前のページは' . $session->get('referer_back_to') . ')▶';

        return $next->handle($request);
    }
}