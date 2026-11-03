# URL Shortener

A multi-company URL shortening application built with Laravel. It supports company-based user management, role-based access control, URL creation, and public short-link redirection.

## Features

- Multi-company architecture.
- Role-based access using Spatie Laravel Permission.
- **SuperAdmin:** Manage companies and invitations, with access to short URLs across companies in a read-only view.
- **Admin:** Invite Admins and Members, and manage short URLs within their company.
- **Member:** Create short URLs and view only their own URLs.
- Public short-link redirection without authentication.
- Invitation acceptance with token validation and expiration.
- Bootstrap-based interface.
- Automated tests for permissions and public redirects.

## Tech Stack

- PHP
- Laravel
- Laravel Jetstream and Fortify
- Livewire
- Spatie Laravel Permission
- SQLite
- Bootstrap 5

## Requirements

Install the following before setting up the project:

- PHP version compatible with the Laravel version specified in `composer.json`
- Composer
- Node.js and npm
- Git

## Installation

### 1. Clone the repository

```bash
git clone <YOUR_GITHUB_REPOSITORY_URL>
cd url-shortner
```

Replace `<YOUR_GITHUB_REPOSITORY_URL>` with your repository URL.

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure the environment

Copy the example environment file.

**Windows PowerShell:**

```powershell
Copy-Item .env.example .env
```

**Linux/macOS:**

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Configure the database

This project can use SQLite for local development.

Create the database file if it does not exist.

**Windows PowerShell:**

```powershell
New-Item database/database.sqlite -ItemType File
```

Configure the following values in `.env`:

```dotenv
DB_CONNECTION=sqlite
```

Ensure the `DB_DATABASE` setting, if present, points to the correct absolute path for your local SQLite database.

### 5. Run migrations and seeders

```bash
php artisan migrate --seed
```

The seeders should create the required roles. If your development seeder creates a default SuperAdmin account, configure its credentials securely for your local environment.

### 6. Install frontend dependencies

```bash
npm install
```

### 7. Start the application

Open two terminals from the project directory.

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

Open the URL printed by `php artisan serve`, usually:

`http://127.0.0.1:8000`

## User Roles and Permissions

| Role | Permissions |
|---|---|
| SuperAdmin | Invite Admins for companies, view all companies, view short URLs across companies, cannot create short URLs |
| Admin | Invite Admins and Members in their company, view company short URLs, create short URLs |
| Member | Create short URLs and view only their own short URLs |

All generated short links should redirect publicly to their original destinations.

## Running Tests

Run the automated test suite:

```bash
php artisan test
```

## Git Setup

Check the files before committing:

```bash
git status
```

Ensure `.env`, credentials, database files containing local data, and other secrets are not committed.

Then commit your changes:

```bash
git add README.md
git commit -m "docs: add project setup instructions"
git push origin main
```

If your default branch is not `main`, replace it with the correct branch name.

## Security Notes

- Never commit `.env` or production credentials.
- Do not publish real user passwords or invitation tokens.
- Configure development accounts using local-only credentials.
- Invitation links should be treated as sensitive and should expire.

## AI Usage Disclosure

ChatGPT was used to assist with UI design and visual layout suggestions.

## License

