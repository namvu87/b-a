<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\GoodsIssueController;
use App\Http\Controllers\MaterialRequisitionController;
use App\Http\Controllers\QualityControlController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Master Data - Warehouses
Route::resource('warehouses', WarehouseController::class);

// Master Data - Products
Route::resource('products', ProductController::class);

// Master Data - Suppliers
Route::resource('suppliers', SupplierController::class);

// Master Data - Locations
Route::resource('locations', LocationController::class);

// Inventory Management
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/by-warehouse/{warehouse}', [InventoryController::class, 'byWarehouse'])->name('inventory.by-warehouse');
Route::get('/inventory/alerts', [InventoryController::class, 'alerts'])->name('inventory.alerts');

// Goods Receipt (Phiếu Nhập kho)
Route::resource('goods-receipts', GoodsReceiptController::class);
Route::post('/goods-receipts/{goodsReceipt}/approve', [GoodsReceiptController::class, 'approve'])->name('goods-receipts.approve');

// Goods Issue (Phiếu Xuất kho)
Route::resource('goods-issues', GoodsIssueController::class);
Route::post('/goods-issues/{goodsIssue}/approve', [GoodsIssueController::class, 'approve'])->name('goods-issues.approve');

// Material Requisition (Yêu cầu Vật tư)
Route::resource('material-requisitions', MaterialRequisitionController::class);
Route::post('/material-requisitions/{materialRequisition}/approve', [MaterialRequisitionController::class, 'approve'])->name('material-requisitions.approve');
Route::post('/material-requisitions/{materialRequisition}/reject', [MaterialRequisitionController::class, 'reject'])->name('material-requisitions.reject');

// Quality Control
Route::resource('quality-controls', QualityControlController::class);
