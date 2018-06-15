<?php
namespace Core;

class View{
    private function compileViewContent($viewPath, $cachePath){
        $f = fopen($cachePath, 'w+');
        $viewContent = file_get_contents($viewPath);
        if(preg_match_all('/{{(.+?)}}/', $viewContent, $matches)){
            foreach(array_combine($matches[0], $matches[1]) as $key => $val){
                $viewContent = str_replace($key, "<?php echo($val); ?>", $viewContent);
            }
        }
        if(preg_match_all('/{php}(.+?){\/php}/s', $viewContent, $matches)){
            foreach(array_combine($matches[0], $matches[1]) as $key => $val){
                $viewContent = str_replace($key, "<?php $val ?>", $viewContent);
            }
        }
        fwrite($f, $viewContent);
        fclose($f);
    }
    private function compileView($view, $data = []){
        $view = str_replace('.', '/', $view).'.php';
        $viewPath = base_path().'/resources/views/'.$view;
        $cachePath = base_path().'/storage/framework/views/'.sha1($view).'.php';
        if(file_exists($viewPath)){
            if(!file_exists($cachePath)){
                try{
                    self::compileViewContent($viewPath, $cachePath);
                } catch(Exception $e){
                    throw new AppException();
                }
            }elseif(filemtime($viewPath) > filemtime($cachePath)){
                self::compileViewContent($viewPath, $cachePath);                
            }
            ob_start();
            if(is_array($data)){
                extract($data);
            }
            set_error_handler([new self, "debugViewError"]);
            require($cachePath);
            return ob_get_clean();
        } else {
            if(file_exists($cachePath)){
                unlink($cachePath);
            }
            throw new AppException('View not found!');
        }
    }
    private function debugViewError($errno, $errstr, $errf, $errl) {
        echo "<b>Error:</b>$errstr in line $errl";
    }

    public static function render($view, $data = []){
        echo (new View)->compileView($view, $data);
    }
}
?>