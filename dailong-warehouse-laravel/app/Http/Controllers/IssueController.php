<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index()
    {
        $issues = [
            [
                'doc_number' => 'PX-2025-1523',
                'date' => '14/10/2025',
                'type' => 'Xuất NVL cho SX',
                'warehouse' => 'ZN-WHRM-01',
                'receiver' => 'PH-SXU',
                'quantity' => '150 kg',
                'status' => 'success',
                'status_text' => 'ĐÃ XUẤT',
                'note' => 'Gạo theo FEFO'
            ],
            [
                'doc_number' => 'PX-2025-1522',
                'date' => '14/10/2025',
                'type' => 'Xuất TP bán hàng',
                'warehouse' => 'ZN-WHDC-01',
                'receiver' => 'NPP Hà Nội',
                'quantity' => '5,000 gói',
                'status' => 'processing',
                'status_text' => 'ĐANG XỬ LÝ',
                'note' => 'Đơn hàng #DH-2025-456'
            ],
        ];

        return view('issue.index', compact('issues'));
    }

    public function createForProduction()
    {
        return view('issue.create-production');
    }

    public function createForSale()
    {
        return view('issue.create-sale');
    }

    public function createForTransfer()
    {
        return view('issue.create-transfer');
    }

    public function store(Request $request)
    {
        return redirect()->route('issue.index')
            ->with('success', 'Đã tạo phiếu xuất thành công');
    }

    public function fefoSuggest(Request $request)
    {
        // FEFO logic: Query lots ordered by expiry date
        $suggestions = [
            [
                'lot' => '20251006',
                'expiry_date' => '06/10/2026',
                'available_qty' => 500,
                'location' => 'ZN-WHRM-01-D01-03-02'
            ],
            [
                'lot' => '20251010',
                'expiry_date' => '10/10/2026',
                'available_qty' => 750,
                'location' => 'ZN-WHRM-01-D01-04-01'
            ],
        ];

        return response()->json($suggestions);
    }
}
