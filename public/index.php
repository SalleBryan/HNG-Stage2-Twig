<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\TicketController;

$router = new Router();

// Public routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/auth/login', [AuthController::class, 'showLogin']);
$router->post('/auth/login', [AuthController::class, 'login']);
$router->get('/auth/signup', [AuthController::class, 'showSignup']);
$router->post('/auth/signup', [AuthController::class, 'signup']);
$router->get('/auth/logout', [AuthController::class, 'logout']);

// Protected routes
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/tickets', [TicketController::class, 'index']);
$router->post('/tickets/create', [TicketController::class, 'create']);
$router->post('/tickets/update', [TicketController::class, 'update']);
$router->post('/tickets/delete', [TicketController::class, 'delete']);

// Theme toggle
$router->post('/theme/toggle', function() {
    $_SESSION['theme'] = $_SESSION['theme'] === 'dark' ? 'light' : 'dark';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
});

$router->dispatch();
