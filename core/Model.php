<?php
namespace Core;

class Model{
    private static $_this;
    protected $key;
    protected $table;
    function __construct(){
        self::$_this = $this;
        $this->key = isset($this->key) ? $this->key : 'id';
        $this->table = isset($this->table) ? $this->table : strtolower(str_replace('App\\Models\\', '', get_class($this))).'s';
    }
    function __destruct(){
        echo 'Closed';
    }
    static function where(){
        return self::$_this;
    }
}