# WMS - Hệ thống Quản lý Kho
## Đại Long Foods

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)

Hệ thống quản lý kho (Warehouse Management System) được xây dựng dựa trên tài liệu phân tích nghiệp vụ chi tiết trong file `final2.md`.

## 📋 Tính năng chính

### 1. Dashboard
- Tổng quan tồn kho
- Cảnh báo tồn kho thấp
- Cảnh báo hàng gần hết hạn
- Theo dõi phiếu chờ kiểm tra QC
- Trạng thái các kho trong hệ thống

### 2. Quản lý Tồn kho
- Xem tồn kho theo kho, vị trí, lot/batch
- Theo dõi trạng thái hàng (Khả dụng, Chờ QC, Cách ly, Gần hết hạn)
- Quản lý số lượng khả dụng và đã đặt hàng
- Cảnh báo tồn kho

### 3. Phiếu Nhập kho
- Tạo phiếu nhập từ NCC, Sản xuất, Chuyển kho
- Quản lý thông tin lot/batch, NSX, HSD
- Tích hợp quy trình kiểm tra QC
- Theo dõi trạng thái phiếu nhập

### 4. Phiếu Xuất kho  
- Tạo phiếu xuất cho Sản xuất, Khách hàng, Chuyển kho
- Áp dụng nguyên tắc FEFO/FIFO
- Quản lý người nhận và bộ phận
- Theo dõi trạng thái xuất kho

### 5. Yêu cầu Vật tư
- Tạo yêu cầu vật tư từ các bộ phận
- Quy trình duyệt/từ chối
- Theo dõi trạng thái chuẩn bị hàng
- Quản lý số lượng yêu cầu và phê duyệt

### 6. Kiểm tra Chất lượng (QC)
- Tạo biên bản kiểm tra chất lượng
- Đánh giá theo nhiều tiêu chí (Ngoại quan, Màu sắc, Mùi vị, Bao bì, HSD)
- Kết quả: Đạt/Không đạt/Có điều kiện
- Quản lý hành động khắc phục
- Upload ảnh minh chứng

### 7. Dữ liệu Cơ bản
- **Sản phẩm**: Quản lý thông tin sản phẩm, phân loại ABC, tồn kho min/max
- **Kho**: 8 loại kho theo nghiệp vụ (WHRM, WHSP, WHSF, WHFG, WHDC, WHSR)
- **Vị trí**: Quản lý vị trí chi tiết (Khu vực - Dãy kệ - Số kệ - Tầng)
- **Nhà cung cấp**: Thông tin liên hệ, mã số thuế

## 🗂️ Cấu trúc Database

### Các bảng chính:
- `warehouses` - Danh sách kho
- `product_categories` - Nhóm sản phẩm
- `products` - Sản phẩm
- `locations` - Vị trí lưu kho
- `suppliers` - Nhà cung cấp
- `inventory` - Tồn kho
- `goods_receipts` & `goods_receipt_items` - Phiếu nhập kho
- `goods_issues` & `goods_issue_items` - Phiếu xuất kho
- `material_requisitions` & `material_requisition_items` - Yêu cầu vật tư
- `quality_controls` - Kiểm tra chất lượng

### Mối quan hệ:
- Sản phẩm thuộc Nhóm sản phẩm
- Vị trí thuộc Kho
- Tồn kho liên kết với Sản phẩm, Kho, Vị trí
- Phiếu nhập/xuất có nhiều dòng hàng
- QC liên kết với Phiếu nhập

## 🚀 Cài đặt

### Yêu cầu:
- PHP 8.4+
- Composer
- SQLite (mặc định) hoặc MySQL/PostgreSQL

### Các bước cài đặt:

1. **Clone project:**
```bash
cd /workspace/wms-dai-long
```

2. **Cài đặt dependencies:**
```bash
composer install
```

3. **Cấu hình environment:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Chạy migrations:**
```bash
php artisan migrate
```

5. **Tạo dữ liệu mẫu (optional):**
```bash
php artisan db:seed
```

6. **Chạy development server:**
```bash
php artisan serve
```

Truy cập: http://localhost:8000

## 📁 Cấu trúc Project

```
wms-dai-long/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php
│   │       ├── WarehouseController.php
│   │       ├── ProductController.php
│   │       ├── InventoryController.php
│   │       ├── GoodsReceiptController.php
│   │       ├── GoodsIssueController.php
│   │       ├── MaterialRequisitionController.php
│   │       └── QualityControlController.php
│   └── Models/
│       ├── Warehouse.php
│       ├── Product.php
│       ├── Inventory.php
│       ├── GoodsReceipt.php
│       ├── GoodsIssue.php
│       ├── MaterialRequisition.php
│       └── QualityControl.php
├── database/
│   └── migrations/
│       ├── *_create_warehouses_table.php
│       ├── *_create_products_table.php
│       ├── *_create_inventory_table.php
│       ├── *_create_goods_receipts_table.php
│       ├── *_create_goods_issues_table.php
│       ├── *_create_material_requisitions_table.php
│       └── *_create_quality_controls_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard/
│       ├── inventory/
│       ├── goods-receipts/
│       ├── goods-issues/
│       ├── material-requisitions/
│       ├── quality-controls/
│       ├── products/
│       ├── warehouses/
│       ├── suppliers/
│       └── locations/
└── routes/
    └── web.php
```

## 🎨 Giao diện

Hệ thống sử dụng **Bootstrap 5.3** với thiết kế hiện đại:
- Sidebar navigation với icons
- Card-based layouts
- Responsive design (Desktop, Tablet, Mobile)
- Color-coded status badges
- Interactive forms

### Màu sắc chủ đạo:
- Primary: `#3498db` (Xanh dương)
- Success: `#27ae60` (Xanh lá)
- Warning: `#f39c12` (Cam)
- Danger: `#e74c3c` (Đỏ)
- Dark: `#2c3e50` (Xanh đen)

## 📝 Các màn hình chính

### 1. Dashboard (`/`)
Tổng quan hệ thống với các chỉ số KPI, phiếu gần đây, trạng thái kho

### 2. Quản lý Tồn kho (`/inventory`)
Danh sách tồn kho với filter theo kho, trạng thái, tìm kiếm

### 3. Phiếu Nhập kho (`/goods-receipts`)
- Danh sách: `/goods-receipts`
- Tạo mới: `/goods-receipts/create`
- Chi tiết: `/goods-receipts/{id}`

### 4. Phiếu Xuất kho (`/goods-issues`)
- Danh sách: `/goods-issues`
- Tạo mới: `/goods-issues/create`

### 5. Yêu cầu Vật tư (`/material-requisitions`)
- Danh sách: `/material-requisitions`
- Duyệt/Từ chối inline

### 6. Kiểm tra Chất lượng (`/quality-controls`)
Danh sách biên bản QC với thống kê tỷ lệ đạt

### 7. Dữ liệu cơ bản
- Sản phẩm: `/products`
- Kho: `/warehouses`
- Vị trí: `/locations`
- Nhà cung cấp: `/suppliers`

## 🔄 Quy trình nghiệp vụ

### Quy trình Nhập kho:
1. Tạo Phiếu Nhập kho → Trạng thái: **Chờ QC**
2. QC kiểm tra → Tạo Biên bản QC
3. Nếu **Đạt** → Duyệt phiếu → Cập nhật Tồn kho
4. Nếu **Không đạt** → Cách ly → Xử lý (Trả/Đổi/Giảm giá)

### Quy trình Xuất kho:
1. Tạo Yêu cầu Vật tư (từ Sản xuất/Kinh doanh)
2. Kho duyệt → Tạo Phiếu Xuất
3. Soạn hàng theo FEFO/FIFO
4. Kiểm đếm Tay Ba
5. Xuất kho → Cập nhật Tồn kho

## 📊 Báo cáo & KPI

Các báo cáo đã được chuẩn bị cấu trúc:
- Báo cáo tồn kho theo kho/nhóm hàng
- Báo cáo xuất nhập tồn
- Báo cáo tuân thủ FEFO/FIFO
- Báo cáo hiệu suất QC
- Báo cáo hàng gần hết hạn
- Báo cáo giá trị tồn kho

## 🔐 Phân quyền (Dự kiến)

- **Admin**: Toàn quyền
- **Warehouse Manager**: Quản lý kho, duyệt phiếu
- **Warehouse Staff**: Tạo/sửa phiếu, cập nhật vị trí
- **QA/QC**: Kiểm tra chất lượng
- **Production**: Tạo yêu cầu vật tư
- **Sales**: Tạo yêu cầu giao hàng
- **Accountant**: Xem báo cáo (chỉ đọc)

## 🛠️ Công nghệ sử dụng

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates + Bootstrap 5.3
- **Database**: SQLite (mặc định), hỗ trợ MySQL/PostgreSQL
- **Icons**: Bootstrap Icons
- **PHP**: 8.4

## 📖 Tài liệu tham khảo

Dự án được xây dựng dựa trên tài liệu phân tích nghiệp vụ chi tiết:
- `final2.md` - Phân tích chi tiết hệ thống WMS Đại Long Foods
- Bao gồm: 8 kho, quy trình nghiệp vụ, mã hóa vị trí, FEFO/FIFO, KPI

## 🚧 Các tính năng cần phát triển tiếp

- [ ] Xây dựng logic controller cho từng module
- [ ] Implement CRUD đầy đủ cho các master data
- [ ] Xây dựng quy trình duyệt phiếu
- [ ] Tích hợp barcode/QR code scanning
- [ ] Báo cáo & Export Excel
- [ ] Dashboard với biểu đồ realtime
- [ ] Hệ thống phân quyền
- [ ] API cho mobile app
- [ ] Tích hợp với ERP/MES
- [ ] Kiểm kê kho (Inventory Count)

## 👥 Đóng góp

Project được tạo bởi AI Assistant dựa trên yêu cầu của khách hàng.

## 📄 License

Proprietary - Đại Long Foods

---

**Ghi chú**: Đây là phiên bản cơ bản với cấu trúc và giao diện đầy đủ. Các chức năng nghiệp vụ chi tiết cần được phát triển thêm theo yêu cầu cụ thể.
