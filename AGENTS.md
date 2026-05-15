# AGENTS.md — CampusLMS

Laravel 13.x + Breeze (Blade + Alpine), PHP 8.3+, SQLite, Vite 8 + Tailwind 3 + PostCSS.

## Commands

| Command | What it does |
|---|---|
| `composer setup` | Full first-time setup: install, `.env`, key:generate, migrate, `npm install`, `npm run build` |
| `composer dev` | Runs four processes concurrently: `artisan serve`, `queue:listen`, `pail` (logs), `vite` dev |
| `composer test` | `artisan config:clear` then `artisan test` (PHPUnit) |
| `./vendor/bin/pint` | PHP linting (Laravel Pint, default rules) |
| `php artisan test --filter=TestName` | Run a single test |
| `npm run build` | Vite production build |
| `npm run dev` | Vite dev server only |

## Notable defaults (differ from framework norms)

- **`.npmrc` has `ignore-scripts=true`** — `npm install` alone will NOT run postinstall scripts. Use `composer setup` or `npm install --ignore-scripts`.
- **Queue, cache, session all use `database` driver** (not file/array). Relevant DB migrations are included.
- **Mail defaults to `log` driver** — no SMTP needed in dev.
- **`.env` has `APP_DEBUG=true` and `LOG_LEVEL=debug`** by default.
- **No CI configured** — no `.github/workflows/`.

## Testing

- **`phpunit.xml`** uses in-memory SQLite — no external DB needed.
- Tests live in `tests/Unit/` and `tests/Feature/`.

## Key packages (beyond default scaffold)

- `spatie/laravel-permission` — roles/permissions (migration already published)
- `barryvdh/laravel-dompdf` — PDF generation
- `simplesoftwareio/simple-qrcode` — QR code generation
- `laravel/breeze` (blade-alpine stack) — auth scaffolding installed (routes, controllers, views)
- `laravel/sanctum` — API authentication

## Architecture

- Standard Laravel structure. Entrypoint: `public/index.php` → `bootstrap/app.php`.
- Routes: `routes/web.php` (web + role redirects), `routes/admin.php`, `routes/dosen.php`, `routes/mahasiswa.php`, `routes/auth.php`, `routes/api.php` (Sanctum), `routes/console.php`.
- Auth login supports email/username/NIM via custom `LoginRequest`.
- Role-based dashboard redirect after login: `/dashboard` → `/admin/dashboard` | `/dosen/dashboard` | `/mahasiswa/dashboard`.
- Layouts: `layouts/admin.blade.php`, `layouts/dosen.blade.php`, `layouts/mahasiswa.blade.php` — each with collapsible sidebar, dark mode toggle, notification dropdown.
- App models: `User` (HasRoles, SoftDeletes, HasApiTokens), `LMSClass`, `Material`, `MaterialProgress`, `Assignment`, `AssignmentSubmission`, `Quiz`, `QuizQuestion`, `QuizAttempt`, `QuizAttemptAnswer`, `ForumThread`, `ForumReply`, `ForumReplyLike`, `Attendance`, `AttendanceRecord`, `Announcement`, `Grade`, `Certificate`, `Notification`, `AuditLog`.
- **All models except `User` and `LMSClass` use the `classes` table** (aliased via `LMSClass` model).
- Vite entrypoints: `resources/css/app.css`, `resources/js/app.js`. Built via `laravel-vite-plugin` + PostCSS (tailwindcss, autoprefixer).

## Key middleware

- `CheckRole` (alias `role`) — checks user has one of the given roles.
- `CheckUserActive` — added to web group; rejects inactive accounts.

## Auth flow

- Login credential field is `login` (not `email`). Accepts email, username, or NIM.
- Form request: `App\Http\Requests\Auth\LoginRequest`.

## Important seeded data

- `php artisan db:seed` creates roles (`super_admin`, `admin`, `dosen`, `mahasiswa`) and test users:
  - Super Admin: `admin@campuslms.test` / `password`
  - Dosen: `dosen@campuslms.test` / `password`
  - Mahasiswa: `mahasiswa@campuslms.test` / `password`
- Factory user has `is_active=true` default (model `$attributes`).

## Multi-role system

- Four roles: `super_admin`, `admin`, `dosen`, `mahasiswa` (via Spatie Permission).
- Each role has a dedicated layout with color-coded sidebar (indigo/purple, emerald/teal, blue/cyan).
- Permissions are seeded in `RolePermissionSeeder`, managed via admin UI at `/admin/roles`.
