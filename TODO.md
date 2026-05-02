Phase 1 — Tailwind + Fonts + App.css
- Set up Tailwind v4 in `resources/css/app.css` with the color palette, font variables, and global styles.
- Add local font loading for `Inter` and `Plus Jakarta Sans` from `public/fonts/`.
- Standardize link hover behavior and button interaction transitions across the app.

Phase 2 — Layouts and Navigation
- Built `resources/views/layouts/public.blade.php` and `resources/views/layouts/auth.blade.php`.
- Implemented the public navbar and authenticated navbar with logout support.
- Built role-specific sidebars for job seekers, employers, and admins.
- Added active route highlighting and consistent sidebar behavior.

Phase 3 — UI Primitives
- Created reusable components: `x-ui.button`, `x-ui.input`, `x-ui.badge`, `x-ui.alert`, and `x-ui.modal`.
- Switched button usage across pages to `x-ui.button` for consistent styling.

Phase 4 — Public Experience
- Implemented the home page, jobs listing, job detail page, and professional about page.
- Added job search, filtering, pagination, and job cards.
- Ensured visitors can browse jobs and read the platform overview without logging in.

Phase 5 — Authentication
- Implemented login and separate registration flows for job seekers and employers.
- Built `AuthController` and `RegisterController` with validation and role-based redirects.
- Added secure logout handling via the authenticated navbar.

Phase 6 — Job Seeker Features
- Added the job seeker dashboard, application list, application detail page, profile editing, and notifications.
- Implemented application submission from job detail pages.
- Added job seeker comment creation on job detail pages and employer notification for new comments.

Phase 7 — Employer Features
- Added the employer dashboard, job posting CRUD, applicant review pages, employer profile editing, and notifications.
- Implemented applicant accept/refuse flows with notification delivery to the job seeker.

Phase 8 — Admin Tools
- Added the admin dashboard, user management pages, and system log viewer.
- Logged admin account deletions and surfaced them in the admin logs page.
- Included aggregate counts for users, jobs, applications, and comments.

Phase 9 — Polish and Documentation
- Refined sidebar, navbar, button, and layout styles to improve consistency.
- Updated `DOCUMENTATION.md` and `TODO.md` to match the current implementation.
- Verified that the current route and controller behavior aligns with the documented app flows.

Key Rules That Apply

- Tailwind v4 — use `@theme` in `app.css` only, no `tailwind.config.js`.
- No CDN links — fonts live in `public/fonts/`, Alpine.js is installed via npm.
- No image generation — UI assets are managed locally.
- No new PHP files outside the existing Laravel structure.
- Routes are only added by explicit instruction.
- Alpine.js is imported in `resources/js/app.js` only.
