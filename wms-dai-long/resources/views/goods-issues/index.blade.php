@extends('layouts.app')

@section('title', 'Phiếu Xuất kho - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-arrow-up-circle"></i> Phiếu Xuất kho</h1>
        <p class="text-muted">Quản lý phiếu xuất hàng ra khỏi kho</p>
    </div>
    <div>
        <a href="{{ route('goods-issues.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tạo Phiếu Xuất
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('goods-issues.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="pending">Chờ duyệt</option>
                    <option value="approved">Đã duyệt</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Loại phiếu</label>
                <select name="type" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="to_production">Cho Sản xuất</option>
                    <option value="to_customer">Cho Khách hàng</option>
                    <option value="transfer">Chuyển kho</option>
                    <option value="return_supplier">Trả NCC</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Số phiếu...">
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

<!-- Goods Issues Table -->
<div class="card">
    <div class="card-header">
        Danh sách Phiếu Xuất kho
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Số phiếu</th>
                        <th>Loại</th>
                        <th>Kho xuất</th>
                        <th>Người nhận</th>
                        <th>Bộ phận</th>
                        <th>Ngày xuất</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goodsIssues ?? [] as $issue)
                    <tr>
                        <td><strong>{{ $issue->issue_number }}</strong></td>
                        <td>
                            @if($issue->type == 'to_production')
                                <span class="badge bg-primary">Sản xuất</span>
                            @elseif($issue->type == 'to_customer')
                                <span class="badge bg-success">Khách hàng</span>
                            @elseif($issue->type == 'transfer')
                                <span class="badge bg-warning">Chuyển kho</span>
                            @else
                                <span class="badge bg-secondary">{{ $issue->type }}</span>
                            @endif
                        </td>
                        <td>{{ $issue->warehouse->name ?? 'N/A' }}</td>
                        <td>{{ $issue->recipient_name ?? '-' }}</td>
                        <td>{{ $issue->recipient_department ?? '-' }}</td>
                        <td>{{ $issue->issue_date->format('d/m/Y') }}</td>
                        <td>
                            @if($issue->status == 'completed')
                                <span class="badge bg-success">Hoàn thành</span>
                            @elseif($issue->status == 'pending')
                                <span class="badge bg-warning">Chờ duyệt</span>
                            @elseif($issue->status == 'approved')
                                <span class="badge bg-info">Đã duyệt</span>
                            @elseif($issue->status == 'cancelled')
                                <span class="badge bg-danger">Đã hủy</span>
                            @else
                                <span class="badge bg-secondary">{{ $issue->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('goods-issues.show', $issue->id) }}" class="btn btn-sm btn-info" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($issue->status == 'pending')
                            <a href="{{ route('goods-issues.edit', $issue->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có phiếu xuất kho nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
