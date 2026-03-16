<?php
namespace App;
class Router{

    private $routes = []; 

    public function get($uri, $callback): void{
        $this->routes['GET'][$uri] = $callback; // gurda la ruta recivida 
    }

    public function put($uri, $callback): void{
        $this->routes['PUT'][$uri] = $callback; 
    }

    public function post($uri, $callback): void{
        $this->routes['POST'][$uri] = $callback; 
    }

    public function delete($uri, $callback): void{
        $this->routes['DELETE'][$uri] = $callback; 
    }

    public function dispatch(string $uri, string $method, $body, $db){
         if (!isset($this->routes[$method])) {
             return  json_encode([
                'status' => 405,
                'message' => 'Method Not Allowed'
             ]);
        }
         foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $pattern = "#^{$pattern}$#";
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); 
                [$controller, $action] = $callback;
                $instance = new $controller($db);
                return json_encode($instance->$action($body, ...$matches));
            }
        }
        return json_encode([
         'status' => 404,
            'message' => 'Route not found'
        ]);
    }
}