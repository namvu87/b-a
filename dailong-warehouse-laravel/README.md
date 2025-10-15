# 🏭 HỆ THỐNG QUẢN LÝ KHO - ĐẠI LONG FOODS

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 GIỚI THIỆU

Hệ thống Quản lý Kho (Warehouse Management System - WMS) cho Đại Long Foods.
Dự án Laravel với giao diện hoàn chỉnh, dựa trên phân tích nghiệp vụ chi tiết.

### Tính năng chính:
- ✅ **Dashboard** với 8 KPI realtime
- ✅ **Quản lý Tồn kho** theo mã hàng, vị trí, lot/batch
- ✅ **Phiếu Nhập kho** từ NCC, Sản xuất
- ✅ **Phiếu Xuất kho** với FEFO tự động
- ✅ **Kiểm tra QC** & SPKPH
- ✅ **Yêu cầu Vật tư** (YCVT)
- ✅ **Kiểm kê** định kỳ/tuần hoàn
- ✅ **Báo cáo** đa dạng (XNT, FEFO, Hiệu suất)

---

## 🚀 CÀI ĐẶT

### Yêu cầu hệ thống:
- PHP >= 8.1
- Composer
- MySQL >= 5.7 hoặc PostgreSQL
- Node.js & NPM (cho assets)

### Các bước cài đặt:

#### 1. Clone repository
```bash
git clone <repository-url>
cd dailong-warehouse-laravel
```

#### 2. Cài đặt dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
npm run build
```

#### 3. Cấu hình environment
```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Cấu hình database trong `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dailong_warehouse
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Migrate database & seed data
```bash
# Run migrations
php artisan migrate

# Seed demo data (optional)
php artisan db:seed
```

#### 6. Chạy development server
```bash
php artisan serve
```

Truy cập: http://localhost:8000

---

## 📁 CẤU TRÚC PROJECT

```
dailong-warehouse-laravel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php       # Dashboard & KPI
│   │       ├── InventoryController.php       # Quản lý Tồn kho
│   │       ├── ReceiptController.php         # Phiếu Nhập kho
│   │       ├── IssueController.php           # Phiếu Xuất kho (FEFO)
│   │       ├── QCController.php              # Kiểm tra QC & SPKPH
│   │       └── ReportController.php          # Báo cáo
│   └── Models/                                # Database models
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                 # Master layout
│       ├── dashboard/
│       │   └── index.blade.php               # Dashboard chính
│       ├── inventory/
│       │   ├── index.blade.php               # Danh sách hàng hóa
│       │   └── show.blade.php                # Chi tiết hàng hóa
│       ├── receipt/
│       │   ├── index.blade.php               # Danh sách phiếu nhập
│       │   └── create-ncc.blade.php          # Tạo phiếu nhập từ NCC
│       ├── issue/
│       │   ├── index.blade.php               # Danh sách phiếu xuất
│       │   └── create-production.blade.php   # Xuất cho SX (FEFO)
│       ├── qc/
│       │   ├── queue.blade.php               # Queue kiểm tra QC
│       │   └── check.blade.php               # Form kiểm tra QC
│       └── report/                            # Báo cáo
│
├── routes/
│   └── web.php                                # Routes định nghĩa
│
├── public/
│   ├── css/
│   │   └── app.css                           # Main CSS
│   └── js/
│       └── app.js                            # Main JavaScript
│
└── database/
    ├── migrations/                            # Database migrations
    └── seeders/                               # Demo data seeders
```

---

## 🗺️ ROUTES

### Dashboard
- `GET /` - Dashboard chính
- `GET /dashboard` - Dashboard
- `GET /dashboard/kpi` - KPI chi tiết

### Inventory (Tồn kho)
- `GET /inventory` - Danh sách hàng hóa
- `GET /inventory/create` - Thêm hàng hóa
- `GET /inventory/{id}` - Chi tiết hàng hóa (4 tabs)
- `GET /inventory/by-location` - Tồn kho theo vị trí
- `GET /inventory/by-lot` - Tồn kho theo Lot/Batch

### Receipt (Phiếu Nhập)
- `GET /receipt` - Danh sách phiếu nhập
- `GET /receipt/create-ncc` - Nhập từ NCC
- `GET /receipt/create-production` - Nhập TP từ SX
- `GET /receipt/{id}` - Chi tiết phiếu nhập

### Issue (Phiếu Xuất)
- `GET /issue` - Danh sách phiếu xuất
- `GET /issue/create-production` - Xuất NVL cho SX (FEFO)
- `GET /issue/create-sale` - Xuất TP bán hàng
- `POST /issue/fefo-suggest` - API FEFO suggest

### QC (Kiểm tra Chất lượng)
- `GET /qc/queue` - Queue kiểm tra
- `GET /qc/{receipt_id}/check` - Form kiểm tra QC
- `POST /qc/{receipt_id}/submit` - Submit kết quả QC
- `GET /qc/spkph` - Danh sách SPKPH

### Request (Yêu cầu Vật tư)
- `GET /request` - Danh sách YCVT
- `GET /request/create` - Tạo YCVT mới

### Stocktake (Kiểm kê)
- `GET /stocktake` - Danh sách kiểm kê
- `GET /stocktake/create` - Tạo kế hoạch kiểm kê

### Report (Báo cáo)
- `GET /report/inventory-movement` - Báo cáo Xuất Nhập Tồn
- `GET /report/fefo-compliance` - Báo cáo tuân thủ FEFO
- `GET /report/warehouse-performance` - Hiệu suất Kho

---

## 💾 DATABASE SCHEMA

### Bảng chính:

#### `warehouses` - Kho
- id, code, name, type, status

#### `locations` - Vị trí lưu kho
- id, warehouse_id, code (VD: D01-03-02), zone, capacity

#### `products` - Hàng hóa
- id, code, name, category, unit, min_stock, max_stock, reorder_point

#### `product_lots` - Lot/Batch
- id, product_id, lot_number, manufacture_date, expiry_date, quantity

#### `inventory` - Tồn kho
- id, product_id, warehouse_id, location_id, available_qty, waiting_qc_qty, quarantine_qty

#### `receipt_docs` - Phiếu Nhập kho
- id, doc_number, type, warehouse_id, supplier_id, status (WAIT_QC, IMPORTED, QUARANTINE)

#### `receipt_details` - Chi tiết Phiếu Nhập
- id, receipt_id, product_id, lot_number, quantity, unit_price

#### `issue_docs` - Phiếu Xuất kho
- id, doc_number, type, warehouse_id, receiver, status

#### `issue_details` - Chi tiết Phiếu Xuất
- id, issue_id, product_id, lot_number, quantity, is_fefo_compliant

#### `qc_results` - Kết quả QC
- id, receipt_id, inspector, result (PASS/FAIL), criteria_results (JSON)

#### `spkph` - Sản phẩm Không Phù Hợp
- id, receipt_id, product_id, defect_description, resolution_status

---

## 🎨 DESIGN SYSTEM

### Màu sắc chủ đạo:
- **Primary**: `#a32718` (Đỏ Đại Long)
- **Secondary**: `#ecc67d` (Vàng gold)
- **Success**: `#27ae60` (Xanh lá)
- **Warning**: `#f39c12` (Cam)
- **Danger**: `#dc3545` (Đỏ cảnh báo)
- **Info**: `#2196F3` (Xanh dương)

### Components:
- Sidebar menu với toggle
- Stats cards (8 KPI cards)
- Table với search & filter
- Modal với animation
- Status badges
- Form elements

---

## 📸 SCREENSHOTS

### Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Danh sách Hàng hóa
![Inventory](docs/screenshots/inventory.png)

### Form Nhập kho
![Receipt](docs/screenshots/receipt.png)

### FEFO Suggestion
![FEFO](docs/screenshots/fefo.png)

### QC Queue
![QC](docs/screenshots/qc.png)

---

## 🧪 TESTING

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=DashboardTest
```

---

## 📚 TÀI LIỆU THAM KHẢO

- [Laravel Documentation](https://laravel.com/docs)
- [Business Analysis Document](../final2.md) - Tài liệu phân tích nghiệp vụ đầy đủ
- [Screen Design Document](../SCREEN_DESIGN.md) - Thiết kế màn hình chi tiết
- [API Documentation](docs/API.md) - API endpoints

---

## 🤝 ĐÓNG GÓP

1. Fork repository
2. Tạo branch mới (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📞 LIÊN HỆ

**Đại Long Foods**
- Website: https://dailongfoods.com
- Email: wms-support@dailongfoods.com
- Hotline: 1900-xxxx (24/7)

---

## 📄 LICENSE

MIT License - xem file [LICENSE](LICENSE) để biết thêm chi tiết.

---

**🎉 CẢM ƠN BẠN ĐÃ SỬ DỤNG HỆ THỐNG WMS ĐẠI LONG FOODS!**
