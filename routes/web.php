<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\Sto\Api\StoApiController;
use App\Http\Controllers\Admin\Sto\ClientController as StoClientController;
use App\Http\Controllers\Admin\Sto\ExpenseController as StoExpenseController;
use App\Http\Controllers\Admin\Sto\OrderController as StoOrderController;
use App\Http\Controllers\Admin\Sto\PartController as StoPartController;
use App\Http\Controllers\Admin\Sto\PaymentController as StoPaymentController;
use App\Http\Controllers\Admin\Sto\ReportController as StoReportController;
use App\Http\Controllers\Admin\Sto\WorkerController as StoWorkerController;
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

Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');
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

    Route::prefix('sto')->middleware(['sto.access'])->name('admin.sto.')->group(function (): void {
        Route::get('orders', [StoOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [StoOrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [StoOrderController::class, 'store'])->name('orders.store');
        Route::patch('orders/{order}/status', [StoOrderController::class, 'updateStatus'])->name('orders.status');
        Route::delete('orders/{order}', [StoOrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('workers', [StoWorkerController::class, 'index'])->name('workers.index');
        Route::post('workers', [StoWorkerController::class, 'store'])->name('workers.store');
        Route::delete('workers/{worker}', [StoWorkerController::class, 'destroy'])->name('workers.destroy');

        Route::get('clients', [StoClientController::class, 'index'])->name('clients.index');
        Route::post('clients', [StoClientController::class, 'store'])->name('clients.store');
        Route::delete('clients/{client}', [StoClientController::class, 'destroy'])->name('clients.destroy');

        Route::get('expenses', [StoExpenseController::class, 'index'])->name('expenses.index');
        Route::post('expenses', [StoExpenseController::class, 'store'])->name('expenses.store');
        Route::delete('expenses/{expense}', [StoExpenseController::class, 'destroy'])->name('expenses.destroy');

        Route::get('payments', [StoPaymentController::class, 'index'])->name('payments.index');
        Route::post('payments/worker/{worker}/pay-all', [StoPaymentController::class, 'payAll'])->name(
            'payments.pay-all',
        );
        Route::post('payments/{payment}/pay', [StoPaymentController::class, 'payOne'])->name('payments.pay-one');

        Route::get('reports', [StoReportController::class, 'index'])->name('reports.index');

        Route::get('parts', [StoPartController::class, 'index'])->name('parts.index');
        Route::post('parts', [StoPartController::class, 'store'])->name('parts.store');
        Route::delete('parts/{part}', [StoPartController::class, 'destroy'])->name('parts.destroy');

        Route::prefix('api')->name('api.')->group(function (): void {
            Route::get('orders', [StoApiController::class, 'orders'])->name('orders');
            Route::post('orders', [StoApiController::class, 'storeOrder'])->name('orders.store');
            Route::patch('orders/{order}/status', [StoApiController::class, 'updateOrderStatus'])->name(
                'orders.status',
            );
            Route::post('payments/worker/{worker}', [StoApiController::class, 'payWorker'])->name('payments.worker');
            Route::post('payments/{payment}', [StoApiController::class, 'payPayment'])->name('payments.one');
        });
    });
});
