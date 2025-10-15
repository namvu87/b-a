@extends('layouts.app')

@section('page_title','Tạo Phiếu Nhập kho')

@section('content')
<div class="card">
  <div class="title">Tạo Phiếu Nhập</div>
  <div class="muted">Form nhập từ NCC / SX (stub)</div>
  <form>
    <div>
      <label>Nhà cung cấp</label>
      <input type="text" placeholder="Nhà cung cấp" />
    </div>
    <div>
      <label>Số PO</label>
      <input type="text" placeholder="PO-..." />
    </div>
  </form>
</div>
@endsection
