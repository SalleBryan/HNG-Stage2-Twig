<?php
namespace App;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View {
    private static $twig;
    
    public static function init() {
        if (!self::$twig) {
            $loader = new FilesystemLoader(__DIR__ . '/../templates');
            self::$twig = new Environment($loader, [
                'cache' => false, // Set to a path for production
                'debug' => true,
            ]);
            
            // Add global variables
            self::$twig->addGlobal('session', $_SESSION);
            self::$twig->addGlobal('user', Auth::user());
            self::$twig->addGlobal('theme', $_SESSION['theme'] ?? 'light');
        }
        
        return self::$twig;
    }
    
    public static function render($template, $data = []) {
        $twig = self::init();
        
        // Get flash messages
        $flash = $_SESSION['flash'] ?? [];
        $_SESSION['flash'] = [];
        
        $data['flash'] = $flash;
        
        echo $twig->render($template, $data);
    }
    
    public static function redirect($path) {
        header("Location: $path");
        exit;
    }
    
    public static function flash($message, $type = 'success') {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][] = ['message' => $message, 'type' => $type];
    }
}
