<?php
use Core\Route;
use Core\View;
use Core\Request;

Route::get('/a/{id}', function(){
    return View::render('wellcome');
});