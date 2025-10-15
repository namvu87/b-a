<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\QcController;
use App\Http\Controllers\StocktakeController;
use App\Http\Controllers\ReportController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Receipts
Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts.index');
Route::get('/receipts/create', [ReceiptController::class, 'create'])->name('receipts.create');

// Issues (Outbound)
Route::get('/issues', [IssueController::class, 'index'])->name('issues.index');
Route::get('/issues/create', [IssueController::class, 'create'])->name('issues.create');

// Quality Control (QC)
Route::get('/qc/queue', [QcController::class, 'queue'])->name('qc.queue');
Route::get('/qc/form', [QcController::class, 'form'])->name('qc.form');

// Stocktake
Route::get('/stocktake/plan/create', [StocktakeController::class, 'planCreate'])->name('stocktake.planCreate');
Route::get('/stocktake/execute', [StocktakeController::class, 'execute'])->name('stocktake.execute');
Route::get('/stocktake/reconcile', [StocktakeController::class, 'reconcile'])->name('stocktake.reconcile');

// Reports
Route::get('/reports/xnt', [ReportController::class, 'xnt'])->name('reports.xnt');
Route::get('/reports/efficiency', [ReportController::class, 'efficiency'])->name('reports.efficiency');
Route::get('/reports/abc', [ReportController::class, 'abc'])->name('reports.abc');
