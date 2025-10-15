<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = [
            [
                'doc_number' => 'PN-2025-0892',
                'date' => '14/10/2025',
                'type' => 'Nhập từ NCC',
                'warehouse' => 'ZN-WHRM-01',
                'source' => 'NCC Đại Phát',
                'quantity' => '500 kg',
                'status' => 'wait',
                'status_text' => 'CHỜ KIỂM TRA',
                'note' => 'Lô gạo nếp'
            ],
            [
                'doc_number' => 'PN-2025-0891',
                'date' => '13/10/2025',
                'type' => 'Nhập TP từ SX',
                'warehouse' => 'ZN-WHFG-01',
                'source' => 'Phòng Sản xuất',
                'quantity' => '2,000 gói',
                'status' => 'success',
                'status_text' => 'ĐÃ NHẬP KHO',
                'note' => 'Bánh gạo 100g'
            ],
        ];

        return view('receipt.index', compact('receipts'));
    }

    public function createFromSupplier()
    {
        return view('receipt.create-ncc');
    }

    public function createFromProduction()
    {
        return view('receipt.create-production');
    }

    public function createOther()
    {
        return view('receipt.create-other');
    }

    public function store(Request $request)
    {
        // Store logic
        return redirect()->route('receipt.index')
            ->with('success', 'Đã tạo phiếu nhập thành công');
    }

    public function show($id)
    {
        return view('receipt.show');
    }
}
