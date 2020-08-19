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
        //アフターミドルウェア
        $response = $next->handle($request);

        $request_method = strtoupper($request->getRequestMethod());
        $session = Service::call('session');

        //投稿アクションのような構成への対応
        //例) 入力フォーム(GET) →(送信)→ 登録ページ(POST)
        //          ↑ ← ← ←(リダイレクト)← ← ← ↓
        if ($request_method == 'GET') {
            //入力ページなどのGETページだったらこのページを戻り先に登録
            $uri = $request->getPathInfo();
        } else {
            //登録アクションなどでPOSTでアクセスした場合はその前の入力ページなどを登録
            $uri = $session->get('prev_page');
        }

        $display = $session->get('prev_page');

        $session->set('prev_page', $uri);

        print '(After)SessionReferer通過(前のページは' . $display . ')▶';

        return $response;
    }
}