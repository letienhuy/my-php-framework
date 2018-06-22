<?php
namespace App\Controllers;
use Core\View;
use Core\Controller as BaseController;
use App\Models\User;
class Controller extends BaseController{
    function index(){
       dd(User::where([['id', '=', 1]])->first());
    }
}
?>