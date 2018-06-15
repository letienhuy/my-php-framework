<?php

namespace Core;

class App{
    private static $config;
    public static function setConfig($config){
        self::$config = $config;
    }
    public static function getConfig(){
        return self::$config;
    }
    public static function run(){
        $config = require_once('../config/config.php');
        self::setConfig($config);
        $route = new Route;
        $route->mapRoute();
    }
}