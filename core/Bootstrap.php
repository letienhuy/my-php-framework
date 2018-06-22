<?php
error_reporting(E_ALL);
function base_path(){
    return dirname(__DIR__);
}
function public_path(){
    return dirname($_SERVER['SCRIPT_FILENAME']);
}
function dd($ext){
    echo '<pre>';
    var_dump($ext);
    echo '</pre>';
}