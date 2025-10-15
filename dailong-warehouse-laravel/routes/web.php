<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\QCController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes - Hệ thống Quản lý Kho Đại Long Foods
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/kpi', [DashboardController::class, 'kpi'])->name('dashboard.kpi');

// Inventory - Quản lý Tồn kho
Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('index');
    Route::get('/create', [InventoryController::class, 'create'])->name('create');
    Route::post('/', [InventoryController::class, 'store'])->name('store');
    Route::get('/{id}', [InventoryController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [InventoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('destroy');
    
    // Sub routes
    Route::get('/by-location', [InventoryController::class, 'byLocation'])->name('by-location');
    Route::get('/by-lot', [InventoryController::class, 'byLot'])->name('by-lot');
});

// Receipt - Phiếu Nhập kho
Route::prefix('receipt')->name('receipt.')->group(function () {
    Route::get('/', [ReceiptController::class, 'index'])->name('index');
    Route::get('/create-ncc', [ReceiptController::class, 'createFromSupplier'])->name('create-ncc');
    Route::get('/create-production', [ReceiptController::class, 'createFromProduction'])->name('create-production');
    Route::get('/create-other', [ReceiptController::class, 'createOther'])->name('create-other');
    Route::post('/', [ReceiptController::class, 'store'])->name('store');
    Route::get('/{id}', [ReceiptController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ReceiptController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ReceiptController::class, 'update'])->name('update');
    Route::delete('/{id}', [ReceiptController::class, 'destroy'])->name('destroy');
});

// Issue - Phiếu Xuất kho
Route::prefix('issue')->name('issue.')->group(function () {
    Route::get('/', [IssueController::class, 'index'])->name('index');
    Route::get('/create-production', [IssueController::class, 'createForProduction'])->name('create-production');
    Route::get('/create-sale', [IssueController::class, 'createForSale'])->name('create-sale');
    Route::get('/create-transfer', [IssueController::class, 'createForTransfer'])->name('create-transfer');
    Route::post('/', [IssueController::class, 'store'])->name('store');
    Route::get('/{id}', [IssueController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [IssueController::class, 'edit'])->name('edit');
    Route::put('/{id}', [IssueController::class, 'update'])->name('update');
    
    // FEFO Suggestion
    Route::post('/fefo-suggest', [IssueController::class, 'fefoSuggest'])->name('fefo-suggest');
});

// QC - Kiểm tra Chất lượng
Route::prefix('qc')->name('qc.')->group(function () {
    Route::get('/queue', [QCController::class, 'queue'])->name('queue');
    Route::get('/{receipt_id}/check', [QCController::class, 'check'])->name('check');
    Route::post('/{receipt_id}/submit', [QCController::class, 'submit'])->name('submit');
    Route::get('/history', [QCController::class, 'history'])->name('history');
    
    // SPKPH
    Route::get('/spkph', [QCController::class, 'spkph'])->name('spkph');
    Route::get('/spkph/{id}', [QCController::class, 'spkphDetail'])->name('spkph-detail');
});

// Request - Yêu cầu Vật tư
Route::prefix('request')->name('request.')->group(function () {
    Route::get('/', [\App\Http\Controllers\RequestController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\RequestController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\RequestController::class, 'store'])->name('store');
    Route::get('/{id}', [\App\Http\Controllers\RequestController::class, 'show'])->name('show');
});

// Stocktake - Kiểm kê
Route::prefix('stocktake')->name('stocktake.')->group(function () {
    Route::get('/', [\App\Http\Controllers\StocktakeController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\StocktakeController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\StocktakeController::class, 'store'])->name('store');
    Route::get('/{id}/reconcile', [\App\Http\Controllers\StocktakeController::class, 'reconcile'])->name('reconcile');
});

// Report - Báo cáo
Route::prefix('report')->name('report.')->group(function () {
    Route::get('/inventory-movement', [ReportController::class, 'inventoryMovement'])->name('inventory-movement');
    Route::get('/fefo-compliance', [ReportController::class, 'fefoCompliance'])->name('fefo-compliance');
    Route::get('/warehouse-performance', [ReportController::class, 'warehousePerformance'])->name('warehouse-performance');
    Route::get('/export/{type}', [ReportController::class, 'export'])->name('export');
});

// Master Data
Route::prefix('master')->name('master.')->group(function () {
    Route::resource('warehouse', \App\Http\Controllers\WarehouseController::class);
    Route::resource('location', \App\Http\Controllers\LocationController::class);
    Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
});
