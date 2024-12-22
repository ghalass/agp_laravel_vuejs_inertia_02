<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnginController;
use App\Http\Controllers\ParcController;
use App\Http\Controllers\SaisieController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TypeparcController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->middleware('guest')
    ->name('authenticate');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');


    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::prefix('configs')->group(function () {
        Route::get('/sites', [SiteController::class, 'index'])
            ->name('sites.index');
        Route::post('/sites', [SiteController::class, 'store'])
            ->name('sites.store');
        Route::get('/sites/edit/{site}', [SiteController::class, 'edit'])
            ->name('sites.edit');
        Route::put('/sites/{site}', [SiteController::class, 'update'])
            ->name('sites.update');
        Route::delete('/sites/{site}', [SiteController::class, 'delete'])
            ->name('sites.delete');

        Route::get('/typeparcs', [TypeparcController::class, 'index'])
            ->name('typeparcs.index');
        Route::post('/typeparcs', [TypeparcController::class, 'store'])
            ->name('typeparcs.store');
        Route::get('/typeparcs/edit/{typeparc}', [TypeparcController::class, 'edit'])
            ->name('typeparcs.edit');
        Route::put('/typeparcs/{typeparc}', [TypeparcController::class, 'update'])
            ->name('typeparcs.update');
        Route::delete('/typeparcs/{typeparc}', [TypeparcController::class, 'delete'])
            ->name('typeparcs.delete');


        Route::get('/parcs', [ParcController::class, 'index'])
            ->name('parcs.index');
        Route::get('/parcs/create', [ParcController::class, 'create'])
            ->name('parcs.create');
        Route::post('/parcs', [ParcController::class, 'store'])
            ->name('parcs.store');
        Route::get('/parcs/edit/{parc}', [ParcController::class, 'edit'])
            ->name('parcs.edit');
        Route::put('/parcs/{parc}', [ParcController::class, 'update'])
            ->name('parcs.update');
        Route::delete('/parcs/{parc}', [ParcController::class, 'delete'])
            ->name('parcs.delete');
        Route::get('/parcs/get_by_typeparc_id/{id}', [ParcController::class, 'get_by_typeparc_id'])
            ->name('parcs.get_by_typeparc_id');

        Route::get('/engins', [EnginController::class, 'index'])
            ->name('engins.index');
        Route::post('/engins', [EnginController::class, 'store'])
            ->name('engins.store');
        Route::get('/engins/edit/{engin}', [EnginController::class, 'edit'])
            ->name('engins.edit');
        Route::put('/engins/{engin}', [EnginController::class, 'update'])
            ->name('engins.update');
        Route::delete('/engins/{engin}', [EnginController::class, 'delete'])
            ->name('engins.delete');
        Route::get('/engins/get_by_parc_id/{id}', [EnginController::class, 'get_by_parc_id'])
            ->name('engins.get_by_parc_id');
    });

    Route::prefix('performaces')->group(function () {
        Route::get('/saisie_rje', [SaisieController::class, 'index'])
            ->name('saisie_rje.index');
        Route::post('/saisie_rje/get_by_date_engin', [SaisieController::class, 'get_by_date_engin'])
            ->name('saisie_rje.get_by_date_engin');
    });
});