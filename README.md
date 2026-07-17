# PawsBank Backend Portfolio

PawsBank is a portfolio application built around shared financial accounts and receipt data. The repository contains a Laravel backend with a token-authenticated JSON API, a relational domain model, and a React interface delivered through Inertia.js.

The implemented API covers authentication and shared-account management. The receipt-oriented portion of the domain is represented by database migrations, Eloquent models, typed data objects, and factories; receipt CRUD endpoints and user-facing receipt workflows are not present in the current codebase.

## Architecture

The application lives in [`backend-web`](backend-web) and follows Laravel's conventional layered structure:

- **HTTP layer:** web, settings, and API routes dispatch to focused controllers. Laravel Fortify provides the browser authentication routes, while Sanctum protects the JSON API.
- **Application layer:** `AccountService` centralizes account membership operations and role checks used by the API controller.
- **Domain and persistence:** Eloquent models define users, accounts, memberships, invitations, receipts, receipt items and images, products, and localized item categories. Migrations enforce foreign keys, composite and unique constraints, and cascade/null-on-delete behavior.
- **Representation layer:** immutable Spatie Laravel Data classes provide explicit response shapes and preserve decimal values as strings.
- **Web presentation:** Laravel renders a single Blade shell; Inertia maps server routes to React pages. Wayfinder generates typed route/controller bindings used by the frontend.

Both the browser interface and `/api` routes use the same Laravel application and database. Browser authentication is session-based; API clients receive Sanctum personal access tokens and send them as bearer tokens.

## Technology stack

### Backend

- PHP 8.3+
- Laravel 13
- Laravel Sanctum 4 for API tokens
- Laravel Fortify 1 for registration, login, password reset, email verification, password confirmation, and TOTP two-factor authentication
- Eloquent ORM and database migrations
- Spatie Laravel Data 4 for typed data-transfer objects
- PHPUnit 12, Laravel model factories, and an in-memory SQLite test database
- Laravel Pint for PHP formatting

### Frontend

- React 19 and TypeScript
- Inertia.js 3
- Vite 8
- Tailwind CSS 4
- Radix UI primitives, Headless UI, and Lucide icons
- ESLint and Prettier

## Backend capabilities

### JSON API

Public endpoints support registration and login. Registration creates a user, a default USD account, an `owner` membership, and an API token. Authenticated clients can revoke their current token on logout.

Authenticated account endpoints support:

- listing only the accounts associated with the current user;
- creating an account and assigning its creator as owner;
- updating an account when the caller is a member;
- deleting an account when the caller is its owner;
- creating a seven-day pending invitation for an existing user when the caller is an owner or admin;
- removing another member when the caller is an owner or admin.

Validation errors use Laravel's JSON validation responses. Account access checks return not-found or forbidden responses according to the controller logic. Invitation acceptance and role-management endpoints are not implemented.

### Browser application

The Inertia interface includes registration, login, password reset, email-verification and two-factor challenge pages; an authenticated dashboard; profile editing and deletion; password updates; TOTP setup and recovery codes; and persisted light, dark, or system appearance preferences. The landing page and dashboard remain starter-style screens rather than account or receipt management interfaces.

### Receipt domain foundation

The schema models account-owned receipts with receipt categories, scanner attribution, monetary and tax fields, payment metadata, image ordering, and line items. Line items can reference products and localized item categories. Foreign-key behavior is declared in the migrations, and model factories support test-data construction. No receipt routes or controllers are currently registered.

## Local setup

### Prerequisites

- PHP 8.3 or later with the extensions required by Laravel and SQLite support
- Composer
- Node.js and npm

From the repository root:

```bash
cd backend-web
touch database/database.sqlite
composer run setup
```

The Composer setup script installs PHP dependencies, creates `.env` from `.env.example` when needed, generates the application key, runs migrations, installs JavaScript dependencies, and creates a production frontend build. The example environment uses SQLite plus database-backed sessions, cache, and queues; outbound mail is written to the log.

Start the development processes with:

```bash
composer run dev
```

This starts Laravel's development server, the database queue listener, the Pail log viewer, and Vite. The application is served at the URL printed by the Laravel process (normally `http://127.0.0.1:8000`).

To load the included development user fixture, run `php artisan db:seed`. The seeded identity is defined in [`backend-web/database/seeders/UserSeeder.php`](backend-web/database/seeders/UserSeeder.php), with its password supplied by the user factory.

## Tests and quality checks

Run the PHP formatter check and PHPUnit suite together:

```bash
cd backend-web
composer test
```

Feature tests cover API registration, login, logout, account visibility, validation, membership authorization, invitations, and member removal. Additional feature tests cover browser authentication, password reset and confirmation, email verification, two-factor challenges, profile/security settings, and dashboard access. PHPUnit uses an in-memory SQLite database.

The full project check adds frontend linting, formatting, and TypeScript validation:

```bash
composer run ci:check
```

Individual frontend checks are also available:

```bash
npm run lint:check
npm run format:check
npm run types:check
npm run build
```

## Repository structure

```text
.
├── README.md
└── backend-web/
    ├── app/
    │   ├── Data/                 # Typed API/domain representations
    │   ├── Http/                 # API and settings controllers, requests, middleware
    │   ├── Models/               # Eloquent entities and relationships
    │   ├── Services/             # Account application logic
    │   └── Actions/Fortify/      # Registration and password-reset actions
    ├── config/                   # Laravel, Fortify, Sanctum, and infrastructure config
    ├── database/
    │   ├── factories/            # Model factories
    │   ├── migrations/           # Relational schema
    │   └── seeders/              # Development seed data
    ├── resources/
    │   ├── js/                   # React pages, layouts, hooks, and UI components
    │   ├── css/                  # Tailwind theme and global styles
    │   └── views/                # Inertia Blade entry point
    ├── routes/                   # API, web, settings, and console routes
    └── tests/                    # PHPUnit unit and feature tests
```
