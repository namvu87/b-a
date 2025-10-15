@extends('layouts.app')

@section('title', 'Phiếu Nhập kho - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-arrow-down-circle"></i> Phiếu Nhập kho</h1>
        <p class="text-muted">Quản lý phiếu nhập hàng vào kho</p>
    </div>
    <div>
        <a href="{{ route('goods-receipts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tạo Phiếu Nhập
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('goods-receipts.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="pending_qc">Chờ kiểm tra QC</option>
                    <option value="approved">Đã duyệt</option>
                    <option value="rejected">Từ chối</option>
                    <option value="completed">Hoàn thành</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Loại phiếu</label>
                <select name="type" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="from_supplier">Từ NCC</option>
                    <option value="from_production">Từ Sản xuất</option>
                    <option value="transfer">Chuyển kho</option>
                    <option value="return">Trả hàng</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Số phiếu, PO...">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Goods Receipts Table -->
<div class="card">
    <div class="card-header">
        Danh sách Phiếu Nhập kho
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Số phiếu</th>
                        <th>Loại</th>
                        <th>Kho nhập</th>
                        <th>Nhà cung cấp</th>
                        <th>Ngày nhập</th>
                        <th>Số PO</th>
                        <th>Trạng thái</th>
                        <th>Người tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goodsReceipts ?? [] as $receipt)
                    <tr>
                        <td><strong>{{ $receipt->receipt_number }}</strong></td>
                        <td>
                            @if($receipt->type == 'from_supplier')
                                <span class="badge bg-info">Từ NCC</span>
                            @elseif($receipt->type == 'from_production')
                                <span class="badge bg-primary">Từ SX</span>
                            @elseif($receipt->type == 'transfer')
                                <span class="badge bg-warning">Chuyển kho</span>
                            @else
                                <span class="badge bg-secondary">{{ $receipt->type }}</span>
                            @endif
                        </td>
                        <td>{{ $receipt->warehouse->name ?? 'N/A' }}</td>
                        <td>{{ $receipt->supplier->name ?? '-' }}</td>
                        <td>{{ $receipt->receipt_date->format('d/m/Y') }}</td>
                        <td>{{ $receipt->po_number ?? '-' }}</td>
                        <td>
                            @if($receipt->status == 'approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @elseif($receipt->status == 'pending_qc')
                                <span class="badge bg-warning">Chờ QC</span>
                            @elseif($receipt->status == 'rejected')
                                <span class="badge bg-danger">Từ chối</span>
                            @elseif($receipt->status == 'completed')
                                <span class="badge bg-success">Hoàn thành</span>
                            @else
                                <span class="badge bg-secondary">{{ $receipt->status }}</span>
                            @endif
                        </td>
                        <td>{{ $receipt->createdBy->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('goods-receipts.show', $receipt->id) }}" class="btn btn-sm btn-info" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($receipt->status == 'pending_qc')
                            <a href="{{ route('goods-receipts.edit', $receipt->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có phiếu nhập kho nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
