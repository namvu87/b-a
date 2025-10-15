@extends('layouts.app')

@section('page_title','Dashboard Tồn kho')

@section('content')
<div class="grid cols-3">
  <div class="card">
    <div class="title">Tổng tồn kho</div>
    <div class="muted">Giá trị và số lượng tổng</div>
  </div>
  <div class="card">
    <div class="title">Cảnh báo</div>
    <div class="muted">Sắp hết hàng, gần hết hạn</div>
  </div>
  <div class="card">
    <div class="title">Xuất nhập gần đây</div>
    <div class="muted">Hoạt động mới nhất</div>
  </div>
</div>
@endsection
