@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Tổng quan</h1>
        <div class="breadcrumb">Trang chủ / Dashboard</div>
    </div>
    <div class="header-actions">
        <button class="btn-secondary">
            📊 Xuất báo cáo
        </button>
        <button class="btn-secondary" onclick="location.reload()">
            🔄 Làm mới
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-header">
            <span class="stat-title">Tổng mã hàng tồn kho</span>
            <div class="stat-icon blue">📦</div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_products']) }}</div>
        <div class="stat-change up">↑ 12% so với tháng trước</div>
    </div>
    
    <div class="stat-card orange">
        <div class="stat-header">
            <span class="stat-title">Chờ kiểm tra QC</span>
            <div class="stat-icon orange">🔍</div>
        </div>
        <div class="stat-value">{{ $stats['waiting_qc'] }}</div>
        <div class="stat-change">8 phiếu hôm nay</div>
    </div>
    
    <div class="stat-card green">
        <div class="stat-header">
            <span class="stat-title">Xuất kho hôm nay</span>
            <div class="stat-icon green">📤</div>
        </div>
        <div class="stat-value">{{ $stats['today_issues'] }}</div>
        <div class="stat-change up">↑ 18 phiếu</div>
    </div>
    
    <div class="stat-card red">
        <div class="stat-header">
            <span class="stat-title">Cảnh báo tồn thấp</span>
            <div class="stat-icon red">⚠️</div>
        </div>
        <div class="stat-value">{{ $stats['low_stock_alerts'] }}</div>
        <div class="stat-change">Cần đặt hàng gấp</div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-header">
            <span class="stat-title">Độ chính xác tồn kho</span>
            <div class="stat-icon blue">✅</div>
        </div>
        <div class="stat-value">{{ $stats['inventory_accuracy'] }}%</div>
        <div class="stat-change up">🎯 Target: ≥ 99.5%</div>
    </div>
    
    <div class="stat-card green">
        <div class="stat-header">
            <span class="stat-title">Tỷ lệ OTIF</span>
            <div class="stat-icon green">🚚</div>
        </div>
        <div class="stat-value">{{ $stats['otif_rate'] }}%</div>
        <div class="stat-change up">↑ 2% so với tháng trước</div>
    </div>
    
    <div class="stat-card orange">
        <div class="stat-header">
            <span class="stat-title">Tuân thủ FEFO</span>
            <div class="stat-icon orange">📋</div>
        </div>
        <div class="stat-value">{{ $stats['fefo_compliance'] }}%</div>
        <div class="stat-change up">🎯 Target: ≥ 98%</div>
    </div>
    
    <div class="stat-card red">
        <div class="stat-header">
            <span class="stat-title">Hàng hư hỏng/mất mát</span>
            <div class="stat-icon red">📉</div>
        </div>
        <div class="stat-value">{{ $stats['damage_rate'] }}%</div>
        <div class="stat-change up">🎯 Target: ≤ 0.3%</div>
    </div>
</div>

<!-- Recent Activities -->
<div class="content-card">
    <div class="section-title">Hoạt động gần đây</div>
    <table>
        <thead>
            <tr>
                <th style="width: 140px;">Số phiếu</th>
                <th style="width: 180px;">Loại nghiệp vụ</th>
                <th style="width: 100px;">Kho</th>
                <th style="width: 140px;">Ngày tạo</th>
                <th style="width: 150px;">Người xử lý</th>
                <th style="width: 140px;">Trạng thái</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentActivities as $activity)
            <tr>
                <td><span class="doc-code">{{ $activity['doc_number'] }}</span></td>
                <td>{{ $activity['type'] }}</td>
                <td>{{ $activity['warehouse'] }}</td>
                <td>{{ $activity['date'] }}</td>
                <td>{{ $activity['user'] }}</td>
                <td>
                    <span class="status-badge {{ $activity['status'] }}">
                        {{ $activity['status_text'] }}
                    </span>
                </td>
                <td>{{ $activity['note'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
