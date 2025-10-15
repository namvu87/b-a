<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of inventory
     */
    public function index()
    {
        // Mock data
        $products = [
            [
                'id' => 1,
                'code' => 'MAIN_gao01',
                'name' => 'Gạo nếp hạt ngắn',
                'category' => 'NVL chính',
                'available_qty' => '1,250 kg',
                'waiting_qc' => 0,
                'quarantine' => 0,
                'location' => 'ZN-WHRM-01-D01-03-02',
                'status' => 'success',
                'status_text' => 'Sẵn sàng'
            ],
            [
                'id' => 2,
                'code' => 'PKG1_bao500',
                'name' => 'Bao 500g in logo',
                'category' => 'Bao bì',
                'available_qty' => '5,000 cái',
                'waiting_qc' => 0,
                'quarantine' => 0,
                'location' => 'ZN-WHSP-01-A01-02-01',
                'status' => 'warning',
                'status_text' => 'Tồn thấp'
            ],
            [
                'id' => 3,
                'code' => 'SPIC_gia01',
                'name' => 'Hạt nêm 1kg',
                'category' => 'Gia vị',
                'available_qty' => '0 kg',
                'waiting_qc' => 0,
                'quarantine' => 0,
                'location' => '-',
                'status' => 'danger',
                'status_text' => 'Hết hàng'
            ],
            [
                'id' => 4,
                'code' => 'PROT_thit01',
                'name' => 'Thịt heo xay',
                'category' => 'NVL chính',
                'available_qty' => '320 kg',
                'waiting_qc' => 50,
                'quarantine' => 0,
                'location' => 'ZN-WHRM-01-C02-01-01',
                'status' => 'success',
                'status_text' => 'Sẵn sàng'
            ],
        ];

        return view('inventory.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource
     */
    public function store(Request $request)
    {
        // Validation and store logic
        return redirect()->route('inventory.index')
            ->with('success', 'Đã thêm hàng hóa thành công');
    }

    /**
     * Display the specified resource
     */
    public function show($id)
    {
        // Mock data
        $product = [
            'code' => 'MAIN_gao01',
            'name' => 'Gạo nếp hạt ngắn',
            'category' => 'NVL chính',
            'unit' => 'kg',
            'specification' => 'Bao 25kg',
            'min_stock' => 500,
            'max_stock' => 2000,
            'reorder_point' => 800,
            'lead_time' => 3,
        ];

        $inventoryByWarehouse = [
            ['warehouse' => 'ZN-WHRM-01', 'available' => 1250, 'waiting_qc' => 0, 'quarantine' => 0, 'total' => 1250],
            ['warehouse' => 'ZN-WHDC-01', 'available' => 350, 'waiting_qc' => 0, 'quarantine' => 0, 'total' => 350],
        ];

        $inventoryByLot = [
            ['lot' => '20251006', 'manufacture_date' => '06/10/2025', 'expiry_date' => '06/10/2026', 'quantity' => '500 kg', 'location' => 'D01-03-02', 'status' => 'success'],
            ['lot' => '20251010', 'manufacture_date' => '10/10/2025', 'expiry_date' => '10/10/2026', 'quantity' => '750 kg', 'location' => 'D01-04-01', 'status' => 'success'],
        ];

        $history = [
            ['date' => '15/10/2025', 'type' => 'Xuất', 'doc_number' => 'PX-2025-1523', 'lot' => '20251006', 'quantity' => '-50 kg', 'price' => '18,000đ', 'user' => 'Nguyễn Văn A'],
            ['date' => '10/10/2025', 'type' => 'Nhập', 'doc_number' => 'PN-2025-0891', 'lot' => '20251010', 'quantity' => '+750 kg', 'price' => '18,500đ', 'user' => 'Trần Thị B'],
        ];

        return view('inventory.show', compact('product', 'inventoryByWarehouse', 'inventoryByLot', 'history'));
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit($id)
    {
        return view('inventory.edit');
    }

    /**
     * Update the specified resource
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('inventory.index')
            ->with('success', 'Đã cập nhật hàng hóa thành công');
    }

    /**
     * Remove the specified resource
     */
    public function destroy($id)
    {
        return redirect()->route('inventory.index')
            ->with('success', 'Đã xóa hàng hóa thành công');
    }

    /**
     * Display inventory by location
     */
    public function byLocation()
    {
        return view('inventory.by-location');
    }

    /**
     * Display inventory by lot
     */
    public function byLot()
    {
        return view('inventory.by-lot');
    }
}
