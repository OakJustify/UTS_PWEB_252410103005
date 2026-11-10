<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', [PageController::class, 'showLogin'])->name('login');
Route::post('/login', [PageController::class, 'login'])->name('login.store');

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/pengelolaan', [PageController::class, 'pengelolaan'])->name('pengelolaan');
Route::get('/profile', [PageController::class, 'profile'])->name('profile');

Route::redirect('/logout', '/login')->name('logout');
