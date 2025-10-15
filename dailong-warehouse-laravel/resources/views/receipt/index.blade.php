@extends('layouts.app')

@section('title', 'Danh sách Phiếu Nhập')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Danh sách Phiếu Nhập kho</h1>
        <div class="breadcrumb">Nhập kho / Danh sách phiếu nhập</div>
    </div>
    <div class="header-actions">
        <button class="btn-secondary">
            📤 Xuất Excel
        </button>
        <button class="btn-add" id="createReceiptBtn">
            + Tạo phiếu nhập ▼
            <div class="dropdown-menu" id="receiptDropdown">
                <a href="{{ route('receipt.create-ncc') }}" class="dropdown-item">📥 Nhập từ NCC</a>
                <a href="{{ route('receipt.create-production') }}" class="dropdown-item">🏭 Nhập TP từ Sản xuất</a>
                <a href="{{ route('receipt.create-other') }}" class="dropdown-item">📦 Nhập khác</a>
            </div>
        </button>
    </div>
</div>

<div class="content-card">
    <div class="toolbar">
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Tìm theo số phiếu, NCC, người nhập...">
        </div>
        <div class="filter-group">
            <select class="form-select" style="width: 150px;">
                <option value="">Tất cả kho</option>
                <option value="ZN-WHRM-01">ZN-WHRM-01</option>
                <option value="ZN-WHSP-01">ZN-WHSP-01</option>
            </select>
            <button class="filter-btn active">Tất cả</button>
            <button class="filter-btn">Chờ QC</button>
            <button class="filter-btn">Đã nhập</button>
            <button class="filter-btn">Cách ly</button>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 40px;"><input type="checkbox"></th>
                <th style="width: 140px;">Số phiếu</th>
                <th style="width: 110px;">Ngày nhập</th>
                <th style="width: 150px;">Loại nhập</th>
                <th style="width: 120px;">Kho nhận</th>
                <th style="width: 180px;">NCC/Nguồn</th>
                <th style="width: 100px;">Tổng SL</th>
                <th style="width: 140px;">Trạng thái</th>
                <th>Ghi chú</th>
                <th style="width: 100px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipts as $receipt)
            <tr>
                <td><input type="checkbox"></td>
                <td>
                    <a href="{{ route('receipt.show', $receipt['doc_number']) }}" class="doc-code">
                        {{ $receipt['doc_number'] }}
                    </a>
                </td>
                <td>{{ $receipt['date'] }}</td>
                <td>{{ $receipt['type'] }}</td>
                <td>{{ $receipt['warehouse'] }}</td>
                <td>{{ $receipt['source'] }}</td>
                <td style="text-align: right;">{{ $receipt['quantity'] }}</td>
                <td>
                    <span class="status-badge {{ $receipt['status'] }}">
                        {{ $receipt['status_text'] }}
                    </span>
                </td>
                <td>{{ $receipt['note'] }}</td>
                <td>
                    <div class="action-btns">
                        <button class="btn-view" title="Xem">👁️</button>
                        @if($receipt['status'] !== 'success')
                        <button class="btn-edit" title="Sửa">✎</button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#createReceiptBtn').on('click', function(e) {
        e.stopPropagation();
        $('#receiptDropdown').toggleClass('active');
    });
    
    $(document).on('click', function() {
        $('.dropdown-menu').removeClass('active');
    });
});
</script>
@endpush
