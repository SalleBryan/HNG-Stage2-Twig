<?php
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/View.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/TicketManager.php';
require_once __DIR__ . '/Controllers/HomeController.php';
require_once __DIR__ . '/Controllers/AuthController.php';
require_once __DIR__ . '/Controllers/DashboardController.php';
require_once __DIR__ . '/Controllers/TicketController.php';

// Initialize session theme if not set
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light';
}

// Initialize flash messages array if not set
if (!isset($_SESSION['flash'])) {
    $_SESSION['flash'] = [];
}
