<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hệ thống Quản lý Kho') - Đại Long Foods</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <div class="logo-section">
            <h2>🏭 ĐẠI LONG FOODS</h2>
            <p>Warehouse Management System</p>
        </div>
        
        <div class="menu-section {{ request()->is('dashboard*') ? 'active' : '' }}">
            <div class="menu-title">📊 Dashboard</div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">Tổng quan</a>
            <a href="{{ route('dashboard.kpi') }}" class="menu-item">KPI & Hiệu suất</a>
        </div>
        
        <div class="menu-section {{ request()->is('inventory*') ? 'active' : '' }}">
            <div class="menu-title">📦 Quản lý Tồn kho</div>
            <a href="{{ route('inventory.index') }}" class="menu-item {{ request()->is('inventory') ? 'active' : '' }}">Danh sách hàng hóa</a>
            <a href="{{ route('inventory.by-location') }}" class="menu-item">Tồn kho theo vị trí</a>
            <a href="{{ route('inventory.by-lot') }}" class="menu-item">Tồn kho theo Lot/Batch</a>
        </div>
        
        <div class="menu-section {{ request()->is('receipt*') ? 'active' : '' }}">
            <div class="menu-title">📥 Nhập kho</div>
            <a href="{{ route('receipt.index') }}" class="menu-item {{ request()->is('receipt') ? 'active' : '' }}">Danh sách phiếu nhập</a>
            <a href="{{ route('receipt.create-ncc') }}" class="menu-item">Nhập từ NCC</a>
            <a href="{{ route('receipt.create-production') }}" class="menu-item">Nhập TP từ Sản xuất</a>
            <a href="{{ route('receipt.create-other') }}" class="menu-item">Nhập khác</a>
        </div>
        
        <div class="menu-section {{ request()->is('issue*') ? 'active' : '' }}">
            <div class="menu-title">📤 Xuất kho</div>
            <a href="{{ route('issue.index') }}" class="menu-item">Danh sách phiếu xuất</a>
            <a href="{{ route('issue.create-production') }}" class="menu-item">Xuất NVL cho SX</a>
            <a href="{{ route('issue.create-sale') }}" class="menu-item">Xuất TP bán hàng</a>
            <a href="{{ route('issue.create-transfer') }}" class="menu-item">Xuất chuyển kho</a>
        </div>
        
        <div class="menu-section {{ request()->is('request*') ? 'active' : '' }}">
            <div class="menu-title">📋 Yêu cầu Vật tư</div>
            <a href="{{ route('request.index') }}" class="menu-item">Danh sách YCVT</a>
            <a href="{{ route('request.create') }}" class="menu-item">Tạo YCVT mới</a>
        </div>
        
        <div class="menu-section {{ request()->is('qc*') ? 'active' : '' }}">
            <div class="menu-title">🔍 Kiểm tra QC</div>
            <a href="{{ route('qc.queue') }}" class="menu-item">Queue kiểm tra</a>
            <a href="{{ route('qc.history') }}" class="menu-item">Lịch sử QC</a>
            <a href="{{ route('qc.spkph') }}" class="menu-item">SPKPH</a>
        </div>
        
        <div class="menu-section {{ request()->is('stocktake*') ? 'active' : '' }}">
            <div class="menu-title">📊 Kiểm kê</div>
            <a href="{{ route('stocktake.create') }}" class="menu-item">Tạo kế hoạch kiểm kê</a>
            <a href="{{ route('stocktake.index') }}" class="menu-item">Danh sách kiểm kê</a>
        </div>
        
        <div class="menu-section {{ request()->is('report*') ? 'active' : '' }}">
            <div class="menu-title">📈 Báo cáo</div>
            <a href="{{ route('report.inventory-movement') }}" class="menu-item">Xuất Nhập Tồn</a>
            <a href="{{ route('report.fefo-compliance') }}" class="menu-item">Báo cáo FEFO</a>
            <a href="{{ route('report.warehouse-performance') }}" class="menu-item">Hiệu suất Kho</a>
        </div>
        
        <div class="menu-section {{ request()->is('master*') ? 'active' : '' }}">
            <div class="menu-title">⚙️ Danh mục</div>
            <a href="{{ route('master.warehouse.index') }}" class="menu-item">Kho</a>
            <a href="{{ route('master.location.index') }}" class="menu-item">Vị trí lưu kho</a>
            <a href="{{ route('master.supplier.index') }}" class="menu-item">Nhà cung cấp</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <header>
            <div>
                <span style="font-size: 18px;">Hệ thống Quản lý Kho</span>
            </div>
            <div class="header-info">
                <span>📅 {{ date('d/m/Y') }}</span>
                <span>👤 {{ Auth::user()->name ?? 'Nguyễn Văn A' }} (TO-KHO)</span>
                <span style="cursor: pointer;">🔔 (3)</span>
            </div>
        </header>
        
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
