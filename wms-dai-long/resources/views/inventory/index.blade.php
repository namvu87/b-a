@extends('layouts.app')

@section('title', 'Quản lý Tồn kho - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-box-seam"></i> Quản lý Tồn kho</h1>
        <p class="text-muted">Theo dõi tồn kho theo kho, vị trí và lot/batch</p>
    </div>
    <div>
        <a href="{{ route('inventory.alerts') }}" class="btn btn-warning">
            <i class="bi bi-exclamation-triangle"></i> Cảnh báo
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('inventory.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Kho</label>
                <select name="warehouse_id" class="form-select">
                    <option value="">Tất cả</option>
                    <!-- Add warehouse options dynamically -->
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="available">Khả dụng</option>
                    <option value="pending_qc">Chờ QC</option>
                    <option value="quarantine">Cách ly</option>
                    <option value="near_expiry">Gần hết hạn</option>
                    <option value="expired">Hết hạn</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Mã hàng, tên hàng...">
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

<!-- Inventory Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Danh sách Tồn kho</span>
        <button class="btn btn-sm btn-success">
            <i class="bi bi-file-excel"></i> Xuất Excel
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã hàng</th>
                        <th>Tên hàng</th>
                        <th>Kho</th>
                        <th>Vị trí</th>
                        <th>Lot/Batch</th>
                        <th>HSD</th>
                        <th>Số lượng</th>
                        <th>Khả dụng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventories ?? [] as $inventory)
                    <tr>
                        <td><strong>{{ $inventory->product->code ?? 'N/A' }}</strong></td>
                        <td>{{ $inventory->product->name ?? 'N/A' }}</td>
                        <td>{{ $inventory->warehouse->name ?? 'N/A' }}</td>
                        <td>{{ $inventory->location->code ?? 'N/A' }}</td>
                        <td>{{ $inventory->lot_number ?? '-' }}</td>
                        <td>
                            @if($inventory->expiry_date)
                                {{ $inventory->expiry_date->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ number_format($inventory->quantity, 2) }}</td>
                        <td>{{ number_format($inventory->available_quantity, 2) }}</td>
                        <td>
                            @if($inventory->status == 'available')
                                <span class="badge bg-success">Khả dụng</span>
                            @elseif($inventory->status == 'pending_qc')
                                <span class="badge bg-warning">Chờ QC</span>
                            @elseif($inventory->status == 'quarantine')
                                <span class="badge bg-danger">Cách ly</span>
                            @elseif($inventory->status == 'near_expiry')
                                <span class="badge bg-warning">Gần hết hạn</span>
                            @else
                                <span class="badge bg-secondary">{{ $inventory->status }}</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Lịch sử">
                                <i class="bi bi-clock-history"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có dữ liệu tồn kho</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
