<?php
use Core\Route;
use Core\View;
use Core\Request;

Route::get('/', function(){
    return View::render('wellcome');
});