@extends('layouts.app')

@section('page_title','Danh sách Hàng hóa')

@section('content')
<div class="card">
  <div class="title">Hàng hóa</div>
  <div class="muted">Danh sách demo (stub)</div>
  <ul>
    <li><a href="{{ route('products.show', 1) }}">Mã HH-001</a></li>
    <li><a href="{{ route('products.show', 2) }}">Mã HH-002</a></li>
  </ul>
</div>
@endsection
