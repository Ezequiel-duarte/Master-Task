<?php
use App\Router;
use App\Controllers\TaskController;  
use App\Controllers\UserController;    
use App\Controllers\CategoryController;
use App\Controllers\AuthController; 

$router->get('/tasks', [TaskController::class, 'index']);
$router->get('/tasks/search', [TaskController::class, 'search']);
$router->get('/tasks/{id}', [TaskController::class, 'show']);
$router->post('/tasks', [TaskController::class, 'store']);
$router->put('/tasks/{id}', [TaskController::class, 'update']);
$router->delete('/tasks/{id}', [TaskController::class, 'destroy']);

$router->get('/users', [UserController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'show']);
$router->post('/users', [UserController::class, 'store']);
$router->delete('/users/{id}', [UserController::class, 'destroy']);

$router->get('/categories', [CategoryController::class, 'index']);
$router->get('/categories/search', [CategoryController::class, 'search']);
$router->get('/categories/{id}', [CategoryController::class, 'show']);
$router->post('/categories', [CategoryController::class, 'store']);
$router->delete('/categories/{id}', [CategoryController::class, 'destroy']);

$router->post('/login', [AuthController::class, 'login']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);