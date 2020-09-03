<?php

namespace App\System\Classes\Facades\Messenger;

use App\System\Classes\Services\Service;

class Info
{
    public static function set($title, $content)
    {
        $messenger = Service::call('messenger');
        $messenger->setInfo($title, $content);
    }

    public static function has()
    {
        $messenger = Service::call('messenger');
        return $messenger->infoExists();
    }

    //htmlを作成してビューに返す。
    public static function showAllInfo($class_name)
    {
        $messenger = Service::call('messenger');
        $items = $messenger->getAllInfo();
        $content = '';
        if (isset($items)) {
            foreach ($items as $item) {
                $content .= "<div class=\"{$class_name}\">" . $item . '</div>';
            }
        }
        return $content;
    }
}