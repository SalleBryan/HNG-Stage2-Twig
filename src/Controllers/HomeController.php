<?php
namespace App\Controllers;

use App\View;

class HomeController {
    public function index() {
        View::render('home.twig');
    }
}
