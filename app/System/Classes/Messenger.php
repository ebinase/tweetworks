<?php

namespace App\System\Classes;

use App\System\Interfaces\HTTP\SessionInterface;
use App\System\Interfaces\MessageInterface;

class Messenger implements MessageInterface
{

    //Sessionクラスに依存
    private $_session;

    private $_error;
    private $_old;
    private $_info;

    public function __construct(SessionInterface $session)
    {
        // セッションクラスをプロパティにセット
        $this->_session = $session;

        // セッションから各種の値を取得
        $this->_error = $this->_session->get('_error');
        $this->_old = $this->_session->get('_old');
        $this->_info = $this->_session->get('_info');

        if (! isset($this->_error)) $this->_error = [];
        if (! isset($this->_old)) $this->_old = [];
        if (! isset($this->_info)) $this->_info = [];

        //基本的にエラーは引き継がないでリクエストのたびに消去
        $this->clear();
    }

    public function clear()
    {
        $this->_session->remove('_error');
        $this->_session->remove('_old');
        $this->_session->remove('_info');
    }

    //==============================================================================
    // 現在のリクエストでエラーが生じたときに使うメソッド
    //==============================================================================
    public function setError($key, $message)
    {
        $this->set('_error', $key, $message);
    }

    public function setOld($key, $message)
    {
        $this->set('_old', $key, $message);
    }

    public function setInfo($key, $message)
    {
        $this->set('_info', $key, $message);
    }

    private function set($type, $key, $message)
    {
        //エスケープ処理
        $message = escape($message);

        $new_errors = $this->_session->get($type);
        $new_errors[$key] = $message;
        // FIXME: $_SESSION['errors']をシンプルに上書きできるなら消去は不要
        $this->_session->remove($type);
        $this->_session->set($type, $new_errors);
    }

    //==============================================================================
    // 前のページで生じたエラーをチェックするためのメソッド
    //==============================================================================
    public function errorExists()
    {
        if (count($this->_error) > 0) {
            return true;
        }
        return false;
    }

    public function oldExists()
    {
        if (count($this->_old) > 0) {
            return true;
        }
        return false;
    }

    public function infoExists()
    {
        if (count($this->_info) > 0) {
            return true;
        }
        return false;
    }


    //　全てのエラー取得(配列)
    // ------------------------------------------------------------------------
    public function getAllError()
    {
        return $this->_error;
    }

    public function getAllOld()
    {
        return $this->_old;
    }

    public function getAllInfo()
    {
        return $this->_info;
    }


    //　エラーの値を取得
    // ------------------------------------------------------------------------
    public function getError($key, $default = null)
    {
        if (isset($this->_error[$key])) {
            return $this->_error[$key];
        }
        return $default;
    }

    public function getOld($key, $default = null)
    {
        if (isset($this->_old[$key])) {
            return $this->_old[$key];
        }
        return $default;
    }

    public function getInfo($key, $default = null)
    {
        if (isset($this->_info[$key])) {
            return $this->_info[$key];
        }
        return $default;
    }
}