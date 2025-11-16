## Quick orientation

This is a Laravel 12 web app (PHP ^8.2) that provides a GIS-backed cultural map for Garut.
Primary runtime pieces:
- PHP (Laravel) backend: controllers in `app/Http/Controllers`, Eloquent models in `app/Models`.
- Frontend: Blade views in `resources/views`, interactive map in `resources/views/map.blade.php` using Leaflet.
- Asset/tooling: Vite + `laravel-vite-plugin`, dependencies in `package.json`.

## Big picture (what to know first)
- Routes and surface area: see `routes/web.php`. Public map endpoints: `GET /map` (Blade) and `GET /map/data` (GeoJSON JSON response).
- Data model: `Cultural` is the main entity (`app/Models/Cultural.php`). Related models:
  - `CulturalGeodata` (table: `cultural_mapsdata`) holds latitude/longitude.
  - `CulturalGallery` stores additional images (`image_path`) and exposes `image_url` via `getImageUrlAttribute()`.
- Admin area: prefixed with `/admin` and protected by `auth` and `is_admin` middleware; admin controllers live in `app/Http/Controllers` (e.g. `AdminController`, `CulturalController` for CRUD).

## Project-specific conventions and gotchas
- Table name mismatch: `CulturalGeodata` uses a custom table name `cultural_mapsdata` (see model). When changing migrations or models, preserve that mapping or update both places.
- Images are stored on the `public` disk root (no nested folder). Thumbnails are saved as `Cultural->image` (filename) and galleries save `image_path`. Views reference images via `/storage/{filename}` — ensure `php artisan storage:link` is run.
- Map flag: a Cultural record must have `has_map = true` and a `CulturalGeodata` row to appear on the map. The controller filters for these conditions.
- Route name 'login' is required: `routes/web.php` registers a route named `login` because Laravel's `auth` middleware redirects to that named route.
- JS map data shape (used in `map.blade.php`): the controller maps model fields to this array of objects: { id, name, description, category, location, image, latitude, longitude }. `@json($culturalData)` injects it into the page.

## Where to look for examples
- Map rendering and interaction: `resources/views/map.blade.php` (Leaflet init, marker creation, popup HTML). Change marker style there (CSS + L.divIcon).
- CRUD examples & file storage: `app/Http/Controllers/CulturalController.php` (store/update/destroy show how files are stored, `Storage::disk('public')->delete()` used on remove).
- Admin dashboard and metrics: `app/Http/Controllers/AdminController.php`.
- Migrations & seed data: `database/migrations` and `database/seeders` (there is a `cultural_map.geojson` in seeders/data).

## Common developer workflows (Windows / PowerShell examples)
Open PowerShell in the repo root and run (preserve order):

```powershell
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run dev
```

You can run the combined dev experience (composer script defined in `composer.json`) which uses `concurrently` to run the app, queue listener and vite:

```powershell
composer run dev
```

Tests:

```powershell
composer test
```

If you change migrations or seeders and need a quick local reset:

```powershell
php artisan migrate:fresh --seed
```

## How to find/modify map data and markers quickly
- To change which fields are exposed to the frontend, edit `CulturalController::map()` — it builds the array passed into the view.
- To change GeoJSON output for APIs, edit `CulturalController::mapData()` which returns FeatureCollection JSON.
- To modify marker HTML, CSS or popup layout, edit `resources/views/map.blade.php` (look for `customMarker`, popup `content` and CSS blocks in `@push('styles')`).

## Integration & external dependencies
- Leaflet is used for mapping (CDN in Blade and also present in `package.json`).
- Vite compiles assets; `laravel-vite-plugin` is configured per default Laravel conventions.
- Storage uses the `public` disk (local filesystem). Ensure `storage/app/public` exists and `storage:link` is created.

## Useful examples for the agent (copy-paste safe)
- Add a new marker: ensure the `Cultural` has `has_map=true` and create/update a `CulturalGeodata` with `latitude`, `longitude`.
- Example DB query to fetch map-capable records (from controller):

```php
$culturalData = Cultural::with('mapdata')
    ->where('has_map', true)
    ->whereHas('mapdata')
    ->get()
    ->map(fn($item) => [
        'id' => $item->id,
        'name' => $item->name,
        'latitude' => optional($item->mapdata)->latitude,
        'longitude' => optional($item->mapdata)->longitude,
    ]);
```

## Last notes and where to ask
- Start by reading `routes/web.php`, `app/Models/Cultural.php`, `app/Http/Controllers/CulturalController.php` and `resources/views/map.blade.php` — these four files show the full round-trip from DB → controller → view → client-side map.
- If something is ambiguous (storage paths, expected image sizes, or a missing migration name), ask a human to point to the intended production storage layout or any manual deployment steps not present in repo.

---
If you want, I can now open a draft of this file in the editor for review or tweak any section to add more examples or commands. What should I refine? 
