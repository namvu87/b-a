@extends('layouts.app')

@section('title', 'Quản lý Sản phẩm - WMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-tags"></i> Quản lý Sản phẩm</h1>
        <p class="text-muted">Danh mục sản phẩm và vật tư</p>
    </div>
    <div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm Sản phẩm
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Nhóm sản phẩm</label>
                <select name="category_id" class="form-select">
                    <option value="">Tất cả</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Phân loại ABC</label>
                <select name="abc_class" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="A">A - Quan trọng nhất</option>
                    <option value="B">B - Trung bình</option>
                    <option value="C">C - Ít quan trọng</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Mã, tên sản phẩm...">
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

<!-- Products Table -->
<div class="card">
    <div class="card-header">
        Danh sách Sản phẩm
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Nhóm</th>
                        <th>ĐVT</th>
                        <th>ABC</th>
                        <th>Tồn Min</th>
                        <th>Tồn Max</th>
                        <th>Có HSD</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $product)
                    <tr>
                        <td><strong>{{ $product->code }}</strong></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>
                            @if($product->abc_class == 'A')
                                <span class="badge bg-danger">A</span>
                            @elseif($product->abc_class == 'B')
                                <span class="badge bg-warning">B</span>
                            @elseif($product->abc_class == 'C')
                                <span class="badge bg-info">C</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ number_format($product->min_stock, 2) }}</td>
                        <td>{{ number_format($product->max_stock, 2) }}</td>
                        <td>
                            @if($product->has_expiry)
                                <span class="badge bg-warning">Có</span>
                            @else
                                <span class="badge bg-secondary">Không</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Ngừng</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Chưa có sản phẩm nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
