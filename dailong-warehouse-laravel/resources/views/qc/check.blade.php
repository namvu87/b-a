@extends('layouts.app')

@section('title', 'Form Kiểm tra QC')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Form Kiểm tra Chất lượng (QC)</h1>
        <div class="breadcrumb">Kiểm tra QC / Form kiểm tra</div>
    </div>
</div>

<div class="content-card">
    <form action="{{ route('qc.submit', $receipt['doc_number']) }}" method="POST">
        @csrf
        
        <div class="section-title">Thông tin phiếu nhập</div>
        
        <div class="lot-info">
            <div class="lot-item">
                <strong>Số phiếu nhập:</strong>
                <span>{{ $receipt['doc_number'] }}</span>
            </div>
            <div class="lot-item">
                <strong>Mã hàng:</strong>
                <span>{{ $receipt['product_code'] }}</span>
            </div>
            <div class="lot-item">
                <strong>Lot/Batch:</strong>
                <span>{{ $receipt['lot'] }}</span>
            </div>
            <div class="lot-item">
                <strong>Số lượng:</strong>
                <span>{{ $receipt['quantity'] }}</span>
            </div>
            <div class="lot-item">
                <strong>NCC:</strong>
                <span>{{ $receipt['supplier'] }}</span>
            </div>
        </div>
        
        <div class="section-title" style="margin-top: 24px;">Tiêu chí kiểm tra</div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Người kiểm tra <span class="required">*</span></label>
                <input type="text" class="form-input" value="{{ Auth::user()->name ?? 'Phạm Thị D (TO-QAC)' }}" disabled>
            </div>
            <div class="form-group">
                <label class="form-label">Ngày giờ kiểm tra <span class="required">*</span></label>
                <input type="datetime-local" class="form-input" name="check_datetime" value="{{ date('Y-m-d\TH:i') }}" required>
            </div>
        </div>
        
        <table class="detail-table">
            <thead>
                <tr>
                    <th style="width: 50px;">STT</th>
                    <th style="width: 200px;">Tiêu chí</th>
                    <th style="width: 150px;">Tiêu chuẩn</th>
                    <th style="width: 150px;">Thực tế</th>
                    <th style="width: 120px;">Kết quả</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteria as $index => $criterion)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $criterion['name'] }}</td>
                    <td>{{ $criterion['standard'] }}</td>
                    <td>
                        <input type="text" class="form-input" name="actual[{{ $index }}]" placeholder="Nhập giá trị">
                    </td>
                    <td>
                        <select class="form-select" name="result[{{ $index }}]">
                            <option value="">Chọn</option>
                            <option value="pass">✅ ĐẠT</option>
                            <option value="fail">❌ KHÔNG ĐẠT</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-input" name="note[{{ $index }}]" placeholder="Ghi chú">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="section-title" style="margin-top: 24px;">Kết luận</div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Kết quả tổng thể <span class="required">*</span></label>
                <select class="form-select" name="result" id="qcResult" required>
                    <option value="">-- Chọn kết quả --</option>
                    <option value="pass">✅ ĐẠT - Cho phép nhập kho</option>
                    <option value="fail">❌ KHÔNG ĐẠT - Cách ly & lập SPKPH</option>
                </select>
            </div>
        </div>
        
        <div class="form-row full">
            <div class="form-group">
                <label class="form-label">Nhận xét chung</label>
                <textarea class="form-input" name="comment" rows="3" placeholder="Nhập nhận xét, đề xuất xử lý..."></textarea>
            </div>
        </div>
        
        <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('qc.queue') }}" class="btn-cancel">Hủy</a>
            <button type="submit" class="btn-save">Lưu kết quả QC</button>
        </div>
    </form>
</div>
@endsection
