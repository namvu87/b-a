<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QCController extends Controller
{
    public function queue()
    {
        $qcQueue = [
            [
                'receipt_number' => 'PN-2025-0892',
                'date' => '14/10/2025',
                'product_code' => 'MAIN_gao01',
                'product_name' => 'Gạo nếp hạt ngắn',
                'lot' => '20251014',
                'quantity' => '500 kg',
                'supplier' => 'NCC Đại Phát',
                'priority' => 'high',
                'priority_text' => 'CAO'
            ],
            [
                'receipt_number' => 'PN-2025-0889',
                'date' => '13/10/2025',
                'product_code' => 'SPIC_gia02',
                'product_name' => 'Muối tinh',
                'lot' => '20251013',
                'quantity' => '100 kg',
                'supplier' => 'NCC Gia vị VN',
                'priority' => 'normal',
                'priority_text' => 'BÌNH THƯỜNG'
            ],
        ];

        return view('qc.queue', compact('qcQueue'));
    }

    public function check($receipt_id)
    {
        $receipt = [
            'doc_number' => 'PN-2025-0892',
            'product_code' => 'MAIN_gao01',
            'lot' => '20251014',
            'quantity' => '500 kg',
            'supplier' => 'NCC Đại Phát'
        ];

        $criteria = [
            ['name' => 'Độ ẩm', 'standard' => '≤ 14%'],
            ['name' => 'Màu sắc', 'standard' => 'Trắng ngà tự nhiên'],
            ['name' => 'Mùi vị', 'standard' => 'Không có mùi lạ'],
            ['name' => 'Tạp chất', 'standard' => '≤ 0.1%'],
        ];

        return view('qc.check', compact('receipt', 'criteria'));
    }

    public function submit(Request $request, $receipt_id)
    {
        // Validation
        $result = $request->input('result');
        
        if ($result === 'pass') {
            // Update receipt status to "IMPORTED"
            // Move goods from "WAITING_QC" to "AVAILABLE"
            // Notify BP-MUH for payment approval
            return redirect()->route('qc.queue')
                ->with('success', '✅ Đã lưu kết quả QC: ĐẠT. Hàng được chuyển sang "ĐÃ NHẬP KHO"');
        } else {
            // Update receipt status to "QUARANTINE"
            // Move goods to "QUARANTINE"
            // Auto create SPKPH
            // Notify BP-MUH & TO-KHO
            return redirect()->route('qc.queue')
                ->with('warning', '❌ Đã lưu kết quả QC: KHÔNG ĐẠT. Hàng được chuyển sang "CÁCH LY" và tự động tạo SPKPH');
        }
    }

    public function history()
    {
        return view('qc.history');
    }

    public function spkph()
    {
        $spkphList = [
            [
                'spkph_number' => 'SPKPH-2025-003',
                'date' => '13/10/2025',
                'receipt_number' => 'PN-2025-0890',
                'product_code' => 'SPIC_gia02',
                'lot' => '20251013',
                'defect' => 'Mùi lạ',
                'resolution' => 'Đang thương lượng NCC'
            ],
        ];

        return view('qc.spkph', compact('spkphList'));
    }

    public function spkphDetail($id)
    {
        return view('qc.spkph-detail');
    }
}
