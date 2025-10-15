@extends('layouts.app')

@section('title', 'Queue Kiểm tra QC')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Queue Kiểm tra QC</h1>
        <div class="breadcrumb">Kiểm tra QC / Queue kiểm tra</div>
    </div>
    <div class="header-actions">
        <button class="btn-secondary">
            🔔 Thông báo (3)
        </button>
    </div>
</div>

<div class="content-card">
    <div class="info-box">
        <strong>🔍 Quy trình kiểm tra QC:</strong>
        Hàng từ NCC → Dán nhãn VÀNG "CHỜ KIỂM TRA" → Lấy mẫu kiểm tra → ĐẠT: Nhập kho | KHÔNG ĐẠT: Cách ly & SPKPH
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 140px;">Số phiếu nhập</th>
                <th style="width: 110px;">Ngày nhập</th>
                <th style="width: 140px;">Mã hàng</th>
                <th style="width: 200px;">Tên hàng</th>
                <th style="width: 120px;">Lot/Batch</th>
                <th style="width: 100px;">Số lượng</th>
                <th style="width: 150px;">NCC</th>
                <th style="width: 120px;">Ưu tiên</th>
                <th style="width: 100px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($qcQueue as $item)
            <tr style="{{ $item['priority'] == 'high' ? 'background: #fff3cd;' : '' }}">
                <td>
                    <span class="doc-code">{{ $item['receipt_number'] }}</span>
                </td>
                <td>{{ $item['date'] }}</td>
                <td><strong>{{ $item['product_code'] }}</strong></td>
                <td>{{ $item['product_name'] }}</td>
                <td>{{ $item['lot'] }}</td>
                <td style="text-align: right;">{{ $item['quantity'] }}</td>
                <td>{{ $item['supplier'] }}</td>
                <td>
                    <span class="status-badge {{ $item['priority'] == 'high' ? 'warning' : 'info' }}">
                        {{ $item['priority'] == 'high' ? '🔥 CAO' : 'BÌNH THƯỜNG' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('qc.check', $item['receipt_number']) }}" class="btn-add" style="padding: 6px 12px; font-size: 12px;">
                        Kiểm tra
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
