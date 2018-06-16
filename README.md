# My simple php framework
__Framework theo mô hình MVC__

_System require_
+ PHP >= 5.6
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
use Core\Controller;
class BasicController extends Controller{
    function index(){
        return View::render('viewname');
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
