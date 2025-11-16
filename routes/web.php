<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CulturalController;
use App\Http\Controllers\AdminController;

// ==========================
// ROUTE USER / FRONTEND
// ==========================

// Public routes: if the current user is an admin (logged in), redirect them to admin dashboard
// Use the middleware class directly to avoid alias resolution issues.
Route::middleware([\App\Http\Middleware\RedirectIfAdmin::class])->group(function () {
    // Homepage / Dashboard User
    Route::get('/', [CulturalController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [CulturalController::class, 'dashboard'])->name('dashboard');

    // Cultural
    Route::get('/cultural', [CulturalController::class, 'index'])->name('cultural.index');
    Route::get('/cultural/{cultural:slug}', [CulturalController::class, 'show'])->name('cultural.show');

    // Halaman statis
    Route::get('/map', [CulturalController::class, 'map'])->name('map');
    Route::get('/map/data', [CulturalController::class, 'mapData'])->name('map.data');
    Route::get('/find', [CulturalController::class, 'find'])->name('find');
    Route::get('/aboutus', fn() => view('aboutus'))->name('aboutus');
});

// ==========================
// ROUTE ADMIN
// ==========================

// Form login admin
// Apply the redirect.admin middleware so already-authenticated admins are
// redirected at the route level instead of reaching the login form.
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware([\App\Http\Middleware\RedirectIfAdmin::class]);

Route::post('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login.submit')
    ->middleware([\App\Http\Middleware\RedirectIfAdmin::class]);

// Logout admin
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// The auth middleware expects a route named 'login'. Keep the
// admin login form named 'admin.login' (used in controllers/views),
// and expose a generic 'login' name that redirects to the admin login page.
Route::get('/login', function() {
    return redirect()->route('admin.login');
})->name('login')->middleware([\App\Http\Middleware\RedirectIfAdmin::class]);

// ===== PUBLIC API ROUTES (CSRF-protected but NOT auth-required) =====
// These must be BEFORE the admin group so they don't get caught by auth middleware
// Note: Plus Code decode endpoint removed — system now uses direct latitude/longitude inputs.

// Group admin dengan prefix 'admin', middleware auth & is_admin
// Use the middleware class directly to avoid "Target class [is_admin] does not exist" when
// middleware alias registration or cached containers are out-of-sync.
use App\Http\Middleware\IsAdmin as IsAdminMiddleware;

Route::prefix('admin')->name('admin.')->middleware(['auth', IsAdminMiddleware::class])->group(function() {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard_admin');

    // Map Admin
    Route::get('/map', [CulturalController::class, 'mapAdmin'])->name('map_admin');

    // CRUD Cultural
    Route::get('/cultural/create', [CulturalController::class, 'create'])->name('cultural.create');
    Route::post('/cultural/store', [CulturalController::class, 'store'])->name('cultural.store');
    Route::get('/cultural/{cultural:slug}/edit', [CulturalController::class, 'edit'])->name('cultural.edit');
    Route::put('/cultural/{cultural:slug}', [CulturalController::class, 'update'])->name('cultural.update');
    Route::delete('/cultural/{cultural:slug}', [CulturalController::class, 'destroy'])->name('cultural.destroy');

});
