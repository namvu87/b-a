@extends('layouts.app')

@section('title', 'Tạo Phiếu Nhập kho - WMS')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-arrow-down-circle"></i> Tạo Phiếu Nhập kho</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('goods-receipts.index') }}">Phiếu Nhập kho</a></li>
            <li class="breadcrumb-item active">Tạo mới</li>
        </ol>
    </nav>
</div>

<form action="{{ route('goods-receipts.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    Thông tin Phiếu Nhập
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số phiếu <span class="text-danger">*</span></label>
                            <input type="text" name="receipt_number" class="form-control" placeholder="PN-2025-001" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày nhập <span class="text-danger">*</span></label>
                            <input type="date" name="receipt_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại phiếu <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="">-- Chọn loại --</option>
                                <option value="from_supplier">Từ Nhà cung cấp</option>
                                <option value="from_production">Từ Sản xuất</option>
                                <option value="transfer">Chuyển kho</option>
                                <option value="return">Trả hàng</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kho nhập <span class="text-danger">*</span></label>
                            <select name="warehouse_id" class="form-select" required>
                                <option value="">-- Chọn kho --</option>
                                @foreach($warehouses ?? [] as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nhà cung cấp</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">-- Chọn NCC --</option>
                                @foreach($suppliers ?? [] as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số PO</label>
                            <input type="text" name="po_number" class="form-control" placeholder="PO-2025-001">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Nhập ghi chú..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Danh sách Hàng hóa</span>
                    <button type="button" class="btn btn-sm btn-success" onclick="addItem()">
                        <i class="bi bi-plus"></i> Thêm hàng
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="items-table">
                            <thead>
                                <tr>
                                    <th width="30%">Sản phẩm</th>
                                    <th width="15%">Số Lot</th>
                                    <th width="15%">NSX</th>
                                    <th width="15%">HSD</th>
                                    <th width="15%">Số lượng</th>
                                    <th width="10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Nhấn "Thêm hàng" để thêm sản phẩm
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Thao tác
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-save"></i> Lưu Phiếu Nhập
                    </button>
                    <a href="{{ route('goods-receipts.index') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-x-circle"></i> Hủy
                    </a>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    Quy trình Nhập kho
                </div>
                <div class="card-body">
                    <ol class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-1-circle text-primary"></i> Nhập thông tin phiếu
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-2-circle text-primary"></i> Thêm hàng hóa
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-3-circle text-warning"></i> Chờ kiểm tra QC
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-4-circle text-success"></i> Duyệt & Nhập kho
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
let itemIndex = 0;

function addItem() {
    const tbody = document.querySelector('#items-table tbody');
    if (tbody.querySelector('td[colspan]')) {
        tbody.innerHTML = '';
    }
    
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <select name="items[${itemIndex}][product_id]" class="form-select form-select-sm" required>
                <option value="">-- Chọn sản phẩm --</option>
                @foreach($products ?? [] as $product)
                    <option value="{{ $product->id }}">{{ $product->code }} - {{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="items[${itemIndex}][lot_number]" class="form-control form-control-sm" placeholder="LOT-20251015">
        </td>
        <td>
            <input type="date" name="items[${itemIndex}][manufacture_date]" class="form-control form-control-sm">
        </td>
        <td>
            <input type="date" name="items[${itemIndex}][expiry_date]" class="form-control form-control-sm">
        </td>
        <td>
            <input type="number" step="0.01" name="items[${itemIndex}][quantity]" class="form-control form-control-sm" placeholder="0.00" required>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
    itemIndex++;
}

function removeItem(button) {
    button.closest('tr').remove();
    const tbody = document.querySelector('#items-table tbody');
    if (tbody.children.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Nhấn "Thêm hàng" để thêm sản phẩm</td></tr>';
    }
}
</script>
@endsection
