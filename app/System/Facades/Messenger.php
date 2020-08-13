<?php

namespace App\System\Facades;

use App\System\Interfaces\MessengerInterface;
use App\System\Session;

class Messenger implements MessengerInterface
{
    private $_session;

    private $_errors = [];
    private $_olds = [];
    private $_messages =[];
    private $_from;

    //Sessionクラスに依存
    public function __construct(Session $session)
    {
        // セッションクラスをプロパティにセット
        $this->_session = $session;

        // セッションから各種の値を取得
        $this->_errors = $this->_session->get('_errors');
        $this->_olds = $this->_session->get('_olds');
        $this->_messages = $this->_session->get('_messages');

        //基本的にエラーは引き継がないでリクエストのたびに消去
        $this->clear();
    }

    public function clear()
    {
        $this->_session->remove('_errors');
        $this->_session->remove('_olds');
        $this->_session->remove('_messages');
    }

    //==============================================================================
    // 現在のリクエストでエラーが生じたときに使うメソッド
    //==============================================================================
    public function setError($key, $message)
    {
        $this->set('_errors', $key, $message);
    }

    public function setOld($key, $message)
    {
        $this->set('_olds', $key, $message);
    }

    public function setMessage($key, $message)
    {
        $this->set('_message', $key, $message);
    }

    private function set($type, $key, $message)
    {
        $new_errors = $this->_session->get($type);
        $new_errors[$key] = $message;
        // FIXME: $_SESSION['errors']をシンプルに上書きできるなら消去は不要
        $this->_session->remove($type);
        $this->_session->set($type, $new_errors);
    }

    //==============================================================================
    // 前のページで生じたエラーをチェックするためのメソッド
    //==============================================================================
    public function errorsExist()
    {
        if (count($this->_errors) > 0) {
            return true;
        }
        return false;
    }

    public function oldsExist()
    {
        if (count($this->_olds) > 0) {
            return true;
        }
        return false;
    }

    public function messagesExist()
    {
        if (count($this->_messages) > 0) {
            return true;
        }
        return false;
    }


    //　全てのエラー取得(配列)
    // ------------------------------------------------------------------------
    public function getAllErrors()
    {
        return $this->_errors;
    }

    public function getAllOlds()
    {
        return $this->_olds;
    }

    public function getAllMessages()
    {
        return $this->_messages;
    }


    //　エラーの値を取得
    // ------------------------------------------------------------------------
    public function getError($key, $default = null)
    {
        if (isset($this->_errors[$key])) {
            return $this->_errors[$key];
        }
        return $default;
    }

    public function getOld($key, $default = null)
    {
        if (isset($this->_olds[$key])) {
            return $this->_olds[$key];
        }
        return $default;
    }

    public function getMessage($key, $default = null)
    {
        if (isset($this->_messages[$key])) {
            return $this->_messages[$key];
        }
        return $default;
    }
}