# Job Application & Admin Auth System - Implementation Summary

## Overview
A complete job application and administration system has been implemented with:
- Job application submission via contact form (with resume upload)
- Admin authentication system with email whitelist
- Admin dashboard for managing applications (Accept, Decline, Review)
- Auto-account creation with temporary password on acceptance
- Email notifications for acceptance and decline
- Applicant login and simple dashboard
- Role-based access control

---

## 📁 Files Created/Modified

### Models
- `app/Models/JobApplication.php` - Stores job applications
- `app/Models/AdminWhitelist.php` - Manages whitelisted admin emails  
- `app/Models/User.php` - **MODIFIED** - Added role field and relationships

### Migrations
- `database/migrations/*_add_role_to_users_table.php` - Adds role enum field to users
- `database/migrations/*_create_job_applications_table.php` - Creates job applications table
- `database/migrations/*_create_admin_whitelists_table.php` - Creates admin whitelist table

### Controllers
- `app/Http/Controllers/AuthController.php` - Admin & applicant auth
- `app/Http/Controllers/ApplicationController.php` - Job application management
- `app/Http/Controllers/Admin/DashboardController.php` - Admin dashboard logic
- `app/Http/Controllers/Applicant/DashboardController.php` - Applicant dashboard logic

### Middleware
- `app/Http/Middleware/AdminMiddleware.php` - Protects admin routes
- `app/Http/Middleware/ApplicantMiddleware.php` - Protects applicant routes
- `app/Http/Kernel.php` - **MODIFIED** - Registered middleware aliases

### Mailable Classes
- `app/Mail/ApplicationAccepted.php` - Acceptance email with temp password
- `app/Mail/ApplicationDeclined.php` - Decline notification email

### Views
#### Authentication
- `resources/views/auth/admin-login.blade.php` - Admin login form
- `resources/views/auth/admin-register.blade.php` - Admin registration form
- `resources/views/auth/applicant-login.blade.php` - Applicant login form

#### Admin
- `resources/views/admin/dashboard.blade.php` - Admin dashboard with applications list
- `resources/views/admin/application-detail.blade.php` - Single application detail view

#### Applicant
- `resources/views/applicant/dashboard.blade.php` - Applicant dashboard

#### Email Templates
- `resources/views/emails/application-accepted.blade.php` - Acceptance email
- `resources/views/emails/application-declined.blade.php` - Decline email

### Routes & Configuration
- `routes/web.php` - **MODIFIED** - Added all auth and application routes
- `.env` - **MODIFIED** - Configured Gmail SMTP settings (needs credentials)
- `resources/views/partials/contact.blade.php` - **MODIFIED** - Updated form for job applications

---

## 🚀 Setup Instructions

### 1. Run Migrations
```bash
php artisan migrate
```

This will:
- Add `role` column to users table (default: 'applicant')
- Create `job_applications` table
- Create `admin_whitelists` table with pre-seeded admin emails:
  - `lui@akawnt.com`
  - `admin@akawnt.com`

### 2. Configure Gmail SMTP

Update `.env` file with your Gmail credentials:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password  # Use Google App Password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Akawnt"
```

**Note:** Use Google App Password, not your regular Gmail password. Create one at: https://myaccount.google.com/apppasswords

### 3. Configure Storage for Private Resumes

Add to `config/filesystems.php` (if not already present):
```php
'private' => [
    'driver' => 'local',
    'root' => storage_path('app/private'),
    'url' => env('APP_URL') . '/storage',
    'visibility' => 'private',
],
```

Ensure storage is writable:
```bash
chmod -R 775 storage/app/private
```

---

## 🔐 User Roles & Access

### Admin Users
- **Role:** `admin`
- **Login Route:** `/admin/login`
- **Register Route:** `/admin/register`
- **Dashboard:** `/admin/dashboard`
- **Requirements:** Email must be in admin whitelist

### Applicant/Accountant Users  
- **Role:** `accountant` (existing role in system)
- **Login Route:** `/login`
- **Apply Route:** Submit form on `/home#contact`
- **Dashboard:** `/dashboard`
- **Access:** Only after admin accepts their application

---

## 📋 Application Workflow

### Applicant's Journey
1. Fill job application form on home page with:
   - First Name, Last Name
   - Email, Phone
   - Position (dropdown with 6 accounting roles + Other)
   - Cover Letter/Message
   - Resume file (PDF, DOC, DOCX - max 5MB)

2. Application submitted with status: **pending**

3. Waits for admin review...

4. Upon acceptance:
   - User account automatically created
   - Temporary password generated (12-char random string)
   - Welcome email sent with login credentials
   - Application status changed to: **accepted**
   - User can now login at `/login`

5. Upon decline:
   - Decline notification email sent
   - Application status changed to: **declined**

### Admin's Journey
1. Login at `/admin/login` (or register at `/admin/register` if first time)
2. View `/admin/dashboard` with:
   - **Statistics:** Total, Pending, Reviewing, Accepted, Declined counts
   - **Search/Filter:** By email, name, or status
   - **Applications List:** Table showing all applications
   - **Actions per application:**
     - **View** - See full details and resume
     - **Mark as Reviewing** - Change status to "reviewing"
     - **Accept** - Auto-create account + send acceptance email
     - **Decline** - Reject and send notification

---

## 📧 Email Templates

### Acceptance Email
- Congratulations message
- Position applied for
- Account credentials (email + temporary password)
- Login link
- Instructions to change password

### Decline Email
- Thank you message
- Professional decline notice
- Encouragement to reapply

Both use branded HTML templates with company colors and footer.

---

## 📊 Database Schema

### users table
```
- id
- name
- email (unique)
- password
- role (enum: 'admin', 'accountant') - existing field
- email_verified_at
- remember_token
- created_at, updated_at
```

### job_applications table
```
- id
- first_name
- last_name
- email
- phone
- position
- message (long text)
- resume_path
- status (enum: 'pending', 'reviewing', 'accepted', 'declined')
- user_id (foreign key, nullable)
- created_at, updated_at
```

### admin_whitelists table
```
- id
- email (unique)
- created_at, updated_at
```

---

## 🔄 Route Summary

### Public Routes
- `GET /` - Redirect to /home
- `GET /home` - Home page with job application form
- `POST /apply` - Submit job application

### Auth Routes (Guest Only)
- `GET/POST /admin/login` - Admin login
- `GET/POST /admin/register` - Admin registration (email whitelist required)
- `GET/POST /login` - Applicant login

### Protected Routes - Logout
- `POST /logout` - Logout (any authenticated user)

### Admin Routes (Admin Only)
- `GET /admin/dashboard` - View all applications
- `GET /admin/applications/{id}` - View application details
- `POST /admin/applications/{id}/accept` - Accept application
- `POST /admin/applications/{id}/decline` - Decline application
- `POST /admin/applications/{id}/review` - Mark as reviewing
- `GET /admin/applications/{id}/resume` - Download resume

### Applicant Routes (Applicant Only)
- `GET /dashboard` - Applicant dashboard

---

## 🛠️ Customization

### Adding Admin Emails
Edit migration: `database/migrations/*_create_admin_whitelists_table.php`
```php
DB::table('admin_whitelists')->insert([
    ['email' => 'admin@company.com'],
    ['email' => 'hr@company.com'],
]);
```

Then run: `php artisan migrate:refresh`

Or programmatically:
```php
AdminWhitelist::create(['email' => 'newemail@company.com']);
```

### Changing Job Positions
Edit: `resources/views/partials/contact.blade.php`
Update the position dropdown options.

### Email Configuration
Modify email templates in:
- `resources/views/emails/application-accepted.blade.php`
- `resources/views/emails/application-declined.blade.php`

---

## 📝 Notes for Future Development

1. **Password Reset:** Currently not implemented. Add password reset functionality in profile settings.

2. **Applicant Dashboard:** Currently minimal. Can expand with:
   - Edit profile
   - Change password
   - View application history
   - Download acceptance letter

3. **Admin Features:** Can add:
   - Bulk actions
   - Export applications to CSV/Excel
   - Application comments/notes
   - Email templates customization
   - Admin audit logs

4. **Job Positions:** Consider moving to database table instead of hardcoded dropdown.

5. **File Storage:** Configure to support different storage drivers (S3, etc.)

---

## ✅ Testing Checklist

- [ ] Run migrations: `php artisan migrate`
- [ ] Configure `.env` with Gmail credentials
- [ ] Test applicant registration: Visit `/home`, fill form, submit
- [ ] Test admin registration: Visit `/admin/register`, register with whitelisted email
- [ ] Test admin login: `/admin/login`
- [ ] Test admin dashboard: View applications, search, filter
- [ ] Test accept: Accept application, check emails sent
- [ ] Test applicant login: Login with generated credentials
- [ ] Test applicant dashboard: View profile and application status
- [ ] Test decline: Decline application, check emails sent
- [ ] Test resume download: Download resume from application detail

---

**Implementation Date:** April 7, 2026
**Status:** Ready for Migration & Testing
