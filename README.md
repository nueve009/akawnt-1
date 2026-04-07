# Akawnt - Job Application & Admin Authentication System

A Laravel-based job application and admin authentication system for the Akawnt accounting firm.

## Features

### For Job Applicants
- Submit applications via form on homepage with resume upload
- Receive email notification upon acceptance/decline
- Login to view application status after acceptance
- View profile and application details on personal dashboard

### For Administrators
- Whitelist-based registration (only approved emails can register)
- Dashboard to view all job applications
- Search and filter applications by status
- Accept, decline, or mark applications as reviewing
- Download applicant resumes
- Automatic user account creation when accepting applications

## Requirements

- PHP 8.2+
- Laravel 10+
- MySQL/SQLite database
- Gmail account for email notifications (or configure your SMTP)

## Installation

1. **Clone and install dependencies:**
   ```bash
   composer install
   ```

2. **Configure environment:**
   ```bash
   cp .env.example .env
   ```

3. **Set up your `.env` file:**
   ```
   DB_DATABASE=akawnt
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_FROM_ADDRESS=your-email@gmail.com
   MAIL_FROM_NAME=Akawnt
   ```

4. **Generate keys and run migrations:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Create storage symlink:**
   ```bash
   php artisan storage:link
   ```

## Routes

### Public Routes
| URL | Description |
|-----|-------------|
| `/home` | Homepage with job application form |
| `/affiliates` | Affiliates page |
| `/reports` | Reports page |

### Authentication
| URL | Description |
|-----|-------------|
| `/admin/login` | Admin login |
| `/admin/register` | Admin registration (whitelist required) |
| `/login` | Applicant login |
| `/logout` | Logout (POST) |

### Admin Dashboard (requires admin login)
| URL | Description |
|-----|-------------|
| `/admin/dashboard` | View all applications with stats |
| `/admin/applications/{id}` | View application details |
| `/admin/applications/{id}/accept` | Accept application |
| `/admin/applications/{id}/decline` | Decline application |
| `/admin/applications/{id}/review` | Mark as reviewing |
| `/admin/applications/{id}/resume` | Download resume |

### Applicant Dashboard (requires applicant login)
| URL | Description |
|-----|-------------|
| `/dashboard` | View profile and application status |

## Whitelisted Admin Emails

By default, only these emails can register as admins:
- `lui@akawnt.com`
- `admin@akawnt.com`

To add more, insert into `admin_whitelists` table or seed it.

## User Roles

| Role | Description |
|------|-------------|
| `admin` | Administrators who manage applications |
| `accountant` | Accepted job applicants |

## Application Status Flow

```
pending → reviewing → accepted/declined (terminal)
```

## Testing the Workflow

1. **Register an admin:**
   - Go to `/admin/register`
   - Use a whitelisted email (e.g., `admin@akawnt.com`)
   - Complete registration

2. **Submit a job application:**
   - Go to `/home`
   - Fill out the application form
   - Upload a resume (PDF, DOC, DOCX - max 5MB)

3. **Accept the application:**
   - Login as admin at `/admin/login`
   - Go to `/admin/dashboard`
   - Find the application, click "Accept"
   - An email will be sent with login credentials

4. **Applicant login:**
   - Check the email for temporary password
   - Go to `/login`
   - Use email and temporary password
   - Access `/dashboard` to view status

## Storage

Resumes are stored in `storage/app/private/` and are not publicly accessible. Only admins can download them through the application detail page.

## Email Configuration

For Gmail SMTP:
1. Enable 2-Factor Authentication on your Google account
2. Generate an App Password: Google Account → Security → App passwords
3. Use the app password as `MAIL_PASSWORD` in `.env`

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── ApplicationController.php
│   │   │   └── Admin|DashboardController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── ApplicantMiddleware.php
│   ├── Mail/
│   │   ├── ApplicationAccepted.php
│   │   └── ApplicationDeclined.php
│   └── Models/
│       ├── JobApplication.php
│       ├── AdminWhitelist.php
│       └── User.php
├── database/migrations/
├── resources/views/
│   ├── layouts/
│   ├── auth/
│   ├── admin/
│   ├── applicant/
│   ├── emails/
│   └── partials/
└── routes/web.php
```

## License

This project is proprietary software for Akawnt.
