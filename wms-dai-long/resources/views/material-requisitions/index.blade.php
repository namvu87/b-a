@extends('layouts.app')

@section('title', 'Yêu cầu Vật tư - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-file-earmark-text"></i> Yêu cầu Vật tư</h1>
        <p class="text-muted">Quản lý yêu cầu vật tư từ các bộ phận</p>
    </div>
    <div>
        <a href="{{ route('material-requisitions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tạo Yêu cầu
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('material-requisitions.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="pending">Chờ duyệt</option>
                    <option value="approved">Đã duyệt</option>
                    <option value="preparing">Đang chuẩn bị</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="rejected">Từ chối</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Bộ phận</label>
                <select name="department" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="Sản xuất">Sản xuất</option>
                    <option value="Kinh doanh">Kinh doanh</option>
                    <option value="Kỹ thuật">Kỹ thuật</option>
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

<!-- Material Requisitions Table -->
<div class="card">
    <div class="card-header">
        Danh sách Yêu cầu Vật tư
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Số phiếu</th>
                        <th>Bộ phận</th>
                        <th>Kho</th>
                        <th>Ngày yêu cầu</th>
                        <th>Ngày cần</th>
                        <th>Người yêu cầu</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materialRequisitions ?? [] as $requisition)
                    <tr>
                        <td><strong>{{ $requisition->requisition_number }}</strong></td>
                        <td>{{ $requisition->department }}</td>
                        <td>{{ $requisition->warehouse->name ?? 'N/A' }}</td>
                        <td>{{ $requisition->request_date->format('d/m/Y') }}</td>
                        <td>{{ $requisition->needed_date ? $requisition->needed_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $requisition->requestedBy->name ?? 'N/A' }}</td>
                        <td>
                            @if($requisition->status == 'approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @elseif($requisition->status == 'pending')
                                <span class="badge bg-warning">Chờ duyệt</span>
                            @elseif($requisition->status == 'preparing')
                                <span class="badge bg-info">Đang chuẩn bị</span>
                            @elseif($requisition->status == 'completed')
                                <span class="badge bg-success">Hoàn thành</span>
                            @elseif($requisition->status == 'rejected')
                                <span class="badge bg-danger">Từ chối</span>
                            @else
                                <span class="badge bg-secondary">{{ $requisition->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('material-requisitions.show', $requisition->id) }}" class="btn btn-sm btn-info" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($requisition->status == 'pending')
                            <form action="{{ route('material-requisitions.approve', $requisition->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Duyệt">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                            <form action="{{ route('material-requisitions.reject', $requisition->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" title="Từ chối">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có yêu cầu vật tư nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
