# TicketFlow - PHP/Twig Version

A beautiful ticket management system built with PHP and Twig templating engine.

## Requirements

- PHP 8.0 or higher
- Composer
- Apache or Nginx web server

## Installation

1. Install dependencies:
\`\`\`bash
composer install
\`\`\`

2. Configure your web server to point to the `public` directory as the document root.

3. Ensure the `data` directory is writable:
\`\`\`bash
chmod 755 data
\`\`\`

## Features

- User authentication (signup/login)
- Ticket CRUD operations
- Dashboard with statistics
- Search and filter tickets
- Light/dark theme toggle
- Session-based authentication
- File-based data storage (JSON)

## Project Structure

\`\`\`
├── public/              # Public web root
│   ├── index.php       # Application entry point
│   ├── styles/         # CSS files
│   └── js/             # JavaScript files
├── src/                # PHP source code
│   ├── Controllers/    # Controller classes
│   ├── Auth.php        # Authentication logic
│   ├── TicketManager.php # Ticket management
│   ├── Router.php      # Routing system
│   └── View.php        # View rendering
├── templates/          # Twig templates
│   ├── layout.twig     # Base layout
│   ├── components/     # Reusable components
│   ├── auth/           # Authentication pages
│   └── tickets/        # Ticket pages
└── data/               # Data storage (JSON files)
\`\`\`

## Usage

### Quick Start (Development)

The easiest way to run the application locally:

\`\`\`bash
# Install dependencies
composer install

# Start the built-in PHP development server
php -S localhost:8000 -t public
\`\`\`

Or use the provided start scripts:
- **Unix/Mac/Linux**: `./start.sh`
- **Windows**: `start.bat`

Then open your browser to [http://localhost:8000](http://localhost:8000)

### Using the Application

1. Navigate to your application URL
2. Sign up for a new account
3. Start creating and managing tickets!

## Security Notes

For production use:
- Use a proper database instead of JSON files
- Enable Twig template caching
- Use HTTPS
- Implement CSRF protection
- Add rate limiting
- Use environment variables for sensitive configuration

## License

MIT License - feel free to use this project for learning and development purposes.
