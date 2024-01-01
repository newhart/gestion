<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CategryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VenteController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/products', [ProductController::class, 'index'])->name('products.list');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::get('/achats', [AchatController::class, 'index'])->name('achats.list');
        Route::get('/achats/create/{bonde}/{type}', [AchatController::class, 'create'])->name('achats.create');
        Route::get('/achats/choice', [AchatController::class, 'choice'])->name('achats.choice');
        Route::get('/achats/create-new', [AchatController::class, 'new'])->name('achats.new');
        Route::get('/ventes', [VenteController::class, 'index'])->name('ventes.list');
        Route::get('/ventes/create', [VenteController::class, 'create'])->name('ventes.create');
        Route::get('/membres', [MembreController::class, 'index'])->name('membres.list');
        Route::get('/membres/create', [MembreController::class, 'create'])->name('membres.create');
        Route::get('/membres/{user}/edit', [MembreController::class, 'edit'])->name('membres.edit');
        Route::get('/categories', [CategryController::class, 'index'])->name('categories.list');
        Route::get('/categories/create', [CategryController::class, 'create'])->name('categories.create');
        Route::get('/categories/sub-categorie/create', [CategryController::class, 'create_sub_category'])->name('categories.sub.create');
        Route::get('/categories/{category}/edit', [CategryController::class, 'edit'])->name('categories.edit');
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies.list');
        Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
        Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
        Route::get('/factures', [FactureController::class, 'index'])->name('factures.index');
        Route::get('/factures/create', [FactureController::class, 'create'])->name('factures.create');
        Route::get('/factures/detail/{facture}', [FactureController::class, 'detail'])->name('factures.create.detail');
        Route::get('/bonde/create', [\App\Http\Controllers\BondeController::class, 'create'])->name('bonde.create');
        Route::get('/bonde/create/sorty', [\App\Http\Controllers\BondeController::class, 'create_entry'])->name('bonde.create.sorty');
    });

require __DIR__ . '/auth.php';
