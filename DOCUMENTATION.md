# J-Hub — Project Documentation

This document explains every file in the J-Hub project. It is written for developers who are familiar with PHP and basic web concepts but may be new to Laravel. Read it top to bottom once before touching any code.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Folder Structure](#2-folder-structure)
3. [Enums](#3-enums)
4. [Database — Migrations](#4-database--migrations)
5. [Models](#5-models)
6. [Factories and Seeders](#6-factories-and-seeders)
7. [Middleware](#7-middleware)
8. [Form Requests](#8-form-requests)
9. [Policies](#9-policies)
10. [Controllers](#10-controllers)
11. [Routes](#11-routes)
12. [Views — Layouts](#12-views--layouts)
13. [Views — Components](#13-views--components)
14. [Views — Pages](#14-views--pages)
15. [Frontend — Tailwind and Alpine.js](#15-frontend--tailwind-and-alpinejs)
16. [Key Laravel Concepts Used](#16-key-laravel-concepts-used)

---

## 1. Project Overview

J-Hub is a job portal web application. It has four types of users:

- **Visitor** — anyone who opens the site without logging in. They can browse jobs and read about the platform.
- **Job Seeker** — a registered user looking for work. They can apply to jobs, track applications, and leave comments.
- **Employer** — a registered company/recruiter. They can post jobs, manage listings, and review applicants.
- **Administrator** — a platform manager. They can view all accounts and read system logs.

The application is built with:
- **Laravel 12** — the PHP framework that handles routing, database, authentication, and business logic
- **Blade** — Laravel's templating engine for building HTML views
- **Tailwind CSS** — a utility-first CSS framework for styling
- **Alpine.js** — a lightweight JavaScript library for interactive UI elements (dropdowns, modals, toggles)
- **MySQL** — the relational database

---

## 2. Folder Structure

```
jhub/
├── app/
│   ├── Enums/              # PHP Enums defining fixed sets of values (roles, statuses)
│   ├── Http/
│   │   ├── Controllers/    # Handle incoming requests and return responses
│   │   ├── Middleware/     # Code that runs before a request reaches a controller
│   │   └── Requests/       # Form validation rules
│   ├── Models/             # Represent database tables as PHP classes
│   └── Policies/           # Authorization rules — who can do what
├── bootstrap/
│   └── app.php             # Application bootstrap — middleware registration lives here
├── database/
│   ├── factories/          # Generate fake data for testing/seeding
│   ├── migrations/         # Define database table structure
│   └── seeders/            # Populate the database with initial data
├── public/
│   └── images/             # Stock photos and static images
├── resources/
│   ├── css/
│   │   └── app.css         # Tailwind CSS entry point
│   ├── js/
│   │   └── app.js          # Alpine.js entry point
│   └── views/              # All Blade templates (HTML pages)
│       ├── layouts/        # Base HTML shells that pages extend
│       ├── components/     # Reusable Blade pieces included in pages
│       ├── public/         # Pages visible to unauthenticated visitors
│       ├── auth/           # Login and registration pages
│       ├── jobseeker/      # Pages for job seekers
│       ├── employer/       # Pages for employers
│       ├── admin/          # Pages for admins
│       └── errors/         # HTTP error pages
├── routes/
│   └── web.php             # All URL route definitions
├── storage/
│   └── logs/
│       └── laravel.log     # Application log file (errors, warnings, info)
├── tailwind.config.js      # Tailwind CSS configuration
├── vite.config.js          # Vite bundler configuration
└── .env                    # Environment variables (DB credentials, app key, etc.)
```

---

## 3. Enums

Enums are PHP files that define a **fixed list of allowed values**. Instead of typing raw strings like `'jobseeker'` everywhere in the code (which is error-prone), we use enum cases. Laravel can automatically cast database string columns to their matching enum.

---

### `app/Enums/UserRole.php`

Defines the three roles a user can have.

```php
enum UserRole: string
{
    case JOBSEEKER = 'jobseeker';
    case EMPLOYER  = 'employer';
    case ADMIN     = 'admin';
}
```

**How it's used:**
- The `users` table stores role as a plain string (`'jobseeker'`, `'employer'`, `'admin'`)
- The `User` model casts the `role` column to this enum automatically
- In code, you compare using `$user->role === UserRole::JOBSEEKER` instead of `$user->role === 'jobseeker'`
- This prevents typos and makes the code self-documenting

---

### `app/Enums/JobStatus.php`

Defines the possible states of a job listing.

```php
enum JobStatus: string
{
    case OPEN   = 'open';
    case CLOSED = 'closed';
    case PAUSED = 'paused';
}
```

**How it's used:**
- `OPEN` — the job is visible and accepting applications
- `CLOSED` — the position has been filled or removed
- `PAUSED` — temporarily not accepting applications
- The `Job` model casts the `status` column to this enum

---

### `app/Enums/ApplicationStatus.php`

Defines the possible states of a job application.

```php
enum ApplicationStatus: string
{
    case PENDING  = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED  = 'refused';
}
```

**How it's used:**
- Every new application starts as `PENDING`
- The employer changes it to `ACCEPTED` or `REFUSED`
- The `Application` model casts the `status` column to this enum

---

## 4. Database — Migrations

Migrations are PHP files that define the **structure of database tables**. Instead of manually creating tables in MySQL, you write migrations and run `php artisan migrate`. This means every developer on the team gets the exact same database structure.

> **Rule:** Never edit a migration file after it has been run and committed. Create a new migration instead.

---

### `0001_01_01_000000_create_users_table.php`

Creates the `users` table. This is Laravel's default migration, extended with J-Hub's custom columns.

| Column | Type | Description |
|---|---|---|
| `id` | bigint, primary key | Auto-incrementing unique ID |
| `name` | string | Full name of the user |
| `email` | string, unique | Email address used to log in |
| `email_verified_at` | timestamp, nullable | When the email was verified (unused in this project) |
| `password` | string | Hashed password (never stored as plain text) |
| `role` | string | One of: `jobseeker`, `employer`, `admin` |
| `resume` | text, nullable | Job seeker's resume text (null for employers and admins) |
| `company_name` | string, nullable | Employer's company name (null for job seekers and admins) |
| `remember_token` | string, nullable | Used by Laravel's "remember me" login feature |
| `timestamps` | — | `created_at` and `updated_at` columns added automatically |

---

### `0001_01_01_000001_create_cache_table.php`

Laravel's default cache table. Used internally by Laravel for caching. **Do not modify.**

---

### `0001_01_01_000002_create_jobs_table.php`

Laravel's default queue jobs table. This is **not** our job listings table — this is an internal Laravel table for background job processing. **Do not modify or confuse with `job_posts`.**

---

### `create_job_posts_table.php`

Creates the `job_posts` table — this is where employer job listings are stored. Named `job_posts` (not `jobs`) to avoid conflicting with Laravel's internal `jobs` table.

| Column | Type | Description |
|---|---|---|
| `id` | bigint, primary key | Auto-incrementing unique ID |
| `employer_id` | foreignId | References `users.id` — the employer who posted it |
| `title` | string | Job title (e.g. "Frontend Developer") |
| `description` | text | Full job description |
| `location` | string | City or region |
| `expected_salary` | decimal(10,2), nullable | Offered salary |
| `status` | string | One of: `open`, `closed`, `paused` |
| `timestamps` | — | `created_at` and `updated_at` |

**Constraint:** If the employer's user account is deleted, all their jobs are deleted too (`cascadeOnDelete`).

---

### `create_applications_table.php`

Creates the `applications` table — tracks which job seeker applied to which job.

| Column | Type | Description |
|---|---|---|
| `id` | bigint, primary key | Auto-incrementing unique ID |
| `job_seeker_id` | foreignId | References `users.id` — the applicant |
| `job_id` | foreignId | References `job_posts.id` — the job applied to |
| `status` | string | One of: `pending`, `accepted`, `refused` |
| `date` | date | Date the application was submitted |
| `timestamps` | — | `created_at` and `updated_at` |

---

### `create_notifications_table.php`

Creates the `notifications` table — stores messages sent to users.

| Column | Type | Description |
|---|---|---|
| `id` | bigint, primary key | Auto-incrementing unique ID |
| `user_id` | foreignId | References `users.id` — who receives the notification |
| `message` | string | The notification text |
| `date` | date | When it was sent |
| `timestamps` | — | `created_at` and `updated_at` |

---

### `create_comments_table.php`

Creates the `comments` table — stores comments on job listings.

| Column | Type | Description |
|---|---|---|
| `id` | bigint, primary key | Auto-incrementing unique ID |
| `user_id` | foreignId | References `users.id` — who wrote the comment |
| `job_id` | foreignId | References `job_posts.id` — which job it's on |
| `content` | string | The comment text |
| `date` | date | When it was posted |
| `timestamps` | — | `created_at` and `updated_at` |

---

## 5. Models

Models are PHP classes that **represent a database table**. Each row in the table becomes an instance of the model. Laravel's Eloquent ORM lets you query the database using readable PHP methods instead of raw SQL.

For example, instead of:
```sql
SELECT * FROM job_posts WHERE employer_id = 5;
```
You write:
```php
Job::where('employer_id', 5)->get();
```

---

### `app/Models/User.php`

Represents a row in the `users` table. All three roles (job seeker, employer, admin) share this model — the `role` column differentiates them.

**Key attributes:**
- `$fillable` (via `#[Fillable]` attribute) — columns that can be mass-assigned: `name`, `email`, `password`, `role`, `resume`, `company_name`
- `$hidden` (via `#[Hidden]` attribute) — columns excluded from JSON output: `password`, `remember_token`

**Casts (defined in `casts()` method):**
- `email_verified_at` → cast to `datetime` (Carbon instance)
- `password` → cast as `hashed` (auto-hashed when set)
- `role` → cast to `UserRole` enum

**Role helper methods:**
- `isJobSeeker()` — returns `true` if this user's role is `JOBSEEKER`
- `isEmployer()` — returns `true` if this user's role is `EMPLOYER`
- `isAdmin()` — returns `true` if this user's role is `ADMIN`

These helpers make views and controllers more readable:
```php
// Instead of:
if ($user->role === UserRole::EMPLOYER) { ... }
// You can write:
if ($user->isEmployer()) { ... }
```

**Relationships:**
- `jobs()` — an employer has many job posts (`hasMany(Job::class, 'employer_id')`)
- `applications()` — a job seeker has many applications (`hasMany(Application::class, 'job_seeker_id')`)
- `notifications()` — a user has many notifications (`hasMany(Notification::class)`)
- `comments()` — a user has many comments (`hasMany(Comment::class)`)

---

### `app/Models/Job.php`

Represents a row in the `job_posts` table.

**Important:** This model explicitly sets `protected $table = 'job_posts'` because the class is named `Job` and Laravel would otherwise assume the table is called `jobs` (which is Laravel's internal queue table).

**Casts:**
- `status` → cast to `JobStatus` enum

**Relationships:**
- `employer()` — belongs to a User (`belongsTo(User::class, 'employer_id')`)
- `applications()` — has many applications (`hasMany(Application::class)`)
- `comments()` — has many comments (`hasMany(Comment::class)`)

---

### `app/Models/Application.php`

Represents a row in the `applications` table — one job seeker applying to one job.

**Casts:**
- `status` → cast to `ApplicationStatus` enum
- `date` → cast to `date` (Carbon instance)

**Relationships:**
- `jobSeeker()` — belongs to a User (`belongsTo(User::class, 'job_seeker_id')`)
- `job()` — belongs to a Job (`belongsTo(Job::class)`)

---

### `app/Models/Notification.php`

Represents a row in the `notifications` table.

**Casts:**
- `date` → cast to `date` (Carbon instance)

**Relationships:**
- `user()` — belongs to a User (`belongsTo(User::class)`)

---

### `app/Models/Comment.php`

Represents a row in the `comments` table.

**Casts:**
- `date` → cast to `date` (Carbon instance)

**Relationships:**
- `user()` — belongs to a User (`belongsTo(User::class)`)
- `job()` — belongs to a Job (`belongsTo(Job::class)`)

---

## 6. Factories and Seeders

Factories and seeders are used to **fill the database with fake data** so you can develop and test without manually entering records.

---

### `database/factories/UserFactory.php`

Generates fake User records.

- `definition()` — base fake user: random name, unique email, password `'password'`, role `jobseeker`
- `employer()` — state that overrides role to `employer` and adds a fake company name
- `admin()` — state that overrides role to `admin`
- `jobSeeker()` — state that sets role to `jobseeker` and adds a fake resume paragraph

**What a "state" is:** A state is a modifier you chain onto a factory to customize the output. Example:
```php
User::factory()->employer()->create(); // creates one employer
User::factory()->jobSeeker()->count(10)->create(); // creates 10 job seekers
```

---

### `database/factories/JobFactory.php`

Generates fake Job records. Does not include `employer_id` in `definition()` — that is passed in manually when creating:
```php
Job::factory()->create(['employer_id' => $employer->id]);
```

---

### `database/factories/ApplicationFactory.php`

Generates fake Application records with a random date in the last 3 months and status `pending`. `job_id` and `job_seeker_id` are passed in manually.

---

### `database/factories/NotificationFactory.php`

Generates fake Notification records with a random sentence and today's date. `user_id` is passed in manually.

---

### `database/factories/CommentFactory.php`

Generates fake Comment records with 2 sentences of content. `user_id` and `job_id` are passed in manually.

---

### `database/seeders/DatabaseSeeder.php`

The main seeder — orchestrates the entire database population. Run with `php artisan db:seed` or `php artisan migrate:fresh --seed`.

**What it creates:**
1. One admin user with email `admin@jhub.com` and password `password`
2. 5 employers, each with a company name
3. 20 job seekers, each with a resume
4. 4 jobs per employer (20 total)
5. 3 applications per job from random job seekers
6. 2 comments per job from random job seekers
7. 2 notifications per user

---

## 7. Middleware

Middleware is code that **runs before a request reaches your controller**. Think of it as a gate — the request must pass through it first.

---

### `app/Http/Middleware/RoleMiddleware.php`

**Purpose:** Protect routes so only users with the correct role can access them.

**`handle(Request $request, Closure $next, string $role)`**

- Checks if the user is authenticated — if not, redirects to the login page
- Checks if `auth()->user()->role->value` matches the `$role` parameter passed from the route
- If the role doesn't match, aborts with a `403 Forbidden` error
- If everything is fine, passes the request to the next middleware or controller with `$next($request)`

**How it's registered:** In `bootstrap/app.php` as an alias:
```php
$middleware->alias(['role' => RoleMiddleware::class]);
```

**How it's used on routes:**
```php
Route::middleware(['auth', 'role:employer'])->group(function () {
    // Only employers can access these routes
});
```

---

## 8. Form Requests

Form Requests are classes that contain **validation rules for form submissions**. Instead of writing validation logic inside controllers (which gets messy), you put it here. Laravel automatically runs the validation before the controller method is called — if validation fails, it redirects back with error messages automatically.

---

### `app/Http/Requests/Auth/LoginRequest.php`

**Used by:** `AuthController@login`

**Rules:**
- `email` — required, must be a valid email format
- `password` — required, must be a string

---

### `app/Http/Requests/Auth/RegisterJobSeekerRequest.php`

**Used by:** `RegisterController@registerJobSeeker`

**Rules:**
- `name` — required, string
- `email` — required, valid email, must not already exist in the `users` table
- `password` — required, minimum 8 characters, must match `password_confirmation` field
- `resume` — optional (nullable), string

---

### `app/Http/Requests/Auth/RegisterEmployerRequest.php`

**Used by:** `RegisterController@registerEmployer`

**Rules:**
- `name` — required, string
- `email` — required, valid email, must not already exist in the `users` table
- `password` — required, minimum 8 characters, must match `password_confirmation`
- `company_name` — required, string

---

### `app/Http/Requests/Job/StoreJobRequest.php`

**Used by:** `Employer\JobController@store`

**Rules:**
- `title` — required, string
- `description` — required, string
- `location` — required, string
- `expected_salary` — optional, must be numeric, minimum 0
- `status` — required, must be one of: `open`, `closed`, `paused`

---

### `app/Http/Requests/Job/UpdateJobRequest.php`

**Used by:** `Employer\JobController@update`

Same rules as `StoreJobRequest` but all fields are wrapped with `sometimes` — meaning they are only validated if they are present in the request. This allows partial updates.

---

### `app/Http/Requests/Profile/UpdateProfileRequest.php`

**Used by:** `JobSeeker\ProfileController@update` and `Employer\ProfileController@update`

**Rules:**
- `name` — required, string
- `email` — required, valid email, unique in `users` table but **ignores the current user's own email** (so they can submit the form without changing their email)
- `resume` — optional, string (job seekers only)
- `company_name` — optional, string (employers only)

---

## 9. Policies

Policies are classes that contain **authorization logic** — they answer the question "is this user allowed to do this action on this resource?". They keep authorization out of controllers and views, centralizing it in one place.

Policies are registered in `AppServiceProvider` using `Gate::policy()`. Once registered, you can use them in controllers with `$this->authorize('action', $model)` or in Blade with `@can('action', $model)`.

---

### `app/Policies/JobPolicy.php`

Controls who can do what with Job listings.

- **`create(User $user)`** — returns `true` only if the user is an employer. Prevents job seekers and admins from posting jobs.
- **`update(User $user, Job $job)`** — returns `true` only if the authenticated user is the employer who created this specific job. An employer cannot edit another employer's job.
- **`delete(User $user, Job $job)`** — same as `update` — only the job's owner can delete it.
- **`viewApplicants(User $user, Job $job)`** — returns `true` only if the authenticated user is the employer who owns this job. Prevents viewing another employer's applicants.

---

### `app/Policies/ApplicationPolicy.php`

Controls who can do what with Applications.

- **`create(User $user, Job $job)`** — returns `true` only if the user is a job seeker AND has not already applied to this specific job. Prevents duplicate applications and prevents employers from applying.
- **`view(User $user, Application $application)`** — returns `true` only if the authenticated user is the job seeker who submitted this application. You cannot view someone else's application.
- **`withdraw(User $user, Application $application)`** — returns `true` only if the user owns the application AND the status is still `PENDING`. You cannot withdraw an already-decided application.

---

### `app/Policies/UserPolicy.php`

Controls who can do what with User accounts.

- **`update(User $user, User $target)`** — returns `true` only if the authenticated user is updating their own account. You cannot edit someone else's profile.
- **`delete(User $user, User $target)`** — returns `true` only if the authenticated user is an admin AND the target user is not also an admin. Admins cannot delete other admins.

---

## 10. Controllers

Controllers are the **brain of the application**. They receive incoming HTTP requests, talk to models to get or save data, and return views or redirects as responses. Controllers are grouped into subfolders by role/area for organization.

---

### `app/Http/Controllers/Auth/AuthController.php`

Handles login and logout.

- **`showLogin()`** — if the user is already logged in, redirect them to their dashboard. Otherwise return the `auth.login` view.
- **`login(LoginRequest $request)`** — attempt authentication using `Auth::attempt(['email' => ..., 'password' => ...])`. On success, regenerate the session (security measure) and redirect based on the user's role. On failure, redirect back with an error message.
- **`logout(Request $request)`** — log the user out using `Auth::logout()`, invalidate the session, regenerate the CSRF token, and redirect to `home`.

---

### `app/Http/Controllers/Auth/RegisterController.php`

Handles registration for both roles.

- **`showJobSeekerForm()`** — return `auth.register.jobseeker` view
- **`showEmployerForm()`** — return `auth.register.employer` view
- **`registerJobSeeker(RegisterJobSeekerRequest $request)`** — create a new User with `role = UserRole::JOBSEEKER`, hash the password (handled automatically by the model cast), log the user in with `Auth::login()`, redirect to `jobseeker.dashboard`
- **`registerEmployer(RegisterEmployerRequest $request)`** — same but with `role = UserRole::EMPLOYER` and `company_name`, redirect to `employer.dashboard`

---

### `app/Http/Controllers/Public/HomeController.php`

- **`index()`** — fetch the 6 most recently created open jobs using `Job::where('status', JobStatus::OPEN)->latest()->take(6)->get()`, pass them to the `public.home` view

---

### `app/Http/Controllers/Public/JobController.php`

Handles public job browsing — no authentication required.

- **`index(Request $request)`** — fetch paginated open jobs (12 per page). If search query params are present (`search`, `location`, salary range), apply them as `where` clauses. Return `public.jobs.index` with the paginated results and the current filter values.
- **`show(Job $job)`** — load the job with its employer relation and its comments with their user relation. Return `public.jobs.show` view.

---

### `app/Http/Controllers/JobSeeker/DashboardController.php`

- **`index()`** — fetch the authenticated job seeker's 5 most recent applications (with their job relation loaded), and their unread notifications count. Pass to `jobseeker.dashboard`.

---

### `app/Http/Controllers/JobSeeker/ApplicationController.php`

- **`index()`** — fetch all of the authenticated job seeker's applications, paginated, with the job relation loaded. Return `jobseeker.applications.index`.
- **`show(Application $application)`** — authorize using `ApplicationPolicy@view`. Return `jobseeker.applications.show` with the application and its job loaded.
- **`store(Job $job)`** — authorize using `ApplicationPolicy@create`. Create an Application record with `job_seeker_id = auth()->id()`, `job_id = $job->id`, `status = PENDING`, `date = today`. Redirect back with a success message.
- **`withdraw(Application $application)`** — authorize using `ApplicationPolicy@withdraw`. Delete the application record. Redirect back with a success message.

---

### `app/Http/Controllers/JobSeeker/ProfileController.php`

- **`edit()`** — return `jobseeker.profile.edit` with the authenticated user
- **`update(UpdateProfileRequest $request)`** — update the authenticated user's `name`, `email`, and `resume`. Redirect back with a success message.

---

### `app/Http/Controllers/JobSeeker/NotificationController.php`

- **`index()`** — fetch all notifications for the authenticated user, ordered by date descending, paginated. Return `jobseeker.notifications.index`.

---

### `app/Http/Controllers/Employer/DashboardController.php`

- **`index()`** — fetch the employer's jobs count, total applications across all their jobs, and their 5 most recent applications. Pass to `employer.dashboard`.

---

### `app/Http/Controllers/Employer/JobController.php`

- **`index()`** — fetch all jobs belonging to the authenticated employer, paginated. Return `employer.jobs.index`.
- **`create()`** — authorize `create` via `JobPolicy`. Return `employer.jobs.create`.
- **`store(StoreJobRequest $request)`** — authorize `create` via `JobPolicy`. Create a new Job with `employer_id = auth()->id()`. Redirect to `employer.jobs.index` with success.
- **`edit(Job $job)`** — authorize `update` via `JobPolicy`. Return `employer.jobs.edit` with the job.
- **`update(UpdateJobRequest $request, Job $job)`** — authorize `update` via `JobPolicy`. Update the job's fields. Redirect back with success.
- **`destroy(Job $job)`** — authorize `delete` via `JobPolicy`. Delete the job (applications and comments are cascade-deleted by the DB). Redirect to `employer.jobs.index` with success.
- **`show(Job $job)`** — authorize `viewApplicants` via `JobPolicy`. Load the job with its paginated applications. Return `employer.jobs.show`.

---

### `app/Http/Controllers/Employer/ApplicantController.php`

- **`index(Job $job)`** — authorize `viewApplicants` via `JobPolicy`. Fetch paginated applications for this job with the job seeker user loaded. Return `employer.applicants.index`.
- **`show(Job $job, Application $application)`** — return `employer.applicants.show` with the application and its job seeker loaded.
- **`accept(Application $application)`** — update the application status to `ACCEPTED`. Create a Notification for the job seeker with a message like "Your application for [job title] has been accepted." Redirect back with success.
- **`refuse(Application $application)`** — update the application status to `REFUSED`. Create a Notification for the job seeker. Redirect back with success.

---

### `app/Http/Controllers/Employer/ProfileController.php`

- **`edit()`** — return `employer.profile.edit` with the authenticated user
- **`update(UpdateProfileRequest $request)`** — update `name`, `email`, `company_name`. Redirect back with success.

---

### `app/Http/Controllers/Employer/NotificationController.php`

- **`index()`** — fetch paginated notifications for the authenticated employer. Return `employer.notifications.index`.

---

### `app/Http/Controllers/CommentController.php`

- **`store(Request $request, Job $job)`** — requires auth. Validate `content` (required, string, max 500 chars). Create a Comment with `user_id = auth()->id()`, `job_id = $job->id`, `date = today()`. Redirect back.
- **`destroy(Comment $comment)`** — requires auth. Check that the authenticated user owns the comment OR is an admin. Delete the comment. Redirect back.

---

### `app/Http/Controllers/Admin/DashboardController.php`

- **`index()`** — fetch total count of users, jobs, and applications. Pass to `admin.dashboard`.

---

### `app/Http/Controllers/Admin/UserController.php`

- **`index(Request $request)`** — fetch all users paginated. If a `search` query param is present, filter by name or email using `where('name', 'like', "%{$search}%")->orWhere('email', 'like', ...)`. Return `admin.users.index`.
- **`show(User $user)`** — return `admin.users.show` with the user and their jobs/applications counts.
- **`destroy(User $user)`** — authorize via `UserPolicy@delete`. Delete the user account. Redirect to `admin.users.index` with success.

---

### `app/Http/Controllers/Admin/LogController.php`

- **`index()`** — read the contents of `storage/logs/laravel.log` using `file()` to get an array of lines. Reverse the array so newest lines appear first. Manually paginate 50 lines per page using Laravel's `LengthAwarePaginator`. Return `admin.logs.index`.

---

## 11. Routes

All routes are defined in `routes/web.php`. Routes are grouped by role using middleware to protect them.

### Route Groups

**Public routes** — no authentication required:
```
GET  /                    → HomeController@index         (home)
GET  /about               → returns public.about view    (about)
GET  /jobs                → Public\JobController@index   (jobs.index)
GET  /jobs/{job}          → Public\JobController@show    (jobs.show)
```

**Auth routes** — for login/register/logout:
```
GET  /login                    → AuthController@showLogin         (login)
POST /login                    → AuthController@login
POST /logout                   → AuthController@logout            (logout)
GET  /register/jobseeker       → RegisterController@showJobSeekerForm  (register.jobseeker)
POST /register/jobseeker       → RegisterController@registerJobSeeker
GET  /register/employer        → RegisterController@showEmployerForm   (register.employer)
POST /register/employer        → RegisterController@registerEmployer
```

**Job Seeker routes** — middleware: `auth`, `role:jobseeker`:
```
GET    /jobseeker                          → dashboard
GET    /jobseeker/applications             → list applications
GET    /jobseeker/applications/{id}        → view single application
POST   /jobseeker/applications/{job}       → submit application
DELETE /jobseeker/applications/{id}        → withdraw application
GET    /jobseeker/profile/edit             → edit profile form
PUT    /jobseeker/profile                  → save profile changes
GET    /jobseeker/notifications            → list notifications
```

**Employer routes** — middleware: `auth`, `role:employer`:
```
GET    /employer                               → dashboard
GET    /employer/jobs                          → list own jobs
GET    /employer/jobs/create                   → create job form
POST   /employer/jobs                          → save new job
GET    /employer/jobs/{job}/edit               → edit job form
PUT    /employer/jobs/{job}                    → save job changes
DELETE /employer/jobs/{job}                    → delete job
GET    /employer/jobs/{job}                    → view job + applicants
GET    /employer/jobs/{job}/applicants         → list applicants for job
GET    /employer/jobs/{job}/applicants/{id}    → view single applicant
POST   /employer/applications/{id}/accept      → accept application
POST   /employer/applications/{id}/refuse      → refuse application
GET    /employer/profile/edit                  → edit profile form
PUT    /employer/profile                       → save profile changes
GET    /employer/notifications                 → list notifications
```

**Admin routes** — middleware: `auth`, `role:admin`:
```
GET    /admin              → dashboard
GET    /admin/users        → list all users
GET    /admin/users/{id}   → view user detail
DELETE /admin/users/{id}   → delete user
GET    /admin/logs         → view system logs
```

**Comment routes** — middleware: `auth`:
```
POST   /jobs/{job}/comments    → store comment
DELETE /comments/{comment}     → delete comment
```

---

## 12. Views — Layouts

Layouts are the **base HTML shells** that all pages extend. They define the outer structure (head, navbar, footer) so you don't repeat it in every view.

---

### `resources/views/layouts/public.blade.php`

Used by all unauthenticated pages (home, about, job listings, login, register, error pages).

**Contains:**
- Full `<!DOCTYPE html>` structure
- `@vite()` for loading Tailwind CSS and Alpine.js
- `<x-navbar.public-navbar />` — the guest navigation bar
- `@yield('content')` — where each page's content is inserted
- `<x-footer />` — the site footer

**How pages use it:**
```blade
@extends('layouts.public')
@section('title', 'Home')
@section('content')
    <h1>Welcome to J-Hub</h1>
@endsection
```

---

### `resources/views/layouts/auth.blade.php`

Used by all authenticated pages (dashboards, profile pages, job management, etc.).

**Contains:**
- Full `<!DOCTYPE html>` structure
- `@vite()` for loading Tailwind CSS and Alpine.js
- `<x-navbar.auth-navbar />` — the logged-in navigation bar with user menu
- A flex container with `@yield('sidebar')` on the left and `@yield('content')` on the right
- `<x-footer />`

**How pages use it:**
```blade
@extends('layouts.auth')
@section('title', 'Dashboard')
@section('sidebar')
    <x-sidebar.jobseeker-sidebar />
@endsection
@section('content')
    <h1>My Dashboard</h1>
@endsection
```

---

## 13. Views — Components

Components are **reusable pieces of HTML** that you include in multiple views. Instead of copy-pasting the same card design in 5 places, you write it once as a component and use `<x-component-name />` anywhere.

---

### Navbar Components

**`components/navbar/public-navbar.blade.php`**
Shown to unauthenticated users. Contains: J-Hub logo/name (links to home), Browse Jobs link, Login link, and a Register dropdown with two options (As Job Seeker, As Employer). Mobile-responsive with an Alpine.js hamburger toggle.

**`components/navbar/auth-navbar.blade.php`**
Shown to all logged-in users. Contains: J-Hub logo, and on the right a user avatar/name dropdown with links to Edit Profile and a Logout button (POST form with CSRF token).

---

### Sidebar Components

**`components/sidebar/jobseeker-sidebar.blade.php`**
Navigation for job seekers. Links: Dashboard, My Applications, Profile, Notifications. The active link is highlighted using `request()->routeIs('jobseeker.dashboard')` etc.

**`components/sidebar/employer-sidebar.blade.php`**
Navigation for employers. Links: Dashboard, My Jobs, Profile, Notifications.

**`components/sidebar/admin-sidebar.blade.php`**
Navigation for admins. Links: Dashboard, Users, System Logs.

---

### Job Components

**`components/job/job-card.blade.php`**
Props: `$job`. A card showing a job listing in grid view. Displays job title, company name, location, salary, status badge, and posted date. The entire card links to `jobs.show`.

**`components/job/job-list.blade.php`**
Props: `$job`. Same info as job-card but in a horizontal list layout. Used in the employer's job management list.

**`components/job/filter-panel.blade.php`**
A panel of filter controls (salary min/max, status dropdown). Submits as GET to `jobs.index` so filters appear in the URL and are shareable/bookmarkable.

**`components/job/job-meta.blade.php`**
Props: `$job`. A small inline display of location, salary, and status badge. Used inside job detail views to avoid repeating this block.

---

### Application Components

**`components/application/application-form.blade.php`**
Props: `$job`. The form a job seeker submits to apply for a job. A simple POST form (no extra fields needed — the job seeker's identity comes from the session).

**`components/application/application-card.blade.php`**
Props: `$application`. A card showing one application from the job seeker's perspective — job title, company, submission date, status badge, and a withdraw button (if still pending).

**`components/application/application-status-badge.blade.php`**
Props: `$status` (ApplicationStatus). Renders a colored badge pill based on status: yellow for pending, green for accepted, red for refused. Used everywhere an application status appears.

---

### Employer Components

**`components/employer/job-row.blade.php`**
Props: `$job`. A table row for the employer's jobs list. Shows title, location, status, application count, posted date, and action buttons (edit, delete). Delete triggers a modal.

**`components/employer/applicant-card.blade.php`**
Props: `$application`. A card showing one applicant from the employer's perspective — applicant name, application date, status badge, and Accept/Refuse action buttons.

---

### Admin Components

**`components/admin/user-row.blade.php`**
Props: `$user`. A table row for the admin's user list — name, email, role badge, registration date, view link, and a delete button that triggers a modal.

**`components/admin/log-row.blade.php`**
Props: `$line` (string). Renders a single line from the Laravel log file in monospace font. Colors the line based on its log level: red for ERROR, yellow for WARNING, gray for INFO.

---

### User Components

**`components/user/profile-form.blade.php`**
Props: `$user`. A reusable form for editing user profile fields (name, email). Extended with role-specific fields in the actual profile views.

**`components/user/avatar.blade.php`**
Props: `$user`. Displays the user's avatar — either a photo or a colored circle with their initials.

---

### UI Primitive Components

These are the base building blocks used everywhere. They wrap common Tailwind patterns so the same styling is consistent across the whole app.

**`components/ui/button.blade.php`**
Props: `$variant` (primary/secondary/danger), `$type` (button/submit). Renders a consistently styled button.
```blade
<x-ui.button variant="primary" type="submit">Save Changes</x-ui.button>
<x-ui.button variant="danger">Delete</x-ui.button>
```

**`components/ui/input.blade.php`**
Props: `$name`, `$label`, `$type`, `$value`, `$placeholder`. Renders a labeled input with automatic error display using `@error($name)`. Uses `old($name, $value)` to preserve the previously entered value after a failed validation.

**`components/ui/badge.blade.php`**
Props: `$color` (green/red/yellow/gray/blue), `$text`. A small pill-shaped label. Used for role badges, status indicators, etc.

**`components/ui/alert.blade.php`**
Props: `$type` (success/error/info/warning). Automatically reads `session('success')` and `session('error')` from Laravel's flash session. Dismissible via Alpine.js `x-show`. Place at the top of any view that performs actions.

**`components/ui/modal.blade.php`**
Props: `$id`, `$title`. A dialog overlay controlled by Alpine.js. Used for destructive action confirmations (delete job, delete user, withdraw application). The trigger button and the modal communicate via an Alpine `x-data` scope.

---

### `components/footer.blade.php`

A simple footer shared across both layouts. Displays the J-Hub name, a short tagline, and the current year (`{{ date('Y') }}`).

---

## 14. Views — Pages

### Public Pages

**`public/home.blade.php`**
The landing page. Contains: a hero section with headline, search bar, and two CTA buttons (Find Jobs → jobseeker register, Post a Job → employer register). A featured jobs section showing 6 recent open jobs as cards. A short pitch section explaining the platform.

**`public/about.blade.php`**
A static informational page. Explains what J-Hub is, who it's for, and how it works — separate step-by-step flows for job seekers and employers. Uses stock images for visual appeal.

**`public/jobs/index.blade.php`**
The main job listings page. Includes the search bar and filter panel at the top, then a grid of job cards. Shows a friendly empty state message if no jobs match the current filters. Pagination links at the bottom.

**`public/jobs/show.blade.php`**
A single job's detail page. Shows the full job info (title, meta, description, employer company). Below the description: an apply button for authenticated job seekers, a login prompt for visitors, or nothing for employers/admins. At the bottom: a comments section showing existing comments and a comment form for logged-in users.

**`public/jobs/partials/search-bar.blade.php`**
A keyword and location search form that submits GET to `jobs.index`. Partial — included inside `jobs/index.blade.php`.

**`public/jobs/partials/filters.blade.php`**
Salary range and status filter controls. Also submits GET to `jobs.index`. Partial — included inside `jobs/index.blade.php`.

---

### Auth Pages

**`auth/login.blade.php`**
The login form. Email and password fields. Shows validation errors via `<x-ui.alert>`. Links to both registration pages.

**`auth/register/jobseeker.blade.php`**
Job seeker registration form. Fields: name, email, password, password confirmation, resume (optional textarea). Links to employer registration and login.

**`auth/register/employer.blade.php`**
Employer registration form. Fields: name, email, password, password confirmation, company name. Links to job seeker registration and login.

---

### Job Seeker Pages

**`jobseeker/dashboard.blade.php`**
The job seeker's home after logging in. Shows a welcome message, a stats row (total applications, pending, accepted), a table of their 5 most recent applications, and a notifications count summary.

**`jobseeker/applications/index.blade.php`**
A paginated list of all the job seeker's applications as `<x-application.application-card>` components.

**`jobseeker/applications/show.blade.php`**
Detail view of a single application. Shows the job info and the current application status. If the status is still pending, shows a withdraw button with a confirmation modal.

**`jobseeker/profile/edit.blade.php`**
Profile editing form for job seekers. Fields: name, email, resume. Success message shown via `<x-ui.alert>`.

**`jobseeker/notifications/index.blade.php`**
Paginated list of all notifications for this job seeker, newest first. Empty state message if none exist.

---

### Employer Pages

**`employer/dashboard.blade.php`**
Employer's home after logging in. Stats row: total jobs posted, total applications received, pending count. A recent applications table. A "Post a Job" quick action button.

**`employer/jobs/index.blade.php`**
List of all jobs posted by this employer. Each row is an `<x-employer.job-row>` component. A "Post a Job" button at the top right. Empty state if no jobs.

**`employer/jobs/create.blade.php`**
Form to post a new job. Fields: title, description, location, expected salary, status (select). Submits POST to `employer.jobs.store`.

**`employer/jobs/edit.blade.php`**
Pre-filled form to edit an existing job. Same fields as create. Uses `old()` with fallback to `$job` attribute values. Submits PUT to `employer.jobs.update`.

**`employer/jobs/show.blade.php`**
Employer's view of a specific job. Shows job details at the top. Below that, a list of all applicants for this job using `<x-employer.applicant-card>`.

**`employer/applicants/index.blade.php`**
All applicants for a specific job, paginated. The job title is shown as the page heading. Each applicant shown as an `<x-employer.applicant-card>`.

**`employer/applicants/show.blade.php`**
Full detail of a single applicant. Shows their name, email, resume text, application date, and status. If the application is still pending, shows Accept and Refuse buttons as POST forms. Back link to the applicants list.

**`employer/profile/edit.blade.php`**
Profile editing form for employers. Fields: name, email, company name.

**`employer/notifications/index.blade.php`**
Paginated list of notifications for this employer.

---

### Admin Pages

**`admin/dashboard.blade.php`**
Admin's home. Displays three stats: total users, total jobs, total applications. Quick links to the users list and logs.

**`admin/users/index.blade.php`**
Searchable, paginated table of all users. Each row is an `<x-admin.user-row>` component.

**`admin/users/show.blade.php`**
Detail view of a single user. Shows name, email, role badge, and registration date. If job seeker: shows resume and application count. If employer: shows company name and job count. Delete button with modal confirmation.

**`admin/logs/index.blade.php`**
A read-only monospace log viewer. Each line rendered as `<x-admin.log-row>`. Paginated at 50 lines per page, newest lines first.

---

### Error Pages

**`errors/404.blade.php`**
Shown when a URL doesn't match any route. Large "404" heading, "Page not found" message, back to home button.

**`errors/403.blade.php`**
Shown when a user tries to access something they're not authorized to. Large "403" heading, "Access denied" message.

**`errors/500.blade.php`**
Shown when an unexpected server error occurs. Large "500" heading, "Something went wrong" message.

---

## 15. Frontend — Tailwind and Alpine.js

### Tailwind CSS

Tailwind is a **utility-first CSS framework**. Instead of writing custom CSS classes, you apply small utility classes directly in your HTML:

```html
{{-- Without Tailwind --}}
<button class="submit-btn">Apply</button>

{{-- With Tailwind --}}
<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Apply</button>
```

**Entry point:** `resources/css/app.css`
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

**Config:** `tailwind.config.js` — the `content` array must include all Blade files so Tailwind knows which classes to include in the final CSS build.

**Build commands:**
- `npm run dev` — watch for changes and rebuild during development
- `npm run build` — production build (minified)

---

### Alpine.js

Alpine.js adds **reactive JavaScript behavior** directly in HTML using attributes. It's ideal for small interactive pieces like dropdowns, modals, and toggles.

**Entry point:** `resources/js/app.js`
```js
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()
```

**Common patterns used in J-Hub:**

Dropdown menu:
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Menu</button>
    <div x-show="open">Dropdown content</div>
</div>
```

Confirm before delete:
```html
<div x-data="{ showModal: false }">
    <button @click="showModal = true">Delete</button>
    <div x-show="showModal">
        <p>Are you sure?</p>
        <button @click="showModal = false">Cancel</button>
        <button @click="$refs.deleteForm.submit()">Confirm</button>
    </div>
    <form x-ref="deleteForm" method="POST" action="...">
        @csrf @method('DELETE')
    </form>
</div>
```

Dismissible alert:
```html
<div x-data="{ show: true }" x-show="show">
    <p>Success! Changes saved.</p>
    <button @click="show = false">×</button>
</div>
```

---

## 16. Key Laravel Concepts Used

**`$this->authorize()`** — called inside controllers to check policies. Throws a 403 exception if the check fails:
```php
$this->authorize('update', $job); // checks JobPolicy@update
```

**`@can` / `@cannot`** — Blade directives for checking policies in views:
```blade
@can('update', $job)
    <a href="{{ route('employer.jobs.edit', $job) }}">Edit</a>
@endcan
```

**Route Model Binding** — when a route parameter matches a model (e.g. `{job}`), Laravel automatically fetches the record from the database and injects it into the controller. If the record doesn't exist, it returns a 404 automatically:
```php
// Route: GET /employer/jobs/{job}
// Controller receives a Job instance, not just an ID
public function show(Job $job) { ... }
```

**`old($field, $default)`** — in Blade forms, retrieves the previously submitted value after a validation failure. Falls back to `$default` if no old value exists. Essential for pre-filling edit forms.

**Flash session messages** — one-time session data that survives exactly one redirect. Used for success/error messages:
```php
// In controller:
return redirect()->route('employer.jobs.index')->with('success', 'Job deleted.');

// In view:
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
```

**`@csrf`** — every POST/PUT/DELETE form must include this. It outputs a hidden input with a token that Laravel uses to verify the form was submitted from your own site (protects against Cross-Site Request Forgery attacks).

**`@method('PUT')` / `@method('DELETE')`** — HTML forms only support GET and POST. For PUT and DELETE routes, you add this directive which outputs a hidden `_method` field that Laravel reads to determine the intended HTTP method.

**Pagination** — Laravel's `paginate($n)` method automatically splits results into pages and generates pagination links:
```php
// Controller:
$jobs = Job::paginate(12);

// View:
{{ $jobs->links() }} // renders previous/next page links
```

**Eager Loading (`with()`)** — when you need a model's relationships, always load them upfront to avoid the N+1 query problem:
```php
// Bad — runs 1 query for jobs + 1 query per job to get employer = N+1 queries:
$jobs = Job::all();
foreach ($jobs as $job) { echo $job->employer->name; }

// Good — runs 2 queries total:
$jobs = Job::with('employer')->get();
```
