# My simple php framework
__Framework theo mô hình MVC__

_System require_
+ PHP >= 7.0
+ PDO extension
+ JSON PHP Extension
+ XML PHP Extension
+ Mbstring Extension

_Routing_

+ Basic Routing
```php
Route::get('/', function(){
  echo 'Hello World';
});
```
```php
Route::get('/', 'HomeController@index');
```

  Trong đó __HomeController__ là tên Controller và __index__ là tên method
+ Router Parameters
```php
Route::get('user/{id}', function ($id) {
    echo 'User '.$id;
});
```
```php
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});
```

_Controller_

```php
<?php
namespace App\Controllers;
use Core\View;
use Core\Controller as BaseController;
class Controller extends BaseController{
    function index(){
        return View::render('path.viewname');
    }
}
?>
```

_Views_
```php
{{$variable}} = <?php echo($variable); ?>
{php}
//php code here
{/php}
```

_Model_
```php
<?php

namespace App\Models;
use Core\Model;
class User extends Model{
    /**
     * Primary key of table
    */
    protected $key;
    /**
     * Table name, default is name of class (Ex: users);
    */
    protected $table;
}
?>
```
```php
//How to use in Controller
<?php
namespace App\Controllers;
use Core\View;
use Core\Controller as BaseController;
use App\Models\User;
class Controller extends BaseController{
    function index(){
        $user = User::where('id', 1); //select * form users where id=1
        $user = User::where([['id', '=', 1], ['name', '=', 'Admin']]); //select * form users where id=1 and name=Admin
        return View::render('path.viewname');
    }
}
?>
```

```
