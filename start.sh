#!/bin/bash

# Ticket Platform - Start Script

echo "🎫 Starting Ticket Platform..."

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install it from https://getcomposer.org/"
    exit 1
fi

# Check if vendor directory exists
if [ ! -d "vendor" ]; then
    echo "📦 Installing dependencies..."
    composer install
fi

# Create data directory if it doesn't exist
if [ ! -d "data" ]; then
    echo "📁 Creating data directory..."
    mkdir -p data
    chmod 755 data
fi

# Start PHP server
echo "✅ Starting PHP development server on http://localhost:8000"
echo "Press Ctrl+C to stop the server"
php -S localhost:8000 -t public
