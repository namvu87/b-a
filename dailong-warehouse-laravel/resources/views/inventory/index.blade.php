@extends('layouts.app')

@section('title', 'Danh sách Hàng hóa')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Danh sách Hàng hóa</h1>
        <div class="breadcrumb">Quản lý Tồn kho / Danh sách hàng hóa</div>
    </div>
    <div class="header-actions">
        <button class="btn-secondary">
            📤 Xuất Excel
        </button>
        <a href="{{ route('inventory.create') }}" class="btn-add">
            + Thêm hàng hóa
        </a>
    </div>
</div>

<div class="content-card">
    <div class="toolbar">
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Tìm theo mã hàng, tên hàng, lot/batch...">
        </div>
        <div class="filter-group">
            <select class="form-select" style="width: 180px;">
                <option value="">Tất cả kho</option>
                <option value="ZN-WHRM-01">ZN-WHRM-01 (NVL)</option>
                <option value="ZN-WHSP-01">ZN-WHSP-01 (Vật tư)</option>
                <option value="ZN-WHSF-01">ZN-WHSF-01 (Bán TP)</option>
                <option value="ZN-WHFG-01">ZN-WHFG-01 (Thành phẩm)</option>
                <option value="ZN-WHDC-01">ZN-WHDC-01 (Phân phối)</option>
            </select>
            <button class="filter-btn active" data-status="all">Tất cả</button>
            <button class="filter-btn" data-status="available">Sẵn sàng</button>
            <button class="filter-btn" data-status="low">Tồn thấp</button>
            <button class="filter-btn" data-status="out">Hết hàng</button>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 40px;"><input type="checkbox" id="selectAll"></th>
                <th style="width: 140px;">Mã hàng</th>
                <th style="width: 220px;">Tên hàng</th>
                <th style="width: 120px;">Nhóm</th>
                <th style="width: 100px;">Tồn khả dụng</th>
                <th style="width: 80px;">Chờ QC</th>
                <th style="width: 80px;">Cách ly</th>
                <th style="width: 180px;">Vị trí</th>
                <th style="width: 120px;">Trạng thái</th>
                <th style="width: 100px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr data-status="{{ $product['status'] }}">
                <td><input type="checkbox" class="row-checkbox"></td>
                <td>
                    <a href="{{ route('inventory.show', $product['id']) }}" class="doc-code">
                        {{ $product['code'] }}
                    </a>
                </td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['category'] }}</td>
                <td style="text-align: right; font-weight: 500;">{{ $product['available_qty'] }}</td>
                <td style="text-align: right;">{{ $product['waiting_qc'] }}</td>
                <td style="text-align: right;">{{ $product['quarantine'] }}</td>
                <td>{{ $product['location'] }}</td>
                <td>
                    <span class="status-badge {{ $product['status'] }}">
                        @if($product['status'] == 'success') 🟢 @endif
                        @if($product['status'] == 'warning') 🟡 @endif
                        @if($product['status'] == 'danger') 🔴 @endif
                        {{ $product['status_text'] }}
                    </span>
                </td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('inventory.show', $product['id']) }}" class="btn-view" title="Xem">👁️</a>
                        <a href="{{ route('inventory.edit', $product['id']) }}" class="btn-edit" title="Sửa">✎</a>
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
    // Filter buttons
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        const status = $(this).data('status');
        if (status === 'all') {
            $('tbody tr').show();
        } else {
            $('tbody tr').hide();
            $('tbody tr[data-status="' + status + '"]').show();
        }
    });
    
    // Search
    $('#searchInput').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('tbody tr').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(searchTerm));
        });
    });
    
    // Select all
    $('#selectAll').on('change', function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });
});
</script>
@endpush
