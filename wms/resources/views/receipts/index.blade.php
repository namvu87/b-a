@extends('layouts.app')

@section('page_title','Danh sách Phiếu Nhập')

@section('content')
<div class="card">
  <div class="title">Phiếu Nhập</div>
  <div class="muted">Danh sách các phiếu nhập gần đây (stub)</div>
  <a href="{{ route('receipts.create') }}">+ Tạo Phiếu Nhập</a>
</div>
@endsection
