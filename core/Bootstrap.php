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
function url($url = null){
    return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_FILENAME'])).'/'.$url;
}
function asset($asset){
    return url().'/'.$asset;
}