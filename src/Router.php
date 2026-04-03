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
        try {
            if (!isset($this->routes[$method])) {
                return $this->jsonResponse(['error' => 'Method Not Allowed'], 405);
            }
            foreach ($this->routes[$method] as $route => $callback) {
                $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
                $pattern = "#^{$pattern}$#";
                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches);
                    [$controller, $action] = $callback;
                    $instance = new $controller($db);
                    $result = $instance->$action($body, ...$matches);
                    return $this->jsonResponse($result, 200);
                }
            }
            return $this->jsonResponse(['error' => 'Route not found'], 404);
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 500;
            $message = $e->getMessage();
            $errorData = json_decode($message, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $this->jsonResponse($errorData, $code);
            }
            return $this->jsonResponse(['error' => $message], $code);
        }
    }

    private function jsonResponse($data, int $code): string{
        http_response_code($code);
        header('Content-Type: application/json');
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
  
}