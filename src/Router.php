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

    public function dispatch($uri, $method){

    }
}