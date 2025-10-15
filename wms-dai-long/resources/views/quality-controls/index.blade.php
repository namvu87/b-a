@extends('layouts.app')

@section('title', 'Kiểm tra Chất lượng - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-clipboard-check"></i> Kiểm tra Chất lượng (QC)</h1>
        <p class="text-muted">Quản lý quy trình kiểm tra chất lượng hàng nhập</p>
    </div>
    <div>
        <a href="{{ route('quality-controls.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tạo Biên bản QC
        </a>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <h3 class="mb-0">{{ $pendingCount ?? 0 }}</h3>
                <p class="text-muted mb-0">Chờ kiểm tra</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <h3 class="mb-0">{{ $passedCount ?? 0 }}</h3>
                <p class="text-muted mb-0">Đạt</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <h3 class="mb-0">{{ $failedCount ?? 0 }}</h3>
                <p class="text-muted mb-0">Không đạt</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <h3 class="mb-0">{{ $passRate ?? 0 }}%</h3>
                <p class="text-muted mb-0">Tỷ lệ đạt</p>
            </div>
        </div>
    </div>
</div>

<!-- Quality Controls Table -->
<div class="card">
    <div class="card-header">
        Danh sách Biên bản Kiểm tra
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Số QC</th>
                        <th>Phiếu nhập</th>
                        <th>Sản phẩm</th>
                        <th>Lot</th>
                        <th>Ngày kiểm tra</th>
                        <th>Người kiểm tra</th>
                        <th>Kết quả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($qualityControls ?? [] as $qc)
                    <tr>
                        <td><strong>{{ $qc->qc_number }}</strong></td>
                        <td>{{ $qc->goodsReceipt->receipt_number ?? 'N/A' }}</td>
                        <td>{{ $qc->product->name ?? 'N/A' }}</td>
                        <td>{{ $qc->lot_number ?? '-' }}</td>
                        <td>{{ $qc->inspection_date->format('d/m/Y') }}</td>
                        <td>{{ $qc->inspector->name ?? 'N/A' }}</td>
                        <td>
                            @if($qc->result == 'passed')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Đạt
                                </span>
                            @elseif($qc->result == 'failed')
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle"></i> Không đạt
                                </span>
                            @elseif($qc->result == 'conditional')
                                <span class="badge bg-warning">
                                    <i class="bi bi-exclamation-circle"></i> Có điều kiện
                                </span>
                            @else
                                <span class="badge bg-secondary">{{ $qc->result }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('quality-controls.show', $qc->id) }}" class="btn btn-sm btn-info" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-secondary" title="In biên bản">
                                <i class="bi bi-printer"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có biên bản kiểm tra nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
