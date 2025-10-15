# 📋 BUSINESS ANALYSIS - HỆ THỐNG QUẢN LÝ KHO
## ĐẠI LONG FOODS

---

## 1. TỔNG QUAN DỰ ÁN

### 1.1. Thông tin dự án
- **Tên dự án**: Hệ thống Quản lý Kho (Warehouse Management System)
- **Đơn vị**: Đại Long Foods
- **Phạm vi**: Quản lý toàn bộ hệ thống kho từ nguyên vật liệu đến thành phẩm
- **Ngày lập**: 14/10/2025

### 1.2. Mục tiêu dự án
- ✅ Số hóa quy trình quản lý kho hiện tại
- ✅ Tự động hóa luồng nhập/xuất/kiểm kê
- ✅ Truy xuất nguồn gốc theo lot/batch
- ✅ Áp dụng nguyên tắc FIFO/FEFO
- ✅ Tích hợp với sản xuất và phân phối
- ✅ Báo cáo và phân tích dữ liệu realtime

---

## 2. PHÂN TÍCH HỆ THỐNG KHO HIỆN TẠI

### 2.1. Sơ đồ hệ thống kho (8 kho)

```
┌─────────────────────────────────────────────┐
│        HỆ THỐNG KHO ĐẠI LONG FOODS          │
├─────────────────────────────────────────────┤
│                                             │
│  📥 NHÓM KHO ĐẦU VÀO                        │
│  ├─ 1. Kho Nguyên vật liệu (ZN-WHRM-01)    │
│  └─ 2. Kho Vật tư & Phụ tùng (ZN-WHSP-01)  │
│                                             │
│  ⚙️ NHÓM KHO NỘI BỘ SẢN XUẤT               │
│  ├─ 3. Kho Bán thành phẩm (ZN-WHSF-01)     │
│  └─ 4. Kho Thành phẩm Nhà máy (ZN-WHFG-01) │
│                                             │
│  🚚 NHÓM KHO PHÂN PHỐI & BÁN LẺNH          │
│  ├─ 5. Trung tâm Phân phối (ZN-WHDC-01)    │
│  ├─ 6. Kho Showroom (ZN-WHSR-01)           │
│  ├─ 7. Kho Vùng (Đề xuất)                  │
│  └─ 8. Kho TMĐT (Đề xuất)                  │
│                                             │
└─────────────────────────────────────────────┘
```

### 2.2. Đặc điểm từng kho

#### **1. Kho Nguyên vật liệu (ZN-WHRM-01)**
- **Chức năng**: Lưu trữ nguyên liệu chính (gạo, thịt, gia vị)
- **Đặc thù**: Cần kiểm soát hạn sử dụng, nhiệt độ, độ ẩm
- **Luồng**: Nhà cung cấp → Kiểm tra QC → Nhập kho → Cấp phát SX
- **Nguyên tắc**: FEFO (First-Expired, First-Out)

#### **2. Kho Vật tư & Phụ tùng (ZN-WHSP-01)**
- **Chức năng**: Bao bì, nhãn mác, phụ tùng thay thế
- **Đặc thù**: Hàng không có HSD, quản lý theo FIFO
- **Luồng**: Nhà cung cấp → Nhập kho → Cấp phát SX/Bảo trì

#### **3. Kho Bán thành phẩm (ZN-WHSF-01)**
- **Chức năng**: Lưu sản phẩm giữa 2 công đoạn (bánh thô đã sấy)
- **Đặc thù**: Thời gian lưu ngắn (< 8 giờ), kiểm soát nhiệt độ
- **Luồng**: Chuyền 1 (Nấu-Sấy) → Kho BTP → Chuyền 2 (Chiên-Đóng gói)

#### **4. Kho Thành phẩm Nhà máy (ZN-WHFG-01)**
- **Chức năng**: Sản phẩm hoàn thiện, chờ xuất kho
- **Đặc thù**: Kiểm định cuối cùng, cấp phát theo đơn hàng
- **Luồng**: Sản xuất → Kiểm định → Nhập kho → Xuất phân phối

#### **5. Trung tâm Phân phối (ZN-WHDC-01)**
- **Chức năng**: Hub phân phối toàn quốc
- **Đặc thù**: Quản lý tồn kho, điều phối vận chuyển
- **Luồng**: Kho TP → TTPP → NPP/Đại lý/Kho vùng

#### **6. Kho Showroom (ZN-WHSR-01)**
- **Chức năng**: Trưng bày, bán lẻ trực tiếp
- **Đặc thù**: Hàng chủ lực, luân chuyển nhanh
- **Luồng**: TTPP → Showroom → Khách hàng lẻ

#### **7. Kho Vùng (Đề xuất)**
- **Chức năng**: Phân bổ theo miền (Bắc, Trung, Nam)
- **Đặc thù**: Giảm thời gian giao hàng, tồn kho vùng
- **Luồng**: TTPP → Kho vùng → NPP/Cửa hàng địa phương

#### **8. Kho TMĐT (Đề xuất)**
- **Chức năng**: Chuyên xử lý đơn hàng online
- **Đặc thù**: Giao hàng nhanh, đóng gói nhỏ lẻ
- **Luồng**: TTPP → Kho TMĐT → Đối tác vận chuyển → KH

---

## 3. PHÂN TÍCH QUY TRÌNH NGHIỆP VỤ

### 3.1. Quy trình Nhập kho & Kiểm tra Chất lượng

**Các bên tham gia:**
- Nhà Cung Cấp (NCC)
- Tổ Kho (TO-KHO)
- Tổ QA/QC (TO-QAC)
- Bộ phận Mua hàng (BP-MUH)

**Luồng xử lý:**

```
NCC giao hàng
    ↓
TO-KHO tiếp nhận → Đối chiếu PO
    ↓
Dán nhãn "CHỜ KIỂM TRA" (VÀNG)
    ↓
Thông báo TO-QAC
    ↓
TO-QAC lấy mẫu & kiểm tra
    ↓
    ├─ ĐẠT → Nhập kho chính thức → Báo BP-MUH → Đề xuất thanh toán
    │
    └─ KHÔNG ĐẠT → Cách ly → Báo cáo SPKPH → Thương lượng NCC
                                                    ↓
                                          ┌─────────┼─────────┐
                                          │         │         │
                                      Trả hàng  Đổi hàng  Giảm giá
```

**Biểu mẫu sử dụng:**
- PO (Purchase Order)
- Biên bản kiểm tra QC
- Báo cáo SPKPH (Sản phẩm Không Phù Hợp)
- Phiếu Nhập kho

### 3.2. Quy trình Cấp phát NVL & Nhập kho Thành phẩm

**LUỒNG 1: CẤP PHÁT NGUYÊN VẬT LIỆU**

```
PH-SXU gửi Phiếu Yêu cầu Vật tư
    ↓
TO-KHO kiểm tra tồn kho
    ↓
    ├─ Hàng ĐỦ → Soạn hàng FEFO → Yêu cầu PH-SXU cử người nhận
    │                  ↓
    │         KIỂM ĐẾM TAY BA tại kho
    │                  ↓
    │         Lập Phiếu Xuất kho Nội bộ
    │                  ↓
    │         Bàn giao vật tư cho SX
    │
    └─ Hàng THIẾU → Phản hồi tình trạng thiếu hàng → PH-SXU
```

**LUỒNG 2: NHẬP KHO THÀNH PHẨM**

```
PH-SXU thông báo có lô TP + Biên bản Bàn giao
    ↓
KIỂM ĐẾM TAY BA tại xưởng
    ↓
Ký xác nhận Biên bản Bàn giao
    ↓
TO-KHO lập Phiếu Nhập kho & Cất hàng vào vị trí
```

**Nguyên tắc Kiểm đếm TAY BA:**
- Luôn có 3 bên: Người giao - Người nhận - Người chứng kiến
- Cùng xác nhận số lượng
- Ký nhận đầy đủ
- Minh bạch thông tin

### 3.3. Quy trình Giao hàng (Phối hợp KDO-GNH-KHO)

**Các bên tham gia:**
- Phòng Kinh doanh (PH-KDO)
- Tổ Giao nhận (TO-GNH)
- Tổ Kho (TO-KHO)

**Luồng chính:**

```
PH-KDO gửi Yêu cầu Giao hàng (YCGH)
    ↓
TO-GNH kiểm tra tồn kho khả dụng với TO-KHO
    ↓
    ├─ Hàng ĐỦ → Lập Kế hoạch Giao hàng → Thông báo lịch giao
    │                  ↓
    │         Thực hiện giao hàng
    │                  ↓
    │         ┌───────┴───────┐
    │         │               │
    │    THÀNH CÔNG      KHÔNG THÀNH CÔNG
    │         │               │
    │    Bàn giao CT     Xử lý hàng trả về
    │    có ký nhận          ↓
    │                   Báo cáo sự cố
    │                        ↓
    │                   Làm việc lại với KH
    │                        ↓
    │                   Tạo YCGH mới (nếu cần)
    │
    └─ Hàng KHÔNG ĐỦ → Phản hồi tình trạng thiếu → PH-KDO
```

**Biểu mẫu:**
- PH-KDO-BM-099: Yêu cầu Giao hàng
- TO-GNH-BM-2025-001: Kế hoạch Giao hàng
- Biên bản giao nhận
- Báo cáo sự cố (nếu có)

---

## 4. THIẾT KẾ HỆ THỐNG NHÃN HIỆU

### 4.1. Cấu trúc mã định vị (Location Code)

**Format:** `ZN-WHRM-01-A01-05-02`

| Phần | Ý nghĩa | Ví dụ |
|------|---------|-------|
| ZN | Mã công ty/Tên kho | ZN (Đại Long) |
| WHRM | Loại kho | WHRM = Warehouse Raw Material |
| 01 | Khu vực/Tầng | 01 = Khu vực 1 |
| A01 | Dãy kệ | A01 = Dãy A01 |
| 05 | Số kệ | 05 = Kệ thứ 5 |
| 02 | Tầng kệ | 02 = Tầng 2 |

### 4.2. Mã loại kho

| Mã | Loại kho | Tiếng Anh |
|---|----------|-----------|
| WHRM | Kho Nguyên vật liệu | Warehouse Raw Material |
| WHSP | Kho Vật tư & Phụ tùng | Warehouse Spare Parts |
| WHSF | Kho Bán thành phẩm | Warehouse Semi-Finished |
| WHFG | Kho Thành phẩm | Warehouse Finished Goods |
| WHDC | Trung tâm Phân phối | Warehouse Distribution Center |
| WHSR | Kho Showroom | Warehouse Showroom |

### 4.3. Hệ thống nhãn

**1. Nhãn Vị trí (cố định trên kệ)**
- Màu: Xanh dương
- Nội dung: Mã định vị đầy đủ
- Vị trí dán: Chính giữa thanh beam, dễ nhìn

**2. Nhãn Hàng hóa (di động)**
- Màu: Trắng
- Nội dung:
    - Tên hàng
    - Mã hàng
    - Số lô/batch
    - NSX/HSD
    - Số lượng
- Vị trí: Dán trên thùng/pallet

**3. Nhãn Tình trạng (tạm thời)**

| Màu | Tình trạng | Ý nghĩa |
|-----|-----------|---------|
| 🟡 Vàng | CHỜ KIỂM TRA | Hàng mới nhập, chưa QC |
| 🟢 Xanh lá | ĐẠT - SẴN SÀNG | QC đạt, sẵn sàng sử dụng |
| 🔴 Đỏ | KHÔNG ĐẠT - CÁCH LY | QC không đạt, đang xử lý |
| 🟠 Cam | GẦN HẾT HẠN | Sắp hết hạn, ưu tiên xuất |
| ⚫ Đen | ĐÓNG BĂNG | Không được phép sử dụng |

---

## 5. NGUYÊN TẮC FIFO/FEFO

### 5.1. FIFO (First-In, First-Out)
- **Định nghĩa**: Hàng nhập trước xuất trước
- **Áp dụng**: Hàng không có HSD (bao bì, phụ liệu)
- **Lợi ích**: Giảm tồn kho lâu, tránh lỗi thời

### 5.2. FEFO (First-Expired, First-Out)
- **Định nghĩa**: Hàng hết hạn trước xuất trước
- **Áp dụng**: Hàng có HSD (NVL chính, thực phẩm)
- **Lợi ích**: Giảm hư hỏng, đảm bảo chất lượng

### 5.3. Sơ đồ bố trí kệ theo FIFO/FEFO

```
   ┌──────────────────────────┐
   │   LÔ HÀNG MỚI           │ ← Đặt vào SAU CÙNG
   │   (Date xa hơn)          │
   ├──────────────────────────┤
   │   LÔ HÀNG CŨ            │ ← Nằm ở NGOÀI, dễ lấy
   │   (Date gần hơn)         │
   └──────────────────────────┘
              ↓
         (Lối đi)
```

**Nguyên tắc:**
- Hàng mới đặt vào phía trong/sau
- Hàng cũ đặt ở ngoài, gần lối đi
- Nhân viên luôn lấy từ ngoài vào trong

---

## 6. THIẾT KẾ LAYOUT KHO (ZN-WHRM-01)

### 6.1. Sơ đồ tổng thể

```
┌────────────────────────────────────────┐
│      CỬA NHẬP HÀNG (DOCK 1)            │
├─────────────────┬──────────────────────┤
│ KHU VỰC NHẬN    │ KHU VỰC KIỂM TRA   │
│ HÀNG            │ CHẤT LƯỢNG (QC)     │
│ 🟡 Nhãn VÀNG    │ 🔬 Bàn lấy mẫu      │
├─────────────────┴──────────────────────┤
│         LỐI ĐI CHÍNH                   │
├─────────────────┬──────────────────────┤
│ DÃY A: BAO BÌ   │ DÃY C: GIA VỊ       │
│ (PKG1, PKG2)    │ & TOPPING           │
│ 🔵 Hàng B, C    │ 🔵 Hàng B           │
│ Kệ A01 → A10    │ Kệ C01 → C10        │
├─────────────────┴──────────────────────┤
│         LỐI ĐI CHÍNH                   │
├─────────────────┬──────────────────────┤
│ DÃY B: BAO BÌ   │ DÃY D: NGUYÊN LIỆU │
│ (Thùng, PKG3)   │ CHÍNH (MAIN, OILF)  │
│ 🟢 Hàng C       │ 🔴 Hàng A (Tần suất cao)│
│ Kệ B01 → B10    │ Kệ D01 → D10        │
├─────────────────┴──────────────────────┤
│         LỐI ĐI CHÍNH                   │
├─────────────────┬──────────────────────┤
│ KHU VỰC SOẠN   │ KHU VỰC CHỜ CẤP    │
│ HÀNG (STAGING) │ PHÁT CHO SẢN XUẤT   │
├─────────────────┴──────────────────────┤
│ CỬA XUẤT SANG XƯỞNG SẢN XUẤT          │
└────────────────────────────────────────┘
```

### 6.2. Phân loại hàng theo tần suất sử dụng (ABC)

| Nhóm | Tần suất | Ví dụ | Vị trí |
|------|----------|-------|--------|
| 🔴 A | Rất cao (hàng ngày) | Gạo, dầu ăn, ruốc | Dãy D - Gần lối đi, tầng thấp |
| 🔵 B | Trung bình (2-3 lần/tuần) | Gia vị, topping, bao bì chính | Dãy A, C - Tầng 1-2 |
| 🟢 C | Thấp (ít khi dùng) | Bao bì dự phòng, phụ liệu | Dãy B - Tầng cao, phía trong |

### 6.3. Nguyên tắc bố trí

1. **Hàng nhóm A**: Gần lối đi, tầng thấp (1-2), dễ tiếp cận
2. **Hàng nhóm B**: Tầng 1-2, vị trí trung bình
3. **Hàng nhóm C**: Tầng cao (3-4), phía trong
4. **Hàng nặng**: Luôn ở tầng 1, dùng pallet
5. **Lối đi chính**: Rộng ≥ 2.5m cho xe nâng

---

## 7. YÊU CẦU CHỨC NĂNG HỆ THỐNG

### 7.1. Module Quản lý Tồn kho

**Chức năng chính:**
- Dashboard hiển thị tồn kho realtime theo từng kho
- Cảnh báo hết hàng/tồn kho thấp
- Theo dõi vị trí lưu kho chi tiết (Kệ-Tầng)
- Tìm kiếm nhanh theo mã hàng/tên hàng/lot/vị trí
- Lịch sử xuất nhập theo mã hàng

**Dữ liệu quản lý:**
- Mã hàng, tên hàng, nhóm hàng
- Số lượng tồn (SL khả dụng, SL đang chờ QC, SL cách ly)
- Vị trí lưu kho (Location code)
- Thông tin lot/batch (NSX, HSD)
- Trạng thái (Sẵn sàng, Chờ kiểm tra, Cách ly, Gần hết hạn)

**Cảnh báo:**
- 🔴 Hết hàng (SL = 0)
- 🟠 Tồn kho thấp (SL < Min stock)
- 🟡 Gần hết hạn (HSD < 30 ngày)
- ⚫ Quá hạn sử dụng (HSD < Ngày hiện tại)

### 7.2. Module Phiếu Yêu cầu Vật tư

**Chức năng:**
- Tạo phiếu yêu cầu từ Sản xuất
- Chọn hàng hóa từ danh mục
- Duyệt/Từ chối phiếu
- Theo dõi trạng thái (Chờ xử lý → Đang chuẩn bị → Đã xuất → Đã nhận)
- Lịch sử yêu cầu

**Workflow:**
1. PH-SXU tạo phiếu → Gửi TO-KHO
2. TO-KHO kiểm tra tồn kho
3. Nếu đủ hàng: Duyệt → Chuyển sang "Đang chuẩn bị"
4. Nếu thiếu hàng: Từ chối + Ghi chú lý do
5. Soạn hàng FEFO → Thông báo PH-SXU cử người nhận
6. Kiểm đếm tay ba → Xuất kho

**Biểu mẫu:** BM-SXC-NVL-2025-001

### 7.3. Module Phiếu Xuất kho

**Loại phiếu:**
1. **Xuất nội bộ**: Cho sản xuất
2. **Xuất bán hàng**: Cho khách hàng
3. **Xuất chuyển kho**: Giữa các kho
4. **Xuất trả NCC**: Hàng không đạt

**Chức năng:**
- Tạo phiếu xuất (auto từ YCVT hoặc tạo thủ công)
- Chọn hàng theo FEFO/FIFO tự động
- Kiểm tra tồn kho trước khi xuất
- In phiếu + QR code
- Chữ ký điện tử (Người giao - Người nhận - Người chứng kiến)
- Cập nhật tồn kho realtime

**Dữ liệu:**
- Số phiếu (auto), ngày xuất
- Kho xuất, nơi nhận
- Danh sách hàng (Mã, Tên, Lot, SL, Vị trí lấy)
- Người giao, người nhận, người chứng kiến
- Lý do xuất, ghi chú

### 7.4. Module Phiếu Nhập kho

**Loại phiếu:**
1. **Nhập từ NCC**: Có kiểm tra QC
2. **Nhập TP từ SX**: Có biên bản bàn giao
3. **Nhập chuyển kho**: Giữa các kho
4. **Nhập trả từ KH**: Hàng đổi/bảo hành

**Workflow nhập từ NCC:**
1. Tạo phiếu → Trạng thái "CHỜ KIỂM TRA"
2. Dán nhãn VÀNG lên hàng
3. Thông báo TO-QAC
4. TO-QAC kiểm tra:
    - ✅ ĐẠT → Chuyển trạng thái "ĐẠT - NHẬP KHO" → Cất hàng vào vị trí
    - ❌ KHÔNG ĐẠT → "CÁCH LY" → Báo cáo SPKPH → Xử lý (Trả/Đổi/Giảm giá)
5. Cập nhật tồn kho

**Dữ liệu:**
- Số phiếu, ngày nhập
- Nhà cung cấp, số PO
- Danh sách hàng (Mã, Tên, Lot, NSX, HSD, SL)
- Trạng thái QC
- Vị trí cất hàng (Location code)
- Người nhập, người kiểm tra

### 7.5. Module Kiểm tra Chất lượng (QC)

**Chức năng:**
- Queue kiểm tra (Danh sách hàng chờ QC)
- Tạo biên bản kiểm tra
- Ghi nhận kết quả (ĐẠT/KHÔNG ĐẠT)
- Upload ảnh minh chứng
- Xử lý hàng KHÔNG ĐẠT:
    - Trả hàng NCC
    - Đổi hàng mới
    - Giảm giá chấp nhận
- Thống kê tỷ lệ ĐẠT/KHÔNG ĐẠT theo NCC

**Biên bản kiểm tra bao gồm:**
- Mã phiếu nhập
- Thông tin hàng hóa
- Tiêu chí kiểm tra (Ngoại quan, Màu sắc, Mùi vị, Bao bì, Hạn sử dụng...)
- Kết quả từng tiêu chí
- Kết luận chung
- Người kiểm tra, ngày kiểm tra

### 7.6. Module Báo cáo & Dashboard

**Dashboard tổng quan:**
- Tổng tồn kho theo giá trị
- Tồn kho theo từng kho
- Top 10 hàng tồn nhiều nhất
- Top 10 hàng sắp hết
- Cảnh báo gần hết hạn
- Biểu đồ xuất nhập theo tháng

**Báo cáo:**
1. **Báo cáo tồn kho**: Theo ngày/kỳ, theo kho, theo nhóm hàng
2. **Báo cáo xuất nhập tồn**: Chi tiết từng mã hàng
3. **Báo cáo FEFO/FIFO compliance**: % tuân thủ nguyên tắc
4. **Báo cáo hiệu suất QC**: Tỷ lệ đạt/không đạt theo NCC, theo tháng
5. **Báo cáo luân chuyển hàng**: Số ngày tồn kho trung bình
6. **Báo cáo hàng ế**: Hàng tồn > 90 ngày
7. **Báo cáo hàng gần hết hạn**: HSD < 30/60/90 ngày
8. **Báo cáo giá trị tồn kho**: Theo giá nhập/giá vốn

---

## 8. YÊU CẦU PHI CHỨC NĂNG

### 8.1. Hiệu năng
- Thời gian tải trang: < 2 giây
- Thời gian xử lý giao dịch: < 1 giây
- Hỗ trợ đồng thời: 50+ users
- Uptime: ≥ 99.5%

### 8.2. Bảo mật
- Phân quyền theo vai trò (Role-based)
- Mã hóa dữ liệu nhạy cảm
- Audit log: Ghi nhận mọi thao tác
- Backup tự động hàng ngày
- Xác thực 2 lớp cho tài khoản quan trọng

### 8.3. Tính khả dụng
- Responsive design (Desktop, Tablet, Mobile)
- Hỗ trợ scan barcode/QR code
- Hoạt động offline (đồng bộ khi có mạng)
- In phiếu trực tiếp từ hệ thống

### 8.4. Khả năng mở rộng
- Dễ dàng thêm kho mới
- Tích hợp API với hệ thống khác (ERP, Accounting)
- Hỗ trợ multi-warehouse
- Cấu hình linh hoạt theo nghiệp vụ

---

## 9. PHÂN QUYỀN HỆ THỐNG

### 9.1. Các vai trò (Roles)

#### **1. Quản lý Kho (Warehouse Manager)**
- Xem tất cả dữ liệu kho
- Duyệt phiếu nhập/xuất
- Quản lý vị trí lưu kho
- Xem tất cả báo cáo
- Cấu hình cảnh báo tồn kho

#### **2. Nhân viên Kho (Warehouse Staff)**
- Tạo/sửa phiếu nhập/xuất
- Cập nhật vị trí hàng hóa
- Scan barcode
- In phiếu
- Xem tồn kho

#### **3. QA/QC**
- Xem queue kiểm tra
- Tạo/sửa biên bản kiểm tra
- Duyệt/từ chối hàng nhập
- Xem báo cáo QC
- Upload ảnh minh chứng

#### **4. Phòng Sản xuất**
- Tạo phiếu yêu cầu vật tư
- Xem trạng thái phiếu
- Xác nhận nhận hàng
- Tạo phiếu nhập thành phẩm

#### **5. Phòng Kinh doanh**
- Tạo yêu cầu giao hàng
- Xem tồn kho khả dụng
- Xem trạng thái đơn hàng
- Xem báo cáo bán hàng

#### **6. Bộ phận Mua hàng**
- Xem báo cáo nhập hàng
- Xem báo cáo QC theo NCC
- Xem tồn kho min/max
- Tạo đề xuất mua hàng

#### **7. Kế toán**
- Xem giá trị tồn kho
- Xem báo cáo xuất nhập tồn
- Export báo cáo Excel
- Không được sửa/xóa phiếu

#### **8. Admin/IT**
- Quản lý người dùng
- Phân quyền
- Cấu hình hệ thống
- Xem audit log
- Backup/restore dữ liệu

### 9.2. Ma trận phân quyền

| Chức năng | WH Manager | WH Staff | QA/QC | Sản xuất | Kinh doanh | Mua hàng | Kế toán | Admin |
|-----------|------------|----------|-------|----------|------------|----------|---------|-------|
| Xem tồn kho | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Tạo phiếu nhập | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |
| Duyệt phiếu nhập | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |
| Tạo phiếu xuất | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |
| QC kiểm tra | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ |
| Tạo YCVT | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ✅ |
| Tạo YCGH | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ✅ |
| Xem báo cáo | ✅ | 📊 | 📊 | 📊 | 📊 | 📊 | ✅ | ✅ |
| Cấu hình hệ thống | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |

📊 = Xem báo cáo giới hạn theo phòng ban

---

## 10. TÍCH HỢP HỆ THỐNG

### 10.1. Tích hợp với các module khác

```
┌─────────────────────────────────────────┐
│      HỆ THỐNG QUẢN LÝ KHO (WMS)        │
└────────────┬────────────────────────────┘
             │
    ┌────────┼────────┐
    │        │        │
┌───▼───┐ ┌─▼──┐ ┌──▼────┐
│  ERP  │ │ MES │ │ ORDER │
│       │ │     │ │ MGMT  │
└───┬───┘ └─┬──┘ └──┬────┘
    │       │       │
    └───────┼───────┘
            │
    ┌───────▼────────┐
    │   ACCOUNTING   │
    └────────────────┘
```

### 10.2. API cần tích hợp

#### **Với ERP:**
- Đồng bộ danh mục hàng hóa
- Đồng bộ nhà cung cấp
- Đồng bộ đơn mua hàng (PO)
- Gửi phiếu nhập/xuất kho
- Đồng bộ giá vốn

#### **Với MES (Manufacturing Execution System):**
- Nhận lệnh sản xuất
- Gửi trạng thái cấp phát NVL
- Nhận thông báo hoàn thành TP
- Đồng bộ số lượng thành phẩm

#### **Với Order Management:**
- Nhận đơn hàng
- Kiểm tra khả dụng hàng
- Gửi trạng thái xuất kho
- Cập nhật lịch giao hàng

#### **Với Accounting:**
- Gửi giá trị nhập/xuất/tồn
- Đồng bộ định kỳ cuối tháng
- Gửi báo cáo chi tiết theo yêu cầu

### 10.3. Format dữ liệu tích hợp
- **Protocol**: REST API
- **Format**: JSON
- **Authentication**: OAuth 2.0 / API Key
- **Frequency**:
    - Realtime: Phiếu nhập/xuất
    - Batch: Tồn kho (mỗi 15 phút)
    - On-demand: Báo cáo

---

## 11. QUY TRÌNH KIỂM KÊ KHO

### 11.1. Các loại kiểm kê

#### **1. Kiểm kê định kỳ (Periodic)**
- **Tần suất**: Tháng/Quý/Năm
- **Phạm vi**: Toàn bộ kho
- **Mục đích**: Đối chiếu sổ sách kế toán

#### **2. Kiểm kê tuần hoàn (Cycle Count)**
- **Tần suất**: Hàng tuần
- **Phạm vi**: Một phần kho (theo nhóm ABC)
    - Nhóm A: Kiểm mỗi tháng
    - Nhóm B: Kiểm mỗi quý
    - Nhóm C: Kiểm 6 tháng/lần
- **Mục đích**: Phát hiện sai lệch sớm

#### **3. Kiểm kê đột xuất (Ad-hoc)**
- **Tần suất**: Khi cần thiết
- **Phạm vi**: Theo yêu cầu cụ thể
- **Mục đích**: Điều tra sai lệch, kiểm tra đột xuất

### 11.2. Quy trình kiểm kê

```
1. LẬP KẾ HOẠCH
   ↓
   - Chọn loại kiểm kê
   - Xác định phạm vi (Kho, Dãy, Nhóm hàng)
   - Phân công nhóm kiểm kê
   - Lên lịch kiểm kê

2. CHUẨN BỊ
   ↓
   - Đóng băng giao dịch kho (nếu cần)
   - In phiếu kiểm kê
   - Chuẩn bị thiết bị (máy scan, tablet)
   - Brief nhóm kiểm kê

3. THỰC HIỆN KIỂM KÊ
   ↓
   - Đếm thực tế tại kho
   - Ghi nhận vào phiếu/app
   - Chụp ảnh minh chứng
   - Ký xác nhận

4. NHẬP DỮ LIỆU & ĐỐI CHIẾU
   ↓
   - Nhập số liệu kiểm kê vào hệ thống
   - Hệ thống tự động so sánh với sổ sách
   - Hiển thị danh sách sai lệch

5. XỬ LÝ SAI LỆCH
   ↓
   - Điều tra nguyên nhân (Lỗi nhập liệu? Thất thoát? Hư hỏng?)
   - Kiểm đếm lại các mã hàng sai lệch
   - Tạo biên bản điều chỉnh
   - Phê duyệt điều chỉnh

6. CẬP NHẬT & BÁO CÁO
   ↓
   - Cập nhật tồn kho theo thực tế
   - Lập báo cáo kiểm kê
   - Phân tích nguyên nhân sai lệch
   - Đề xuất cải tiến
```

### 11.3. Xử lý sai lệch

| Loại sai lệch | Nguyên nhân | Xử lý |
|---------------|-------------|-------|
| Thừa hàng | Nhập sai, không xuất hệ thống | Điều chỉnh tăng tồn |
| Thiếu hàng | Xuất sai, thất thoát | Điều tra → Điều chỉnh giảm tồn |
| Sai vị trí | Cất sai chỗ | Di chuyển hàng về đúng vị trí |
| Sai lot/HSD | Ghi nhầm thông tin | Cập nhật thông tin đúng |

**Ngưỡng chấp nhận sai lệch:**
- Giá trị < 500,000đ: Auto duyệt
- Giá trị 500,000đ - 5,000,000đ: Quản lý kho duyệt
- Giá trị > 5,000,000đ: Giám đốc duyệt

---

## 12. QUY TRÌNH XỬ LÝ HÀNG ĐẶC BIỆT

### 12.1. Hàng hư hỏng/hết hạn

```
Phát hiện hàng hư hỏng/hết hạn
    ↓
Cách ly hàng + Dán nhãn ĐEN
    ↓
Tạo báo cáo hư hỏng
    ↓
Chụp ảnh minh chứng
    ↓
Trình duyệt thanh lý
    ↓
    ├─ Trả NCC (nếu còn trong thời gian bảo hành)
    ├─ Hủy/Tiêu hủy (nếu hết hạn)
    └─ Giảm giá bán thanh lý (nếu chất lượng chấp nhận được)
    ↓
Xuất kho hủy/thanh lý
    ↓
Cập nhật giảm tồn kho
```

### 12.2. Hàng chờ xử lý SPKPH

```
Phát hiện hàng không đạt QC
    ↓
Cách ly + Dán nhãn ĐỎ "KHÔNG ĐẠT"
    ↓
Lập báo cáo SPKPH
    ↓
Gửi BP Mua hàng
    ↓
Liên hệ NCC thương lượng
    ↓
    ├─ TRẢ HÀNG
    │   ↓
    │   Tạo phiếu xuất trả NCC
    │   ↓
    │   Giảm tồn kho
    │
    ├─ ĐỔI HÀNG MỚI
    │   ↓
    │   Giữ hàng cũ đến khi hàng mới về
    │   ↓
    │   Nhận hàng mới → QC lại
    │   ↓
    │   Xuất trả hàng cũ
    │
    └─ GIẢM GIÁ CHẤP NHẬN
        ↓
        Cập nhật giá nhập mới
        ↓
        Chuyển trạng thái "ĐẠT"
        ↓
        Nhập kho sử dụng bình thường
```

### 12.3. Hàng bảo hành/đổi trả từ khách

```
Nhận hàng trả từ khách
    ↓
Kiểm tra điều kiện đổi trả
    ↓
    ├─ HỢP LỆ
    │   ↓
    │   Tạo phiếu nhập trả
    │   ↓
    │   QC kiểm tra tình trạng
    │   ↓
    │   ├─ CÒN TỐT → Nhập kho lại (khu vực riêng)
    │   └─ HƯ HỎNG → Cách ly → Xử lý hủy
    │
    └─ KHÔNG HỢP LỆ
        ↓
        Từ chối nhận + Ghi chú lý do
        ↓
        Thông báo KH + Phòng KD
```

---

## 13. KPI & CHỈ SỐ ĐÁNH GIÁ

### 13.1. KPI Kho vận

| STT | Chỉ số | Công thức | Mục tiêu |
|-----|--------|-----------|----------|
| 1 | Độ chính xác tồn kho | (Số lượng đúng / Tổng số lượng kiểm kê) × 100% | ≥ 98% |
| 2 | Tỷ lệ đáp ứng đơn hàng | (Đơn đủ hàng / Tổng đơn) × 100% | ≥ 95% |
| 3 | Thời gian xử lý xuất kho | Từ nhận lệnh đến xuất hàng xong | ≤ 2 giờ |
| 4 | Tỷ lệ hàng hư hỏng | (Giá trị hàng hư / Tổng giá trị tồn) × 100% | ≤ 0.5% |
| 5 | Tuân thủ FEFO/FIFO | (Số lần xuất đúng / Tổng số lần xuất) × 100% | ≥ 95% |
| 6 | Số ngày tồn kho trung bình | Tồn kho TB / (Xuất kho TB/ngày) | ≤ 30 ngày |
| 7 | Tỷ lệ sử dụng diện tích | (Diện tích sử dụng / Tổng diện tích) × 100% | 75-85% |
| 8 | Vòng quay hàng tồn kho | Giá vốn hàng bán / Tồn kho TB | ≥ 12 lần/năm |

### 13.2. KPI QA/QC

| STT | Chỉ số | Công thức | Mục tiêu |
|-----|--------|-----------|----------|
| 1 | Tỷ lệ hàng nhập đạt chuẩn | (Lô hàng đạt / Tổng lô nhập) × 100% | ≥ 95% |
| 2 | Thời gian kiểm tra QC | Từ nhận hàng đến có kết quả | ≤ 4 giờ |
| 3 | Tỷ lệ xử lý SPKPH | (SPKPH xử lý xong / Tổng SPKPH) × 100% | ≥ 98% (trong 48h) |
| 4 | Đánh giá NCC | Điểm trung bình tất cả NCC | ≥ 4/5 sao |

### 13.3. Báo cáo định kỳ

#### **Báo cáo hàng ngày:**
- Tồn kho đầu ngày/cuối ngày
- Phiếu nhập/xuất trong ngày
- Hàng gần hết hạn (< 7 ngày)
- Cảnh báo hết hàng

#### **Báo cáo hàng tuần:**
- Xuất nhập tồn tuần
- Hiệu suất xuất nhập kho
- Danh sách hàng ế (tồn > 30 ngày)
- Kết quả kiểm kê tuần hoàn

#### **Báo cáo hàng tháng:**
- Xuất nhập tồn tháng
- Giá trị tồn kho cuối tháng
- Phân tích ABC
- Đánh giá KPI kho vận
- Báo cáo QC theo NCC
- Hàng hư hỏng/thanh lý

#### **Báo cáo hàng quý/năm:**
- Tổng hợp hiệu suất kho
- Phân tích xu hướng tồn kho
- Đánh giá tổng thể NCC
- Đề xuất cải tiến quy trình

---

## 14. LỘ TRÌNH TRIỂN KHAI

### 14.1. Phase 1: Cơ sở hạ tầng (Tháng 1-2)

**Công việc:**
- ✅ Thiết kế database
- ✅ Setup môi trường dev/staging/production
- ✅ Xây dựng kiến trúc hệ thống
- ✅ Chuẩn bị thiết bị (máy scan, máy in, tablet)
- ✅ Đào tạo IT team

**Kết quả:**
- Hệ thống sẵn sàng phát triển
- Team nắm vững công nghệ

### 14.2. Phase 2: Module cốt lõi (Tháng 3-4)

**Công việc:**
- ✅ Module Quản lý Tồn kho
- ✅ Module Phiếu Nhập kho
- ✅ Module Phiếu Xuất kho
- ✅ Quản lý danh mục (Hàng hóa, Kho, Vị trí)
- ✅ Quản lý người dùng & phân quyền

**Kết quả:**
- Hệ thống cơ bản hoạt động
- Có thể ghi nhận nhập/xuất

### 14.3. Phase 3: Quy trình nghiệp vụ (Tháng 5-6)

**Công việc:**
- ✅ Module Phiếu Yêu cầu Vật tư
- ✅ Module Kiểm tra Chất lượng (QC)
- ✅ Module Yêu cầu Giao hàng
- ✅ Workflow duyệt phiếu
- ✅ Tích hợp scan barcode/QR

**Kết quả:**
- Quy trình nghiệp vụ đầy đủ
- Tự động hóa workflow

### 14.4. Phase 4: Báo cáo & Tích hợp (Tháng 7-8)

**Công việc:**
- ✅ Module Kiểm kê kho
- ✅ Dashboard & Báo cáo
- ✅ Tích hợp API với ERP/MES
- ✅ Xuất báo cáo Excel/PDF
- ✅ Cảnh báo tự động (email/SMS)

**Kết quả:**
- Hệ thống hoàn chỉnh
- Tích hợp với các module khác

### 14.5. Phase 5: Pilot & Go-live (Tháng 9-10)

**Công việc:**
- ✅ Nhập dữ liệu ban đầu (Master data)
- ✅ Pilot tại 1-2 kho
- ✅ Đào tạo người dùng cuối
- ✅ Thu thập feedback & điều chỉnh
- ✅ Go-live toàn bộ hệ thống
- ✅ Hỗ trợ sau triển khai (1 tháng)

**Kết quả:**
- Hệ thống đưa vào vận hành
- Người dùng thành thạo

### 14.6. Phase 6: Tối ưu & Mở rộng (Tháng 11-12)

**Công việc:**
- ✅ Tối ưu hiệu năng
- ✅ Phát triển tính năng nâng cao
- ✅ Tích hợp thêm với Accounting
- ✅ Mobile app cho nhân viên kho
- ✅ AI dự báo tồn kho (optional)

**Kết quả:**
- Hệ thống ổn định, hiệu quả
- Sẵn sàng mở rộng

---

## 15. RỦI RO & GIẢI PHÁP

| STT | Rủi ro | Mức độ | Giải pháp |
|-----|--------|--------|-----------|
| 1 | Nhân viên không quen với hệ thống mới | Cao | Đào tạo kỹ lưỡng, có tài liệu hướng dẫn chi tiết, hỗ trợ 24/7 trong tháng đầu |
| 2 | Dữ liệu ban đầu không chính xác | Cao | Kiểm kê toàn diện trước khi nhập, đối chiếu kỹ với sổ sách |
| 3 | Downtime ảnh hưởng hoạt động | Trung bình | Có chế độ offline, backup tự động, hotline hỗ trợ |
| 4 | Tích hợp với ERP gặp khó khăn | Trung bình | Làm việc sớm với team ERP, có API documentation rõ ràng |
| 5 | Thiết bị (máy scan) hỏng | Thấp | Dự phòng thiết bị, có quy trình xử lý thủ công tạm thời |
| 6 | Nhân viên kháng cự thay đổi | Trung bình | Truyền thông lợi ích rõ ràng, thu thập feedback sớm |
| 7 | Budget vượt dự kiến | Thấp | Chia nhỏ phase, ưu tiên tính năng cốt lõi trước |

---

## 16. PHỤ LỤC

### 16.1. Danh sách Biểu mẫu

1. **BM-SXC-NVL-2025-001**: Phiếu Yêu cầu Vật tư
2. **PH-KDO-BM-099**: Yêu cầu Giao hàng
3. **TO-GNH-BM-2025-001**: Kế hoạch Giao hàng
4. **Phiếu Xuất kho Nội bộ**
5. **Phiếu Nhập kho**
6. **Biên bản Bàn giao TP**
7. **Biên bản Kiểm tra QC**
8. **Báo cáo SPKPH**
9. **Phiếu Kiểm kê**
10. **Biên bản Điều chỉnh tồn kho**

### 16.2. Thuật ngữ viết tắt

| Viết tắt | Tiếng Việt | Tiếng Anh |
|----------|-----------|-----------|
| WMS | Hệ thống Quản lý Kho | Warehouse Management System |
| NVL | Nguyên vật liệu | Raw Material |
| TP | Thành phẩm | Finished Goods |
| BTP | Bán thành phẩm | Semi-Finished Goods |
| QC/QA | Kiểm tra/Đảm bảo Chất lượng | Quality Control/Assurance |
| PO | Đơn mua hàng | Purchase Order |
| YCVT | Yêu cầu Vật tư | Material Request |
| YCGH | Yêu cầu Giao hàng | Delivery Request |
| SPKPH | Sản phẩm Không Phù Hợp | Non-Conforming Product |
| FIFO | Vào trước Ra trước | First-In, First-Out |
| FEFO | Hết hạn trước Ra trước | First-Expired, First-Out |
| NSX | Ngày sản xuất | Manufacturing Date |
| HSD | Hạn sử dụng | Expiry Date |
| SKU | Đơn vị lưu kho | Stock Keeping Unit |
| NPP | Nhà phân phối | Distributor |
| NCC | Nhà cung cấp | Supplier |
| TTPP | Trung tâm Phân phối | Distribution Center |

### 16.3. Liên hệ

**Người lập tài liệu:**
- Business Analyst
- Email: ba@dailongfoods.com
- Ngày: 14/10/2025

**Người phê duyệt:**
- Giám đốc Điều hành
- Trưởng phòng Kho vận
- Trưởng phòng IT

---

## 17. MÔ TẢ CHI TIẾT CÁC CHỨC NĂNG

### 17.1. Module Quản lý Tồn kho

#### **17.1.1. Màn hình Dashboard Tồn kho**

**Layout:**
```
┌─────────────────────────────────────────────────────────┐
│  📊 DASHBOARD TỒN KHO                    [Tìm kiếm...] │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ │
│  │ 💰 Tổng  │ │ 📦 Tổng  │ │ ⚠️ Cảnh │ │ 🔴 Hết  │ │
│  │ giá trị  │ │ số SKU   │ │ báo      │ │ hạn      │ │
│  │ 2.5 tỷ   │ │ 450 SKU  │ │ 15 mã    │ │ 3 mã     │ │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘ │
│                                                         │
│  📊 Biểu đồ Tồn kho theo Kho              🔄 Realtime │
│  ┌───────────────────────────────────────────────────┐ │
│  │ [Bar Chart: Kho NVL | Kho TP | TTPP...]          │ │
│  └───────────────────────────────────────────────────┘ │
│                                                         │
│  📈 Xu hướng Tồn kho 30 ngày                          │
│  ┌───────────────────────────────────────────────────┐ │
│  │ [Line Chart: Nhập - Xuất - Tồn]                  │ │
│  └───────────────────────────────────────────────────┘ │
│                                                         │
│  ⚠️ CẢNH BÁO                                           │
│  ┌─────────────────────────────────────────────────┐   │
│  │ 🟡 Gạo nếp hạt ngắn - HSD: 15/11/2025 (20 ngày) │   │
│  │ 🔴 Dầu ăn chai 1L - Tồn: 5 chai (< Min: 50)    │   │
│  │ 🟠 Bao bì 500g - Hết hàng                        │   │
│  └─────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

**Chức năng:**
1. **Thống kê tổng quan:**
    - Tổng giá trị tồn kho (theo giá vốn)
    - Tổng số SKU đang tồn
    - Số cảnh báo (hết hàng, tồn thấp, gần hết hạn)
    - Số mã hàng quá hạn

2. **Biểu đồ:**
    - Tồn kho theo kho (Bar chart)
    - Xu hướng 7/30/90 ngày (Line chart)
    - Phân bổ theo nhóm hàng (Pie chart)

3. **Cảnh báo realtime:**
    - Ưu tiên hiển thị theo mức độ nghiêm trọng
    - Click vào cảnh báo → Chuyển đến chi tiết

4. **Tìm kiếm nhanh:**
    - Theo mã hàng, tên hàng, lot/batch
    - Auto-complete suggestions

#### **17.1.2. Màn hình Danh sách Hàng hóa**

**Bảng dữ liệu:**

| Mã hàng | Tên hàng | Nhóm | Tồn khả dụng | Chờ QC | Cách ly | Vị trí | Trạng thái | Thao tác |
|---------|----------|------|--------------|--------|---------|--------|------------|----------|
| MAIN_gao01 | Gạo nếp hạt ngắn | NVL chính | 1,250 kg | 0 | 0 | ZN-WHRM-01-D01-03-02 | 🟢 Sẵn sàng | 👁️ 📝 📊 |
| PKG1_bao500 | Bao 500g in logo | Bao bì | 5,000 cái | 0 | 0 | ZN-WHSP-01-A01-02-01 | 🟡 Tồn thấp | 👁️ 📝 📊 |
| SPIC_gia01 | Hạt nêm 1kg | Gia vị | 0 | 0 | 0 | - | 🔴 Hết hàng | 👁️ 📝 📊 |

**Bộ lọc:**
- Kho
- Nhóm hàng (NVL chính, Bao bì, Gia vị...)
- Trạng thái (Sẵn sàng, Chờ QC, Cách ly, Hết hàng...)
- Khoảng HSD (Hết hạn trong 30/60/90 ngày)
- Tồn kho (Hết hàng, Tồn thấp, Tồn cao)

**Thao tác:**
- 👁️ Xem chi tiết: Lịch sử xuất nhập, các lot/batch
- 📝 Chỉnh sửa thông tin: Cập nhật min/max stock, vị trí...
- 📊 Biểu đồ: Xu hướng xuất nhập của mã hàng
- 📤 Export Excel

#### **17.1.3. Màn hình Chi tiết Hàng hóa**

**Tabs:**

**Tab 1: Thông tin chung**
- Mã hàng, tên hàng, nhóm hàng
- Đơn vị tính, quy cách đóng gói
- Hình ảnh sản phẩm
- Mô tả, ghi chú
- Min stock, Max stock, Reorder point
- Thời gian giao hàng (Lead time)

**Tab 2: Tồn kho theo Kho**

| Kho | Tồn khả dụng | Chờ QC | Cách ly | Tổng |
|-----|--------------|--------|---------|------|
| ZN-WHRM-01 | 1,250 kg | 0 | 0 | 1,250 kg |
| ZN-WHDC-01 | 350 kg | 0 | 0 | 350 kg |
| **TỔNG** | **1,600 kg** | **0** | **0** | **1,600 kg** |

**Tab 3: Tồn kho theo Lot/Batch**

| Lot/Batch | NSX | HSD | Số lượng | Vị trí | Trạng thái |
|-----------|-----|-----|----------|--------|------------|
| 20251006 | 06/10/2025 | 06/10/2026 | 500 kg | ZN-WHRM-01-D01-03-02 | 🟢 Sẵn sàng |
| 20251010 | 10/10/2025 | 10/10/2026 | 750 kg | ZN-WHRM-01-D01-04-01 | 🟢 Sẵn sàng |

**Tab 4: Lịch sử Xuất Nhập**

| Ngày | Loại | Số phiếu | Lot | SL | Đơn giá | Người xử lý |
|------|------|----------|-----|----|---------| ------------|
| 15/10/2025 | Xuất | PX-2025-1523 | 20251006 | -50 kg | 18,000đ | Nguyễn Văn A |
| 10/10/2025 | Nhập | PN-2025-0891 | 20251010 | +750 kg | 18,500đ | Trần Thị B |

**Tab 5: Biểu đồ & Phân tích**
- Biểu đồ xu hướng xuất nhập 90 ngày
- Số ngày tồn kho trung bình
- Tần suất xuất kho
- Dự báo tồn kho (nếu có AI)

---

### 17.2. Module Phiếu Nhập kho

#### **17.2.1. Tạo mới Phiếu Nhập kho**

**Bước 1: Thông tin chung**
```
┌─────────────────────────────────────────────┐
│  📥 TẠO PHIẾU NHẬP KHO                     │
├─────────────────────────────────────────────┤
│                                             │
│  Loại nhập: [Dropdown]                     │
│  ◉ Nhập từ NCC                             │
│  ○ Nhập TP từ Sản xuất                     │
│  ○ Nhập chuyển kho                         │
│  ○ Nhập trả từ Khách hàng                  │
│                                             │
│  Kho nhận:    [Dropdown: ZN-WHRM-01]      │
│  Ngày nhập:   [Date: 15/10/2025]          │
│  NCC:         [Autocomplete: Công ty A]    │
│  Số PO:       [PO-2025-0123]              │
│  Người nhập:  [Tự động: User hiện tại]    │
│  Ghi chú:     [Textarea...]               │
│                                             │
│  [Tiếp theo →]                             │
└─────────────────────────────────────────────┘
```

**Bước 2: Chi tiết Hàng hóa**
```
┌─────────────────────────────────────────────────────────┐
│  [+ Thêm hàng]                           [Quét mã ▼]   │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  STT | Mã hàng | Tên | Lot | NSX | HSD | SL | ĐVT | Thao tác │
│  ──────────────────────────────────────────────────── │
│  1   | MAIN_gao01 | Gạo nếp | 20251015 | 15/10/25 |  │
│         15/10/26 | 500 | kg | 🗑️              │
│  2   | SPIC_gia01 | Hạt nêm | 20251015 | 15/10/25 |  │
│         15/12/26 | 100 | kg | 🗑️              │
│                                                         │
│  Tổng: 2 mặt hàng                                      │
│                                                         │
│  [← Quay lại]  [Lưu nháp]  [Tạo phiếu →]             │
└─────────────────────────────────────────────────────────┘
```

**Lưu ý:**
- Với "Nhập từ NCC": Mặc định trạng thái = "CHỜ KIỂM TRA"
- Tự động tạo task cho QA/QC
- In nhãn VÀNG để dán lên hàng

**Bước 3: Xác nhận**
```
┌─────────────────────────────────────────────┐
│  ✅ TẠO PHIẾU NHẬP THÀNH CÔNG              │
├─────────────────────────────────────────────┤
│                                             │
│  Số phiếu: PN-2025-0892                    │
│  Trạng thái: CHỜ KIỂM TRA                  │
│                                             │
│  ✅ Đã thông báo cho QA/QC                 │
│  ✅ Đã gửi email cho BP Mua hàng           │
│                                             │
│  [In phiếu] [In nhãn VÀNG] [Xem chi tiết] │
└─────────────────────────────────────────────┘
```

#### **17.2.2. Danh sách Phiếu Nhập**

**Bảng dữ liệu:**

| Số phiếu | Ngày | Loại | Kho | NCC | Tổng SL | Trạng thái | Thao tác |
|----------|------|------|-----|-----|---------|------------|----------|
| PN-2025-0892 | 15/10/2025 | Nhập NCC | ZN-WHRM-01 | Công ty A | 600 kg | 🟡 Chờ QC | 👁️ ✏️ 🖨️ |
| PN-2025-0891 | 10/10/2025 | Nhập NCC | ZN-WHRM-01 | Công ty B | 750 kg | 🟢 Đã nhập | 👁️ 🖨️ |
| PN-2025-0890 | 09/10/2025 | Nhập TP | ZN-WHFG-01 | Sản xuất | 1,000 pcs | 🟢 Đã nhập | 👁️ 🖨️ |

**Bộ lọc:**
- Kho
- Loại nhập
- Trạng thái (Chờ QC, Đã nhập, Cách ly, Đã hủy)
- Khoảng ngày
- NCC

**Trạng thái Phiếu:**
- 🟡 **CHỜ KIỂM TRA**: Hàng đã nhận, đang chờ QC
- 🟢 **ĐÃ NHẬP KHO**: QC đạt, đã cất hàng vào vị trí
- 🔴 **CÁCH LY**: QC không đạt, đang xử lý
- ⚫ **ĐÃ HỦY**: Phiếu bị hủy (nhập sai, hàng trả lại...)

---

### 17.3. Module Phiếu Xuất kho

#### **17.3.1. Tạo mới Phiếu Xuất kho**

**Bước 1: Thông tin chung**
```
┌─────────────────────────────────────────────┐
│  📤 TẠO PHIẾU XUẤT KHO                     │
├─────────────────────────────────────────────┤
│                                             │
│  Loại xuất: [Dropdown]                     │
│  ◉ Xuất nội bộ (Sản xuất)                 │
│  ○ Xuất bán hàng                           │
│  ○ Xuất chuyển kho                         │
│  ○ Xuất trả NCC                            │
│                                             │
│  Kho xuất:     [ZN-WHRM-01]               │
│  Ngày xuất:    [15/10/2025]               │
│  Nơi nhận:     [Phòng Sản xuất]           │
│  Liên kết:     [YCVT-2025-0156] (nếu có)  │
│  Người xuất:   [Tự động]                   │
│  Ghi chú:      [Textarea...]              │
│                                             │
│  [Tiếp theo →]                             │
└─────────────────────────────────────────────┘
```

**Bước 2: Chọn hàng theo FEFO/FIFO**
```
┌─────────────────────────────────────────────────────────┐
│  [+ Thêm hàng]        [✓ Tự động FEFO]  [Quét mã ▼]   │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  Chọn: [Gạo nếp hạt ngắn - MAIN_gao01]  [Tìm]         │
│                                                         │
│  Số lượng cần: [50] kg                                 │
│                                                         │
│  📊 HỆ THỐNG ĐỀ XUẤT (FEFO):                          │
│  ┌─────────────────────────────────────────────────┐   │
│  │ ☑️ Lot 20251006 | HSD: 06/10/2026                │   │
│  │    Vị trí: ZN-WHRM-01-D01-03-02                 │   │
│  │    Tồn: 500 kg → Lấy: 50 kg                     │   │
│  │                                                  │   │
│  │ ☐ Lot 20251010 | HSD: 10/10/2026 (Dự phòng)    │   │
│  │    Vị trí: ZN-WHRM-01-D01-04-01                 │   │
│  │    Tồn: 750 kg                                   │   │
│  └─────────────────────────────────────────────────┘   │
│                                                         │
│  [← Thay đổi] [Xác nhận]                              │
└─────────────────────────────────────────────────────────┘
```

**Lưu ý Logic FEFO:**
1. Hệ thống tự động sắp xếp các lot theo HSD (gần nhất trước)
2. Ưu tiên lấy từ lot có HSD gần nhất
3. Nếu lot không đủ số lượng → Tự động lấy thêm từ lot tiếp theo
4. Cho phép người dùng override (chọn lot khác) nếu cần

**Bước 3: Xác nhận & Ký nhận**
```
┌─────────────────────────────────────────────┐
│  ✍️ KÝ NHẬN PHIẾU XUẤT                     │
├─────────────────────────────────────────────┤
│                                             │
│  Số phiếu: PX-2025-1524                    │
│  Tổng: 50 kg (1 mặt hàng, 1 lot)          │
│                                             │
│  [Chữ ký người giao: _____________]        │
│  Họ tên: Nguyễn Văn A (TO-KHO)            │
│                                             │
│  [Chữ ký người nhận: _____________]        │
│  Họ tên: Trần Văn B (PH-SXU)              │
│                                             │
│  [Chữ ký người chứng kiến: _____________] │
│  Họ tên: Lê Thị C (TO-KHO)                │
│                                             │
│  [✓ Xác nhận & Xuất kho]                   │
└─────────────────────────────────────────────┘
```

**Sau khi Xuất:**
- Tự động trừ tồn kho
- Gửi email/notification cho các bên liên quan
- In phiếu xuất
- Cập nhật trạng thái YCVT (nếu có) thành "Đã xuất"

---

### 17.4. Module Kiểm tra Chất lượng (QC)

#### **17.4.1. Queue Kiểm tra**

**Màn hình danh sách:**
```
┌─────────────────────────────────────────────────────────┐
│  🔬 QUEUE KIỂM TRA CHẤT LƯỢNG                          │
├─────────────────────────────────────────────────────────┤
│  [Bộ lọc: Tất cả ▼]  [Ưu tiên: Cao → Thấp]           │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  🔴 ƯU TIÊN CAO                                        │
│  ┌─────────────────────────────────────────────────┐   │
│  │ PN-2025-0892 | Gạo nếp 500kg | Công ty A       │   │
│  │ Chờ: 3 giờ | Hẹn QC: 16:00 hôm nay             │   │
│  │ [Bắt đầu kiểm tra]                              │   │
│  └─────────────────────────────────────────────────┘   │
│                                                         │
│  🟡 ƯU TIÊN TRUNG BÌNH                                 │
│  ┌─────────────────────────────────────────────────┐   │
│  │ PN-2025-0893 | Bao bì 5000 cái | Công ty B     │   │
│  │ Chờ: 1 giờ | Hẹn QC: 17:00 hôm nay             │   │
│  │ [Bắt đầu kiểm tra]                              │   │
│  └─────────────────────────────────────────────────┘   │
│                                                         │
│  📊 Thống kê: 5 lô chờ kiểm tra | TB: 2.5 giờ/lô     │
└─────────────────────────────────────────────────────────┘
```

#### **17.4.2. Form Kiểm tra**

```
┌─────────────────────────────────────────────────────────┐
│  🔬 BIÊN BẢN KIỂM TRA CHẤT LƯỢNG                      │
├─────────────────────────────────────────────────────────┤
│  Phiếu nhập: PN-2025-0892                              │
│  Hàng hóa: Gạo nếp hạt ngắn (MAIN_gao01)              │
│  Lot: 20251015 | NSX: 15/10/2025 | HSD: 15/10/2026   │
│  Số lượng: 500 kg                                      │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  TIÊU CHÍ KIỂM TRA:                                    │
│                                                         │
│  1. ☑️ Ngoại quan                                      │
│     ◉ Đạt  ○ Không đạt                                │
│     Ghi chú: [Hạt đều, không vỡ...]                   │
│                                                         │
│  2. ☑️ Màu sắc                                         │
│     ◉ Đạt  ○ Không đạt                                │
│     Ghi chú: [Trắng đục tự nhiên...]                  │
│                                                         │
│  3. ☑️ Mùi vị                                          │
│     ◉ Đạt  ○ Không đạt                                │
│     Ghi chú: [Mùi thơm tự nhiên...]                   │
│                                                         │
│  4. ☑️ Bao bì                                          │
│     ◉ Đạt  ○ Không đạt                                │
│     Ghi chú: [Nguyên vẹn, không rách...]              │
│                                                         │
│  5. ☑️ Nhãn mác & HSD                                  │
│     ◉ Đạt  ○ Không đạt                                │
│     Ghi chú: [Đầy đủ thông tin, HSD rõ ràng...]      │
│                                                         │
│  6. ☑️ Độ ẩm (nếu có)                                  │
│     Giá trị đo: [14.2] % (Chuẩn: ≤ 14%)              │
│     ◉ Đạt  ○ Không đạt                                │
│                                                         │
│  📸 HÌNH ẢNH MINH CHỨNG:                               │
│  [Upload ảnh...] (Tối đa 10 ảnh)                      │
│                                                         │
│  ───────────────────────────────────────────────────   │
│                                                         │
│  KẾT LUẬN:                                             │
│  ◉ ĐẠT - Cho phép nhập kho                            │
│  ○ KHÔNG ĐẠT - Cách ly và xử lý                       │
│                                                         │
│  Người kiểm tra: [Tự động - Trần Thị B (QA/QC)]      │
│  Ngày kiểm tra: [15/10/2025 16:30]                    │
│                                                         │
│  [Lưu nháp]  [Hoàn thành kiểm tra]                    │
└─────────────────────────────────────────────────────────┘
```

**Luồng sau QC:**

**Nếu ĐẠT:**
1. Cập nhật trạng thái phiếu nhập: "Chờ QC" → "Đã nhập"
2. Cho phép cất hàng vào vị trí
3. Gửi thông báo cho TO-KHO & BP-MUH
4. Đề xuất thanh toán (nếu cấu hình)

**Nếu KHÔNG ĐẠT:**
1. Cập nhật trạng thái: "Chờ QC" → "Cách ly"
2. Dán nhãn ĐỎ lên hàng
3. Tự động tạo Báo cáo SPKPH
4. Gửi cảnh báo đến BP-MUH
5. Tạo task: "Liên hệ NCC xử lý"

---

### 17.5. Module Kiểm kê Kho

#### **17.5.1. Tạo Kế hoạch Kiểm kê**

```
┌─────────────────────────────────────────────────────────┐
│  📋 TẠO KẾ HOẠCH KIỂM KÊ                               │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  Loại kiểm kê:                                         │
│  ◉ Kiểm kê định kỳ                                     │
│  ○ Kiểm kê tuần hoàn (Cycle count)                    │
│  ○ Kiểm kê đột xuất                                    │
│                                                         │
│  Phạm vi:                                              │
│  Kho: [✓ ZN-WHRM-01] [  ZN-WHSP-01] [  Tất cả]       │
│  Dãy: [✓ A01] [✓ A02] [  B01] [  Tất cả]            │
│  Nhóm hàng: [✓ NVL chính] [  Bao bì] [  Tất cả]     │
│                                                         │
│  Thời gian:                                            │
│  Ngày kiểm kê: [20/10/2025]                           │
│  Giờ bắt đầu: [08:00]                                 │
│  Giờ kết thúc: [12:00]                                │
│                                                         │
│  ☑️ Đóng băng giao dịch kho trong thời gian kiểm kê   │
│                                                         │
│  Nhóm kiểm kê:                                         │
│  ┌─────────────────────────────────────────────────┐   │
│  │ Trưởng nhóm: [Nguyễn Văn A] (TO-KHO)          │   │
│  │ Thành viên 1: [Trần Văn B] (TO-KHO)           │   │
│  │ Thành viên 2: [Lê Thị C] (Kế toán)            │   │
│  │ [+ Thêm thành viên]                            │   │
│  └─────────────────────────────────────────────────┘   │
│                                                         │
│  [Tạo kế hoạch & Gửi thông báo]                       │
└─────────────────────────────────────────────────────────┘
```

#### **17.5.2. Thực hiện Kiểm kê (Mobile App)**

```
┌─────────────────────────────────────────┐
│  📱 KIỂM KÊ KHO - MOBILE               │
├─────────────────────────────────────────┤
│  Kế hoạch: KK-2025-10-20               │
│  Khu vực: ZN-WHRM-01-A01               │
│  Tiến độ: 15/45 mã (33%)               │
│  [███████░░░░░░░░░░░░░░]               │
├─────────────────────────────────────────┤
│                                         │
│  📦 MÃ HÀNG HIỆN TẠI:                  │
│  MAIN_gao01 - Gạo nếp hạt ngắn        │
│                                         │
│  📍 Vị trí: ZN-WHRM-01-A01-05-02      │
│  [📷 Quét QR code vị trí]              │
│                                         │
│  📊 Theo sổ sách:                      │
│  Lot 20251006 | HSD: 06/10/2026       │
│  Số lượng: 500 kg                      │
│                                         │
│  ✍️ KIỂM ĐẾM THỰC TẾ:                 │
│  Lot: [20251006] [📷 Quét]            │
│  Số lượng: [____] kg                   │
│                                         │
│  📸 Chụp ảnh thực tế: [+]             │
│                                         │
│  Ghi chú: [Textarea...]                │
│                                         │
│  [← Trước]  [Lưu & Tiếp →]           │
│                                         │
│  [☰ Menu]  [📊 Tiến độ]  [🔄 Sync]   │
└─────────────────────────────────────────┘
```

**Tính năng Mobile:**
- Hoạt động offline (đồng bộ khi có mạng)
- Quét QR code vị trí & mã hàng
- Chụp ảnh trực tiếp
- Ghi âm ghi chú (optional)
- Hiển thị tiến độ realtime
- Cảnh báo nếu sai lệch lớn

#### **17.5.3. Đối chiếu & Xử lý Sai lệch**

```
┌─────────────────────────────────────────────────────────┐
│  📊 BÁO CÁO KIỂM KÊ - KK-2025-10-20                    │
├─────────────────────────────────────────────────────────┤
│  Kho: ZN-WHRM-01 | Ngày: 20/10/2025                   │
│  Trạng thái: Đang xử lý sai lệch                       │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  📈 TỔNG QUAN:                                         │
│  • Tổng số mã kiểm kê: 45 mã                          │
│  • Đúng: 40 mã (88.9%)                                │
│  • Sai lệch: 5 mã (11.1%)                             │
│  • Chưa kiểm: 0 mã                                     │
│                                                         │
│  ⚠️ DANH SÁCH SAI LỆCH:                                │
│                                                         │
│  STT | Mã hàng | Lot | Sổ sách | Thực tế | Chênh | Giá trị | Trạng thái │
│  ───────────────────────────────────────────────────────────────────── │
│  1 | MAIN_gao01 | 20251006 | 500 kg | 485 kg | -15 kg | -270K | 🟡 Chờ duyệt │
│  2 | PKG1_bao500 | - | 1000 | 1050 | +50 | +25K | ✅ Đã duyệt │
│  3 | SPIC_gia01 | 20250920 | 50 kg | 0 kg | -50 kg | -2.5M | 🔴 Đang điều tra │
│                                                         │
│  💰 TỔNG GIÁ TRỊ SAI LỆCH: -2,745,000đ (Thiếu)       │
│                                                         │
│  [📥 Export Excel] [📧 Gửi báo cáo] [✏️ Xử lý sai lệch] │
└─────────────────────────────────────────────────────────┘
```

**Form Xử lý Sai lệch:**

```
┌─────────────────────────────────────────────────────────┐
│  ⚠️ XỬ LÝ SAI LỆCH - MAIN_gao01                        │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  Thông tin:                                            │
│  • Mã hàng: MAIN_gao01 - Gạo nếp hạt ngắn            │
│  • Lot: 20251006                                       │
│  • Vị trí: ZN-WHRM-01-A01-05-02                       │
│  • Sổ sách: 500 kg                                     │
│  • Thực tế: 485 kg                                     │
│  • Chênh lệch: -15 kg (-270,000đ)                     │
│                                                         │
│  Nguyên nhân: [Dropdown]                               │
│  ◉ Lỗi nhập liệu                                       │
│  ○ Xuất kho không nhập hệ thống                        │
│  ○ Hư hỏng/Hao hụt tự nhiên                            │
│  ○ Thất thoát                                          │
│  ○ Khác (ghi rõ)                                       │
│                                                         │
│  Chi tiết nguyên nhân:                                 │
│  [Textarea: Kiểm tra lại, phát hiện đã xuất cho      │
│   sản xuất nhưng chưa lập phiếu xuất kho...]          │
│                                                         │
│  📸 Ảnh minh chứng: [Upload...]                        │
│                                                         │
│  Hành động:                                            │
│  ◉ Điều chỉnh tồn kho theo thực tế                     │
│  ○ Kiểm đếm lại                                        │
│  ○ Chuyển cho cấp trên xử lý                           │
│                                                         │
│  Người đề xuất: [Nguyễn Văn A - TO-KHO]               │
│  Người phê duyệt: [Chọn...]                            │
│                                                         │
│  [Hủy] [Gửi duyệt]                                     │
└─────────────────────────────────────────────────────────┘
```

**Workflow Phê duyệt:**
1. **Sai lệch nhỏ (< 500K)**: Quản lý kho duyệt trực tiếp
2. **Sai lệch vừa (500K - 5M)**: Cần phê duyệt Trưởng phòng
3. **Sai lệch lớn (> 5M)**: Cần phê duyệt Giám đốc + Điều tra

---

### 17.6. Module Báo cáo & Phân tích

#### **17.6.1. Báo cáo Xuất Nhập Tồn**

```
┌─────────────────────────────────────────────────────────┐
│  📊 BÁO CÁO XUẤT NHẬP TỒN                              │
├─────────────────────────────────────────────────────────┤
│  Kỳ báo cáo: [01/10/2025] → [31/10/2025]             │
│  Kho: [✓ Tất cả] [  ZN-WHRM-01] [  ZN-WHSP-01]      │
│  Nhóm hàng: [✓ Tất cả] [  NVL chính] [  Bao bì]     │
│  [📊 Xem báo cáo] [📥 Export Excel]                   │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  STT | Mã hàng | Tên | Tồn đầu | Nhập | Xuất | Tồn cuối | Giá trị │
│  ──────────────────────────────────────────────────────────────── │
│  1 | MAIN_gao01 | Gạo nếp | 1200 | +800 | -850 | 1150 kg | 20.7M │
│  2 | SPIC_gia01 | Hạt nêm | 80 | +100 | -130 | 50 kg | 2.5M │
│  ...                                                    │
│                                                         │
│  TỔNG CỘNG:                                            │
│  • Tồn đầu kỳ: 85,500,000đ                            │
│  • Nhập trong kỳ: 120,000,000đ                         │
│  • Xuất trong kỳ: 98,750,000đ                          │
│  • Tồn cuối kỳ: 106,750,000đ                          │
│                                                         │
│  📈 Biểu đồ:                                           │
│  [Line chart: Tồn kho qua các ngày trong tháng]      │
└─────────────────────────────────────────────────────────┘
```

#### **17.6.2. Báo cáo Hiệu suất Kho**

```
┌─────────────────────────────────────────────────────────┐
│  📈 BÁO CÁO HIỆU SUẤT KHO - THÁNG 10/2025             │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  🎯 CÁC CHỈ SỐ KPI:                                    │
│                                                         │
│  ┌──────────────────────────────────────────────────┐  │
│  │ Độ chính xác tồn kho         98.5%  ✅ Đạt     │  │
│  │ Target: ≥ 98%                [████████████░]    │  │
│  ├──────────────────────────────────────────────────┤  │
│  │ Tỷ lệ đáp ứng đơn hàng       96.2%  ✅ Đạt     │  │
│  │ Target: ≥ 95%                [████████████░░]   │  │
│  ├──────────────────────────────────────────────────┤  │
│  │ Thời gian xử lý xuất kho     1.8h   ✅ Đạt     │  │
│  │ Target: ≤ 2h                 [██████████████]   │  │
│  ├──────────────────────────────────────────────────┤  │
│  │ Tuân thủ FEFO/FIFO           94.1%  ⚠️ Gần đạt │  │
│  │ Target: ≥ 95%                [███████████░░░]   │  │
│  ├──────────────────────────────────────────────────┤  │
│  │ Tỷ lệ hàng hư hỏng           0.3%   ✅ Đạt     │  │
│  │ Target: ≤ 0.5%               [██]               │  │
│  └──────────────────────────────────────────────────┘  │
│                                                         │
│  📊 SỐ LIỆU CHI TIẾT:                                  │
│  • Số phiếu nhập: 125 phiếu                           │
│  • Số phiếu xuất: 238 phiếu                           │
│  • Số lần kiểm kê: 4 lần (tuần hoàn)                  │
│  • Số SPKPH: 3 trường hợp (đã xử lý xong)             │
│                                                         │
│  🎯 ĐIỂM CẢI THIỆN:                                    │
│  ⚠️ Cần tăng tuân thủ FEFO/FIFO lên 95%               │
│     → Đề xuất: Đào tạo lại nhân viên kho              │
│                                                         │
│  [📥 Export PDF] [📧 Gửi email]                       │
└─────────────────────────────────────────────────────────┘
```

#### **17.6.3. Báo cáo Phân tích ABC**

```
┌─────────────────────────────────────────────────────────┐
│  📊 PHÂN TÍCH ABC - Q3/2025                            │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  🔴 NHÓM A (20% SKU - 80% Giá trị)                    │
│  ┌─────────────────────────────────────────────────┐   │
│  │ STT | Mã hàng | Tần suất xuất | Giá trị | %  │   │
│  │ ──────────────────────────────────────────────  │   │
│  │ 1 | MAIN_gao01 | 156 lần/tháng | 25.2M | 18.5% │   │
│  │ 2 | MAIN_ruoc | 145 lần/tháng | 22.8M | 16.7%  │   │
│  │ 3 | OILF_dau01 | 138 lần/tháng | 19.5M | 14.3% │   │
│  │ ... (10 mã)                                     │   │
│  │ TỔNG NHÓM A: 109.2M (80%)                      │   │
│  └─────────────────────────────────────────────────┘   │
│                                                         │
│  🔵 NHÓM B (30% SKU - 15% Giá trị)                    │
│  • Tổng: 45 mã                                         │
│  • Giá trị: 20.5M (15%)                               │
│  • Tần suất: 3-10 lần/tháng                           │
│                                                         │
│  🟢 NHÓM C (50% SKU - 5% Giá trị)                     │
│  • Tổng: 75 mã                                         │
│  • Giá trị: 6.8M (5%)                                 │
│  • Tần suất: < 3 lần/tháng                            │
│                                                         │
│  💡 ĐỀ XUẤT:                                           │
│  ✅ Nhóm A: Đặt ở vị trí dễ tiếp cận, kiểm kê hàng tháng │
│  ⚠️ Nhóm B: Vị trí trung bình, kiểm kê hàng quý      │
│  🔍 Nhóm C: Xem xét thanh lý 15 mã tồn >180 ngày     │
│                                                         │
│  [📊 Chi tiết] [📥 Export] [📧 Gửi báo cáo]          │
└─────────────────────────────────────────────────────────┘
```

---

## 18. THIẾT KẾ DATABASE

### 18.1. Sơ đồ ERD (Entity Relationship Diagram)

```
┌──────────────┐      ┌──────────────┐      ┌──────────────┐
│   WAREHOUSE  │      │   LOCATION   │      │   PRODUCT    │
├──────────────┤      ├──────────────┤      ├──────────────┤
│ id (PK)      │─────<│ warehouse_id │      │ id (PK)      │
│ code         │      │ id (PK)      │      │ code         │
│ name         │      │ code         │      │ name         │
│ type         │      │ aisle        │      │ category_id  │
│ address      │      │ rack         │      │ unit         │
│ status       │      │ level        │      │ min_stock    │
└──────────────┘      │ status       │      │ max_stock    │
                      └──────────────┘      │ has_expiry   │
                                            └──────────────┘
                                                    │
                                                    │
┌──────────────┐                              ┌────▼─────────┐
│  INVENTORY   │                              │ PRODUCT_LOT  │
├──────────────┤                              ├──────────────┤
│ id (PK)      │<─────────────────────────────│ id (PK)      │
│ product_id   │                              │ product_id   │
│ location_id  │                              │ lot_number   │
│ lot_id       │                              │ mfg_date     │
│ quantity     │                              │ exp_date     │
│ status       │                              │ supplier_id  │
└──────────────┘                              └──────────────┘
       │                                             
       │                                             
┌──────▼───────┐      ┌──────────────┐      ┌──────────────┐
│ RECEIPT_DOC  │      │ ISSUE_DOC    │      │ QC_RESULT    │
├──────────────┤      ├──────────────┤      ├──────────────┤
│ id (PK)      │      │ id (PK)      │      │ id (PK)      │
│ doc_no       │      │ doc_no       │      │ receipt_id   │
│ doc_date     │      │ doc_date     │      │ inspector    │
│ warehouse_id │      │ warehouse_id │      │ inspect_date │
│ supplier_id  │      │ issue_to     │      │ result       │
│ status       │      │ status       │      │ note         │
└──────────────┘      └──────────────┘      └──────────────┘
       │                      │
       │                      │
┌──────▼──────┐      ┌────────▼─────┐
│ RECEIPT_DTL │      │ ISSUE_DTL    │
├─────────────┤      ├──────────────┤
│ id (PK)     │      │ id (PK)      │
│ receipt_id  │      │ issue_id     │
│ product_id  │      │ product_id   │
│ lot_id      │      │ lot_id       │
│ quantity    │      │ quantity     │
│ location_id │      │ location_id  │
└─────────────┘      └──────────────┘
```

### 18.2. Bảng chính

#### **Bảng: warehouses (Kho)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID kho |
| code | VARCHAR(20) | UNIQUE, NOT NULL | Mã kho (VD: ZN-WHRM-01) |
| name | VARCHAR(200) | NOT NULL | Tên kho |
| type | ENUM | NOT NULL | Loại kho (WHRM, WHSP, WHSF...) |
| address | TEXT | NULL | Địa chỉ |
| manager_id | INT | FK → users | Quản lý kho |
| status | ENUM | DEFAULT 'ACTIVE' | Trạng thái (ACTIVE, INACTIVE) |
| created_at | DATETIME | | Ngày tạo |
| updated_at | DATETIME | | Ngày cập nhật |

#### **Bảng: locations (Vị trí lưu kho)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID vị trí |
| warehouse_id | INT | FK → warehouses | Thuộc kho nào |
| code | VARCHAR(50) | UNIQUE, NOT NULL | Mã vị trí đầy đủ |
| aisle | VARCHAR(10) | NOT NULL | Dãy (VD: A01) |
| rack | VARCHAR(10) | NOT NULL | Kệ (VD: 05) |
| level | VARCHAR(10) | NOT NULL | Tầng (VD: 02) |
| capacity | DECIMAL(10,2) | NULL | Sức chứa (kg/m³) |
| status | ENUM | DEFAULT 'AVAILABLE' | AVAILABLE, OCCUPIED, BLOCKED |
| created_at | DATETIME | | |

#### **Bảng: products (Hàng hóa)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID hàng hóa |
| code | VARCHAR(50) | UNIQUE, NOT NULL | Mã hàng (VD: MAIN_gao01) |
| name | VARCHAR(200) | NOT NULL | Tên hàng |
| category_id | INT | FK → categories | Nhóm hàng |
| unit | VARCHAR(20) | NOT NULL | Đơn vị tính |
| min_stock | DECIMAL(10,2) | NULL | Tồn kho tối thiểu |
| max_stock | DECIMAL(10,2) | NULL | Tồn kho tối đa |
| reorder_point | DECIMAL(10,2) | NULL | Điểm đặt hàng lại |
| has_expiry | BOOLEAN | DEFAULT FALSE | Có hạn sử dụng không |
| shelf_life_days | INT | NULL | Thời hạn sử dụng (ngày) |
| abc_class | ENUM | NULL | Phân loại ABC |
| status | ENUM | DEFAULT 'ACTIVE' | ACTIVE, INACTIVE |
| created_at | DATETIME | | |

#### **Bảng: product_lots (Lot/Batch)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID lot |
| product_id | INT | FK → products | Hàng hóa |
| lot_number | VARCHAR(50) | NOT NULL | Số lot |
| mfg_date | DATE | NULL | Ngày sản xuất |
| exp_date | DATE | NULL | Hạn sử dụng |
| supplier_id | INT | FK → suppliers | Nhà cung cấp |
| unit_price | DECIMAL(15,2) | NULL | Đơn giá |
| created_at | DATETIME | | |
| INDEX | | (product_id, exp_date) | Index cho FEFO |

#### **Bảng: inventory (Tồn kho)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID tồn kho |
| product_id | INT | FK → products | Hàng hóa |
| location_id | INT | FK → locations | Vị trí |
| lot_id | INT | FK → product_lots | Lot |
| quantity | DECIMAL(10,2) | NOT NULL | Số lượng |
| status | ENUM | DEFAULT 'AVAILABLE' | AVAILABLE, QC_PENDING, QUARANTINE |
| last_updated | DATETIME | | Cập nhật cuối |
| UNIQUE | | (product_id, location_id, lot_id, status) | |

#### **Bảng: receipt_docs (Phiếu nhập kho)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID phiếu |
| doc_no | VARCHAR(50) | UNIQUE, NOT NULL | Số phiếu (PN-2025-0001) |
| doc_date | DATE | NOT NULL | Ngày nhập |
| warehouse_id | INT | FK → warehouses | Kho nhận |
| receipt_type | ENUM | NOT NULL | FROM_SUPPLIER, FROM_PRODUCTION... |
| supplier_id | INT | FK → suppliers | NCC (nếu từ NCC) |
| po_number | VARCHAR(50) | NULL | Số PO |
| status | ENUM | DEFAULT 'QC_PENDING' | QC_PENDING, RECEIVED, QUARANTINE, CANCELLED |
| created_by | INT | FK → users | Người tạo |
| approved_by | INT | FK → users | Người duyệt |
| note | TEXT | NULL | Ghi chú |
| created_at | DATETIME | | |

#### **Bảng: receipt_details (Chi tiết phiếu nhập)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID |
| receipt_id | INT | FK → receipt_docs | Phiếu nhập |
| product_id | INT | FK → products | Hàng hóa |
| lot_id | INT | FK → product_lots | Lot |
| quantity | DECIMAL(10,2) | NOT NULL | Số lượng |
| location_id | INT | FK → locations | Vị trí cất |
| unit_price | DECIMAL(15,2) | NULL | Đơn giá |
| total_amount | DECIMAL(15,2) | NULL | Thành tiền |

#### **Bảng: qc_results (Kết quả QC)**
| Cột | Kiểu | Ràng buộc | Mô tả |
|-----|------|-----------|-------|
| id | INT | PK, AUTO | ID |
| receipt_id | INT | FK → receipt_docs | Phiếu nhập |
| inspector_id | INT | FK → users | Người kiểm tra |
| inspect_date | DATETIME | NOT NULL | Ngày kiểm tra |
| result | ENUM | NOT NULL | PASS, FAIL |
| criteria_json | JSON | NULL | Chi tiết tiêu chí |
| images | JSON | NULL | Danh sách ảnh |
| note | TEXT | NULL | Ghi chú |
| created_at | DATETIME | | |

---

## 19. TÍCH HỢP VÀ API

### 19.1. REST API Endpoints

#### **Authentication**
```
POST /api/v1/auth/login
POST /api/v1/auth/logout
POST /api/v1/auth/refresh-token
```

#### **Inventory (Tồn kho)**
```
GET    /api/v1/inventory                    # Danh sách tồn kho
GET    /api/v1/inventory/:id                # Chi tiết tồn kho
GET    /api/v1/inventory/product/:productId # Tồn kho theo sản phẩm
GET    /api/v1/inventory/warehouse/:whId    # Tồn kho theo kho
GET    /api/v1/inventory/alerts              # Cảnh báo tồn kho
```

#### **Receipt (Phiếu nhập)**
```
GET    /api/v1/receipts                     # Danh sách phiếu nhập
POST   /api/v1/receipts                     # Tạo phiếu nhập
GET    /api/v1/receipts/:id                 # Chi tiết phiếu nhập
PUT    /api/v1/receipts/:id                 # Cập nhật phiếu nhập
DELETE /api/v1/receipts/:id                 # Hủy phiếu nhập
POST   /api/v1/receipts/:id/approve         # Duyệt phiếu nhập
```

#### **Issue (Phiếu xuất)**
```
GET    /api/v1/issues                       # Danh sách phiếu xuất
POST   /api/v1/issues                       # Tạo phiếu xuất
GET    /api/v1/issues/:id                   # Chi tiết phiếu xuất
POST   /api/v1/issues/:id/fefo-suggest      # Đề xuất FEFO
POST   /api/v1/issues/:id/confirm           # Xác nhận xuất kho
```

#### **QC (Kiểm tra chất lượng)**
```
GET    /api/v1/qc/queue                     # Queue chờ kiểm tra
POST   /api/v1/qc/results                   # Gửi kết quả QC
GET    /api/v1/qc/results/:id               # Chi tiết kết quả
GET    /api/v1/qc/statistics                # Thống kê QC
```

#### **Reports (Báo cáo)**
```
GET    /api/v1/reports/inventory            # Báo cáo tồn kho
GET    /api/v1/reports/transaction          # Báo cáo xuất nhập tồn
GET    /api/v1/reports/kpi                  # Báo cáo KPI
GET    /api/v1/reports/abc-analysis         # Phân tích ABC
POST   /api/v1/reports/export               # Export báo cáo
```

### 19.2. Webhook Events

**Các sự kiện cần gửi webhook:**

```javascript
// Khi tạo phiếu nhập mới
{
  "event": "receipt.created",
  "timestamp": "2025-10-15T10:30:00Z",
  "data": {
    "receipt_id": 892,
    "doc_no": "PN-2025-0892",
    "warehouse": "ZN-WHRM-01",
    "supplier": "Công ty A",
    "status": "QC_PENDING",
    "total_items": 2
  }
}

// Khi QC hoàn thành
{
  "event": "qc.completed",
  "timestamp": "2025-10-15T14:30:00Z",
  "data": {
    "receipt_id": 892,
    "result": "PASS",
    "inspector": "Trần Thị B"
  }
}

// Khi tồn kho xuống dưới min
{
  "event": "inventory.low_stock",
  "timestamp": "2025-10-15T16:00:00Z",
  "data": {
    "product_id": 123,
    "product_code": "PKG1_bao500",
    "current_qty": 50,
    "min_stock": 500,
    "warehouse": "ZN-WHSP-01"
  }
}

// Khi hàng gần hết hạn
{
  "event": "inventory.expiry_warning",
  "timestamp": "2025-10-15T18:00:00Z",
  "data": {
    "product_id": 45,
    "product_code": "MAIN_gao01",
    "lot_number": "20251006",
    "exp_date": "2025-11-15",
    "days_remaining": 30,
    "quantity": 500
  }
}
```

### 19.3. Integration với ERP

**Đồng bộ Master Data:**

```json
// Đồng bộ Sản phẩm từ ERP → WMS
POST /api/v1/sync/products
{
  "products": [
    {
      "erp_id": "P001",
      "code": "MAIN_gao01",
      "name": "Gạo nếp hạt ngắn",
      "category": "NVL chính",
      "unit": "kg",
      "min_stock": 500,
      "max_stock": 2000
    }
  ]
}

// Gửi Phiếu nhập từ WMS → ERP
POST /api/erp/v1/goods-receipt
{
  "wms_receipt_no": "PN-2025-0892",
  "receipt_date": "2025-10-15",
  "warehouse_code": "ZN-WHRM-01",
  "supplier_code": "SUP001",
  "po_number": "PO-2025-0123",
  "items": [
    {
      "product_code": "MAIN_gao01",
      "lot_number": "20251015",
      "quantity": 500,
      "unit_price": 18000,
      "total": 9000000
    }
  ],
  "total_amount": 9000000
}

// Gửi Phiếu xuất từ WMS → ERP
POST /api/erp/v1/goods-issue
{
  "wms_issue_no": "PX-2025-1524",
  "issue_date": "2025-10-15",
  "warehouse_code": "ZN-WHRM-01",
  "cost_center": "PRODUCTION",
  "items": [
    {
      "product_code": "MAIN_gao01",
      "lot_number": "20251006",
      "quantity": 50,
      "unit_price": 18000,
      "total": 900000
    }
  ],
  "total_amount": 900000
}
```

---

## 20. BẢO MẬT & AUDIT LOG

### 20.1. Yêu cầu Bảo mật

#### **Authentication & Authorization**
- Đăng nhập bằng username/password
- Session timeout: 8 giờ (làm việc)
- Đăng xuất tự động khi đóng browser
- 2FA (Two-Factor Authentication) cho Admin/Quản lý cấp cao

#### **Phân quyền**
- Role-Based Access Control (RBAC)
- Phân quyền đến từng chức năng (Read, Create, Update, Delete, Approve)
- Không cho phép một người tự duyệt phiếu do chính mình tạo
- Tách biệt quyền giữa các kho

#### **Mã hóa Dữ liệu**
- HTTPS bắt buộc cho tất cả API
- Mã hóa mật khẩu bằng bcrypt
- Mã hóa dữ liệu nhạy cảm trong database (giá cả, thông tin NCC...)
- Ẩn thông tin nhạy cảm trong logs

#### **Backup & Recovery**
- Auto backup database hàng ngày (2:00 AM)
- Giữ 30 bản backup gần nhất
- Backup transaction log mỗi 4 giờ
- Kiểm tra backup định kỳ (test restore)
- Lưu trữ backup ở 2 địa điểm khác nhau

### 20.2. Audit Log

**Ghi nhận các thao tác:**

| Thao tác | Thông tin ghi nhận |
|----------|-------------------|
| Đăng nhập/Đăng xuất | User, IP, Device, Thời gian |
| Tạo/Sửa/Xóa phiếu | User, Phiếu, Nội dung thay đổi (Old/New), Thời gian |
| Duyệt phiếu | User phê duyệt, Phiếu, Kết quả, Thời gian |
| Kiểm kê | User, Kế hoạch, Sai lệch, Thời gian |
| Điều chỉnh tồn kho | User, Sản phẩm, Lý do, SL cũ/mới, Thời gian |
| Export dữ liệu | User, Loại báo cáo, Filters, Thời gian |
| Thay đổi phân quyền | Admin, User bị thay đổi, Quyền cũ/mới, Thời gian |

**Cấu trúc Audit Log:**

```json
{
  "id": 12345,
  "timestamp": "2025-10-15T10:30:45Z",
  "user_id": 42,
  "username": "nguyenvana",
  "ip_address": "192.168.1.100",
  "action": "receipt.approve",
  "resource_type": "receipt_doc",
  "resource_id": 892,
  "changes": {
    "status": {
      "old": "QC_PENDING",
      "new": "RECEIVED"
    }
  },
  "metadata": {
    "warehouse": "ZN-WHRM-01",
    "doc_no": "PN-2025-0892"
  }
}
```

**Truy vấn Audit Log:**
- Xem lịch sử theo User
- Xem lịch sử theo Phiếu/Sản phẩm
- Xem lịch sử theo Thời gian
- Export audit log để điều tra

---

## 21. TRAINING & CHANGE MANAGEMENT

### 21.1. Kế hoạch Đào tạo

#### **Phase 1: Đào tạo IT Team (1 tuần)**
- Kiến trúc hệ thống
- Database design
- API documentation
- Deployment & monitoring
- Troubleshooting

#### **Phase 2: Đào tạo Key Users (2 tuần)**
**Nhóm 1: Quản lý Kho**
- Tổng quan hệ thống
- Dashboard & Báo cáo
- Duyệt phiếu nhập/xuất
- Quản lý vị trí kho
- Kiểm kê & xử lý sai lệch
- Cấu hình cảnh báo

**Nhóm 2: QA/QC**
- Queue kiểm tra
- Form kiểm tra chất lượng
- Upload ảnh minh chứng
- Xử lý SPKPH
- Báo cáo QC

**Nhóm 3: Nhân viên Kho**
- Tạo phiếu nhập/xuất
- Scan barcode/QR code
- Cập nhật vị trí hàng hóa
- Kiểm kê (mobile app)
- Xử lý tình huống thường gặp

#### **Phase 3: Đào tạo End Users (1 tuần)**
**Nhóm 4: Phòng Sản xuất**
- Tạo Phiếu Yêu cầu Vật tư
- Theo dõi trạng thái
- Xác nhận nhận hàng

**Nhóm 5: Phòng Kinh doanh**
- Tạo Yêu cầu Giao hàng
- Kiểm tra tồn kho khả dụng
- Theo dõi trạng thái đơn hàng

**Nhóm 6: Bộ phận Mua hàng**
- Xem báo cáo nhập hàng
- Đánh giá NCC
- Xử lý SPKPH

**Nhóm 7: Kế toán**
- Xem báo cáo giá trị tồn kho
- Export dữ liệu
- Đối chiếu với sổ sách

### 21.2. Tài liệu Hướng dẫn

**1. User Manual (Hướng dẫn Sử dụng)**
- 📖 File PDF 100-150 trang
- Ảnh chụp màn hình chi tiết
- Từng bước thực hiện
- FAQ (Câu hỏi thường gặp)
- Troubleshooting guide

**2. Quick Reference Guide (Tài liệu Tham khảo Nhanh)**
- 📄 File PDF 10-20 trang
- Các thao tác thường dùng
- Shortcut keys
- Format in A4 để dán tường

**3. Video Tutorials (Video Hướng dẫn)**
- 🎥 Mỗi chức năng 1 video 5-10 phút
- Có tiếng Việt
- Upload lên hệ thống nội bộ
- Tổng cộng: 30-40 video

**4. Mobile App Guide (Hướng dẫn App Mobile)**
- 📱 Dành cho nhân viên kho
- Hướng dẫn cài đặt, sử dụng
- Demo scan barcode/QR

### 21.3. Change Management

#### **Communication Plan (Kế hoạch Truyền thông)**

**T-60 ngày (2 tháng trước Go-live):**
- 📧 Email thông báo dự án cho toàn công ty
- 🎤 Kick-off meeting với các phòng ban
- 📊 Trình bày lợi ích của hệ thống mới

**T-30 ngày:**
- 📹 Video demo hệ thống
- 📧 Email chi tiết về lộ trình triển khai
- 💬 Q&A session

**T-14 ngày:**
- 🎓 Bắt đầu đào tạo Key Users
- 📋 Gửi lịch đào tạo cho End Users

**T-7 ngày:**
- ⚠️ Thông báo downtime (nếu có)
- 📋 Checklist chuẩn bị
- 📞 Hotline hỗ trợ

**T-Day (Go-live):**
- 🚀 Chính thức đưa vào vận hành
- 👥 Team hỗ trợ onsite
- 📱 Hotline 24/7

**T+7 ngày:**
- 📊 Thu thập feedback
- 🐛 Fix bugs nhanh
- 📧 Email cảm ơn & nhắc nhở

**T+30 ngày:**
- 📈 Báo cáo kết quả triển khai
- 🎖️ Ghi nhận đóng góp
- 🔧 Fine-tuning system

#### **Resistance Management (Quản lý Kháng cự)**

**Dấu hiệu kháng cự:**
- ❌ Không tham gia đào tạo
- ❌ Tiếp tục dùng quy trình cũ
- ❌ Phàn nàn hệ thống khó dùng
- ❌ Không nhập liệu đầy đủ

**Giải pháp:**
1. **Lắng nghe & Thấu hiểu**: Họp 1-1 để hiểu lo ngại
2. **Giải thích Lợi ích**: Tập trung vào lợi ích CÁ NHÂN họ nhận được
3. **Hỗ trợ Cá nhân hóa**: Đào tạo thêm nếu cần
4. **Tạo Champions**: Tìm người nhiệt tình để truyền cảm hứng
5. **Gamification**: Tặng quà cho người dùng tích cực
6. **Cuối cùng**: Áp dụng chính sách bắt buộc nếu cần

---

## 22. SUCCESS METRICS (CHỈ SỐ THÀNH CÔNG)

### 22.1. Sau 1 tháng Go-live

| Chỉ số | Mục tiêu | Cách đo |
|--------|---------|---------|
| **Adoption Rate** | ≥ 90% | % người dùng đăng nhập ≥ 1 lần/tuần |
| **Data Accuracy** | ≥ 95% | So sánh với kiểm kê thực tế |
| **Uptime** | ≥ 99% | Monitoring tool |
| **Avg Response Time** | < 2s | APM tool |
| **Support Tickets** | < 50 tickets | Helpdesk system |
| **User Satisfaction** | ≥ 4/5 | Survey |

### 22.2. Sau 3 tháng Go-live

| Chỉ số | Mục tiêu | Baseline (trước WMS) |
|--------|---------|---------------------|
| **Độ chính xác tồn kho** | ≥ 98% | 85% |
| **Thời gian xử lý xuất kho** | < 1.5h | 3-4h |
| **Tỷ lệ hàng hư hỏng** | < 0.3% | 1.2% |
| **Tuân thủ FEFO/FIFO** | ≥ 95% | 60% |
| **Số ngày tồn kho TB** | < 25 ngày | 40 ngày |
| **Năng suất nhân viên kho** | +30% | Baseline |

### 22.3. ROI (Return on Investment)

**Chi phí dự kiến:**
- Development: 800 triệu đồng
- Hardware (máy scan, tablet, server): 200 triệu đồng
- Training: 50 triệu đồng
- **Tổng: 1,050 triệu đồng**

**Lợi ích hàng năm (ước tính):**
- Giảm thất thoát/hư hỏng: 300 triệu đồng
- Tăng năng suất (tiết kiệm 2 FTE): 240 triệu đồng
- Giảm hàng tồn kho: 400 triệu đồng (freed-up cash)
- Giảm sai sót & xử lý khiếu nại: 60 triệu đồng
- **Tổng: 1,000 triệu đồng/năm**

**ROI:**
- Payback Period: 1.05 năm (~13 tháng)
- ROI Year 1: -5%
- ROI Year 2: +90%
- ROI Year 3: +186%

---

## 23. NEXT STEPS & FUTURE ENHANCEMENTS

### 23.1. Phase 1 (Đã phân tích trong tài liệu này)
- ✅ Module cốt lõi: Tồn kho, Nhập/Xuất, QC
- ✅ Quy trình nghiệp vụ cơ bản
- ✅ Báo cáo & Dashboard
- ✅ Tích hợp ERP/MES

### 23.2. Phase 2 (6 tháng sau Go-live)
- 🔮 **Dự báo Tồn kho bằng AI/ML**
    - Phân tích xu hướng tiêu thụ
    - Dự báo nhu cầu 30/60/90 ngày
    - Đề xuất đặt hàng tự động

- 📱 **Mobile App nâng cao**
    - Offline mode hoàn chỉnh
    - Voice command (ghi chú bằng giọng nói)
    - AR (Augmented Reality) để tìm vị trí hàng

- 🤖 **Tự động hóa nâng cao**
    - Auto-suggest vị trí cất hàng tối ưu
    - Auto-create PO khi tồn kho < reorder point
    - Auto-match PO vs Phiếu nhập

### 23.3. Phase 3 (12 tháng sau Go-live)
- 🚚 **Tích hợp IoT & Sensors**
    - Cảm biến nhiệt độ, độ ẩm
    - RFID tracking
    - Smart shelves (tự động cân đo)

- 🌐 **Multi-warehouse Advanced**
    - Auto-balancing stock giữa các kho
    - Cross-docking
    - Drop-shipping management

- 🔬 **Advanced Analytics**
    - Predictive maintenance (dự báo hỏng hóc thiết bị)
    - Supplier performance scoring
    - Warehouse space optimization

---

## 24. KẾT LUẬN

### 24.1. Tóm tắt

Tài liệu Business Analysis này đã phân tích toàn diện hệ thống Quản lý Kho cho Đại Long Foods, bao gồm:

✅ **8 kho** trong hệ thống (từ NVL đầu vào đến phân phối)
✅ **3 quy trình nghiệp vụ** chính đã được số hóa
✅ **Hệ thống nhãn hiệu** chuẩn hóa với FIFO/FEFO
✅ **6 module chức năng** cốt lõi
✅ **8 vai trò** phân quyền chi tiết
✅ **15+ báo cáo** & dashboard
✅ **Tích hợp** với ERP, MES, Accounting
✅ **Lộ trình triển khai** 10 tháng rõ ràng

### 24.2. Lợi ích Mong đợi

**Cho Doanh nghiệp:**
- 💰 Giảm 70% thất thoát & hư hỏng hàng hóa
- 📊 Tăng 30% năng suất kho vận
- ⚡ Giảm 60% thời gian xử lý xuất kho
- 🎯 Tăng độ chính xác tồn kho lên 98%+
- 💸 ROI trong vòng 13 tháng

**Cho Nhân viên:**
- 📱 Công việc dễ dàng hơn với mobile app
- 🚫 Giảm lỗi thủ công
- ⏰ Tiết kiệm thời gian giấy tờ
- 📈 Theo dõi hiệu suất rõ ràng
- 🎓 Nâng cao kỹ năng số hóa

**Cho Khách hàng:**
- ✅ Giao hàng nhanh, đúng hạn
- 🔍 Truy xuất nguồn gốc minh bạch
- 🌟 Chất lượng ổn định
- 💬 Giảm khiếu nại

### 24.3. Yếu tố Thành công

Để dự án thành công, cần đảm bảo:

1. **Cam kết từ Ban Lãnh đạo**: Hỗ trợ nguồn lực & thúc đẩy
2. **Team dự án mạnh**: BA, Developer, Tester có kinh nghiệm
3. **User Involvement**: Thu thập feedback liên tục
4. **Data Quality**: Chuẩn bị dữ liệu ban đầu tốt
5. **Training đầy đủ**: Đầu tư thời gian đào tạo
6. **Change Management**: Quản lý kháng cự tốt
7. **Support tốt**: Hotline 24/7 trong giai đoạn đầu

### 24.4. Rủi ro cần Lưu ý

⚠️ **Rủi ro cao nhất**: Nhân viên không quen dùng hệ thống mới
→ **Giảm thiểu**: Đào tạo kỹ, hỗ trợ tận tình, có incentive

⚠️ **Rủi ro thứ hai**: Dữ liệu ban đầu không chính xác
→ **Giảm thiểu**: Kiểm kê toàn diện trước khi triển khai

⚠️ **Rủi ro thứ ba**: Tích hợp ERP/MES gặp khó khăn
→ **Giảm thiểu**: Làm việc sớm với team ERP, có API doc rõ ràng

---

## 25. PHỤ LỤC

### 25.1. Danh sách Stakeholders

| STT | Bộ phận/Vai trò | Người liên hệ | Email | Ghi chú |
|-----|----------------|---------------|-------|---------|
| 1 | Giám đốc Điều hành | [Tên] | [Email] | Sponsor |
| 2 | Trưởng phòng Kho vận | [Tên] | [Email] | Key User |
| 3 | Trưởng phòng QA/QC | [Tên] | [Email] | Key User |
| 4 | Trưởng phòng Sản xuất | [Tên] | [Email] | End User |
| 5 | Trưởng phòng Kinh doanh | [Tên] | [Email] | End User |
| 6 | Trưởng phòng IT | [Tên] | [Email] | Technical Lead |
| 7 | Kế toán trưởng | [Tên] | [Email] | End User |

### 25.2. Tài liệu Tham khảo

1. **Quy trình hiện tại**
    - Quy trình Cấp phát NVL & Nhập kho TP
    - Quy trình Nhập kho & Kiểm tra Chất lượng
    - Quy trình Giao hàng (KDO-GNH-KHO)

2. **Biểu mẫu**
    - BM-SXC-NVL-2025-001: Phiếu YC Vật tư
    - PH-KDO-BM-099: Yêu cầu Giao hàng
    - Các biểu mẫu khác đã liệt kê

3. **Tiêu chuẩn ngành**
    - ISO 9001:2015 (Quản lý Chất lượng)
    - GMP (Good Manufacturing Practice)
    - HACCP (Hazard Analysis Critical Control Point)

### 25.3. Lịch sử Phiên bản

| Phiên bản | Ngày | Người thực hiện | Nội dung thay đổi |
|-----------|------|----------------|-------------------|
| 1.0 | 14/10/2025 | Business Analyst | Phiên bản đầu tiên - Full document |
| | | | |

### 25.4. Phê duyệt

**Tài liệu này cần được phê duyệt bởi:**

| Vai trò | Họ tên | Chữ ký | Ngày |
|---------|--------|--------|------|
| Người lập | Business Analyst | | 14/10/2025 |
| Trưởng phòng Kho vận | | | |
| Trưởng phòng IT | | | |
| Giám đốc Điều hành | | | |

---

## 📞 LIÊN HỆ HỖ TRỢ

**Trong quá trình triển khai, vui lòng liên hệ:**

📧 **Email**: wms-support@dailongfoods.com
📱 **Hotline**: 1900-xxxx (24/7)
💬 **Teams Channel**: WMS Project Team
📍 **Địa điểm**: Văn phòng IT, Tầng 2, Nhà máy Đại Long

---

**🎉 CẢM ƠN BẠN ĐÃ ĐỌC TÀI LIỆU!**

**Tài liệu này là cơ sở để triển khai Hệ thống Quản lý Kho hiện đại, giúp Đại Long Foods nâng cao hiệu quả vận hành và phục vụ khách hàng tốt hơn.**

**Chúc dự án thành công! 🚀**

---

*Tài liệu Business Analysis - Hệ thống Quản lý Kho*  
*Đại Long Foods - Phiên bản 1.0 - Ngày 14/10/2025*