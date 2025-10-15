@extends('layouts.app')

@section('title', 'Quản lý Vị trí - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-geo-alt"></i> Quản lý Vị trí</h1>
        <p class="text-muted">Danh sách vị trí lưu kho (Kệ, Tầng)</p>
    </div>
    <div>
        <a href="{{ route('locations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm Vị trí
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Kho</label>
                <select name="warehouse_id" class="form-select">
                    <option value="">Tất cả</option>
                    @foreach($warehouses ?? [] as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Mã vị trí...">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Locations Table -->
<div class="card">
    <div class="card-header">
        Danh sách Vị trí
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã vị trí</th>
                        <th>Kho</th>
                        <th>Khu vực</th>
                        <th>Dãy kệ</th>
                        <th>Số kệ</th>
                        <th>Tầng</th>
                        <th>Sức chứa</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations ?? [] as $location)
                    <tr>
                        <td><strong>{{ $location->code }}</strong></td>
                        <td>{{ $location->warehouse->name ?? 'N/A' }}</td>
                        <td>{{ $location->zone ?? '-' }}</td>
                        <td>{{ $location->aisle ?? '-' }}</td>
                        <td>{{ $location->rack ?? '-' }}</td>
                        <td>{{ $location->level ?? '-' }}</td>
                        <td>{{ $location->capacity ? number_format($location->capacity, 2) . ' ' . $location->capacity_unit : 'N/A' }}</td>
                        <td>
                            @if($location->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Ngừng</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('locations.show', $location->id) }}" class="btn btn-sm btn-info" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có vị trí nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
