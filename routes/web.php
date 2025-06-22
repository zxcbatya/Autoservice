<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Backend\ReviewController as BackendReviewController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(env('ADMIN_DOMAIN'))
    ->group(function () {
        require __DIR__ . '/auth.php';
        require __DIR__ . '/backend.php';
    });

Route::get('/', [SiteController::class, 'index'])->name('/');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/lead', [LeadController::class, 'store'])->name('lead.store');
Route::get('/services', [SiteController::class, 'services'])->name('services');
Route::get('/login', [AdminController::class, 'index'])->name('login');

Route::post('/login', [AdminController::class, 'login']);

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::resource('reviews', BackendReviewController::class)->only(['index', 'edit', 'update', 'destroy'])->names(
        'admin.review',
    );

    Route::get('/service', [ServiceController::class, 'index'])->name('admin.service.index');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('admin.service.create');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('admin.service.store');
    Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('admin.service.edit');
    Route::patch('/service/update/{id}', [ServiceController::class, 'update'])->name('admin.service.update');
    Route::delete('/service/delete/{id}', [ServiceController::class, 'delete'])->name('admin.service.delete');
});
