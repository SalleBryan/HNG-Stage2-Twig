@echo off
REM Ticket Platform - Start Script for Windows

echo Starting Ticket Platform...

REM Check if composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Composer is not installed. Please install it from https://getcomposer.org/
    exit /b 1
)

REM Check if vendor directory exists
if not exist "vendor" (
    echo Installing dependencies...
    composer install
)

REM Create data directory if it doesn't exist
if not exist "data" (
    echo Creating data directory...
    mkdir data
)

REM Start PHP server
echo Starting PHP development server on http://localhost:8000
echo Press Ctrl+C to stop the server
php -S localhost:8000 -t public
