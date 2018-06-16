<?php
namespace Core;

class Model{
    private static $_this;
    private static $connect;
    protected $key;
    protected $table;
    private $config;
    function __construct(){
        self::$_this = $this;
        $this->config = App::getConfig();
        $this->key = isset($this->key) ? $this->key : 'id';
        $this->table = isset($this->table) ? $this->table : strtolower(str_replace('App\\Models\\', '', get_class($this))).'s';
    }
    function __destruct(){
    }
    private function connection($config){
        if(!self::$connect){
            $dsn = $config['driver'].':host='.$config['host'].';dbname='.$config['database'];
            $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                $db = new PDO($dsn, $config['username'], $config['password'], $options);
            } catch(PDOException $e) {
                throw new AppException();
            }
        }
        return self::$connect;
    }
    public static function where($query){
        return self::$_this;
    }
}