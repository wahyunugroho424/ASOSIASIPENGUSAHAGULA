<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SocialContentController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrganizationalStructureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Admin Authentication Routes
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Admin Protected Routes
Route::middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alt');
    
    // Profile Management
    Route::get('/profile', [AdminAuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
    
    // Change Password
    Route::get('/change-password', [AdminAuthController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [AdminAuthController::class, 'changePassword'])->name('change-password.post');
    
    // Gallery Management
    Route::resource('galleries', GalleryController::class);
    
    // Event Management  
    Route::resource('events', EventController::class);
    
    // Social Content Management
    Route::resource('social-contents', SocialContentController::class);
    
    // News Management
    Route::resource('news', NewsController::class);
    Route::resource('structure', OrganizationalStructureController::class);
    Route::post('structure/update-order', [OrganizationalStructureController::class, 'updateOrder'])
        ->name('structure.update-order');
        

    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/create', [MemberController::class, 'create'])->name('create');
        Route::post('/', [MemberController::class, 'store'])->name('store');
        Route::get('/{encryptedId}/edit', [MemberController::class, 'edit'])->name('edit');
        Route::put('/{encryptedId}', [MemberController::class, 'update'])->name('update');
        Route::delete('/{encryptedId}', [MemberController::class, 'destroy'])->name('destroy');
        Route::patch('/{encryptedId}/toggle-status', [MemberController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/update-order', [MemberController::class, 'updateOrder'])->name('update-order');
    });
});