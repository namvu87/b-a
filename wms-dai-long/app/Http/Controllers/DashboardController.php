<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Inventory;
use App\Models\GoodsReceipt;
use App\Models\MaterialRequisition;

class DashboardController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $totalInventory = Inventory::count();
        $lowStockCount = 0; // Will be calculated based on min_stock
        $nearExpiryCount = Inventory::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', now()->addDays(30))
            ->whereDate('expiry_date', '>=', now())
            ->count();
        $pendingQCCount = GoodsReceipt::where('status', 'pending_qc')->count();
        
        $recentGoodsReceipts = GoodsReceipt::latest()->take(5)->get();
        $recentMaterialRequisitions = MaterialRequisition::latest()->take(5)->get();
        
        return view('dashboard.index', compact(
            'warehouses',
            'totalInventory',
            'lowStockCount',
            'nearExpiryCount',
            'pendingQCCount',
            'recentGoodsReceipts',
            'recentMaterialRequisitions'
        ));
    }
}
