Phase 1 — Tailwind + Fonts + App.css
Purely CSS. Configure @theme in app.css with colors and font variables. Set up @font-face declarations pointing to /fonts/ directory. Nothing else.
Phase 2 — Base Layouts
Build layouts/public.blade.php and layouts/auth.blade.php as proper shells. Vite tags, font classes on body, @yield slots, nothing fancy yet — just the skeleton that everything else extends.
Phase 3 — UI Primitives
Build only: button, input, badge, alert, modal in components/ui/. And application-status-badge. No views yet — just these components so everything else can use them.
Phase 4 — Navigation
Build public navbar (with inline SVG logo), auth navbar, and all three sidebars. Alpine.js for mobile toggle and dropdowns. Active link detection. Nothing connects to routes yet — just the HTML structure.
Phase 5 — Footer + Layouts Wired Up
Build footer. Wire navbar and footer into both layouts. At this point npm run dev + php artisan serve should show a styled shell at any URL.
Phase 6 — Home Page (Visible Milestone)
Build HomeController, its route (GET /), and public/home.blade.php. Hero section (stock photo from public/images/hero.jpg + dark overlay, headline, search bar, two CTA buttons), featured jobs section (6 cards from DB), pitch section. This is the first thing you actually see in the browser.
Phase 7 — Remaining Public Pages
public/about.blade.php, public/jobs/index.blade.php, public/jobs/show.blade.php, search bar partial, filters partial, Public/JobController, and those routes. Job card and job meta components.
Phase 8 — Auth Backend
RoleMiddleware → register in bootstrap/app.php. All three Form Requests (Login, RegisterJobSeeker, RegisterEmployer). AuthController and RegisterController. Auth routes in web.php.
Phase 9 — Auth Views
auth/login.blade.php, auth/register/jobseeker.blade.php, auth/register/employer.blade.php. Wire them to the controllers. Test login redirects by role.
Phase 10 — Job Seeker Backend + Views
ApplicationPolicy, all JobSeeker controllers, jobseeker route group, all jobseeker views.
Phase 11 — Employer Backend + Views
JobPolicy, all Employer controllers, employer route group, all employer views.
Phase 12 — Comments
CommentController, comment routes, wire comment form into jobs/show.blade.php.
Phase 13 — Admin Backend + Views
UserPolicy, all Admin controllers, admin route group, admin views, user-row, log-row components.
Phase 14 — Error Pages + Final Polish
404, 403, 500. Auth redirect for already-logged-in users. CSRF/method audit. Full flow test. npm run build.

Key Rules That Will Be Hardcoded Into Every Phase

Tailwind v4 — @theme in app.css only, no tailwind.config.js
No CDN links — fonts in public/fonts/, Alpine.js via npm
No image generation — stock photos downloaded manually and placed in public/images/
No new PHP files outside the ones explicitly listed
Routes added only via explicit instruction — never auto-generated
Alpine.js imported in resources/js/app.js only
