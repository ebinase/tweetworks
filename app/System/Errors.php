<?php

namespace App\System;

use App\System\Interfaces\ErrorsInterface;

class Errors implements ErrorsInterface
{
    private $_errors = [];
    private $_session;

    //Sessionクラスに依存
    public function __construct($session)
    {
        $this->_session = $session;

        $this->_errors = $this->_session->get('errors');
        //基本的にエラーは引き継がないでリクエストのたびに消去
        $this->clearErrors();
    }

    public function clearErrors()
    {
        $this->_session->remove('errors');
    }


    //==============================================================================
    // 前のページで生じたエラーをチェックするためのメソッド
    //==============================================================================
    public function getMessage($key, $default = null)
    {
        if (isset($this->_errors[$key])) {
            return $this->_errors[$key];
        }
        return $default;
    }

    /**
     *
     * @return array $errors
     */
    public function getAllErrors()
    {
        return $this->_errors;
    }

    /**
     * エラー自体が存在するか
     *
     * @return bool
     */
    public function errorExists()
    {
        if (count($this->_errors) === 0) {
            return false;
        }
        return true;
    }

    public function hasError($key)
    {
        return isset($this->_errors[$key]);
    }

    //==============================================================================
    // 現在のリクエストでエラーが生じたときに使うメソッド
    //==============================================================================
    public function set($key, $message)
    {
        $new_errors = $this->_session->get('errors');
        $new_errors[$key] = $message;
        // FIXME: $_SESSION['errors']をシンプルに上書きできるなら消去は不要
        $this->clearErrors();
        $this->_session->set('errors', $new_errors);
    }

}