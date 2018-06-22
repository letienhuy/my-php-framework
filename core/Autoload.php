<?php
require_once('Bootstrap.php');
class Autoload{
    public function __construct() {
        spl_autoload_register(array($this, 'loader'));
    }
    private function loader($className) {
        $className = str_replace('\\','/',$className);
        $className = str_replace('Core/','core/',$className);
        $className = str_replace('App/','app/',$className);
        $filePath = base_path().'/'.$className.'.php';
        if(file_exists($filePath)){
            require_once($filePath);
        }
    }
}
$autoload = new Autoload();
require_once(base_path().'/routes/routes.php');