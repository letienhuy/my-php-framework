<?php
namespace Core;
use \Exception;

class AppException extends Exception{
    function __construct($message = null, $code = null){
        parent::__construct($message, $code);
        set_exception_handler([$this, 'handlerException']);
    }
    function handlerException($e){
        require(base_path().'/core/cache/errors/9fa134a7ae979845fde599480595db95dcd0ff78.php');
        die();
    }
}

