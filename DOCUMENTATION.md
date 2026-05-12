# J-Hub Project Documentation

This document explains the J-Hub application in beginner-friendly language. It is meant for teammates who understand basic PHP/HTML, but may still be learning Laravel.

J-Hub is a job portal. Visitors can browse jobs. Job seekers can register, apply to jobs, comment on jobs, manage their comments, and track application updates. Employers can post jobs, review applicants, accept or refuse applications, and receive notifications. Admins can monitor users, view activity, and delete accounts.

## 1. The Big Picture

The app has four kinds of people:

- Visitor: someone who is not logged in.
- Job seeker: a registered user looking for jobs.
- Employer: a registered user posting jobs and reviewing applicants.
- Admin: a platform manager.

The main workflow is:

1. An employer creates a job.
2. A visitor or job seeker browses job listings.
3. A job seeker applies to a job.
4. The employer reviews the application.
5. The employer accepts or refuses the application.
6. The job seeker receives a notification with a link to the application.
7. Job seekers can comment on job posts, edit their own comments, delete their own comments, and see all comments they have made.
8. Employers are notified when comments are created, updated, or deleted.
9. Admins can monitor users, logs, totals, and platform activity.

## 2. Technology Used

| Part | Technology | Why it is used |
|---|---|---|
| Backend framework | Laravel 13 | Handles routing, controllers, models, authentication, validation, and database access. |
| Templates | Blade | Laravel's HTML templating system. |
| Styling | Tailwind CSS v4 | Utility CSS classes for building the UI. |
| JavaScript | Alpine.js | Small interactions such as dropdowns, modals, dismissible alerts, and the homepage carousel. |
| Database | MySQL | Stores users, jobs, applications, comments, and notifications. |
| Build tool | Vite | Compiles CSS and JavaScript assets. |

## 3. Important Laravel Ideas

Routes decide which controller method handles a URL. Routes live in `routes/web.php`.

Controllers contain request logic. They receive requests, query models, and return views or redirects.

Models represent database tables. For example, `User` represents the `users` table and `Job` represents the `jobs_post` table.

Migrations define database table structure. Running `php artisan migrate` creates or updates the tables.

Factories and seeders create fake/sample data. Running `php artisan migrate:fresh --seed` builds the database and fills it with test users, jobs, applications, comments, and notifications.

Blade views are HTML templates. They live in `resources/views`.

Components are reusable Blade pieces. Examples include buttons, navbars, sidebars, job cards, badges, and alerts.

Middleware runs before a controller. The `RoleMiddleware` checks if a logged-in user has the correct role.

Form Requests are validation classes. They keep validation rules out of controllers.

## 4. Main Folder Structure

```text
app/
  Enums/
    ApplicationStatus.php
    JobStatus.php
    UserRole.php
  Http/
    Controllers/
    Middleware/
    Requests/
  Models/
  Policies/
    ApplicationPolicy.php
    CommentPolicy.php
    JobPolicy.php
    UserPolicy.php

database/
  factories/
  migrations/
  seeders/

public/
  fonts/
  images/
    j-hub-logo.svg
    home/

resources/
  css/app.css
  js/app.js
  views/
    admin/
    auth/
    components/
    employer/
    errors/
    jobseeker/
    layouts/
    public/

routes/
  web.php
```

## 5. Enums

Enums are fixed sets of allowed values. They prevent spelling mistakes in important strings.

### `app/Enums/UserRole.php`

Defines user roles:

- `jobseeker`
- `employer`
- `admin`

The `users.role` column is stored as a string in the database, but Laravel casts it to this enum in the `User` model.

### `app/Enums/JobStatus.php`

Defines job listing statuses:

- `open`
- `closed`
- `paused`

Only open jobs are shown in the main public job list.

### `app/Enums/ApplicationStatus.php`

Defines application statuses:

- `pending`
- `accepted`
- `refused`

New applications start as pending. Employers later accept or refuse them.

## 6. Database Tables

### `users`

Stores all users. There is no separate table for job seekers, employers, or admins. One `role` column decides what kind of user it is.

Important columns:

- `name`
- `email`
- `password`
- `role`
- `resume` for job seekers
- `company_name` for employers

### `jobs_post`

Stores job listings. The table is named `jobs_post` because Laravel already has a default `jobs` table for queues.

Important columns:

- `employer_id`: the user who posted the job
- `title`
- `description`
- `location`
- `expected_salary`
- `status`

### `applications`

Stores job applications.

Important columns:

- `job_seeker_id`: the user applying
- `job_id`: the job being applied to
- `status`: pending, accepted, or refused
- `date`

### `comments`

Stores comments on jobs.

Important columns:

- `user_id`: the job seeker who wrote the comment
- `job_id`: the job being commented on
- `content`
- `date`

Job seekers can now create, edit, delete, and list their own comments.

### `notifications`

Stores messages sent to users.

Important columns:

- `user_id`: who receives the notification
- `message`: text shown to the user
- `action_url`: optional link to the relevant page
- `date`

The `action_url` is nullable because some notifications do not need a link. Admin deleted-user events are log-related and do not use notification links.

## 7. Models and Relationships

### `User`

Represents one user account.

Important relationships:

- `jobs()`: an employer has many jobs.
- `applications()`: a job seeker has many applications.
- `notifications()`: a user has many notifications.
- `comments()`: a user has many comments.

Important helper methods:

- `isJobSeeker()`
- `isEmployer()`
- `isAdmin()`

### `Job`

Represents one job listing from `jobs_post`.

Important relationships:

- `employer()`: a job belongs to one employer.
- `applications()`: a job has many applications.
- `comments()`: a job has many comments.

### `Application`

Represents one job seeker applying to one job.

Important relationships:

- `jobSeeker()`: the applicant.
- `job()`: the job they applied to.

### `Comment`

Represents one comment on a job.

Important relationships:

- `user()`: the comment author.
- `job()`: the commented job.

### `Notification`

Represents one notification.

Important relationships:

- `user()`: the receiver.

## 8. Routes

All main web routes live in `routes/web.php`.

### Public routes

```text
GET /              home page
GET /about         about page
GET /jobs          job listing page
GET /jobs/{job}    job detail page
```

Visitors can view these pages without logging in.

### Auth routes

```text
GET  /login
POST /login
POST /logout
GET  /register/jobseeker
POST /register/jobseeker
GET  /register/employer
POST /register/employer
```

There are separate registration pages for job seekers and employers.

### Job seeker routes

These routes require login and the `jobseeker` role.

```text
GET    /jobseeker/dashboard
GET    /jobseeker/applications
GET    /jobseeker/applications/{application}
GET    /jobseeker/comments
GET    /jobseeker/comments/{comment}/edit
PATCH  /jobseeker/comments/{comment}
DELETE /jobseeker/comments/{comment}
GET    /jobseeker/notifications
GET    /jobseeker/profile
PATCH  /jobseeker/profile
POST   /jobs/{job}/apply
POST   /jobs/{job}/comments
```

Important safety detail: when editing, updating, deleting, or viewing comments/applications, controllers call policies before the action is completed. This prevents one user from managing another user's records.

### Employer routes

These routes require login and the `employer` role.

```text
GET    /employer/dashboard
GET    /employer/jobs
GET    /employer/jobs/create
POST   /employer/jobs
GET    /employer/jobs/{job}
GET    /employer/jobs/{job}/edit
PUT    /employer/jobs/{job}
PATCH  /employer/jobs/{job}
DELETE /employer/jobs/{job}
GET    /employer/applicants
GET    /employer/applicants/{application}
PATCH  /employer/applicants/{application}/status
GET    /employer/notifications
GET    /employer/profile
PATCH  /employer/profile
```

Employer job routes are protected by `JobPolicy`, so employers can only view, edit, update, and delete jobs they own.

### Admin routes

These routes require login and the `admin` role.

```text
GET    /admin/dashboard
GET    /admin/users
GET    /admin/users/{user}
DELETE /admin/users/{user}
GET    /admin/logs
GET    /admin/profile
PATCH  /admin/profile
```

Admins can view users, delete users, view paginated logs/activity, and edit their own profile.

## 9. Controllers

### Public controllers

`HomeController` loads the homepage. It redirects logged-in users to their dashboard. For guests, it loads featured jobs and platform stats for the homepage.

`Public\JobController` loads job listings and single job pages. It supports keyword and location search.

### Auth controllers

`AuthController` handles login, logout, and redirecting users to the correct dashboard after login. Login and registration routes use guest middleware, so logged-in users cannot accidentally create or switch accounts through the public auth pages.

`RegisterController` handles separate job seeker and employer registration.

### Job seeker controllers

`JobSeeker\DashboardController` loads the job seeker dashboard.

`JobSeeker\ApplicationController` lists applications, shows one application, and creates a new application. It prevents duplicate applications to the same job.

`JobSeeker\ProfileController` handles profile editing.

`JobSeeker\NotificationController` lists notifications.

### Comment controller

`CommentController` handles job seeker comments.

It can:

- list all comments made by the logged-in job seeker
- create a comment on a job
- show an edit page for a comment
- update a comment
- delete a comment

When a comment is created, updated, or deleted, the employer who owns the job gets a notification. For created and updated comments, the notification links to the job and comment anchor. For deleted comments, the notification links to the job because the exact comment no longer exists.

### Employer controllers

`Employer\DashboardController` loads employer totals, recent jobs, and a simple chart comparing jobs posted with applications received.

`Employer\JobController` handles job CRUD: create, read, update, delete.

`Employer\ApplicantController` lists applicants, shows one applicant, and updates application status.

`Employer\ProfileController` handles company profile editing.

`Employer\NotificationController` lists employer notifications.

### Admin controllers

`Admin\DashboardController` loads totals and a simple chart comparing employer accounts with job seeker accounts.

`Admin\UserController` lists users, shows user details, and deletes user accounts. `UserPolicy` prevents an admin from deleting their own account.

`Admin\LogController` builds a readable paginated activity list from recent users, applications, comments, and deletion log entries.

`Admin\ProfileController` lets admins update their own name, email, and password.

## 10. Validation

Validation rules are stored in Form Request classes:

- `LoginRequest`
- `RegisterJobSeekerRequest`
- `RegisterEmployerRequest`
- `StoreJobRequest`
- `UpdateJobRequest`
- `UpdateProfileRequest`

This keeps controllers cleaner. If validation fails, Laravel automatically redirects back and shows errors in the form.

## 11. Middleware

`RoleMiddleware` protects role-specific routes.

Example:

```php
Route::middleware(['auth', 'role:employer'])->group(function () {
    // employer-only routes
});
```

The middleware checks:

1. Is the user logged in?
2. Does the user's role match the required role?

If not, the user is redirected or gets a 403 error.

Middleware only answers the broad role question, such as "is this user an employer?" or "is this user an admin?" It does not decide whether a user owns one specific job, application, or comment.

## 11.1 Policies

Policies protect model-specific actions. They answer ownership and permission questions such as:

- Can this employer view, edit, or delete this exact job?
- Can this employer review this exact application?
- Can this job seeker view this exact application?
- Can this job seeker edit or delete this exact comment?
- Can this admin delete this exact user account?

Policy files live in `app/Policies` and are registered in `app/Providers/AppServiceProvider.php`.

Current policies:

- `JobPolicy`: employers can create jobs; job owners can view, update, and delete their own jobs; admins can view jobs.
- `ApplicationPolicy`: job seekers can create applications; job seekers can view their own applications; employers can view and update applications attached to their own jobs; admins can view applications.
- `CommentPolicy`: job seekers can create comments; comment authors can update and delete their own comments; admins, authors, and job owners can view comments.
- `UserPolicy`: admins can list and view users; admins can delete users except their own account.

Controllers call policies with `Gate::authorize(...)` before protected model actions. The role middleware still remains in place, so policies do not replace login or role checks. They add the more precise ownership checks.

## 12. Views and Layouts

### `resources/views/layouts/public.blade.php`

Used by public pages such as home, about, jobs, login, and register.

It includes:

- browser favicon
- CSS and JavaScript through Vite
- public navbar or auth navbar depending on login state
- main page content
- footer

The body uses a flex column layout so the footer stays at the bottom of short pages.

### `resources/views/layouts/auth.blade.php`

Used by logged-in dashboards and account pages.

It includes:

- browser favicon
- auth navbar
- sidebar slot
- main content area

The footer is not currently shown on auth pages.

## 13. Navigation and Footer

### Public navbar

File: `resources/views/components/navbar/public-navbar.blade.php`

Shows:

- J-Hub SVG logo
- Home
- Jobs
- About
- Login
- Sign up

### Auth navbar

File: `resources/views/components/navbar/auth-navbar.blade.php`

Shows:

- J-Hub SVG logo
- Jobs
- About
- Account/Dashboard link based on role
- welcome text
- logout button

### Sidebars

Job seeker sidebar:

- Dashboard
- Applications
- Comments
- Notifications
- Profile

Employer sidebar:

- Dashboard
- Jobs
- Applicants
- Notifications
- Profile

Admin sidebar:

- Dashboard
- Users
- Logs
- Profile

### Footer

File: `resources/views/components/footer.blade.php`

Shown on public pages. The public layout pushes it to the bottom on short pages.

## 14. Public Pages

### Home page

File: `resources/views/public/home.blade.php`

The homepage includes:

- full-width hero section
- background image carousel using Alpine.js
- search form for jobs
- calls to action for job seekers and employers
- real platform stats from the database
- featured jobs
- explanation of who the platform serves
- final call to action

Images used by the homepage are stored locally in `public/images/home`.

### About page

File: `resources/views/public/about.blade.php`

The about page explains:

- what J-Hub is
- what the platform provides
- how it supports job seekers, employers, and admins
- the project team

The team names, roles, descriptions, and GitHub links are kept in the page.

### Jobs index page

File: `resources/views/public/jobs/index.blade.php`

Shows open jobs with search, location filter, and pagination.

### Job detail page

File: `resources/views/public/jobs/show.blade.php`

Shows:

- job title, employer, location, salary, and description
- apply button for job seekers
- login/register prompt for guests
- comments
- comment form for job seekers
- edit/delete buttons for the current user's own comments

## 15. Auth Pages

### Login

File: `resources/views/auth/login.blade.php`

Allows users to log in. After login, users are redirected based on role.

The login and registration pages are guest-only. If a user is already logged in, Laravel redirects them away from these pages.

### Job seeker registration

File: `resources/views/auth/register/jobseeker.blade.php`

Creates a job seeker account.

### Employer registration

File: `resources/views/auth/register/employer.blade.php`

Creates an employer account.

## 16. Job Seeker Pages

### Dashboard

File: `resources/views/jobseeker/dashboard.blade.php`

Shows job seeker account activity.

### Applications list

File: `resources/views/jobseeker/applications/index.blade.php`

Shows all applications submitted by the logged-in job seeker.

### Application detail

File: `resources/views/jobseeker/applications/show.blade.php`

Shows one application and its status.

### Comments list

File: `resources/views/jobseeker/comments/index.blade.php`

Shows every comment made by the logged-in job seeker, along with the job it belongs to.

From this page, the job seeker can:

- view the job
- edit the comment
- delete the comment

### Comment edit

File: `resources/views/jobseeker/comments/edit.blade.php`

Allows a job seeker to update their own comment.

### Notifications

File: `resources/views/jobseeker/notifications/index.blade.php`

Shows notifications for the logged-in job seeker. If a notification has an `action_url`, a View button appears.

### Profile

File: `resources/views/jobseeker/profile/edit.blade.php`

Allows the job seeker to edit name, email, and resume.

## 17. Employer Pages

### Dashboard

File: `resources/views/employer/dashboard.blade.php`

Shows:

- number of jobs posted
- number of applications received
- number of recent jobs
- simple bar chart comparing jobs and applications
- latest job posts

The chart is built from existing database data. No migration or model change was needed.

### Jobs pages

Files:

- `resources/views/employer/jobs/index.blade.php`
- `resources/views/employer/jobs/create.blade.php`
- `resources/views/employer/jobs/edit.blade.php`
- `resources/views/employer/jobs/show.blade.php`

Employers can create, update, view, and delete their own jobs.

### Applicant pages

Files:

- `resources/views/employer/applicants/index.blade.php`
- `resources/views/employer/applicants/show.blade.php`

Employers can review applicants, view the job seeker's resume, and update application status.

When an application is accepted or refused, the job seeker gets a linked notification.

### Notifications

File: `resources/views/employer/notifications/index.blade.php`

Shows employer notifications. Linked notifications have a View button.

### Profile

File: `resources/views/employer/profile/edit.blade.php`

Allows employers to edit name, email, and company name.

## 18. Admin Pages

### Dashboard

File: `resources/views/admin/dashboard.blade.php`

Shows:

- users count
- jobs count
- applications count
- comments count
- simple bar chart comparing employers and job seekers

The chart is built from existing user role counts. No migration or model change was needed.

### Users list

File: `resources/views/admin/users/index.blade.php`

Shows all users.

### User detail

File: `resources/views/admin/users/show.blade.php`

Shows details for one user. Admins can delete users from here.

### Logs

File: `resources/views/admin/logs/index.blade.php`

Shows paginated activity entries and admin deletion log entries.

### Profile

File: `resources/views/admin/profile/edit.blade.php`

Allows admins to edit their name, email, and password.

## 19. Components

Components keep repeated UI consistent.

Common UI components:

- `x-ui.button`
- `x-ui.input`
- `x-ui.badge`
- `x-ui.alert`
- `x-ui.modal`

Job components:

- `x-job.job-card`
- `x-job.job-list`
- `x-job.job-meta`
- `x-job.filter-panel`

Application components:

- `x-application.application-card`
- `x-application.application-form`
- `x-application.application-status-badge`

The application status badge accepts either raw status strings or `ApplicationStatus` enum values, and falls back to pending styling for unexpected values.

Admin and employer components:

- `x-admin.user-row`
- `x-admin.log-row`
- `x-employer.job-row`
- `x-employer.applicant-card`

User components:

- `x-user.avatar`
- `x-user.profile-form`

## 20. Frontend Assets

### CSS

File: `resources/css/app.css`

Contains:

- Tailwind v4 import
- Tailwind `@source` paths
- local font declarations
- theme colors
- global link/button hover styles
- `[x-cloak]` support for Alpine.js

Important note: this project uses Tailwind v4, so styling configuration is in `app.css`, not `tailwind.config.js`.

### JavaScript

File: `resources/js/app.js`

Imports Alpine.js and starts it.

### Images

Important image files:

- `public/images/j-hub-logo.svg`: favicon and navbar logo.
- `public/images/home/interview-office.jpg`
- `public/images/home/candidate-review.jpg`
- `public/images/home/remote-interview.jpg`
- `public/images/home/offer-handshake.jpg`

The homepage and about page use local images rather than remote hotlinks.

## 21. Notifications

Notifications are created in several places:

- when a job seeker applies to a job
- when an employer accepts or refuses an application
- when a job seeker creates a comment
- when a job seeker updates a comment
- when a job seeker deletes a comment

The optional `action_url` field lets notification pages show a View button.

Examples:

- New application notification links employer to applicant detail.
- Accepted/refused notification links job seeker to application detail.
- New/updated comment notification links employer to the job comment.
- Deleted comment notification links employer to the job.

## 22. Charts

The dashboards use simple bar charts built with Blade and Tailwind.

Employer chart:

- Jobs Posted
- Applications Received

Admin chart:

- Employers
- Job Seekers

No chart library is installed. No database changes are required. The controller calculates counts and widths, then the Blade view renders proportional bars.

## 23. Error Pages

Error views live in `resources/views/errors`.

- `403.blade.php`: shown when a user is not allowed to access something.
- `404.blade.php`: shown when a page or model does not exist.
- `500.blade.php`: shown for unexpected server errors.

These pages are useful even in a class project because role restrictions and missing URLs can happen during testing.

## 24. Running the Project

Install dependencies:

```bash
composer install
npm install
```

Set up environment:

```bash
cp .env.example .env
php artisan key:generate
```

Configure MySQL in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jhub
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create and seed tables:

```bash
php artisan migrate:fresh --seed
```

Run the app:

```bash
php artisan serve
npm run dev
```

Build assets for production:

```bash
npm run build
```

Run tests:

```bash
php artisan test
```

## 25. Seeded Data

The seeder creates:

- one admin user
- five employers
- twenty job seekers
- jobs for employers
- applications for jobs
- comments on jobs
- notifications for users

Default admin account:

```text
Email: admin@jhub.com
Password: password
```

Generated employer and job seeker accounts also use:

```text
Password: password
```

## 26. Important Notes for Teammates

- Do not confuse Laravel's default `jobs` queue table with this app's `jobs_post` job listing table.
- Role behavior is controlled by `UserRole`, not a separate roles table.
- Most ownership checks are done by querying through `auth()->user()`, such as `auth()->user()->comments()->findOrFail(...)`.
- If you add a new form, use CSRF protection with `@csrf`.
- If a form updates or deletes something, use `@method('PATCH')`, `@method('PUT')`, or `@method('DELETE')`.
- If you add a new protected page, place it in the correct role middleware group.
- Keep login and registration routes guest-only so authenticated users cannot accidentally switch accounts.
- If a protected page acts on a specific model, add or update a policy and call `Gate::authorize(...)` in the controller.
- If you add a new notification that should link somewhere, set `action_url`.
- Keep public images in `public/images`.
- Keep reusable UI in Blade components when it appears in multiple places.

## 27. Current Completion Summary

Implemented:

- Public homepage with carousel and local stock photos
- Professional about page
- Public job browsing and job detail pages
- Login and separate registration flows
- Job seeker applications
- Job seeker comment create/edit/delete/list
- Linked notifications
- Employer job CRUD
- Employer applicant review and status decisions
- Employer applicant resume visibility
- Admin dashboard, users, paginated logs, and profile editing
- Dashboard bar charts using existing data
- SVG J-Hub logo and favicon
- Sticky-bottom footer on public pages
- Polished sticky sidebars for authenticated pages
- Error pages
- Seeded demo data
- Active policies for job, application, comment, and user authorization

The app is ready for demonstration as a class project.
