<?php
namespace App\Controllers;
use Core\View;
use Core\Controller as BaseController;
class Controller extends BaseController{
    function index(){
        return View::render('viewname');
    }
}
?>