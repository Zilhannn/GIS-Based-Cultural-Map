<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CulturalController;

Route::get('/cultural', [CulturalController::class, 'index'])->name('cultural.index');
Route::get('/cultural/{id}', [CulturalController::class, 'show'])->name('cultural.show');

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/map', function () {
    return view('map');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/find', function () {
    return view('find');
});
