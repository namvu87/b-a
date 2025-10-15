@extends('layouts.app')

@section('page_title','Danh sách Phiếu Xuất')

@section('content')
<div class="card">
  <div class="title">Phiếu Xuất</div>
  <div class="muted">Danh sách các phiếu xuất gần đây (stub)</div>
  <a href="{{ route('issues.create') }}">+ Tạo Phiếu Xuất</a>
</div>
@endsection
