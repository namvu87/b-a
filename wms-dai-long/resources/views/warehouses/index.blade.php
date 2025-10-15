@extends('layouts.app')

@section('title', 'Quản lý Kho - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-building"></i> Quản lý Kho</h1>
        <p class="text-muted">Danh sách các kho trong hệ thống</p>
    </div>
    <div>
        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm Kho
        </a>
    </div>
</div>

<div class="row">
    @forelse($warehouses ?? [] as $warehouse)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ $warehouse->name }}</strong>
                @if($warehouse->is_active)
                    <span class="badge bg-success">Hoạt động</span>
                @else
                    <span class="badge bg-secondary">Ngừng</span>
                @endif
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Mã kho:</strong> {{ $warehouse->code }}</p>
                <p class="mb-2"><strong>Loại:</strong> 
                    <span class="badge bg-info">{{ $warehouse->type }}</span>
                </p>
                <p class="mb-2"><strong>Địa chỉ:</strong> {{ $warehouse->address ?? 'Chưa cập nhật' }}</p>
                <p class="mb-2"><strong>Diện tích:</strong> {{ $warehouse->area ? number_format($warehouse->area, 2) . ' m²' : 'N/A' }}</p>
                <p class="text-muted small">{{ $warehouse->description ?? 'Không có mô tả' }}</p>
            </div>
            <div class="card-footer bg-white">
                <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> Xem
                </a>
                <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i> Sửa
                </a>
                <a href="{{ route('inventory.by-warehouse', $warehouse->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-box-seam"></i> Tồn kho
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-building" style="font-size: 4rem;"></i>
                <p class="mt-3">Chưa có kho nào được tạo</p>
                <a href="{{ route('warehouses.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Tạo Kho đầu tiên
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection
