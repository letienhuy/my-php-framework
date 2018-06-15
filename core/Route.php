<?php
namespace Core;
use ReflectionMethod;
class Route{
    private static $routers = [];
    /**
     * GET Request Uri
     *
     * @return string
     */
    private function getRequestUri(){
        if(isset($_SERVER['REQUEST_URI'])){
            $uri = explode('/public/', $_SERVER['REQUEST_URI']);
            return '/'.end($uri);
        } else {
            return '/';
        }
    }
    /**
     * GET Request Method
     *
     * @return string
     */
    private function getRequestMethod(){
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        return $method;
    }
    /**
     * GET Query String
     *
     * @return string
     */
    private function getQueryString(){
        $query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
        return $query;
    }
    private function addRoute($method, $uri, $action){
        $uri = strpos($uri, '/') === 0 ? $uri : '/'.$uri;
        Route::$routers[] = [$method,$uri,$action];
    }
    /**
     * GET Method
     *
     * @return void
     */
    public static function get($uri, $action){
        self::addRoute('GET', $uri, $action);
    }
    /**
     * POST Method
     *
     * @return void
     */
    public static function post($uri, $action){
        self::addRoute('POST', $uri, $action);
    }
    /**
     * ANY Method
     *
     * @return void
     */
    public static function any($uri, $action){
        self::addRoute('GET|POST|PUT|DELETE', $uri, $action);
    }
    /**
     * Match method GET|POST|PUT|DELETE
     *
     * @param string $method
     * @param string $uri
     * @param string|Array|Clouse $action
     * @return void
     */
    public static function match($method, $uri, $action){
        self::addRoute($method, $uri, $action);
    }
    public function mapRoute(){
        $requestUri = $this->getRequestUri();
        $requestMethod = $this->getRequestMethod();
        $realUri = $this->getQueryString() ? explode('?', $requestUri)[0] : $requestUri;
        $isNotFound = true;
        foreach(self::$routers as $router){
            list($method,$uri,$action) = $router;
            $routerParams = [];
            $requestParams = [];
            if(strpos($method,$requestMethod) === FALSE){
                continue;
            }
            if(preg_match('/{\w+}/', $uri)){
                $requestParams = explode('/', $requestUri);
                $routerParams = explode('/', $uri);
                if(count($requestParams) !== count($routerParams)){
                    continue;
                }
            } else {
                if(strcmp(strtolower($realUri),strtolower($uri)) !== 0){
                    continue;
                }
            }
            $params = [];
            foreach($routerParams as $key => $val){
                if(preg_match('/{\w+}/', $val)){
                    $params[] = $requestParams[$key];
                }
            }
            if(is_callable($action)){
                call_user_func_array($action, $params);
                $isNotFound = false;
                return;
            }else{
                if(is_array($action)){
                    $action = explode('@', is_null($action['uses']) ? "" : $action['uses']);
                }else{
                    $action = explode('@', $action);
                }
                if(count($action) < 2){
                    throw new AppException();
                }
                list($controllerName,$methodName) = $action;
                $className = 'App\\Controllers\\'.$controllerName;
                if(!class_exists($className)){
                    throw new AppException();
                }
                $obj = new $className;
                if(!method_exists($obj, $methodName)){
                    throw new AppException();
                }
                $reflection = new ReflectionMethod($obj, $methodName);
                if(count($params) < $reflection->getNumberOfRequiredParameters()){
                    throw new AppException();
                }
                $isNotFound = false;
                call_user_func_array(array($obj,$methodName), $params);
                return;
            }
        }
        if($isNotFound){
            throw new AppException('404 Page not found!');
        }
    }
    public static function redirect($url, $httpResponseCode = 302){
        header('Location:'.$url, true, $httpResponseCode);
        exit();
    }
}