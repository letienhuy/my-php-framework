<?php
function base_path(){
    return dirname(__DIR__);
}
function public_path(){
    return dirname($_SERVER['SCRIPT_FILENAME']);
}