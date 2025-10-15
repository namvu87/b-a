<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display dashboard with KPIs
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mock data - Replace with actual database queries
        $stats = [
            'total_products' => 1248,
            'waiting_qc' => 15,
            'today_issues' => 45,
            'low_stock_alerts' => 12,
            'inventory_accuracy' => 99.2,
            'otif_rate' => 96.5,
            'fefo_compliance' => 98.1,
            'damage_rate' => 0.25,
        ];

        $recentActivities = [
            [
                'doc_number' => 'PN-2025-0892',
                'type' => 'Nhập NVL từ NCC',
                'warehouse' => 'ZN-WHRM-01',
                'date' => '14/10/2025 09:30',
                'user' => 'Nguyễn Văn A',
                'status' => 'wait',
                'status_text' => 'CHỜ KIỂM TRA',
                'note' => 'Lô gạo 500kg từ NCC Đại Phát'
            ],
            [
                'doc_number' => 'PX-2025-1523',
                'type' => 'Xuất NVL cho SX',
                'warehouse' => 'ZN-WHRM-01',
                'date' => '14/10/2025 08:15',
                'user' => 'Trần Thị B',
                'status' => 'success',
                'status_text' => 'HOÀN THÀNH',
                'note' => 'Cấp phát cho PH-SXU'
            ],
            [
                'doc_number' => 'YCVT-2025-0156',
                'type' => 'Yêu cầu Vật tư',
                'warehouse' => 'ZN-WHSP-01',
                'date' => '13/10/2025 16:20',
                'user' => 'Lê Văn C',
                'status' => 'processing',
                'status_text' => 'ĐANG XỬ LÝ',
                'note' => 'Yêu cầu bao bì 500g'
            ],
            [
                'doc_number' => 'QC-2025-0089',
                'type' => 'Kiểm tra QC',
                'warehouse' => 'ZN-WHRM-01',
                'date' => '13/10/2025 14:00',
                'user' => 'Phạm Thị D (TO-QAC)',
                'status' => 'success',
                'status_text' => 'ĐẠT',
                'note' => 'Lô MAIN_gao01-20251013'
            ],
            [
                'doc_number' => 'SPKPH-2025-003',
                'type' => 'SPKPH',
                'warehouse' => 'ZN-WHRM-01',
                'date' => '13/10/2025 11:30',
                'user' => 'Hoàng Văn E (TO-QAC)',
                'status' => 'danger',
                'status_text' => 'KHÔNG ĐẠT',
                'note' => 'Gia vị lỗi - Thương lượng NCC'
            ],
        ];

        return view('dashboard.index', compact('stats', 'recentActivities'));
    }

    /**
     * Display KPI details
     *
     * @return \Illuminate\View\View
     */
    public function kpi()
    {
        return view('dashboard.kpi');
    }
}
