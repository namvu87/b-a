# 📋 BUSINESS ANALYSIS DOCUMENT
## Hệ thống Quản lý Kho - Đại Long Foods

**Phiên bản:** 1.0  
**Ngày:** 14/10/2025  
**Người lập:** Business Analyst  
**Trạng thái:** Draft for Review

---

## 📑 MỤC LỤC

1. [Tổng quan dự án](#1-tổng-quan-dự-án)
2. [Phạm vi nghiệp vụ](#2-phạm-vi-nghiệp-vụ)
3. [Phân tích stakeholder](#3-phân-tích-stakeholder)
4. [Quy trình nghiệp vụ hiện tại](#4-quy-trình-nghiệp-vụ-hiện-tại)
5. [Yêu cầu nghiệp vụ](#5-yêu-cầu-nghiệp-vụ)
6. [Yêu cầu chức năng](#6-yêu-cầu-chức-năng)
7. [Yêu cầu phi chức năng](#7-yêu-cầu-phi-chức-năng)
8. [Thiết kế logic module](#8-thiết-kế-logic-module)
9. [Kế hoạch mở rộng](#9-kế-hoạch-mở-rộng)
10. [Rủi ro và giải pháp](#10-rủi-ro-và-giải-pháp)

---

## 1. TỔNG QUAN DỰ ÁN

### 1.1 Bối cảnh nghiệp vụ

**Đại Long Foods** là công ty sản xuất thực phẩm với các hoạt động chính:
- Nhập nguyên vật liệu (NVL) từ nhà cung cấp
- Sản xuất thành phẩm (TP)
- Quản lý xuất/nhập kho nội bộ
- Kiểm soát chất lượng QA/QC

### 1.2 Vấn đề hiện tại

| Vấn đề | Tác động | Mức độ |
|--------|----------|--------|
| Quản lý tồn kho thủ công (Excel) | Sai sót, mất thời gian | 🔴 Cao |
| Không theo dõi realtime | Không kiểm soát được số lượng chính xác | 🔴 Cao |
| Quy trình kiểm tra QC chưa chuẩn hóa | Hàng KHÔNG ĐẠT chưa được xử lý kịp thời | 🟡 Trung bình |
| Không áp dụng FEFO/FIFO | Nguy cơ hàng hết hạn, lãng phí | 🟡 Trung bình |
| Khó truy xuất nguồn gốc | Không đáp ứng được yêu cầu audit | 🟡 Trung bình |

### 1.3 Mục tiêu dự án

**Mục tiêu kinh doanh:**
- Giảm 80% thời gian xử lý phiếu xuất/nhập
- Giảm 50% sai sót trong kiểm đếm tồn kho
- Tăng 90% tuân thủ FEFO/FIFO
- Giảm 30% hàng tồn quá hạn

**Mục tiêu hệ thống:**
- Số hóa 100% quy trình quản lý kho
- Tích hợp realtime với module sản xuất
- Tự động cảnh báo tồn kho thấp
- Tạo báo cáo tự động theo yêu cầu

### 1.4 Phạm vi dự án

**Trong phạm vi (Phase 1):**
- ✅ Quản lý NVL & TP tồn kho
- ✅ Quy trình nhập/xuất kho
- ✅ Kiểm tra QC/QA
- ✅ Xử lý SPKPH (Sản phẩm không phù hợp)
- ✅ Báo cáo cơ bản

**Ngoài phạm vi:**
- ❌ Quản lý bán hàng (Phase 2)
- ❌ Tích hợp kế toán (Phase 2)
- ❌ Mobile app (Phase 3)
- ❌ Barcode/RFID scanning (Phase 3)

---

## 2. PHẠM VI NGHIỆP VỤ

### 2.1 Sơ đồ nghiệp vụ tổng quan

```
[Nhà cung cấp] ──> [NHẬP KHO NVL] ──> [KIỂM TRA QC]
                                           │
                                           ├─ ĐẠT ──> [KHO NVL]
                                           │              │
                                           └─ KHÔNG ĐẠT   │
                                              ↓           ↓
                                          [XỬ LÝ SPKPH] [YÊU CẦU VẬT TƯ]
                                                           │
                                                           ↓
                                                    [XUẤT CHO SẢN XUẤT]
                                                           │
                                                           ↓
                                                      [SẢN XUẤT]
                                                           │
                                                           ↓
                                                    [NHẬP KHO TP]
                                                           │
                                                           ↓
                                                      [KIỂM ĐẾM]
                                                           │
                                                           ├─ KHỚP ──> [KHO TP]
                                                           └─ SAI ──> [ĐIỀU TRA]
```

### 2.2 Các quy trình chính

#### 2.2.1 Quy trình 1: NHẬP KHO VÀ KIỂM TRA CHẤT LƯỢNG

| Bước | Actor | Hành động | Output | Thời gian SLA |
|------|-------|-----------|--------|---------------|
| 1 | Nhà cung cấp | Giao hàng + Phiếu giao hàng | Hàng hóa thực tế | - |
| 2 | Kho | Nhận hàng, đối chiếu PO | Phiếu tạm nhận | 15 phút |
| 3 | QC | Kiểm tra chất lượng | Biên bản QC | 2 giờ |
| 4a | QC | Nếu ĐẠT → Chuyển Kho | Phiếu nhập kho | 30 phút |
| 4b | QC | Nếu KHÔNG ĐẠT → Tạo SPKPH | Biên bản SPKPH | 1 giờ |
| 5 | Kho | Nhập hệ thống, xếp vào kệ | Cập nhật tồn kho | 30 phút |

**Điều kiện nghiệp vụ:**
- Hàng phải có PO (Purchase Order) được duyệt
- 100% lô hàng phải qua QC
- SPKPH phải được xử lý trong vòng 24h

#### 2.2.2 Quy trình 2: XUẤT KHO CHO SẢN XUẤT

| Bước | Actor | Hành động | Output | Thời gian SLA |
|------|-------|-----------|--------|---------------|
| 1 | Sản xuất | Tạo yêu cầu vật tư | Phiếu YC (Pending) | - |
| 2 | Quản đốc | Duyệt yêu cầu | Phiếu YC (Approved) | 30 phút |
| 3 | Kho | Soạn hàng theo FEFO | Hàng đã soạn | 1 giờ |
| 4 | Kho | Xuất phiếu, giao hàng | Phiếu xuất kho | 15 phút |
| 5 | Sản xuất | Nhận hàng, ký xác nhận | Xác nhận nhận hàng | 5 phút |
| 6 | Hệ thống | Tự động trừ tồn kho | Cập nhật tồn | Realtime |

**Quy tắc FEFO:**
- First Expired First Out (ưu tiên hàng gần hết hạn)
- Nếu nhiều lô cùng HSD → lấy theo FIFO
- Cảnh báo nếu xuất hàng có HSD < 30 ngày

#### 2.2.3 Quy trình 3: NHẬP THÀNH PHẨM TỪ SẢN XUẤT

| Bước | Actor | Hành động | Output | Thời gian SLA |
|------|-------|-----------|--------|---------------|
| 1 | Sản xuất | Hoàn thành sản xuất | Thành phẩm + Phiếu SX | - |
| 2 | Sản xuất | Giao TP cho Kho | Giao hàng thực tế | - |
| 3 | Kho + SX | Kiểm đếm tay ba | Biên bản kiểm đếm | 30 phút |
| 4a | Kho | Nếu KHỚP → Nhập kho | Phiếu nhập TP | 15 phút |
| 4b | Kho | Nếu SAI → Điều tra | Biên bản điều tra | 2 giờ |
| 5 | Kho | Xếp TP vào kho, gán vị trí | Cập nhật tồn TP | 30 phút |

---

## 3. PHÂN TÍCH STAKEHOLDER

### 3.1 Bảng stakeholder

| Vai trò | Trách nhiệm | Quyền hạn | Tần suất sử dụng |
|---------|-------------|-----------|------------------|
| **Quản lý Kho** | Giám sát toàn bộ hoạt động kho | Full access | Daily |
| **Nhân viên Kho** | Xử lý nhập/xuất, kiểm đếm | Create/Update phiếu | Daily |
| **QC/QA** | Kiểm tra chất lượng NVL/TP | Approve/Reject hàng | Daily |
| **Bộ phận Sản xuất** | Tạo yêu cầu vật tư | Create yêu cầu, View tồn kho | Daily |
| **Quản đốc SX** | Duyệt yêu cầu vật tư | Approve yêu cầu | Daily |
| **Mua hàng** | Xử lý SPKPH với NCC | View SPKPH, Contact NCC | Weekly |
| **Ban Giám đốc** | Xem báo cáo tổng hợp | View reports only | Weekly |

### 3.2 User Stories

**US-001: Quản lý tồn kho realtime**
```
As a: Quản lý Kho
I want to: Xem tồn kho realtime của tất cả NVL/TP
So that: Tôi có thể ra quyết định đặt hàng kịp thời
```

**US-002: Tạo yêu cầu vật tư**
```
As a: Nhân viên Sản xuất
I want to: Tạo phiếu yêu cầu vật tư với danh sách NVL cần thiết
So that: Kho có thể chuẩn bị hàng trước khi sản xuất
```

**US-003: Kiểm tra chất lượng**
```
As a: QC Inspector
I want to: Ghi nhận kết quả kiểm tra với ảnh chụp và ghi chú
So that: Có bằng chứng để xử lý nếu hàng không đạt
```

**US-004: Cảnh báo tồn kho**
```
As a: Quản lý Kho
I want to: Nhận thông báo tự động khi tồn kho < mức an toàn
So that: Tôi có thể yêu cầu mua hàng trước khi hết hàng
```

---

## 4. QUY TRÌNH NGHIỆP VỤ HIỆN TẠI

### 4.1 Quy trình AS-IS (Hiện tại)

**Nhập kho NVL:**
1. Nhận hàng từ NCC → Ghi tay vào sổ
2. QC kiểm tra → Viết biên bản giấy
3. Nếu ĐẠT → Nhập Excel, in phiếu nhập
4. Nếu KHÔNG ĐẠT → Gọi điện cho Mua hàng

**Xuất kho cho SX:**
1. Sản xuất gọi điện yêu cầu
2. Kho tìm hàng trong Excel
3. Lấy hàng, viết phiếu tay
4. Cuối ngày cập nhật Excel

**Vấn đề AS-IS:**
- ❌ Tồn kho không chính xác (lệch 10-15%)
- ❌ Mất 2-3 giờ để tìm hàng trong kho lớn
- ❌ Không biết hàng nào gần hết hạn
- ❌ Không có audit trail

### 4.2 Quy trình TO-BE (Mục tiêu)

**Nhập kho NVL:**
1. Scan mã vận đơn → Tự động tạo phiếu tạm nhận
2. QC scan mẫu → Điền form QC trên tablet
3. Hệ thống tự động:
    - Nếu ĐẠT → Tạo phiếu nhập, cập nhật tồn
    - Nếu KHÔNG ĐẠT → Tạo SPKPH, gửi email Mua hàng
4. In nhãn kệ với QR code, xếp vào vị trí

**Xuất kho cho SX:**
1. Sản xuất tạo YC trên hệ thống
2. Quản đốc duyệt online
3. Hệ thống gợi ý vị trí lấy hàng (FEFO)
4. Kho scan QR → Tự động trừ tồn
5. Sản xuất ký điện tử xác nhận

**Lợi ích TO-BE:**
- ✅ Tồn kho chính xác 99%
- ✅ Giảm 70% thời gian tìm hàng
- ✅ Tuân thủ FEFO 95%
- ✅ Full audit trail

---

## 5. YÊU CẦU NGHIỆP VỤ

### 5.1 Business Rules

**BR-001: Kiểm tra QC bắt buộc**
- Mọi lô hàng nhập từ NCC phải qua QC
- Không được nhập kho khi chưa có kết quả QC
- Exception: Hàng khẩn cấp (cần duyệt Giám đốc)

**BR-002: Quy tắc FEFO**
- Luôn xuất hàng có HSD gần nhất trước
- Cảnh báo nếu xuất hàng HSD < 30 ngày
- Không cho phép xuất hàng đã hết hạn

**BR-003: Tồn kho âm**
- Hệ thống không cho phép xuất kho khi số lượng tồn = 0
- Nếu cần xuất khẩn → tạo phiếu "Xuất tạm" (cần duyệt)

**BR-004: Quyền truy cập**
- Chỉ Quản lý Kho mới được xóa phiếu
- Phiếu đã hoàn thành không được sửa (chỉ được hủy)
- Mọi thao tác phải có audit log

**BR-005: Kiểm đếm tay ba**
- Nhập TP từ SX phải có 3 bên ký: Kho, SX, Giám sát
- Nếu lệch > 5% → Báo cáo ngay Quản lý
- Kiểm đếm định kỳ: tối thiểu 1 lần/tháng

### 5.2 Business Constraints

| Ràng buộc | Mô tả | Mức độ |
|-----------|-------|--------|
| **Thời gian** | Go-live trong Q1/2026 | Must have |
| **Ngân sách** | Tối đa 500 triệu VNĐ | Must have |
| **Nhân sự** | Đào tạo toàn bộ nhân viên (50 người) | Must have |
| **Tích hợp** | Tích hợp với hệ thống ERP hiện tại | Should have |
| **Dữ liệu cũ** | Migrate 3 năm dữ liệu Excel | Could have |

---

## 6. YÊU CẦU CHỨC NĂNG

### 6.1 Module 1: Quản lý Tồn kho

**FR-1.1: Danh sách NVL/TP**
- Hiển thị tất cả NVL/TP với thông tin:
    - Mã, Tên, Đơn vị tính
    - Số lượng tồn (realtime)
    - Vị trí kho (Shelf, Bin)
    - HSD gần nhất
    - Trạng thái (Bình thường / Sắp hết / Hết hàng)
- Tìm kiếm theo: Mã, Tên, Loại, NCC
- Lọc theo: Tồn kho thấp, Gần hết hạn, Hết hàng

**FR-1.2: Cảnh báo tồn kho**
- Tự động cảnh báo khi:
    - Số lượng tồn < Mức tồn kho tối thiểu
    - HSD < 30 ngày
    - Hàng đã hết hạn
- Gửi email/SMS cho Quản lý Kho và Mua hàng

**FR-1.3: Kiểm kê tồn kho**
- Tạo phiếu kiểm kê (định kỳ hoặc đột xuất)
- Nhập số lượng thực tế
- So sánh với số liệu hệ thống
- Xử lý chênh lệch (duyệt bởi Giám đốc)

### 6.2 Module 2: Nhập kho

**FR-2.1: Phiếu nhập NVL**
- Tạo phiếu nhập từ PO
- Nhập thông tin:
    - Nhà cung cấp
    - Danh sách NVL (Mã, Tên, SL, Giá, HSD)
    - Số xe/Container
    - Ghi chú
- Trạng thái:
    - CHỜ KIỂM TRA QC
    - ĐẠT - ĐÃ NHẬP KHO
    - KHÔNG ĐẠT - SPKPH
- In phiếu nhập (có chữ ký điện tử)

**FR-2.2: Phiếu nhập TP**
- Tạo phiếu nhập từ Sản xuất
- Liên kết với Lệnh sản xuất
- Kiểm đếm tay ba (3 chữ ký)
- Xử lý lệch số lượng
- Tự động cập nhật tồn kho TP

**FR-2.3: Lịch sử nhập kho**
- Xem tất cả phiếu nhập theo:
    - Ngày tạo
    - Loại (NVL/TP)
    - Trạng thái
    - Người tạo
- Export Excel

### 6.3 Module 3: Xuất kho

**FR-3.1: Phiếu xuất cho Sản xuất**
- Tạo phiếu xuất từ Yêu cầu vật tư
- Hệ thống gợi ý lấy hàng theo FEFO
- Cảnh báo nếu xuất hàng HSD < 30 ngày
- Ký xác nhận nhận hàng (Sản xuất)
- Tự động trừ tồn kho

**FR-3.2: Phiếu xuất khác**
- Xuất hủy (hàng hết hạn)
- Xuất điều chuyển (giữa các kho)
- Xuất trả NCC (SPKPH)
- Xuất mẫu (R&D)

**FR-3.3: Lịch sử xuất kho**
- Tương tự FR-2.3

### 6.4 Module 4: Yêu cầu vật tư

**FR-4.1: Tạo yêu cầu**
- Sản xuất tạo phiếu YC
- Chọn danh sách NVL từ BOM
- Điền số lượng cần
- Ngày cần hàng
- Submit → Chờ duyệt

**FR-4.2: Duyệt yêu cầu**
- Quản đốc xem danh sách YC chờ duyệt
- Kiểm tra tồn kho (đủ/không đủ)
- Approve/Reject
- Nếu Approve → Chuyển Kho soạn hàng

**FR-4.3: Soạn hàng**
- Kho xem danh sách YC đã duyệt
- Lấy hàng theo gợi ý FEFO
- Đóng gói, gắn nhãn
- Tạo phiếu xuất → Giao cho Sản xuất

### 6.5 Module 5: Kiểm tra QC

**FR-5.1: Queue kiểm tra**
- Hiển thị tất cả lô hàng CHỜ KIỂM TRA
- Sắp xếp theo: Ngày nhận, Mức độ ưu tiên
- QC chọn lô để kiểm tra

**FR-5.2: Form kiểm tra**
- Điền kết quả kiểm tra:
    - Ngoại quan (Pass/Fail)
    - Kích thước (đo lường)
    - Màu sắc (so màu chuẩn)
    - Nhiệt độ (nếu có)
- Upload ảnh (tối đa 5 ảnh)
- Kết luận: ĐẠT / KHÔNG ĐẠT
- Nếu ĐẠT → Tự động tạo phiếu nhập
- Nếu KHÔNG ĐẠT → Tạo SPKPH

**FR-5.3: Biên bản QC**
- In biên bản QC (PDF)
- Có chữ ký QC Inspector
- Lưu trữ trong hệ thống

### 6.6 Module 6: SPKPH

**FR-6.1: Danh sách SPKPH**
- Hiển thị tất cả hàng KHÔNG ĐẠT
- Trạng thái:
    - CHỜ XỬ LÝ
    - ĐANG LIÊN HỆ NCC
    - TRẢ HÀNG
    - NHẬN ĐỔI
    - GIẢM GIÁ - NHẬP KHO
- Phân công cho nhân viên Mua hàng

**FR-6.2: Xử lý SPKPH**
- Mua hàng cập nhật tiến độ
- Upload email/giấy tờ trao đổi NCC
- Chọn phương án xử lý:
    - Trả hàng hoàn toàn
    - Đổi hàng mới
    - Giảm giá x% → Nhập kho
- Hoàn tất → Đóng SPKPH

### 6.7 Module 7: Báo cáo

**FR-7.1: Báo cáo tồn kho**
- Tồn kho theo thời gian (chart)
- Tồn kho theo loại NVL/TP
- Giá trị tồn kho (VNĐ)
- Top 10 NVL/TP tồn nhiều nhất

**FR-7.2: Báo cáo xuất/nhập**
- Tổng xuất/nhập theo ngày/tuần/tháng
- Xuất/nhập theo loại
- Xuất/nhập theo bộ phận

**FR-7.3: Báo cáo QC**
- Tỷ lệ ĐẠT/KHÔNG ĐẠT theo NCC
- Tỷ lệ ĐẠT/KHÔNG ĐẠT theo loại NVL
- Xu hướng chất lượng theo thời gian

**FR-7.4: Báo cáo FEFO**
- Tuân thủ FEFO (% lần xuất đúng FEFO)
- Danh sách hàng gần hết hạn
- Danh sách hàng đã hết hạn (chưa xuất hủy)

---

## 7. YÊU CẦU PHI CHỨC NĂNG

### 7.1 Performance

| Chỉ số | Yêu cầu | Đo lường |
|--------|---------|----------|
| Response time | < 2 giây | 95% requests |
| Concurrent users | Hỗ trợ 50 users đồng thời | Peak time |
| Database size | Lưu trữ 5 năm dữ liệu | ~100GB |
| Uptime | 99.5% | Theo tháng |

### 7.2 Security

- **Authentication:** Username/Password + 2FA (optional)
- **Authorization:** Role-based access control (RBAC)
- **Audit Log:** Ghi nhận mọi thao tác Create/Update/Delete
- **Data encryption:** HTTPS, encrypt password
- **Backup:** Full backup hàng ngày, lưu trữ 30 ngày

### 7.3 Usability

- **Giao diện:** Đơn giản, dễ sử dụng (cho nhân viên kho 40-50 tuổi)
- **Ngôn ngữ:** Tiếng Việt (chính), Tiếng Anh (phụ)
- **Đào tạo:** Tài liệu hướng dẫn + Video tutorial
- **Responsive:** Hỗ trợ tablet (iPad) cho QC

### 7.4 Compatibility

- **Browser:** Chrome, Edge, Firefox (3 phiên bản mới nhất)
- **OS:** Windows 10+, macOS, Linux
- **Mobile:** iOS 14+, Android 10+ (future)
- **Integration:** API REST/JSON với ERP

---

## 8. THIẾT KẾ LOGIC MODULE

### 8.1 Data Model (ERD Core Entities)

```
[NhaCC] 1──M [PhieuNhapKho] M──1 [NVL_TP]
                │
                1
                │
                M
            [ChiTietNhap]


[YeuCauVatTu] 1──M [ChiTietYeuCau] M──1 [NVL_TP]
        │
        1
        │
        1
    [PhieuXuatKho] 1──M [ChiTietXuat]


[PhieuNhapKho] 1──1 [BienBanQC]
                        │
                        1
                        │
                        1
                    [SPKPH]
```

### 8.2 Key Entities

**NVL_TP (Nguyên vật liệu / Thành phẩm)**
- ID, MaNVL, TenNVL, LoaiNVL, DonViTinh
- SoLuongTon, GiaTriTon
- TonKhoToiThieu, TonKho