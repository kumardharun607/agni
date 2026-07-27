# AGNI Combined Project — Merge Notes

This project merges `sharvin_agni` (host/UI base, Laravel 12) and `dharun_agni`
(Laravel 11) into a single app. Folder structure of each source module was kept
as-is; only the pieces below were changed to make them work together.

## Key decision
Two different permission systems existed (`spatie/laravel-permission` in
sharvin_agni vs. a custom `Role`/`RolePermission`/`CheckPermission` system in
dharun_agni). Since the Permission page's **workflow** was specified to follow
dharun_agni, **dharun's User/Role/RolePermission model is now the single source
of truth** for auth and permissions. spatie's tables, config, and composer
dependency were removed.

## What came from where
- **Login / Dashboard / Logout / Sidebar chrome / global AJAX+SweetAlert
  script / color palette**: sharvin_agni (`resources/views/layouts/app.blade.php`,
  `components/*`).
- **Countries, States, Cities, Pincodes, Dealers, Dealer Mapping, View
  Hierarchy, Users, Permission Dropdown, Sales Stage, Roles, Permissions**:
  controllers/models/services/repositories/migrations/views from dharun_agni,
  folder structure unchanged, views re-pointed to sharvin's shared layout.
- **Scrap Distributor, Scrap Seller, BDE Home Location, SO Home Location**:
  unchanged from sharvin_agni (folder structure, controllers, models, views).

## What was added/changed to make the merge work
- `bootstrap/app.php`: registered dharun's `CheckPermission` middleware
  (`permission:Feature,ability`), added a global exception handler so
  AJAX/JSON errors always return a short, generic message (404/405/401/403/
  422/500) — no SQL errors or stack traces are ever exposed.
- `app/Providers/AppServiceProvider.php`: added dharun's `@userCan` /
  `@enduserCan` Blade directive.
- `composer.json`: added `app/helpers.php` to the `files` autoload array;
  removed the now-unused `spatie/laravel-permission` dependency.
- `database/migrations`: reordered so dharun's core tables (roles, countries,
  states, cities, pincodes, users, dealers, dealer_mappings, permission_
  dropdowns, sales_stages, role_permissions) run before sharvin's scrap/BDE/SO
  tables, which reference the location tables by foreign key.
- `database/seeders/DatabaseSeeder.php`: added ScrapDistributor, ScrapSeller,
  BdeHomeLocation, SoHomeLocation as permission-dropdown features so they're
  governable from the Permissions page.
- `routes/web.php`: fully rewritten — every module route now uses the
  `permission:Feature,ability` middleware convention consistently.
- `resources/views/layouts/app.blade.php`: added DataTables assets, Material
  Symbols font, and dharun's `.btn-primary/.card/.form-input/...` utility CSS
  (re-themed to sharvin's exact `#B91C1C` red / Inter font — no second
  "heading" font was introduced, to match sharvin's single-font look).
  Added dharun's `confirmDelete()` / `openImportModal()` JS helpers and the
  `form.ajax-form` submit handler (dedicated AJAX handler used by the ported
  module forms — the pre-existing generic form handler now skips
  `.ajax-form` forms to avoid double-submitting).
- `app/Http/Controllers/Permission/PermissionController.php`: added a guard —
  only the `Admin` role can view/edit the `Admin` role's own permission row;
  every other role is blocked (403) even if it otherwise has permission-edit
  access.
- Login page & sidebar: now show the actual AGNI logo
  (`public/images/agni-logo.png`, sourced from dharun_agni) instead of a text
  placeholder.
- Dashboard: added Dealers / Users / Sales Stage cards (dharun) alongside the
  existing Countries/States/Cities/Pincodes/Scrap Distributor/Scrap Seller/
  BDE/SO cards (sharvin), plus the AGNI logo and a page title.

## Setup (this was NOT run or tested in the sandbox — no PHP/network available)
```bash
composer install
cp .env.example .env   # then set DB_* to a real mysql database
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

## Known TODOs / things to verify once it runs
1. **Run a real `composer install`** — the merge only edited `composer.json`;
   `vendor/` was intentionally excluded from the delivered zip (was ~150MB+ and
   partially stale after removing spatie). Fresh install is required.
2. **Click through every ported dharun view** (dealers, dealer-mapping, users,
   permission-dropdown, sales-stage, roles, permissions, countries, states,
   cities, pincodes) to confirm the re-themed CSS classes render as expected —
   this was hand-verified by reading the code, not by rendering it.
3. **DataTables `ajax` source URLs** in each dharun view (e.g. `dealers-data`)
   should be double-checked against the exact route names in the new
   `routes/web.php`.
4. **Seed a first Admin user** (dharun's `DatabaseSeeder` creates one) so you
   can log in and use the Permissions page to configure the rest of the
   roles.
5. The four sharvin-side resource routes (`scrap-distributors`, etc.) assume
   their existing controllers already return JSON on AJAX requests the same
   way dharun's do — worth a quick check since they weren't originally built
   against `CheckPermission`.
