<?php
namespace App\Controllers;

use App\View;
use App\Auth;
use App\TicketManager;

class TicketController {
    public function index() {
        Auth::requireAuth();
        
        $user = Auth::user();
        $tickets = TicketManager::getTickets($user['id']);
        
        // Apply filters
        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';
        
        if ($filter !== 'all') {
            $tickets = array_filter($tickets, fn($t) => $t['status'] === $filter);
        }
        
        if (!empty($search)) {
            $search = strtolower($search);
            $tickets = array_filter($tickets, function($t) use ($search) {
                return str_contains(strtolower($t['title']), $search) ||
                       str_contains(strtolower($t['description']), $search) ||
                       str_contains(strtolower($t['priority']), $search);
            });
        }
        
        $stats = [
            'total' => count(TicketManager::getTickets($user['id'])),
            'open' => count(array_filter(TicketManager::getTickets($user['id']), fn($t) => $t['status'] === 'open')),
            'inProgress' => count(array_filter(TicketManager::getTickets($user['id']), fn($t) => $t['status'] === 'in-progress')),
            'closed' => count(array_filter(TicketManager::getTickets($user['id']), fn($t) => $t['status'] === 'closed')),
            'highPriority' => count(array_filter(TicketManager::getTickets($user['id']), fn($t) => $t['priority'] === 'high')),
            'mediumPriority' => count(array_filter(TicketManager::getTickets($user['id']), fn($t) => $t['priority'] === 'medium')),
            'lowPriority' => count(array_filter(TicketManager::getTickets($user['id']), fn($t) => $t['priority'] === 'low'))
        ];
        
        View::render('tickets/index.twig', [
            'tickets' => array_values($tickets),
            'stats' => $stats,
            'filter' => $filter,
            'search' => $search
        ]);
    }
    
    public function create() {
        Auth::requireAuth();
        
        $user = Auth::user();
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $priority = $_POST['priority'] ?? 'medium';
        
        TicketManager::createTicket($user['id'], $title, $description, $priority);
        View::flash('Ticket created successfully!', 'success');
        View::redirect('/tickets');
    }
    
    public function update() {
        Auth::requireAuth();
        
        $user = Auth::user();
        $ticketId = $_POST['id'] ?? '';
        
        $updates = [];
        if (isset($_POST['title'])) $updates['title'] = $_POST['title'];
        if (isset($_POST['description'])) $updates['description'] = $_POST['description'];
        if (isset($_POST['status'])) $updates['status'] = $_POST['status'];
        if (isset($_POST['priority'])) $updates['priority'] = $_POST['priority'];
        
        TicketManager::updateTicket($user['id'], $ticketId, $updates);
        View::flash('Ticket updated successfully!', 'success');
        View::redirect('/tickets');
    }
    
    public function delete() {
        Auth::requireAuth();
        
        $user = Auth::user();
        $ticketId = $_POST['id'] ?? '';
        
        TicketManager::deleteTicket($user['id'], $ticketId);
        View::flash('Ticket deleted successfully!', 'success');
        View::redirect('/tickets');
    }
}
