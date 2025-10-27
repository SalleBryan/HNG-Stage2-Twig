<?php
namespace App;

class Auth {
    private const USERS_FILE = __DIR__ . '/../data/users.json';
    
    public static function login($email, $password) {
        $users = self::getUsers();
        
        foreach ($users as $user) {
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
                return true;
            }
        }
        
        return false;
    }
    
    public static function signup($name, $email, $password) {
        $users = self::getUsers();
        
        // Check if email already exists
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return false;
            }
        }
        
        $newUser = [
            'id' => uniqid(),
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'createdAt' => date('c')
        ];
        
        $users[] = $newUser;
        self::saveUsers($users);
        
        $_SESSION['user_id'] = $newUser['id'];
        $_SESSION['user'] = [
            'id' => $newUser['id'],
            'name' => $newUser['name'],
            'email' => $newUser['email']
        ];
        
        return true;
    }
    
    public static function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user']);
    }
    
    public static function check() {
        return isset($_SESSION['user_id']);
    }
    
    public static function user() {
        return $_SESSION['user'] ?? null;
    }
    
    public static function requireAuth() {
        if (!self::check()) {
            View::redirect('/auth/login');
        }
    }
    
    private static function getUsers() {
        if (!file_exists(self::USERS_FILE)) {
            self::ensureDataDirectory();
            file_put_contents(self::USERS_FILE, '[]');
            return [];
        }
        
        return json_decode(file_get_contents(self::USERS_FILE), true) ?? [];
    }
    
    private static function saveUsers($users) {
        self::ensureDataDirectory();
        file_put_contents(self::USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
    }
    
    private static function ensureDataDirectory() {
        $dir = __DIR__ . '/../data';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}
