<?php
namespace App\Controllers;

use App\View;
use App\Auth;

class AuthController {
    public function showLogin() {
        if (Auth::check()) {
            View::redirect('/dashboard');
        }
        View::render('auth/login.twig');
    }
    
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (Auth::login($email, $password)) {
            View::flash('Welcome back!', 'success');
            View::redirect('/dashboard');
        } else {
            View::flash('Invalid email or password', 'error');
            View::redirect('/auth/login');
        }
    }
    
    public function showSignup() {
        if (Auth::check()) {
            View::redirect('/dashboard');
        }
        View::render('auth/signup.twig');
    }
    
    public function signup() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        
        // Validation
        $errors = [];
        
        if (empty($name) || strlen($name) < 2) {
            $errors['name'] = 'Name must be at least 2 characters';
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        
        if (empty($password) || strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }
        
        if ($password !== $confirmPassword) {
            $errors['confirmPassword'] = 'Passwords do not match';
        }
        
        if (!empty($errors)) {
            View::render('auth/signup.twig', ['errors' => $errors, 'old' => $_POST]);
            return;
        }
        
        if (Auth::signup($name, $email, $password)) {
            View::flash('Account created successfully!', 'success');
            View::redirect('/dashboard');
        } else {
            View::flash('Email already exists', 'error');
            View::redirect('/auth/signup');
        }
    }
    
    public function logout() {
        Auth::logout();
        View::flash('You have been logged out', 'success');
        View::redirect('/');
    }
}
