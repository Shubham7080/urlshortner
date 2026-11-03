<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:SuperAdmin')
        ->name('dashboard');

    Route::get('/company-dashboard', [DashboardController::class, 'companyAdmin'])
        ->middleware('role:Admin')
        ->name('company-dashboard');
    Route::get('/go-to-dashboard', [
            DashboardController::class,
            'redirectByRole',
        ])->name('dashboard.redirect');
    Route::get('/companies', [CompanyController::class, 'index'])
        ->name('companies.index');

    Route::get('/companies/create', [CompanyController::class, 'create'])
        ->name('companies.create');

    Route::post('/companies', [CompanyController::class, 'store'])
        ->name('companies.store');

    Route::get('/invitations/create', [InvitationController::class, 'create'])
        ->name('invitations.create');

    Route::post('/invitations', [InvitationController::class, 'store'])
        ->name('invitations.store');

   Route::post('/invitations/accept/{token}', [
        InvitationController::class,
        'acceptStore',
        ])->name('invitations.accept.store');

    Route::get('/short-urls', [ShortUrlController::class, 'index'])
    ->middleware('role:Admin|Member')
    ->name('short-urls.index');

    Route::get('/short-urls/create', [ShortUrlController::class, 'create'])
        ->middleware('role:Admin|Member')
        ->name('short-urls.create');

    Route::post('/short-urls', [ShortUrlController::class, 'store'])
        ->middleware('role:Admin|Member')
        ->name('short-urls.store');
});
 Route::get('/invitations/accept/{token}', [
    InvitationController::class,
        'accept',
    ])->name('invitations.accept');
    
    Route::get('/{code}', [ShortUrlController::class, 'redirect'])
    ->where('code', '[A-Za-z0-9]{7}')
    ->name('short-urls.redirect');