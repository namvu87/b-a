@extends('layouts.app')

@section('page_title','Form QC')

@section('content')
<div class="card">
  <div class="title">Form Kiểm tra Chất lượng</div>
  <div class="muted">Nhập kết quả kiểm tra (stub)</div>
  <form>
    <div>
      <label>Kết quả</label>
      <select>
        <option>Đạt</option>
        <option>Không đạt</option>
      </select>
    </div>
  </form>
</div>
@endsection
