<?php
namespace App\Controllers;
use Core\View;
use Core\Controller;
class BasicController extends Controller{
    function index(){
        return View::render('viewname');
    }
}
?>