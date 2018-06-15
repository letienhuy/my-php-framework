<?php
require_once('Bootstrap.php');
class Autoload{
    public function __construct() {
        spl_autoload_register(array($this, 'loader'));
    }
    private function loader($className) {
        $filePath = base_path().'/'.strtolower($className).'.php';
        if(file_exists($filePath)){
            require_once($filePath);
        }
    }
    public function getLoaded(){
        return $this->loaded;
    }
}
$autoload = new Autoload();
require_once(base_path().'/routes/routes.php');