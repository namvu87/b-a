# 📱 THIẾT KẾ MÀN HÌNH - HỆ THỐNG QUẢN LÝ KHO ĐẠI LONG FOODS

## MỤC LỤC

1. [Dashboard & Tổng quan](#1-dashboard--tổng-quan)
2. [Quản lý Tồn kho](#2-quản-lý-tồn-kho)
3. [Phiếu Nhập kho](#3-phiếu-nhập-kho)
4. [Phiếu Xuất kho](#4-phiếu-xuất-kho)
5. [Yêu cầu Vật tư](#5-yêu-cầu-vật-tư)
6. [Kiểm tra QC](#6-kiểm-tra-qc)
7. [Kiểm kê](#7-kiểm-kê)
8. [Báo cáo](#8-báo-cáo)

---

## 1. DASHBOARD & TỔNG QUAN

### 1.1. Màn hình Dashboard chính

**Mô tả:** Trang tổng quan hiển thị KPI và hoạt động gần đây

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  🏭 ĐẠI LONG FOODS - Warehouse Management System           │
│  📅 14/10/2025  👤 Nguyễn Văn A (TO-KHO)  🔔 (3)          │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐     │
│  │📦 Tồn  │  │🔍 Chờ   │  │📤 Xuất  │  │⚠️ Cảnh  │     │
│  │  kho   │  │   QC    │  │  hôm nay│  │  báo    │     │
│  │ 1,248  │  │   15    │  │   45    │  │   12    │     │
│  │ +12%   │  │  8 mới  │  │  +18    │  │  cần đặt│     │
│  └─────────┘  └─────────┘  └─────────┘  └─────────┘     │
│                                                             │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐     │
│  │✅ Độ    │  │🚚 Tỷ lệ │  │📋 Tuân  │  │📉 Hàng  │     │
│  │  chính  │  │   OTIF  │  │  thủ    │  │  hư hỏng│     │
│  │  xác    │  │ 96.5%   │  │  FEFO   │  │ 0.25%   │     │
│  │ 99.2%   │  │  +2%    │  │ 98.1%   │  │  ✅     │     │
│  └─────────┘  └─────────┘  └─────────┘  └─────────┘     │
│                                                             │
│  📊 HOẠT ĐỘNG GẦN ĐÂY                                      │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ Số phiếu  │ Loại    │ Ngày    │ Người │ Trạng thái│   │
│  ├───────────┼─────────┼─────────┼───────┼───────────┤   │
│  │PN-2025-092│ Nhập NCC│14/10/25 │ Văn A │🟡 Chờ QC │   │
│  │PX-2025-523│ Xuất SX │14/10/25 │ Thị B │🟢 Hoàn TT│   │
│  │YCVT-156   │ Yêu cầu │13/10/25 │ Văn C │⏳ Xử lý  │   │
│  └─────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

**Components:**
- Header: Logo + Tiêu đề + User info + Notifications
- 8 KPI Cards (4 hàng trên + 4 hàng dưới)
- Table: Hoạt động gần đây (5-10 dòng)
- Buttons: [Làm mới] [Xuất báo cáo]

**Chức năng:**
- ✅ Hiển thị KPI realtime
- ✅ Click vào stat card → Chuyển đến màn hình chi tiết
- ✅ Click vào số phiếu trong bảng → Xem chi tiết phiếu
- ✅ Auto refresh mỗi 30s

---

## 2. QUẢN LÝ TỒN KHO

### 2.1. Màn hình Danh sách Hàng hóa

**Mô tả:** Quản lý tất cả mã hàng trong kho

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📦 Danh sách Hàng hóa                    [📤 Excel] [+Thêm]│
│  Quản lý Tồn kho / Danh sách hàng hóa                       │
├─────────────────────────────────────────────────────────────┤
│  🔍 [Tìm theo mã, tên, lot/batch...]                       │
│                                                              │
│  [Kho: Tất cả ▼] [Tất cả] [Sẵn sàng] [Tồn thấp] [Hết hàng]│
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │☐│Mã hàng    │Tên hàng  │Nhóm│Tồn│Chờ│Cách│Vị trí│⚙️│   │
│  ├──┼───────────┼──────────┼────┼───┼───┼────┼──────┼──┤   │
│  │☐│MAIN_gao01 │Gạo nếp   │NVL │1.2│ 0 │ 0  │D01-03│👁✎│   │
│  │ │           │hạt ngắn  │chính│k │   │    │-02   │  │   │
│  │ │           │          │    │🟢 │   │    │      │  │   │
│  ├──┼───────────┼──────────┼────┼───┼───┼────┼──────┼──┤   │
│  │☐│PKG1_bao500│Bao 500g  │Bao │5k │ 0 │ 0  │A01-02│👁✎│   │
│  │ │           │in logo   │bì  │   │   │    │-01   │  │   │
│  │ │           │          │    │🟡 │   │    │      │  │   │
│  ├──┼───────────┼──────────┼────┼───┼───┼────┼──────┼──┤   │
│  │☐│SPIC_gia01 │Hạt nêm   │Gia │ 0 │ 0 │ 0  │  -   │👁✎│   │
│  │ │           │1kg       │vị  │   │   │    │      │  │   │
│  │ │           │          │    │🔴 │   │    │      │  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  Hiển thị 1-10 của 1,248 mã hàng          [< 1 2 3 ... >]  │
└─────────────────────────────────────────────────────────────┘
```

**Components:**
- Search bar + Filter buttons
- Dropdown: Chọn kho
- Table với checkbox
- Status badges: 🟢 Sẵn sàng, 🟡 Tồn thấp, 🔴 Hết hàng
- Action buttons: 👁️ Xem, ✎ Sửa

**Chức năng:**
- ✅ Search realtime
- ✅ Filter theo kho, trạng thái
- ✅ Click mã hàng → Xem chi tiết
- ✅ Xuất Excel
- ✅ Thêm/Sửa hàng hóa

---

### 2.2. Màn hình Chi tiết Hàng hóa

**Mô tả:** Xem chi tiết 1 mã hàng (Tabs: Thông tin, Tồn kho, Lot/Batch, Lịch sử)

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📦 Chi tiết Hàng hóa: MAIN_gao01                    [X]    │
├─────────────────────────────────────────────────────────────┤
│  [Thông tin chung] [Tồn kho theo Kho] [Lot/Batch] [Lịch sử]│
│                                                              │
│  ════════════════ TAB: THÔNG TIN CHUNG ════════════════     │
│                                                              │
│  📷 [Ảnh sản phẩm]        Mã hàng:     MAIN_gao01          │
│                           Tên hàng:    Gạo nếp hạt ngắn     │
│                           Nhóm:        NVL chính            │
│                           ĐVT:         kg                   │
│                           Quy cách:    Bao 25kg             │
│                                                              │
│                           Min stock:   500 kg               │
│                           Max stock:   2,000 kg             │
│                           Reorder:     800 kg               │
│                           Lead time:   3 ngày               │
│                                                              │
│  ════════════════ TAB: TỒN KHO THEO KHO ════════════════    │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ Kho         │ Tồn khả dụng │ Chờ QC │ Cách ly │ Tổng│   │
│  ├─────────────┼──────────────┼────────┼─────────┼─────┤   │
│  │ ZN-WHRM-01  │   1,250 kg   │   0    │    0    │1,250│   │
│  │ ZN-WHDC-01  │     350 kg   │   0    │    0    │ 350 │   │
│  │ **TỔNG**    │ **1,600 kg** │ **0**  │  **0**  │**1.6│   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  ════════════════ TAB: TỒN KHO THEO LOT ════════════════    │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │Lot/Batch │ NSX      │ HSD      │ SL   │ Vị trí │ TT │   │
│  ├──────────┼──────────┼──────────┼──────┼────────┼────┤   │
│  │20251006  │06/10/2025│06/10/2026│500 kg│D01-03-2│🟢  │   │
│  │20251010  │10/10/2025│10/10/2026│750 kg│D01-04-1│🟢  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  ════════════════ TAB: LỊCH SỬ XUẤT NHẬP ══════════════     │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ Ngày  │Loại│Số phiếu │Lot│ SL  │Đơn giá│Người xử lý│   │
│  ├───────┼────┼─────────┼───┼─────┼───────┼───────────┤   │
│  │15/10  │Xuất│PX-1523  │'06│-50kg│18,000đ│ Văn A     │   │
│  │10/10  │Nhập│PN-0891  │'10│+750 │18,500đ│ Thị B     │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│                                    [Đóng] [Chỉnh sửa]       │
└─────────────────────────────────────────────────────────────┘
```

**Chức năng:**
- ✅ 4 tabs thông tin
- ✅ Hiển thị tồn kho theo kho, theo lot
- ✅ Lịch sử xuất nhập đầy đủ
- ✅ Biểu đồ xu hướng (nếu có)

---

## 3. PHIẾU NHẬP KHO

### 3.1. Màn hình Danh sách Phiếu Nhập

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📥 Danh sách Phiếu Nhập kho              [📤Excel] [+Tạo▼]│
│  Nhập kho / Danh sách phiếu nhập                            │
├─────────────────────────────────────────────────────────────┤
│  🔍 [Tìm theo số phiếu, NCC, người nhập...]                │
│  [Kho: Tất cả▼] [Tất cả] [Chờ QC] [Đã nhập] [Cách ly]     │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │☐│Số phiếu │Ngày│Loại│Kho│NCC/Nguồn│SL│Trạng thái│⚙️│   │
│  ├─┼─────────┼────┼────┼───┼─────────┼──┼──────────┼──┤   │
│  │☐│PN-2025- │14/1│Nhập│ZN-│NCC Đại  │500│🟡 CHỜ   │👁✎│   │
│  │ │0892     │0/25│NCC │WHR│Phát     │kg │KIỂM TRA  │  │   │
│  ├─┼─────────┼────┼────┼───┼─────────┼──┼──────────┼──┤   │
│  │☐│PN-2025- │13/1│Nhập│ZN-│Phòng SX │2k │🟢 ĐÃ    │👁 │   │
│  │ │0891     │0/25│TP  │WHF│         │gói│NHẬP KHO  │  │   │
│  ├─┼─────────┼────┼────┼───┼─────────┼──┼──────────┼──┤   │
│  │☐│PN-2025- │12/1│Nhập│ZN-│NCC Bao  │10k│🔴 CÁCH  │👁✎│   │
│  │ │0890     │0/25│NCC │WHS│bì VN    │cái│LY        │  │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

**Dropdown [+Tạo▼]:**
```
┌────────────────────┐
│ 📥 Nhập từ NCC    │
│ 🏭 Nhập TP từ SX  │
│ 📦 Nhập khác      │
└────────────────────┘
```

---

### 3.2. Modal: Tạo Phiếu Nhập từ NCC

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📥 Tạo Phiếu Nhập kho từ NCC                         [X]   │
├─────────────────────────────────────────────────────────────┤
│  ═══════════════ THÔNG TIN CHUNG ═══════════════            │
│                                                              │
│  📌 Lưu ý: Hàng nhập từ NCC sẽ tự động chuyển vào trạng     │
│     thái "CHỜ KIỂM TRA" và thông báo cho TO-QAC.           │
│                                                              │
│  Loại nhập: *      [Nhập từ NCC ▼]                         │
│  Ngày nhập: *      [14/10/2025 📅]                          │
│                                                              │
│  Kho nhận: *       [ZN-WHRM-01 - Kho NVL ▼]                │
│  Nhà cung cấp: *   [NCC Đại Phát ▼] [+]                    │
│                                                              │
│  Số PO:            [________________]                        │
│  Người nhập: *     [Nguyễn Văn A (TO-KHO)] (disabled)      │
│                                                              │
│  Ghi chú:          [________________________]               │
│                    [________________________]               │
│                                                              │
│  ═══════════════ CHI TIẾT HÀNG HÓA ═══════════════          │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │STT│Mã hàng │Tên│Lot* │NSX │HSD │SL│ĐVT│Vị trí│⚙️  │   │
│  ├───┼────────┼───┼─────┼────┼────┼──┼───┼──────┼────┤   │
│  │ 1 │[Chọn▼] │...│[___]│[__]│[__]│[]│kg │[Chọn]│ ×  │   │
│  │ 2 │[Chọn▼] │...│[___]│[__]│[__]│[]│kg │[Chọn]│ ×  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  + Thêm dòng                                                │
│                                                              │
│                         [Hủy] [Lưu & thêm mới] [Lưu phiếu] │
└─────────────────────────────────────────────────────────────┘
```

**Flow:**
1. User chọn Kho nhận, NCC
2. User thêm dòng hàng hóa
3. User chọn Mã hàng → Tên tự động điền
4. User nhập **Lot/Batch** (BẮT BUỘC)
5. User nhập NSX, HSD
6. User nhập Số lượng, chọn Vị trí
7. Click [Lưu phiếu]
8. ✅ Hệ thống tạo phiếu với trạng thái **"CHỜ KIỂM TRA"**
9. ✅ Hệ thống gửi thông báo cho TO-QAC
10. ✅ Hệ thống in nhãn VÀNG

---

### 3.3. Modal: Tạo Phiếu Nhập TP từ Sản xuất

**Đặc thù:**
- Nguồn: PH-SXU (Phòng Sản xuất)
- Có Biên bản Bàn giao (TAY BA)
- Không cần QC (vì đã QC ở công đoạn cuối)
- Trạng thái: Trực tiếp **"ĐÃ NHẬP KHO"**

**Layout tương tự 3.2, nhưng:**
- Loại nhập: [Nhập TP từ Sản xuất]
- Nguồn: [PH-SXU - Phòng Sản xuất]
- Biên bản bàn giao: [BBGN-2025-xxx]
- Không có trường NCC

---

## 4. PHIẾU XUẤT KHO

### 4.1. Màn hình Danh sách Phiếu Xuất

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📤 Danh sách Phiếu Xuất kho              [📤Excel] [+Tạo▼]│
│  Xuất kho / Danh sách phiếu xuất                            │
├─────────────────────────────────────────────────────────────┤
│  🔍 [Tìm theo số phiếu, nơi nhận, người xuất...]           │
│  [Tất cả] [Đang xử lý] [Đã xuất] [Đã hủy]                 │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │☐│Số phiếu │Ngày│Loại│Kho│Nơi nhận│SL│Trạng thái│⚙️│   │
│  ├─┼─────────┼────┼────┼───┼────────┼──┼──────────┼──┤   │
│  │☐│PX-2025- │14/1│Xuất│ZN-│PH-SXU  │150│🟢 ĐÃ    │👁 │   │
│  │ │1523     │0/25│NVL │WHR│        │kg │XUẤT      │  │   │
│  ├─┼─────────┼────┼────┼───┼────────┼──┼──────────┼──┤   │
│  │☐│PX-2025- │14/1│Xuất│ZN-│NPP Hà  │5k │⏳ ĐANG  │👁✎│   │
│  │ │1522     │0/25│TP  │WHD│Nội     │gói│XỬ LÝ    │  │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

**Dropdown [+Tạo▼]:**
```
┌─────────────────────┐
│ 🏭 Xuất NVL cho SX │
│ 🛒 Xuất TP bán hàng│
│ 🚚 Xuất chuyển kho │
└─────────────────────┘
```

---

### 4.2. Modal: Xuất NVL cho Sản xuất (FEFO)

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📤 Tạo Phiếu Xuất NVL cho Sản xuất                   [X]   │
├─────────────────────────────────────────────────────────────┤
│  ═══════════════ THÔNG TIN CHUNG ═══════════════            │
│                                                              │
│  📌 Nguyên tắc FEFO: Hệ thống sẽ tự động đề xuất lot/batch │
│     có HSD gần nhất để xuất trước.                          │
│                                                              │
│  Loại xuất: *      [Xuất NVL cho Sản xuất ▼]               │
│  Ngày xuất: *      [14/10/2025 📅]                          │
│                                                              │
│  Kho xuất: *       [ZN-WHRM-01 - Kho NVL ▼]                │
│  Nơi nhận: *       [PH-SXU - Phòng Sản xuất ▼]             │
│                                                              │
│  Liên kết YCVT:    [YCVT-2025-0156]                        │
│  Người xuất: *     [Nguyễn Văn A (TO-KHO)] (disabled)      │
│                                                              │
│  ═══════════════ CHI TIẾT XUẤT KHO (FEFO) ═══════════════   │
│                                                              │
│  Chọn mã hàng: *   [MAIN_gao01 - Gạo nếp hạt ngắn ▼]      │
│  SL cần xuất: *    [50] kg                                  │
│                                                              │
│  🎯 HỆ THỐNG ĐỀ XUẤT THEO FEFO:                            │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ Lot 1: 20251006 - HSD: 06/10/2026 - Tồn: 500 kg     │   │
│  │        Vị trí: ZN-WHRM-01-D01-03-02                  │   │
│  │ Lot 2: 20251010 - HSD: 10/10/2026 - Tồn: 750 kg     │   │
│  │        Vị trí: ZN-WHRM-01-D01-04-01                  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  ✅ Chi tiết xuất (Đã áp dụng FEFO):                        │
│  ┌──────────────────────────────────────────────────────┐   │
│  │STT│Mã hàng    │Lot   │HSD  │SL xuất│ĐVT│Vị trí│Người│   │
│  │   │           │      │     │       │   │      │nhận │   │
│  ├───┼───────────┼──────┼─────┼───────┼───┼──────┼─────┤   │
│  │ 1 │MAIN_gao01 │'06   │06/10│ 50    │kg │D01-03│[Chọn]│  │
│  │   │           │      │/2026│       │   │-02   │     │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  📝 Ghi chú: Cấp phát theo YCVT-2025-0156                   │
│                                                              │
│                                      [Hủy] [Tạo phiếu xuất] │
└─────────────────────────────────────────────────────────────┘
```

**Flow FEFO:**
1. User chọn Mã hàng
2. User nhập Số lượng cần xuất (VD: 50 kg)
3. ✅ Hệ thống tự động:
   - Query tất cả lot của mã hàng đó
   - Sort theo HSD tăng dần (FEFO)
   - Hiển thị danh sách đề xuất
4. User xác nhận hoặc điều chỉnh
5. Nếu User chọn lot khác → Ghi log "Không tuân thủ FEFO"
6. User chọn Người nhận (từ PH-SXU)
7. Click [Tạo phiếu xuất]
8. ✅ Kiểm đếm TAY BA tại kho
9. ✅ Cập nhật tồn kho

---

## 5. YÊU CẦU VẬT TƯ (YCVT)

### 5.1. Màn hình Danh sách YCVT

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📋 Danh sách Yêu cầu Vật tư                   [+Tạo YCVT]  │
│  Yêu cầu Vật tư / Danh sách YCVT                            │
├─────────────────────────────────────────────────────────────┤
│  🔍 [Tìm theo số YCVT, người yêu cầu...]                   │
│  [Tất cả] [Chờ duyệt] [Đang xử lý] [Hoàn thành] [Từ chối] │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │Số YCVT  │Ngày│Người YC│Bộ phận│SL mã│Trạng thái│⚙️│   │
│  ├─────────┼────┼────────┼───────┼─────┼──────────┼──┤   │
│  │YCVT-156 │13/1│Lê Văn C│PH-SXU │  5  │⏳ ĐANG  │👁✎│   │
│  │         │0/25│        │       │     │XỬ LÝ    │  │   │
│  ├─────────┼────┼────────┼───────┼─────┼──────────┼──┤   │
│  │YCVT-155 │12/1│Trần T B│PH-SXU │  3  │🟢 HOÀN  │👁 │   │
│  │         │0/25│        │       │     │THÀNH     │  │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

---

### 5.2. Modal: Tạo YCVT mới

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📋 Tạo Yêu cầu Vật tư mới                            [X]   │
├─────────────────────────────────────────────────────────────┤
│  Số YCVT:          [YCVT-2025-0157] (auto)                  │
│  Ngày yêu cầu: *   [14/10/2025 📅]                          │
│                                                              │
│  Người yêu cầu: *  [Lê Văn C (PH-SXU)] (current user)      │
│  Bộ phận: *        [PH-SXU - Phòng Sản xuất ▼]             │
│                                                              │
│  Ngày cần: *       [16/10/2025 📅]                          │
│  Độ ưu tiên:       [⭐ Bình thường ▼]                       │
│                                                              │
│  ═══════════════ DANH SÁCH VẬT TƯ YÊU CẦU ═══════════════   │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ STT │ Mã hàng      │ Tên hàng   │ SL cần │ ĐVT │ ⚙️│   │
│  ├─────┼──────────────┼────────────┼────────┼─────┼───┤   │
│  │  1  │ [Chọn mã ▼] │ ...        │ [____] │ kg  │ × │   │
│  │  2  │ [Chọn mã ▼] │ ...        │ [____] │ cái │ × │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  + Thêm dòng                                                │
│                                                              │
│  Lý do yêu cầu:    [________________________]               │
│                    [Sản xuất lô bánh gạo mới]               │
│                                                              │
│                                      [Hủy] [Gửi yêu cầu]    │
└─────────────────────────────────────────────────────────────┘
```

**Flow:**
1. User (PH-SXU) tạo YCVT
2. Chọn các mã hàng + số lượng cần
3. Gửi yêu cầu
4. ✅ TO-KHO nhận thông báo
5. TO-KHO kiểm tra tồn kho:
   - Nếu **ĐỦ** → Soạn hàng FEFO → Tạo phiếu xuất
   - Nếu **THIẾU** → Phản hồi thiếu hàng → PH-SXU điều chỉnh

---

## 6. KIỂM TRA QC

### 6.1. Màn hình Queue Kiểm tra QC

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  🔍 Queue Kiểm tra QC                         🔔 Thông báo(3)│
│  Kiểm tra QC / Queue kiểm tra                               │
├─────────────────────────────────────────────────────────────┤
│  📌 Quy trình QC: Hàng từ NCC → Dán nhãn VÀNG "CHỜ KIỂM    │
│     TRA" → Lấy mẫu kiểm tra → ĐẠT: Nhập kho | KHÔNG ĐẠT:   │
│     Cách ly & SPKPH                                          │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │Số phiếu│Ngày│Mã hàng   │Tên hàng│Lot  │SL │Ưu tiên│⚙️│   │
│  ├────────┼────┼──────────┼────────┼─────┼───┼───────┼──┤   │
│  │PN-0892 │14/1│MAIN_gao01│Gạo nếp │'1014│500│🔥 CAO │[KT]│  │
│  │        │0/25│          │hạt ngắn│     │kg │       │  │   │
│  ├────────┼────┼──────────┼────────┼─────┼───┼───────┼──┤   │
│  │PN-0889 │13/1│SPIC_gia02│Muối    │'1013│100│BÌNH   │[KT]│  │
│  │        │0/25│          │tinh    │     │kg │THƯỜNG │  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  [KT] = [Kiểm tra] button                                   │
└─────────────────────────────────────────────────────────────┘
```

**Chức năng:**
- ✅ Hiển thị tất cả phiếu nhập có trạng thái "CHỜ KIỂM TRA"
- ✅ Sắp xếp theo độ ưu tiên (CAO → BÌNH THƯỜNG)
- ✅ Click [Kiểm tra] → Mở Modal Form QC

---

### 6.2. Modal: Form Kiểm tra QC

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  🔍 Form Kiểm tra Chất lượng (QC)                     [X]   │
├─────────────────────────────────────────────────────────────┤
│  ═══════════════ THÔNG TIN PHIẾU NHẬP ═══════════════       │
│                                                              │
│  ┌────────────┬────────────┬────────────┬────────────┐      │
│  │ Số phiếu:  │ Mã hàng:   │ Lot/Batch: │ Số lượng:  │      │
│  │ PN-2025-892│ MAIN_gao01 │ 20251014   │ 500 kg     │      │
│  └────────────┴────────────┴────────────┴────────────┘      │
│                                                              │
│  NCC: NCC Đại Phát                                          │
│                                                              │
│  ═══════════════ TIÊU CHÍ KIỂM TRA ═══════════════          │
│                                                              │
│  Người kiểm tra: * [Phạm Thị D (TO-QAC)] (disabled)        │
│  Ngày giờ: *       [14/10/2025 10:30 🕐]                    │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │STT│Tiêu chí │Tiêu chuẩn│Thực tế│Kết quả│Ghi chú    │   │
│  ├───┼─────────┼──────────┼───────┼───────┼───────────┤   │
│  │ 1 │Độ ẩm    │≤ 14%     │[____] │[Chọn▼]│[_______]  │   │
│  │ 2 │Màu sắc  │Trắng ngà │[____] │[Chọn▼]│[_______]  │   │
│  │ 3 │Mùi vị   │Không mùi │[____] │[Chọn▼]│[_______]  │   │
│  │ 4 │Tạp chất │≤ 0.1%    │[____] │[Chọn▼]│[_______]  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  Dropdown [Chọn▼]: ✅ ĐẠT | ❌ KHÔNG ĐẠT                   │
│                                                              │
│  ═══════════════ KẾT LUẬN ═══════════════                   │
│                                                              │
│  Kết quả tổng thể: * [-- Chọn kết quả -- ▼]                │
│                      ✅ ĐẠT - Cho phép nhập kho             │
│                      ❌ KHÔNG ĐẠT - Cách ly & lập SPKPH     │
│                                                              │
│  Nhận xét chung:     [_____________________________]        │
│                      [_____________________________]        │
│                                                              │
│                                      [Hủy] [Lưu kết quả QC] │
└─────────────────────────────────────────────────────────────┘
```

**Flow:**
1. TO-QAC click [Kiểm tra] từ Queue
2. Điền từng tiêu chí: Thực tế, Kết quả (ĐẠT/KHÔNG ĐẠT)
3. Chọn Kết quả tổng thể:
   - **✅ ĐẠT:**
     - Hệ thống cập nhật trạng thái phiếu → "ĐÃ NHẬP KHO"
     - Hàng chuyển từ "Chờ QC" → "Tồn khả dụng"
     - Thông báo BP-MUH → Đề xuất thanh toán
   - **❌ KHÔNG ĐẠT:**
     - Hệ thống cập nhật trạng thái → "CÁCH LY"
     - Hàng chuyển vào "Cách ly"
     - Tự động tạo SPKPH
     - Thông báo BP-MUH & TO-KHO

---

### 6.3. Màn hình SPKPH (Sản phẩm Không Phù Hợp)

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  ⚠️ Danh sách SPKPH                            [+Tạo SPKPH] │
│  Kiểm tra QC / SPKPH                                        │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────────────────────────────────────────────┐   │
│  │Số SPKPH│Ngày│Phiếu nhập│Mã hàng│Lot│Lỗi│Xử lý│⚙️    │   │
│  ├────────┼────┼──────────┼───────┼───┼───┼─────┼──────┤   │
│  │SPKPH-03│13/1│PN-0890   │SPIC_  │'13│Mùi│Đang │👁✎🗑│   │
│  │        │0/25│          │gia02  │   │lạ │thương│     │   │
│  │        │    │          │       │   │   │lượng│     │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

**Xử lý SPKPH:**
- Trả hàng
- Đổi hàng
- Giảm giá
- Sử dụng nội bộ (hạ cấp)

---

## 7. KIỂM KÊ

### 7.1. Màn hình Tạo Kế hoạch Kiểm kê

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📊 Tạo Kế hoạch Kiểm kê mới                          [X]   │
├─────────────────────────────────────────────────────────────┤
│  Loại kiểm kê: *   [⚪ Định kỳ  ⚪ Tuần hoàn  ⚪ Đột xuất] │
│                                                              │
│  Tên kế hoạch: *   [Kiểm kê Quý 4/2025]                    │
│  Mã kế hoạch:      [KK-2025-Q4] (auto)                     │
│                                                              │
│  Ngày bắt đầu: *   [20/10/2025 📅]                          │
│  Ngày kết thúc: *  [25/10/2025 📅]                          │
│                                                              │
│  ═══════════════ PHẠM VI KIỂM KÊ ═══════════════            │
│                                                              │
│  Kho kiểm kê: *    [☑ ZN-WHRM-01 - Kho NVL]                │
│                    [☐ ZN-WHSP-01 - Kho Vật tư]              │
│                    [☐ ZN-WHFG-01 - Kho TP]                  │
│                                                              │
│  Nhóm hàng:        [☑ NVL chính]                            │
│                    [☑ Gia vị]                               │
│                    [☐ Bao bì]                               │
│                                                              │
│  ═══════════════ PHÂN CÔNG ═══════════════                  │
│                                                              │
│  Trưởng đoàn: *    [Nguyễn Văn A (TO-KHO) ▼]               │
│                                                              │
│  Thành viên:       [☑ Trần Thị B (TO-KHO)]                 │
│                    [☑ Lê Văn C (TO-KHO)]                    │
│                    [☑ Phạm Thị D (TO-QAC)]                  │
│                                                              │
│  Ghi chú:          [________________________]               │
│                                                              │
│                                      [Hủy] [Tạo kế hoạch]   │
└─────────────────────────────────────────────────────────────┘
```

---

### 7.2. Mobile App: Thực hiện Kiểm kê

**Layout (Mobile Screen):**
```
┌─────────────────────────┐
│  📱 KIỂM KÊ KHO        │
│  KK-2025-Q4             │
├─────────────────────────┤
│                         │
│  Kho: ZN-WHRM-01       │
│  Tiến độ: 45/120 mã    │
│  [████████░░] 37%      │
│                         │
│  ────────────────────   │
│  Quét mã Vị trí:       │
│  [📷 Quét QR Code]     │
│                         │
│  Vị trí: D01-03-02     │
│                         │
│  Quét mã Hàng hóa:     │
│  [📷 Quét Barcode]     │
│                         │
│  Mã: MAIN_gao01        │
│  Tên: Gạo nếp hạt ngắn │
│  Lot: 20251006         │
│                         │
│  SL Hệ thống: 500 kg   │
│  SL Thực tế:  [____] kg│
│                         │
│  [Xác nhận] [Bỏ qua]  │
│                         │
└─────────────────────────┘
```

**Flow:**
1. User chọn Kế hoạch kiểm kê
2. Quét QR Code vị trí
3. Quét Barcode hàng hóa
4. Hệ thống hiển thị SL hệ thống
5. User nhập SL thực tế
6. Click [Xác nhận]
7. Hệ thống so sánh:
   - Khớp → Tiếp tục
   - Sai lệch → Đánh dấu "Cần đối chiếu"

---

### 7.3. Màn hình Đối chiếu & Xử lý Sai lệch

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📊 Đối chiếu Kiểm kê: KK-2025-Q4                           │
├─────────────────────────────────────────────────────────────┤
│  Tổng số mã kiểm: 120     Khớp: 112 (93%)   Lệch: 8 (7%)   │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │Mã hàng│Lot │Vị trí│SL hệ │SL thực│Chênh│% │Xử lý│⚙️│   │
│  │       │    │      │thống │tế     │lệch │  │     │  │   │
│  ├───────┼────┼──────┼──────┼───────┼─────┼──┼─────┼──┤   │
│  │MAIN_  │'06 │D01-  │500 kg│498 kg │-2 kg│-0│🔍   │✎ │   │
│  │gao01  │    │03-02 │      │       │     │.4│Điều │  │   │
│  │       │    │      │      │       │     │% │tra  │  │   │
│  ├───────┼────┼──────┼──────┼───────┼─────┼──┼─────┼──┤   │
│  │PKG1_  │'12 │A01-  │5,000 │4,950  │-50  │-1│🔍   │✎ │   │
│  │bao500 │    │02-01 │cái   │cái    │cái  │% │Điều │  │   │
│  │       │    │      │      │       │     │  │tra  │  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  Xử lý sai lệch:                                            │
│  ⚪ Chấp nhận sai lệch (điều chỉnh hệ thống)               │
│  ⚪ Kiểm kê lại                                             │
│  ⚪ Lập biên bản mất mát/hư hỏng                            │
│                                                              │
│                              [Hủy] [Xác nhận xử lý]         │
└─────────────────────────────────────────────────────────────┘
```

---

## 8. BÁO CÁO

### 8.1. Báo cáo Xuất Nhập Tồn

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📊 Báo cáo Xuất Nhập Tồn                      [📤 Excel]   │
├─────────────────────────────────────────────────────────────┤
│  Từ ngày: [01/10/2025 📅]   Đến ngày: [14/10/2025 📅]      │
│  Kho:     [ZN-WHRM-01 ▼]    Nhóm hàng: [Tất cả ▼]         │
│                                            [Xem báo cáo]     │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐   │
│  │Mã hàng│Tên   │ĐVT│Tồn đầu│Nhập│Xuất│Tồn cuối│Giá trị│   │
│  ├───────┼──────┼───┼───────┼────┼────┼────────┼───────┤   │
│  │MAIN_  │Gạo   │kg │ 1,200 │500 │450 │ 1,250  │22.5tr │   │
│  │gao01  │nếp   │   │       │    │    │        │       │   │
│  ├───────┼──────┼───┼───────┼────┼────┼────────┼───────┤   │
│  │SPIC_  │Hạt   │kg │   150 │100 │120 │   130  │3.9tr  │   │
│  │gia01  │nêm   │   │       │    │    │        │       │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  📊 Biểu đồ cột: Xuất Nhập theo ngày                        │
└─────────────────────────────────────────────────────────────┘
```

---

### 8.2. Báo cáo Tuân thủ FEFO

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📋 Báo cáo Tuân thủ FEFO                      [📤 Excel]   │
├─────────────────────────────────────────────────────────────┤
│  Tháng: [10/2025 ▼]                                         │
│                                                              │
│  📊 KPI:                                                     │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ Tỷ lệ tuân thủ FEFO:  98.1%        🎯 Target: ≥ 98%  │   │
│  │ Tổng số lần xuất:     245 lần                        │   │
│  │ Tuân thủ FEFO:        240 lần                        │   │
│  │ Không tuân thủ:       5 lần                          │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                              │
│  📋 Chi tiết các lần KHÔNG TUÂN THỦ:                        │
│  ┌──────────────────────────────────────────────────────┐   │
│  │Ngày│Phiếu  │Mã hàng│Lot xuất│Lot đúng│Lý do      │   │   │
│  ├────┼───────┼───────┼────────┼────────┼───────────┼───┤   │
│  │12/1│PX-1520│MAIN_  │'1010   │'1006   │KH yêu cầu │👁 │   │
│  │0   │       │gao01  │        │        │lot cụ thể │   │   │
│  └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

---

### 8.3. Báo cáo Hiệu suất Kho

**Layout:**
```
┌─────────────────────────────────────────────────────────────┐
│  📈 Báo cáo Hiệu suất Kho                      [📤 Excel]   │
├─────────────────────────────────────────────────────────────┤
│  Tháng: [10/2025 ▼]   Kho: [ZN-WHRM-01 ▼]                 │
│                                                              │
│  ═══════════════ NHÓM 1: ĐỘ CHÍNH XÁC ═══════════════      │
│                                                              │
│  ┌─────────────────┬────────┬────────┬───────────────┐      │
│  │ KPI             │ Giá trị│ Target │ Trạng thái    │      │
│  ├─────────────────┼────────┼────────┼───────────────┤      │
│  │ Độ chính xác TK │ 99.2%  │≥99.5%  │⚠️ Cần cải thiện│     │
│  │ Tỷ lệ OTIF      │ 96.5%  │≥ 95%   │✅ Đạt         │      │
│  │ Tuân thủ FEFO   │ 98.1%  │≥ 98%   │✅ Đạt         │      │
│  │ Hàng hư hỏng    │ 0.25%  │≤ 0.3%  │✅ Đạt         │      │
│  └─────────────────┴────────┴────────┴───────────────┘      │
│                                                              │
│  ═══════════════ NHÓM 2: THỜI GIAN XỬ LÝ ═══════════════    │
│                                                              │
│  ┌─────────────────┬────────┬────────┬───────────────┐      │
│  │ KPI             │ Giá trị│ Target │ Trạng thái    │      │
│  ├─────────────────┼────────┼────────┼───────────────┤      │
│  │ Thời gian nhập  │ 25 phút│≤30 phút│✅ Đạt         │      │
│  │ Thời gian xuất  │ 55 phút│≤60 phút│✅ Đạt         │      │
│  └─────────────────┴────────┴────────┴───────────────┘      │
│                                                              │
│  📊 Biểu đồ xu hướng theo tuần                              │
└─────────────────────────────────────────────────────────────┘
```

---

## PHỤ LỤC

### A. Màu sắc & Icon

**Màu chủ đạo:**
- Primary: #a32718 (Đỏ Đại Long Foods)
- Secondary: #ecc67d (Vàng gold)
- Success: #27ae60 (Xanh lá)
- Warning: #f39c12 (Cam)
- Danger: #dc3545 (Đỏ cảnh báo)
- Info: #2196F3 (Xanh dương)

**Status Badges:**
- 🟢 Sẵn sàng / Đạt / Hoàn thành
- 🟡 Chờ kiểm tra / Tồn thấp / Đang xử lý
- 🔴 Hết hàng / Không đạt / Cách ly
- ⏳ Đang xử lý
- ⚠️ Cảnh báo

**Icons:**
- 📦 Tồn kho, Hàng hóa
- 📥 Nhập kho
- 📤 Xuất kho
- 📋 Yêu cầu, Danh sách
- 🔍 Kiểm tra QC
- 📊 Kiểm kê, Báo cáo
- 🏭 Sản xuất
- 🚚 Vận chuyển
- ✅ Đạt, Xác nhận
- ❌ Không đạt
- 👁️ Xem
- ✎ Sửa
- 🗑️ Xóa

---

### B. Responsive Design

**Desktop (≥ 1200px):**
- Sidebar 260px
- Main content full width
- Table full columns

**Tablet (768px - 1199px):**
- Sidebar 220px
- Table scroll horizontal
- Form 2 columns → 1 column

**Mobile (< 768px):**
- Sidebar collapse → Hamburger menu
- Card view thay vì table
- Form 1 column

---

### C. Quy tắc Validation

**Bắt buộc (*) cho:**
- Loại nhập/xuất
- Ngày nhập/xuất
- Kho nhận/xuất
- Nhà cung cấp (với nhập từ NCC)
- Lot/Batch (với hàng có HSD)
- Số lượng

**Format:**
- Ngày: dd/mm/yyyy
- Lot/Batch: yyyyMMdd hoặc tùy chỉnh
- Số lượng: Number, min = 0

---

**🎯 TỔNG KẾT:**
- **Tổng số màn hình:** 25+ màn hình
- **Module chính:** 8 modules
- **Workflows:** 6 quy trình nghiệp vụ
- **Components:** 30+ components

File này sẵn sàng để:
✅ Làm tài liệu thiết kế cho team
✅ Import vào Figma/Adobe XD
✅ Làm base cho development
✅ Review với stakeholders
