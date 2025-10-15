<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function inventoryMovement(Request $request)
    {
        $data = [
            ['code' => 'MAIN_gao01', 'name' => 'Gạo nếp', 'unit' => 'kg', 'opening' => 1200, 'receipt' => 500, 'issue' => 450, 'closing' => 1250, 'value' => '22.5tr'],
            ['code' => 'SPIC_gia01', 'name' => 'Hạt nêm', 'unit' => 'kg', 'opening' => 150, 'receipt' => 100, 'issue' => 120, 'closing' => 130, 'value' => '3.9tr'],
        ];

        return view('report.inventory-movement', compact('data'));
    }

    public function fefoCompliance(Request $request)
    {
        $stats = [
            'compliance_rate' => 98.1,
            'total_issues' => 245,
            'compliant_issues' => 240,
            'non_compliant_issues' => 5,
        ];

        $violations = [
            ['date' => '12/10', 'doc_number' => 'PX-1520', 'product_code' => 'MAIN_gao01', 'issued_lot' => '20251010', 'correct_lot' => '20251006', 'reason' => 'KH yêu cầu lot cụ thể'],
        ];

        return view('report.fefo-compliance', compact('stats', 'violations'));
    }

    public function warehousePerformance(Request $request)
    {
        $kpis = [
            ['name' => 'Độ chính xác TK', 'value' => '99.2%', 'target' => '≥99.5%', 'status' => 'warning'],
            ['name' => 'Tỷ lệ OTIF', 'value' => '96.5%', 'target' => '≥ 95%', 'status' => 'success'],
            ['name' => 'Tuân thủ FEFO', 'value' => '98.1%', 'target' => '≥ 98%', 'status' => 'success'],
            ['name' => 'Hàng hư hỏng', 'value' => '0.25%', 'target' => '≤ 0.3%', 'status' => 'success'],
        ];

        return view('report.warehouse-performance', compact('kpis'));
    }

    public function export($type)
    {
        // Export logic (Excel, PDF)
        return response()->download(storage_path('app/exports/' . $type . '.xlsx'));
    }
}
