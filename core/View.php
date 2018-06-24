<?php
namespace Core;

class View{
    private function compileDirectoryViews($pathView = null){
        $pathView = $pathView ?? base_path().'/resources/views';
        $arrayDir = array_diff(scandir($pathView), array('.', '..'));
        foreach($arrayDir as $dir){
            if(is_dir($pathView.'/'.$dir)){
                $this->compileDirectoryViews($pathView.'/'.$dir);
            } else if(is_file($pathView.'/'.$dir)) {
                $viewPath = $pathView.'/'.$dir;
                $cachePath = base_path().'/storage/framework/views/'.sha1($viewPath).'.php';
                if(!file_exists($cachePath)){
                    $f = fopen($cachePath, 'w+');
                    fwrite($f, $this->compileViewContent($viewPath));
                } else {
                    if(filemtime($viewPath) > filemtime($cachePath)){
                        $f = fopen($cachePath, 'w+');
                        fwrite($f, $this->compileViewContent($viewPath));
                    } else {
                        continue;
                    }
                }
            } else {
                continue;
            }
        }
    }
    private function compileViewContent($viewPath){
        $viewContent = file_get_contents($viewPath);
        if(preg_match_all("/@include\('(.+?)'\)/", $viewContent, $matches)){
            foreach(array_combine($matches[0], $matches[1]) as $key => $val){
                $view = str_replace('.', '/', $val).'.php';
                $viewPath = base_path().'/resources/views/'.$view;
                $cachePath = base_path().'/storage/framework/views/'.sha1($viewPath).'.php';
                $viewContent = str_replace($key, "<?php include('$cachePath'); ?>", $viewContent);
            }
        }
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
        return $viewContent;
    }
    private function compileView($view, $data = []){
        $this->compileDirectoryViews();
        $view = str_replace('.', '/', $view).'.php';
        $viewPath = base_path().'/resources/views/'.$view;
        $cachePath = base_path().'/storage/framework/views/'.sha1($viewPath).'.php';
        if(file_exists($viewPath)){
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
            throw new AppException();
        }
    }
    private function debugViewError($errno, $errstr, $errf, $errl) {
        echo "<b>Error:</b>$errstr in line $errl";
    }

    public static function render($view, $data = []){
        echo (new View)->compileView($view, $data);
    }
    public static function exist($view){
        $view = str_replace('.', '/', $view).'.php';
        $viewPath = base_path().'/resources/views/'.$view;
        if(file_exists($viewPath))
            return true;
        return false;
    }
}
?>