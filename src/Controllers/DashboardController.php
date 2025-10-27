<?php
namespace App\Controllers;

use App\View;
use App\Auth;
use App\TicketManager;

class DashboardController {
    public function index() {
        Auth::requireAuth();
        
        $user = Auth::user();
        $tickets = TicketManager::getTickets($user['id']);
        
        $stats = [
            'total' => count($tickets),
            'open' => count(array_filter($tickets, fn($t) => $t['status'] === 'open')),
            'inProgress' => count(array_filter($tickets, fn($t) => $t['status'] === 'in-progress')),
            'closed' => count(array_filter($tickets, fn($t) => $t['status'] === 'closed'))
        ];
        
        $recentTickets = array_slice($tickets, 0, 5);
        
        View::render('dashboard.twig', [
            'stats' => $stats,
            'recentTickets' => $recentTickets
        ]);
    }
}
