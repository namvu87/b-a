@extends('layouts.app')

@section('title', 'Dashboard - WMS Đại Long Foods')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-speedometer2"></i> Dashboard</h1>
    <p class="text-muted">Tổng quan hệ thống quản lý kho</p>
</div>

<div class="row">
    <!-- Stat Cards -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Tổng Tồn kho</p>
                        <h3 class="mb-0">{{ number_format($totalInventory ?? 0) }}</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> Mã hàng</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Cảnh báo Tồn thấp</p>
                        <h3 class="mb-0">{{ $lowStockCount ?? 0 }}</h3>
                        <small class="text-warning"><i class="bi bi-exclamation-triangle"></i> Mã hàng</small>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem;">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Gần hết hạn</p>
                        <h3 class="mb-0">{{ $nearExpiryCount ?? 0 }}</h3>
                        <small class="text-danger"><i class="bi bi-clock"></i> Lô hàng</small>
                    </div>
                    <div class="text-danger" style="font-size: 2.5rem;">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Chờ Kiểm tra QC</p>
                        <h3 class="mb-0">{{ $pendingQCCount ?? 0 }}</h3>
                        <small class="text-info"><i class="bi bi-hourglass-split"></i> Phiếu nhập</small>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem;">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Goods Receipts -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-arrow-down-circle"></i> Phiếu Nhập kho gần đây
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Số phiếu</th>
                                <th>Ngày nhập</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentGoodsReceipts ?? [] as $receipt)
                            <tr>
                                <td><a href="{{ route('goods-receipts.show', $receipt->id) }}">{{ $receipt->receipt_number }}</a></td>
                                <td>{{ $receipt->receipt_date->format('d/m/Y') }}</td>
                                <td>
                                    @if($receipt->status == 'approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @elseif($receipt->status == 'pending_qc')
                                        <span class="badge bg-warning">Chờ QC</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $receipt->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Chưa có dữ liệu</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Material Requisitions -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-text"></i> Yêu cầu Vật tư gần đây
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Số phiếu</th>
                                <th>Bộ phận</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMaterialRequisitions ?? [] as $requisition)
                            <tr>
                                <td><a href="{{ route('material-requisitions.show', $requisition->id) }}">{{ $requisition->requisition_number }}</a></td>
                                <td>{{ $requisition->department }}</td>
                                <td>
                                    @if($requisition->status == 'approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @elseif($requisition->status == 'pending')
                                        <span class="badge bg-warning">Chờ duyệt</span>
                                    @elseif($requisition->status == 'rejected')
                                        <span class="badge bg-danger">Từ chối</span>
                                    @else
                                        <span class="badge bg-info">{{ $requisition->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Chưa có dữ liệu</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Warehouse Status -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-building"></i> Trạng thái Kho
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($warehouses ?? [] as $warehouse)
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3">
                            <h6 class="fw-bold">{{ $warehouse->name }}</h6>
                            <p class="text-muted small mb-2">{{ $warehouse->code }}</p>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Loại:</span>
                                <span class="badge bg-info">{{ $warehouse->type }}</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="text-muted">Trạng thái:</span>
                                @if($warehouse->is_active)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Không hoạt động</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">
                        Chưa có kho nào được tạo
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
