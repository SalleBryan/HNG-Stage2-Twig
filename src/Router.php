<?php
namespace App;

class Router {
    private $routes = [];
    
    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }
    
    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }
    
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            
            if (is_callable($handler)) {
                call_user_func($handler);
            } elseif (is_array($handler)) {
                [$controller, $method] = $handler;
                $instance = new $controller();
                call_user_func([$instance, $method]);
            }
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
