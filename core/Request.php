<?php

namespace Core;

class Request{
    private static $instance;
    private function __construct(){}
    public static function getInstance(){
        if(!is_object(self::$instance)){
            self::$instance = new Request;
        }
        foreach($_REQUEST as $key => $val){
            self::$instance->$key = $val;
        }
        return self::$instance;
    }
    public function url(){
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }
}