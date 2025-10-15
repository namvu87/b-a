<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMS Demo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0b1020; --card:#121833; --muted:#9aa4c7; --text:#e6e9f4; --primary:#6ea8ff; --accent:#22d3ee; }
        *{ box-sizing:border-box }
        body{ margin:0; font-family:Inter,system-ui,Arial; background:var(--bg); color:var(--text); }
        a{ color:var(--text); text-decoration:none }
        .container{ display:grid; grid-template-columns:240px 1fr; min-height:100vh }
        .sidebar{ background:linear-gradient(180deg,#101739,#0d1431); border-right:1px solid #1d2548; padding:20px }
        .brand{ font-weight:700; letter-spacing:.5px; margin-bottom:16px; display:flex; align-items:center; gap:10px }
        .brand .dot{ width:10px; height:10px; border-radius:50%; background:var(--accent); box-shadow:0 0 16px var(--accent) }
        .nav a{ display:block; padding:10px 12px; border-radius:8px; color:#c9d3f5; margin:4px 0; }
        .nav a:hover{ background:#1a2250; color:#fff }
        .nav .section{ margin-top:14px; font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:.08em }
        header{ display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid #1d2548; background:rgba(16,23,57,.5); position:sticky; top:0; backdrop-filter: blur(6px) }
        main{ padding:24px }
        .card{ background:var(--card); border:1px solid #1d2548; border-radius:14px; padding:18px; box-shadow:0 8px 16px rgba(2,6,23,.35) }
        .title{ font-size:20px; font-weight:700; margin:0 0 10px }
        .muted{ color:var(--muted); font-size:14px }
        .grid{ display:grid; gap:16px }
        .grid.cols-3{ grid-template-columns:repeat(3,1fr) }
        @media (max-width: 1024px){ .container{ grid-template-columns:180px 1fr } .grid.cols-3{ grid-template-columns:1fr } }
    </style>
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <div class="brand"><span class="dot"></span> WMS Demo</div>
        <div class="nav">
            <div class="section">Tổng quan</div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <div class="section">Danh mục</div>
            <a href="{{ route('products.index') }}">Hàng hóa</a>
            <div class="section">Nghiệp vụ</div>
            <a href="{{ route('receipts.index') }}">Phiếu Nhập</a>
            <a href="{{ route('receipts.create') }}">Tạo Phiếu Nhập</a>
            <a href="{{ route('issues.index') }}">Phiếu Xuất</a>
            <a href="{{ route('issues.create') }}">Tạo Phiếu Xuất</a>
            <a href="{{ route('qc.queue') }}">QC Queue</a>
            <a href="{{ route('qc.form') }}">Form QC</a>
            <a href="{{ route('stocktake.planCreate') }}">Lập kế hoạch kiểm kê</a>
            <a href="{{ route('stocktake.execute') }}">Thực hiện kiểm kê</a>
            <a href="{{ route('stocktake.reconcile') }}">Đối chiếu sai lệch</a>
            <div class="section">Báo cáo</div>
            <a href="{{ route('reports.xnt') }}">Xuất Nhập Tồn</a>
            <a href="{{ route('reports.efficiency') }}">Hiệu suất kho</a>
            <a href="{{ route('reports.abc') }}">Phân tích ABC</a>
        </div>
    </aside>
    <section>
        <header>
            <div>@yield('page_title', 'WMS')</div>
        </header>
        <main>
            @yield('content')
        </main>
    </section>
</div>
</body>
</html>
