# J-Hub — Job Portal System

J-Hub is a web-based job portal that connects job seekers with employers in a clean, straightforward way. Employers post jobs, job seekers apply, and everything in between (notifications, comments, application tracking) is handled within the platform. There's also an admin side for keeping accounts in check and monitoring what's going on in the system.

Built as a class project using Laravel and Blade, with Tailwind CSS for the UI.

---

## What it does

**For visitors**
- Browse the platform and read about it
- View job listings and individual job details without needing an account
- Create an account as either a Job Seeker or an Employer

**For job seekers**
- Search and filter available job listings
- Apply for jobs and track application statuses
- Leave comments on job posts
- Receive notifications about application updates
- Manage their profile and resume

**For employers**
- Post, edit, and delete job listings
- Review incoming applications per job
- Accept or refuse applicants
- Receive notifications
- Manage their company profile

**For admins**
- Monitor system activity through logs
- View and control user accounts

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| Templating | Laravel Blade |
| Styling | Tailwind CSS |
| Database | MySQL |
| Auth | Laravel Sanctum |

---

## Project Structure (high level)

```
app/
├── Enums/           # UserRole, JobStatus, ApplicationStatus
├── Models/          # User, Job, Application, Notification, Comment
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
resources/
└── views/
    ├── layouts/     # public and auth shell layouts
    ├── components/  # reusable Blade components
    ├── public/      # guest-facing pages
    ├── auth/        # login and registration
    ├── jobseeker/   # job seeker dashboard and pages
    ├── employer/    # employer dashboard and pages
    └── admin/       # admin dashboard and pages
```

---

## Getting Started

### Requirements
- PHP 8.4+
- Composer
- MySQL
- Node.js + npm

### Installation

```bash
# Clone the repo
git clone https://github.com/your-username/jhub.git
cd jhub

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Set up environment
cp .env.example .env
php artisan key:generate
```

### Configure your database

Open `.env` and update these values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jhub
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Run migrations and seed

```bash
php artisan migrate:fresh --seed
```

This will create all tables and populate the database with sample employers, job seekers, jobs, applications, comments, and notifications.

### Start the dev server

```bash
php artisan serve
npm run dev
```

App will be running at `http://localhost:8000`.

---

## Default Seeded Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@jhub.com | password |
| Employer | *(5 generated)* | password |
| Job Seeker | *(20 generated)* | password |

---

## Data Model Overview

- A **User** is either a Job Seeker, Employer, or Admin (role-based via enum)
- An **Employer** owns many **Jobs**
- A **Job Seeker** submits many **Applications**, one per job
- Each **Application** has a status: `pending`, `accepted`, or `refused`
- **Comments** are attached to jobs and written by users
- **Notifications** are sent to any user and tracked by date

---

## Notes

- The `job_posts` table is used for job listings (not `jobs`, which Laravel reserves for its queue system)
- Role management is handled via the `UserRole` PHP enum — no separate roles table
- Enums are stored as strings in the database for readability and portability

---

## License

Class project — not licensed for production use.
