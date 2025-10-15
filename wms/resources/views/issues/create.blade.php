@extends('layouts.app')

@section('page_title','Tạo Phiếu Xuất kho')

@section('content')
<div class="card">
  <div class="title">Tạo Phiếu Xuất</div>
  <div class="muted">Xuất nội bộ / bán hàng / chuyển kho (stub)</div>
  <form>
    <div>
      <label>Loại xuất</label>
      <select>
        <option>Xuất nội bộ</option>
        <option>Xuất bán hàng</option>
        <option>Xuất chuyển kho</option>
      </select>
    </div>
  </form>
</div>
@endsection
