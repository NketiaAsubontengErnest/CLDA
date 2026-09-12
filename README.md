# CLDA Website

A custom PHP MVC web application for the Center for Learning Disabilities (CLD). The site provides public information, educational resources, research material, events, and a test assessment flow for learning disability screening and support services.

## Overview

This project includes:

- Public pages for About, Services, Resources, Advocacy, Understand, News, Contact, and Get Involved
- Research and media listings with file uploads
- Event management
- Downloadable resource materials
- Assessment/test intake and reporting flow
- Admin dashboard for managing website content and assessments
- Paystack-based payment integration for assessments

## Tech Stack

- PHP
- MySQL / MariaDB
- Custom MVC architecture (no framework)
- Native PHP session handling
- PHPMailer for email notifications
- Paystack payment gateway integration

## Project Structure

```text
CLDA/
├── app/
│   ├── controllers/
│   ├── core/
│   ├── models/
│   └── views/
├── config/
│   └── app.php
├── public/
│   ├── assets/
│   ├── css/
│   ├── js/
│   ├── phpmailer/
│   └── index.php
├── uploads/
├── database_schema.sql
├── index.php
├── public/index.php
├── README.md
└── .gitignore (if present)
```

## Requirements

- PHP 7.4+
- MySQL 5.7+ or MariaDB
- Apache or XAMPP/WAMP/LAMP local stack
- Composer is not required for this project

## Local Setup

1. Place the project in your web server document root.
   - For XAMPP, this is usually:
     `C:\xampp\htdocs\CLDA`

2. Start Apache and MySQL in XAMPP.

3. Create the database:
   - Database name: `clda_db`
   - Username: `root`
   - Password: empty (default local XAMPP setup)

4. Import the schema:
   ```bash
   mysql -u root -p clda_db < database_schema.sql
   ```
   Or use phpMyAdmin and import `database_schema.sql` manually.

5. Open the app in a browser:
   ```text
   http://localhost/CLDA
   ```

The app entry point is `public/index.php`, and the project root `index.php` forwards requests there.

## Database Configuration

Database connection settings are defined in:

- `app/core/Database.php`

If needed, update the DB host, name, username, and password for your environment.

## Admin Access

After setting up the database, create an admin user in the `users` table, then log in at:

```text
http://localhost/CLDA/admin/login
```

Example SQL to create a local admin user:

```sql
INSERT INTO users (username, password)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/9vb9m7zE.4a6m');
```

The example above uses the hash for the password `password`.

## Main Features

### Public-facing content

- Home page
- About CLD and organizational mission
- Services and programs
- Research and educational resource pages
- Advocacy and understanding pages
- News and events listings
- Contact form / general inquiry flow

### Assessment workflow

- Browse available tests
- Take a test intake form
- Record answers and scoring data
- Handle payment via Paystack
- Complete submission and report access workflow

### Admin panel

The admin area supports:

- Dashboard
- User profile management
- Manage news
- Manage research
- Manage media
- Manage downloads
- Manage events
- Manage test-related content and assessments

## Routing Model

The app uses a lightweight custom router implemented in:

- `app/core/App.php`

URL format is similar to:

```text
http://localhost/CLDA/home
http://localhost/CLDA/about
http://localhost/CLDA/tests
http://localhost/CLDA/admin/login
```

Controller classes are resolved from the `app/controllers` folder.

## Important Notes

- This project uses local file uploads under `uploads/` and should be writable by the web server.
- Ensure the upload folders are writable, especially:
  - `uploads/news/`
  - `uploads/research/`
  - `uploads/media/`
  - `uploads/downloads/`
- Email sending is configured directly in `app/controllers/TestController.php`.
- Paystack secret/public keys are stored in the database via settings.

## Security Reminder

This project was built for a local educational website and contains direct database and email credentials in code. Before production deployment:

- move secrets to environment variables or a secure config layer
- restrict admin access
- validate file uploads and user input more strictly
- review Paystack and email integration configuration

## License

This project is provided for internal use and project delivery. Please confirm licensing requirements with the project owner before public or commercial deployment.

## Support

For local troubleshooting, check:

- Apache is running
- MySQL is running
- `clda_db` exists in the database server
- `uploads/` directories are writable
- `app/core/Database.php` matches your local environment
