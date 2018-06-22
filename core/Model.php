<?php
namespace Core;
use PDO;
class Model{
    protected static $connect;
    private static $result;
    protected $key = 'id';
    protected $table;
    function __construct(){
        $this->table = isset($this->table) ? $this->table : strtolower(str_replace('App\\Models\\','',get_class($this))).'s';
    }
    protected function connection(){
        $config = App::getConfig()['connections'];
        if(!self::$connect){
            $dsn = $config['driver'].':hos='.$config['host'].';dbname='.$config['database'];
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                self::$connect = new PDO($dsn, $config['username'], $config['password'], $options);
            } catch(PDOException $e) {
                throw new AppException('Connection failed!');
            }
        }
        return true;
    }
    public function first(){
        return is_array(self::$result) ? self::$result[0] : (object)[];
    }
    public function get(){
        return isset(self::$result) ? self::$result : (object)[];
    }
    public static function where($where, $condition = null){
        (new static)->connection();
        $executeQuery = 'select * from '.(new static)->table.' where ';
        if(is_array($where) && is_null($condition)){
            foreach($where as $arr){
                if(!is_array($arr) || count($arr) < 3){
                    throw new AppException();
                }
                $executeQuery .= "`{$arr[0]}`{$arr[1]}'{$arr[2]}' and ";
            }
            $executeQuery = trim($executeQuery, 'and ');
        } else {
            $executeQuery .= $where.' = '.$condition;
        }
        try{
            $sth = static::$connect->prepare($executeQuery);
            $sth->execute();
            self::$result = $sth->fetchAll(PDO::FETCH_OBJ);
        } catch(\PDOException $e){
            throw new AppException($e->getMessage());
        }
        return (new static);
    }
}