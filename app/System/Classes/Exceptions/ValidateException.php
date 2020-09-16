<?php


namespace App\System\Classes\Exceptions;


use Throwable;

class ValidateException extends \Exception
{
    private $errors;

    public function __construct($errors, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

}