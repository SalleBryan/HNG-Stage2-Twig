<?php
namespace App;

class TicketManager {
    private const TICKETS_FILE = __DIR__ . '/../data/tickets.json';
    
    public static function getTickets($userId) {
        $tickets = self::getAllTickets();
        return array_filter($tickets, fn($t) => $t['userId'] === $userId);
    }
    
    public static function createTicket($userId, $title, $description, $priority) {
        $tickets = self::getAllTickets();
        
        $newTicket = [
            'id' => uniqid(),
            'userId' => $userId,
            'title' => $title,
            'description' => $description,
            'status' => 'open',
            'priority' => $priority,
            'createdAt' => date('c'),
            'updatedAt' => date('c')
        ];
        
        $tickets[] = $newTicket;
        self::saveTickets($tickets);
        
        return $newTicket;
    }
    
    public static function updateTicket($userId, $ticketId, $updates) {
        $tickets = self::getAllTickets();
        
        foreach ($tickets as &$ticket) {
            if ($ticket['id'] === $ticketId && $ticket['userId'] === $userId) {
                $ticket = array_merge($ticket, $updates, ['updatedAt' => date('c')]);
                self::saveTickets($tickets);
                return $ticket;
            }
        }
        
        return null;
    }
    
    public static function deleteTicket($userId, $ticketId) {
        $tickets = self::getAllTickets();
        $filtered = array_filter($tickets, fn($t) => !($t['id'] === $ticketId && $t['userId'] === $userId));
        
        if (count($filtered) < count($tickets)) {
            self::saveTickets(array_values($filtered));
            return true;
        }
        
        return false;
    }
    
    private static function getAllTickets() {
        if (!file_exists(self::TICKETS_FILE)) {
            self::ensureDataDirectory();
            file_put_contents(self::TICKETS_FILE, '[]');
            return [];
        }
        
        return json_decode(file_get_contents(self::TICKETS_FILE), true) ?? [];
    }
    
    private static function saveTickets($tickets) {
        self::ensureDataDirectory();
        file_put_contents(self::TICKETS_FILE, json_encode($tickets, JSON_PRETTY_PRINT));
    }
    
    private static function ensureDataDirectory() {
        $dir = __DIR__ . '/../data';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}
