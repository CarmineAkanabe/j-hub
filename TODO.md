# J-Hub — Agent TODO

## Important Rules — Read Before Doing Anything

- Do **not** modify the following files under any circumstance:
  - `app/Models/User.php`
  - `app/Enums/UserRole.php`
  - `app/Enums/JobStatus.php`
  - `app/Enums/ApplicationStatus.php`
  - All migration files in `database/migrations/`
  - `database/seeders/DatabaseSeeder.php`
  - All factory files in `database/factories/`
  - `composer.json`, `package.json`, `vite.config.js`
- Do **not** create any file that already exists unless explicitly told to replace it
- Do **not** use any CDN links for CSS or JS — everything must go through npm and Vite
- Alpine.js must be installed via npm: `npm install alpinejs` and imported in `resources/js/app.js`
- Tailwind CSS is already configured — do not touch `tailwind.config.js` or `postcss.config.js`
- All views extend either `layouts.public` or `layouts.auth` — never write standalone HTML pages
- Always use `{{ csrf_field() }}` or `@csrf` inside forms
- Always use `{{ route('route.name') }}` for URLs, never hardcode paths
- After completing each phase, stop and wait for the user to review, commit, and confirm before proceeding

---

## Stack Reference

- **Framework:** Laravel 12
- **Templating:** Laravel Blade
- **Styling:** Tailwind CSS (via Vite)
- **JS:** Alpine.js (via npm)
- **Database:** MySQL
- **Auth:** Session-based (no Sanctum for web)
- **Images:** Stored in `public/images/` — use `asset('images/filename.jpg')` to reference them

---

## Models Reference

| Model | Table | Key Relationships |
|---|---|---|
| User | users | hasMany Jobs (as employer), hasMany Applications (as jobseeker), hasMany Notifications, hasMany Comments |
| Job | job_posts | belongsTo User (employer), hasMany Applications, hasMany Comments |
| Application | applications | belongsTo User (job_seeker_id), belongsTo Job |
| Notification | notifications | belongsTo User |
| Comment | comments | belongsTo User, belongsTo Job |

## Enums Reference

- `UserRole` — `JOBSEEKER`, `EMPLOYER`, `ADMIN`
- `JobStatus` — `OPEN`, `CLOSED`, `PAUSED`
- `ApplicationStatus` — `PENDING`, `ACCEPTED`, `REFUSED`

---

## Phase 1 — Foundation Setup
> Install JS dependencies, configure Vite, set up layouts, Alpine.js

### 1.1 Install and configure Alpine.js
- Run `npm install alpinejs`
- In `resources/js/app.js`, import and initialize Alpine:
```js
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()
```

### 1.2 Configure Tailwind content paths
- Open `tailwind.config.js` and ensure `content` includes:
```js
'./resources/views/**/*.blade.php',
'./resources/js/**/*.js',
```

### 1.3 Build `resources/views/layouts/public.blade.php`
- Full HTML shell for unauthenticated pages
- Include `@vite(['resources/css/app.css', 'resources/js/app.js'])` in `<head>`
- Include `<x-navbar.public-navbar />`
- Include `@yield('content')` in `<main>`
- Include `<x-footer />`
- Add `x-data` on `<body>` for Alpine scope

### 1.4 Build `resources/views/layouts/auth.blade.php`
- Full HTML shell for authenticated pages
- Include `@vite(['resources/css/app.css', 'resources/js/app.js'])` in `<head>`
- Include `<x-navbar.auth-navbar />`
- Flex layout: `@yield('sidebar')` on the left, `@yield('content')` on the right as `flex-1`
- Include `<x-footer />`

### 1.5 Build `resources/views/components/footer.blade.php`
- Simple footer with J-Hub name, tagline, current year via `{{ date('Y') }}`
- Tailwind styled

---

## Phase 2 — UI Primitive Components
> Build the reusable ui/ components that all other views will use

### 2.1 `resources/views/components/ui/button.blade.php`
- Props: `$variant` (default `'primary'`), `$type` (default `'button'`)
- Variants: `primary`, `secondary`, `danger`
- Styled with Tailwind, uses `{{ $slot }}`

### 2.2 `resources/views/components/ui/input.blade.php`
- Props: `$name`, `$label`, `$type` (default `'text'`), `$value` (default `''`), `$placeholder` (default `''`)
- Renders label + input + error message using `@error($name)`
- Uses `old($name, $value)` for value

### 2.3 `resources/views/components/ui/badge.blade.php`
- Props: `$color` (default `'gray'`), `$text`
- Small pill badge, colors: `green`, `red`, `yellow`, `gray`, `blue`

### 2.4 `resources/views/components/ui/alert.blade.php`
- Props: `$type` (default `'info'`) — `success`, `error`, `info`, `warning`
- Reads `session('success')`, `session('error')` automatically
- Dismissible using Alpine.js `x-data` / `x-show`

### 2.5 `resources/views/components/ui/modal.blade.php`
- Props: `$id`, `$title`
- Toggle using Alpine.js `x-data="{ open: false }"`
- Uses `{{ $slot }}` for modal body content
- Used for delete confirmations

### 2.6 `resources/views/components/application/application-status-badge.blade.php`
- Props: `$status` (ApplicationStatus enum value)
- Renders a `<x-ui.badge>` with correct color per status:
  - `pending` → yellow
  - `accepted` → green
  - `refused` → red

---

## Phase 3 — Navigation Components
> Navbar and sidebars for all roles

### 3.1 `resources/views/components/navbar/public-navbar.blade.php`
- J-Hub logo/name on the left (links to `home`)
- Right side: `Browse Jobs` link, `Login` link, `Register` dropdown with two options: `As Job Seeker`, `As Employer`
- Mobile hamburger menu using Alpine.js
- Tailwind styled, clean and modern

### 3.2 `resources/views/components/navbar/auth-navbar.blade.php`
- J-Hub logo/name on the left
- Right side: user avatar/name, dropdown with `Edit Profile` and `Logout`
- Logout is a POST form with `@csrf` inside the dropdown
- Mobile responsive using Alpine.js

### 3.3 `resources/views/components/sidebar/jobseeker-sidebar.blade.php`
- Links: Dashboard, My Applications, Profile, Notifications
- Highlight active link using `request()->routeIs()`
- Collapsible on mobile using Alpine.js

### 3.4 `resources/views/components/sidebar/employer-sidebar.blade.php`
- Links: Dashboard, My Jobs, Profile, Notifications
- Highlight active link using `request()->routeIs()`
- Collapsible on mobile using Alpine.js

### 3.5 `resources/views/components/sidebar/admin-sidebar.blade.php`
- Links: Dashboard, Users, System Logs
- Highlight active link using `request()->routeIs()`

---

## Phase 4 — Authentication
> Middleware, policies registration, login, register, logout

### 4.1 Write `app/Http/Middleware/RoleMiddleware.php`
- `handle()` method checks `auth()->user()->role` against the allowed role passed as parameter
- If mismatch, abort with 403
- If unauthenticated, redirect to login

### 4.2 Register middleware in `bootstrap/app.php`
- Register `RoleMiddleware` as `role` alias in the `withMiddleware` block:
```php
$middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
```

### 4.3 Write `app/Http/Requests/Auth/LoginRequest.php`
- Rules: `email` required|email, `password` required|string

### 4.4 Write `app/Http/Requests/Auth/RegisterJobSeekerRequest.php`
- Rules: `name` required|string, `email` required|email|unique:users, `password` required|min:8|confirmed, `resume` nullable|string

### 4.5 Write `app/Http/Requests/Auth/RegisterEmployerRequest.php`
- Rules: `name` required|string, `email` required|email|unique:users, `password` required|min:8|confirmed, `company_name` required|string

### 4.6 Write `app/Http/Controllers/Auth/AuthController.php`
- `showLogin()` — return `auth.login` view
- `login()` — use `Auth::attempt()`, on success redirect based on role using match on `UserRole` enum, on fail redirect back with error
- `logout()` — `Auth::logout()`, invalidate session, redirect to `home`

### 4.7 Write `app/Http/Controllers/Auth/RegisterController.php`
- `showJobSeekerForm()` — return `auth.register.jobseeker` view
- `showEmployerForm()` — return `auth.register.employer` view
- `registerJobSeeker()` — validate via `RegisterJobSeekerRequest`, create User with `role = UserRole::JOBSEEKER`, login, redirect to `jobseeker.dashboard`
- `registerEmployer()` — validate via `RegisterEmployerRequest`, create User with `role = UserRole::EMPLOYER`, login, redirect to `employer.dashboard`

### 4.8 Write auth routes in `routes/web.php`
- `GET /login` → `AuthController@showLogin` named `login`
- `POST /login` → `AuthController@login`
- `POST /logout` → `AuthController@logout` named `logout` (auth middleware)
- `GET /register/jobseeker` → `RegisterController@showJobSeekerForm` named `register.jobseeker`
- `POST /register/jobseeker` → `RegisterController@registerJobSeeker`
- `GET /register/employer` → `RegisterController@showEmployerForm` named `register.employer`
- `POST /register/employer` → `RegisterController@registerEmployer`

### 4.9 Build `resources/views/auth/login.blade.php`
- Extends `layouts.public`
- Email and password inputs using `<x-ui.input>`
- Submit button using `<x-ui.button>`
- Show `<x-ui.alert>` for auth errors
- Links to both register pages

### 4.10 Build `resources/views/auth/register/jobseeker.blade.php`
- Extends `layouts.public`
- Fields: name, email, password, password_confirmation, resume (textarea)
- Show validation errors via `<x-ui.alert>`
- Link to employer register and login

### 4.11 Build `resources/views/auth/register/employer.blade.php`
- Extends `layouts.public`
- Fields: name, email, password, password_confirmation, company_name
- Show validation errors via `<x-ui.alert>`
- Link to jobseeker register and login

---

## Phase 5 — Public Pages
> Home, about, job listings, job detail — no auth required

### 5.1 Write `app/Http/Controllers/Public/HomeController.php`
- `index()` — fetch 6 most recent open jobs, pass to `public.home`

### 5.2 Write `app/Http/Controllers/Public/JobController.php`
- `index()` — fetch paginated open jobs (12 per page), apply search (title, location) and filter (status, salary range) from query params, pass to `public.jobs.index`
- `show(Job $job)` — fetch job with employer and comments (with user), pass to `public.jobs.show`

### 5.3 Write public routes in `routes/web.php`
- `GET /` → `Public\HomeController@index` named `home`
- `GET /about` → returns `public.about` view directly (no controller needed)
- `GET /jobs` → `Public\JobController@index` named `jobs.index`
- `GET /jobs/{job}` → `Public\JobController@show` named `jobs.show`

### 5.4 Build `resources/views/public/home.blade.php`
- Extends `layouts.public`
- Hero section: headline, subtext, search bar linking to `jobs.index`, two CTA buttons (Find Jobs → register jobseeker, Post a Job → register employer)
- Hero background: use stock photo from `public/images/hero.jpg` with a dark overlay
- Featured jobs section: grid of 6 `<x-job.job-card>` components
- About/pitch section: short description of J-Hub with an image

### 5.5 Build `resources/views/public/about.blade.php`
- Extends `layouts.public`
- Static content: what J-Hub is, who it's for, how it works (3 steps for job seeker, 3 for employer)
- Use stock photos from `public/images/` for visual breaks

### 5.6 Build `resources/views/components/job/job-card.blade.php`
- Props: `$job` (Job model)
- Displays: job title, company name (employer), location, salary, status badge, posted date
- Links to `jobs.show`
- Tailwind card with hover effect

### 5.7 Build `resources/views/components/job/job-meta.blade.php`
- Props: `$job`
- Inline display of: location icon + location, salary icon + salary, status badge
- Used inside job detail views

### 5.8 Build `resources/views/public/jobs/partials/search-bar.blade.php`
- Input for keyword search (name `search`) and location (name `location`)
- Submits GET to `jobs.index`
- Preserves current values using `request('search')` and `request('location')`

### 5.9 Build `resources/views/public/jobs/partials/filters.blade.php`
- Salary range inputs (min, max), status filter select
- Submits GET to `jobs.index`
- Preserves current filter values

### 5.10 Build `resources/views/public/jobs/index.blade.php`
- Extends `layouts.public`
- Includes search-bar and filters partials
- Grid of `<x-job.job-card>` for each job
- Pagination links using `{{ $jobs->links() }}`
- Empty state message if no jobs found

### 5.11 Build `resources/views/public/jobs/show.blade.php`
- Extends `layouts.public`
- Job title, `<x-job.job-meta>`, full description
- Employer info block (company name)
- Apply button: if authenticated as jobseeker → POST form to `jobseeker.applications.store`; if not authenticated → link to `login`; if employer/admin → hide button
- Comments section at the bottom: list of comments, add comment form (auth only)

---

## Phase 6 — Job Components (Employer-facing)
> Components used in employer job management

### 6.1 Build `resources/views/components/job/job-list.blade.php`
- Props: `$job`
- List/row view of a job: title, location, status badge, applicant count, edit and delete actions
- Delete triggers a modal confirmation using `<x-ui.modal>`

### 6.2 Build `resources/views/components/employer/job-row.blade.php`
- Props: `$job`
- Table row version of a job for employer's jobs table
- Columns: title, location, status, applications count, posted date, actions (edit, delete)

### 6.3 Build `resources/views/components/employer/applicant-card.blade.php`
- Props: `$application`
- Displays: applicant name, application date, status badge, link to full detail
- Accept and Refuse buttons as POST forms

---

## Phase 7 — Job Seeker Features

### 7.1 Write `app/Policies/ApplicationPolicy.php`
- `create(User $user, Job $job)` — return true if user is jobseeker and has not already applied to this job
- `view(User $user, Application $application)` — return true if `$user->id === $application->job_seeker_id`
- `withdraw(User $user, Application $application)` — return true if user owns it and status is PENDING

### 7.2 Register `ApplicationPolicy` in `app/Providers/AppServiceProvider.php`
- Inside `boot()`, use `Gate::policy(Application::class, ApplicationPolicy::class)`

### 7.3 Write `app/Http/Controllers/JobSeeker/DashboardController.php`
- `index()` — fetch auth user's recent 5 applications with job, fetch unread notifications count, pass to `jobseeker.dashboard`

### 7.4 Write `app/Http/Controllers/JobSeeker/ApplicationController.php`
- `index()` — paginated list of auth user's applications with job relation
- `show(Application $application)` — authorize via policy, return detail view
- `store(Job $job)` — authorize via policy, create application with status PENDING and today's date, redirect back with success message
- `withdraw(Application $application)` — authorize via policy, update status to... actually delete the record, redirect back

### 7.5 Write `app/Http/Controllers/JobSeeker/ProfileController.php`
- `edit()` — return view with auth user
- `update(UpdateProfileRequest $request)` — update name, email, resume, redirect back with success

### 7.6 Write `app/Http/Controllers/JobSeeker/NotificationController.php`
- `index()` — paginated list of auth user's notifications ordered by date desc

### 7.7 Write jobseeker routes in `routes/web.php`
- Group with prefix `jobseeker`, middleware `['auth', 'role:jobseeker']`, name prefix `jobseeker.`
- `GET /jobseeker` → `JobSeeker\DashboardController@index` named `jobseeker.dashboard`
- `GET /jobseeker/applications` → `JobSeeker\ApplicationController@index` named `jobseeker.applications.index`
- `GET /jobseeker/applications/{application}` → `JobSeeker\ApplicationController@show` named `jobseeker.applications.show`
- `POST /jobseeker/applications/{job}` → `JobSeeker\ApplicationController@store` named `jobseeker.applications.store`
- `DELETE /jobseeker/applications/{application}` → `JobSeeker\ApplicationController@withdraw` named `jobseeker.applications.withdraw`
- `GET /jobseeker/profile/edit` → `JobSeeker\ProfileController@edit` named `jobseeker.profile.edit`
- `PUT /jobseeker/profile` → `JobSeeker\ProfileController@update` named `jobseeker.profile.update`
- `GET /jobseeker/notifications` → `JobSeeker\NotificationController@index` named `jobseeker.notifications.index`

### 7.8 Build `resources/views/jobseeker/dashboard.blade.php`
- Extends `layouts.auth`, injects `<x-sidebar.jobseeker-sidebar />`
- Welcome message with user name
- Stats row: total applications, pending count, accepted count
- Recent applications table (5 rows) with status badges and link to full list
- Notifications summary: unread count with link to notifications page

### 7.9 Build `resources/views/components/application/application-card.blade.php`
- Props: `$application`
- Displays: job title, employer/company, application date, status badge, link to detail
- Withdraw button (POST DELETE form) if status is pending — with modal confirmation

### 7.10 Build `resources/views/jobseeker/applications/index.blade.php`
- Extends `layouts.auth`, injects jobseeker sidebar
- Paginated list of `<x-application.application-card>` components
- Empty state if no applications

### 7.11 Build `resources/views/jobseeker/applications/show.blade.php`
- Extends `layouts.auth`, injects jobseeker sidebar
- Job title, company, location, salary, description
- Application date and current status badge
- Withdraw button if status is pending

### 7.12 Build `resources/views/jobseeker/profile/edit.blade.php`
- Extends `layouts.auth`, injects jobseeker sidebar
- Form: name, email, resume textarea
- PUT method via `@method('PUT')`
- Success alert using `<x-ui.alert>`

### 7.13 Build `resources/views/jobseeker/notifications/index.blade.php`
- Extends `layouts.auth`, injects jobseeker sidebar
- Paginated list of notification messages with dates
- Empty state if no notifications

---

## Phase 8 — Employer Features

### 8.1 Write `app/Policies/JobPolicy.php`
- `create(User $user)` — return true if user is employer
- `update(User $user, Job $job)` — return true if `$user->id === $job->employer_id`
- `delete(User $user, Job $job)` — return true if `$user->id === $job->employer_id`
- `viewApplicants(User $user, Job $job)` — return true if `$user->id === $job->employer_id`

### 8.2 Register `JobPolicy` in `AppServiceProvider`
- `Gate::policy(Job::class, JobPolicy::class)`

### 8.3 Write `app/Http/Requests/Job/StoreJobRequest.php`
- Rules: `title` required|string, `description` required|string, `location` required|string, `expected_salary` nullable|numeric|min:0, `status` required|in:open,closed,paused

### 8.4 Write `app/Http/Requests/Job/UpdateJobRequest.php`
- Same rules as StoreJobRequest, all fields optional using `sometimes`

### 8.5 Write `app/Http/Controllers/Employer/DashboardController.php`
- `index()` — fetch employer's jobs count, total applications across all jobs, recent 5 applications, pass to `employer.dashboard`

### 8.6 Write `app/Http/Controllers/Employer/JobController.php`
- `index()` — paginated list of auth employer's jobs
- `create()` — return create view
- `store(StoreJobRequest $request)` — authorize via policy, create job with `employer_id = auth()->id()`, redirect to `employer.jobs.index` with success
- `edit(Job $job)` — authorize via policy, return edit view with job
- `update(UpdateJobRequest $request, Job $job)` — authorize via policy, update job, redirect back with success
- `destroy(Job $job)` — authorize via policy, delete job, redirect to index with success
- `show(Job $job)` — authorize viewApplicants via policy, return show view with job and paginated applications

### 8.7 Write `app/Http/Controllers/Employer/ApplicantController.php`
- `index(Job $job)` — authorize via JobPolicy viewApplicants, paginated applicants for this job
- `show(Job $job, Application $application)` — return detail view
- `accept(Application $application)` — update status to ACCEPTED, create notification for the job seeker, redirect back with success
- `refuse(Application $application)` — update status to REFUSED, create notification for the job seeker, redirect back with success

### 8.8 Write `app/Http/Controllers/Employer/ProfileController.php`
- `edit()` — return view with auth user
- `update(UpdateProfileRequest $request)` — update name, email, company_name, redirect back with success

### 8.9 Write `app/Http/Controllers/Employer/NotificationController.php`
- `index()` — paginated list of auth employer's notifications

### 8.10 Write `app/Http/Requests/Profile/UpdateProfileRequest.php`
- Rules: `name` required|string, `email` required|email|unique:users,email,{auth user id}, `resume` nullable|string, `company_name` nullable|string

### 8.11 Write employer routes in `routes/web.php`
- Group with prefix `employer`, middleware `['auth', 'role:employer']`, name prefix `employer.`
- `GET /employer` → `Employer\DashboardController@index` named `employer.dashboard`
- `GET /employer/jobs` → `Employer\JobController@index` named `employer.jobs.index`
- `GET /employer/jobs/create` → `Employer\JobController@create` named `employer.jobs.create`
- `POST /employer/jobs` → `Employer\JobController@store` named `employer.jobs.store`
- `GET /employer/jobs/{job}/edit` → `Employer\JobController@edit` named `employer.jobs.edit`
- `PUT /employer/jobs/{job}` → `Employer\JobController@update` named `employer.jobs.update`
- `DELETE /employer/jobs/{job}` → `Employer\JobController@destroy` named `employer.jobs.destroy`
- `GET /employer/jobs/{job}` → `Employer\JobController@show` named `employer.jobs.show`
- `GET /employer/jobs/{job}/applicants` → `Employer\ApplicantController@index` named `employer.applicants.index`
- `GET /employer/jobs/{job}/applicants/{application}` → `Employer\ApplicantController@show` named `employer.applicants.show`
- `POST /employer/applications/{application}/accept` → `Employer\ApplicantController@accept` named `employer.applicants.accept`
- `POST /employer/applications/{application}/refuse` → `Employer\ApplicantController@refuse` named `employer.applicants.refuse`
- `GET /employer/profile/edit` → `Employer\ProfileController@edit` named `employer.profile.edit`
- `PUT /employer/profile` → `Employer\ProfileController@update` named `employer.profile.update`
- `GET /employer/notifications` → `Employer\NotificationController@index` named `employer.notifications.index`

### 8.12 Build `resources/views/employer/dashboard.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Stats row: total jobs posted, total applications received, pending applications count
- Recent applications table with applicant name, job title, date, status badge, link
- Quick action button: Post a Job

### 8.13 Build `resources/views/employer/jobs/index.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Table of employer's jobs using `<x-employer.job-row>` per row
- Post a Job button at the top right
- Empty state if no jobs yet

### 8.14 Build `resources/views/employer/jobs/create.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Form: title, description (textarea), location, expected_salary, status (select: open/closed/paused)
- Uses `<x-ui.input>` for fields
- POST to `employer.jobs.store`

### 8.15 Build `resources/views/employer/jobs/edit.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Same form as create but pre-filled with `old()` values falling back to `$job` attributes
- PUT via `@method('PUT')` to `employer.jobs.update`

### 8.16 Build `resources/views/employer/jobs/show.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Job details at the top
- List of applicants using `<x-employer.applicant-card>` per application
- Empty state if no applications yet

### 8.17 Build `resources/views/employer/applicants/index.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Paginated list of `<x-employer.applicant-card>` for the given job
- Job title as page heading

### 8.18 Build `resources/views/employer/applicants/show.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Applicant name, email, resume (displayed as formatted text)
- Application date and current status badge
- Accept and Refuse buttons as POST forms (hidden if already decided)
- Back link to applicants list

### 8.19 Build `resources/views/employer/profile/edit.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Form: name, email, company_name
- PUT to `employer.profile.update`
- Success alert

### 8.20 Build `resources/views/employer/notifications/index.blade.php`
- Extends `layouts.auth`, injects employer sidebar
- Paginated list of notification messages with dates
- Empty state if none

---

## Phase 9 — Comments

### 9.1 Write `app/Http/Controllers/CommentController.php`
- `store(Request $request, Job $job)` — validate `content` required|string|max:500, create comment with `user_id = auth()->id()` and `job_id = $job->id` and today's date, redirect back
- `destroy(Comment $comment)` — authorize that `auth()->id() === $comment->user_id` or user is admin, delete, redirect back

### 9.2 Write comment routes in `routes/web.php`
- `POST /jobs/{job}/comments` → `CommentController@store` named `comments.store` (middleware: auth)
- `DELETE /comments/{comment}` → `CommentController@destroy` named `comments.destroy` (middleware: auth)

---

## Phase 10 — Admin Features

### 10.1 Write `app/Policies/UserPolicy.php`
- `update(User $user, User $target)` — return true if `$user->id === $target->id`
- `delete(User $user, User $target)` — return true if user is admin and target is not admin

### 10.2 Register `UserPolicy` in `AppServiceProvider`
- `Gate::policy(User::class, UserPolicy::class)`

### 10.3 Write `app/Http/Controllers/Admin/DashboardController.php`
- `index()` — fetch total users count, total jobs count, total applications count, pass to `admin.dashboard`

### 10.4 Write `app/Http/Controllers/Admin/UserController.php`
- `index()` — paginated list of all users, searchable by name or email via query param
- `show(User $user)` — return detail view with user and their jobs/applications counts
- `destroy(User $user)` — authorize via policy, delete user, redirect to index with success

### 10.5 Write `app/Http/Controllers/Admin/LogController.php`
- `index()` — read `storage/logs/laravel.log`, parse into lines, paginate manually (50 lines per page), pass to `admin.logs.index`

### 10.6 Write admin routes in `routes/web.php`
- Group with prefix `admin`, middleware `['auth', 'role:admin']`, name prefix `admin.`
- `GET /admin` → `Admin\DashboardController@index` named `admin.dashboard`
- `GET /admin/users` → `Admin\UserController@index` named `admin.users.index`
- `GET /admin/users/{user}` → `Admin\UserController@show` named `admin.users.show`
- `DELETE /admin/users/{user}` → `Admin\UserController@destroy` named `admin.users.destroy`
- `GET /admin/logs` → `Admin\LogController@index` named `admin.logs.index`

### 10.7 Build `resources/views/admin/dashboard.blade.php`
- Extends `layouts.auth`, injects admin sidebar
- Stats row: total users, total jobs, total applications
- Quick links to users list and logs

### 10.8 Build `resources/views/components/admin/user-row.blade.php`
- Props: `$user`
- Table row: name, email, role badge, registered date, view and delete actions
- Delete triggers modal confirmation

### 10.9 Build `resources/views/admin/users/index.blade.php`
- Extends `layouts.auth`, injects admin sidebar
- Search bar (GET, name `search`)
- Table of users using `<x-admin.user-row>` per row
- Pagination links

### 10.10 Build `resources/views/admin/users/show.blade.php`
- Extends `layouts.auth`, injects admin sidebar
- User name, email, role badge, registered date
- If jobseeker: show resume and applications count
- If employer: show company name and jobs count
- Delete account button with modal confirmation

### 10.11 Build `resources/views/components/admin/log-row.blade.php`
- Props: `$line` (string)
- Renders a single log line in monospace font
- Color code by log level: ERROR → red, WARNING → yellow, INFO → gray

### 10.12 Build `resources/views/admin/logs/index.blade.php`
- Extends `layouts.auth`, injects admin sidebar
- Monospace log viewer, one `<x-admin.log-row>` per line
- Pagination controls

---

## Phase 11 — Error Pages

### 11.1 Build `resources/views/errors/404.blade.php`
- Extends `layouts.public`
- Large 404 text, "Page not found" message, back to home button

### 11.2 Build `resources/views/errors/403.blade.php`
- Extends `layouts.public`
- Large 403 text, "Access denied" message, back to home button

### 11.3 Build `resources/views/errors/500.blade.php`
- Extends `layouts.public`
- Large 500 text, "Something went wrong" message, back to home button

---

## Phase 12 — Stock Photos

### 12.1 Download and place images
- Download the following from Unsplash (free, no account needed) and place in `public/images/`:
  - `hero.jpg` — office or workspace, wide/landscape (search: "modern office workspace")
  - `about-1.jpg` — team collaboration (search: "team collaboration office")
  - `about-2.jpg` — job interview or handshake (search: "job interview professional")
  - `placeholder-avatar.jpg` — generic person silhouette (search: "person silhouette professional")
- Reference in Blade using `asset('images/filename.jpg')`

---

## Phase 13 — Final Polish

### 13.1 Redirect authenticated users away from guest pages
- In `AuthController@showLogin` and `RegisterController@show*` methods, add:
```php
if (auth()->check()) {
    return redirect()->route(auth()->user()->role->value . '.dashboard');
}
```

### 13.2 Add `<x-ui.alert>` to all views that perform actions
- Ensure every view that redirects with `session('success')` or `session('error')` renders the alert component at the top of `@section('content')`

### 13.3 Confirm all forms use `@csrf` and correct `@method()` directives
- PUT/PATCH forms need `@method('PUT')`
- DELETE forms need `@method('DELETE')`

### 13.4 Run final check
- `php artisan route:list` — confirm all routes are registered correctly
- `php artisan migrate:fresh --seed` — confirm DB seeds without errors
- `npm run build` — confirm Vite builds without errors
- Manually test: register as jobseeker, register as employer, login as admin, post a job, apply, accept/refuse
