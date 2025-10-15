Tôi sẽ phân tích chi tiết hệ thống quản lý kho của Đại Long Foods dựa trên các tài liệu bạn cung cấp:

## 📊 TỔNG QUAN HỆ THỐNG KHO

### 1. **CẤU TRÚC HỆ THỐNG KHO** (8 kho chính)

**A. Nhóm Kho Đầu Vào:**
- **ZN-WHRM-01**: Kho Nguyên vật liệu (gạo, thịt, gia vị)
- **ZN-WHSP-01**: Kho Vật tư & Phụ tùng (bao bì, nhãn mác, phụ tùng thay thế)

**B. Nhóm Kho Nội Bộ Sản Xuất:**
- **ZN-WHSF-01**: Kho Bán thành phẩm (sản phẩm đang chế biến)
- **ZN-WHFG-01**: Kho Thành phẩm Nhà máy (sản phẩm hoàn thiện)

**C. Nhóm Kho Phân Phối:**
- **ZN-WHDC-01**: Trung tâm Phân phối
- **ZN-WHSR-01**: Kho Showroom
- Kho Vùng (đề xuất - Miền Bắc/Trung/Nam)
- Kho TMĐT (đề xuất - chuyên hàng online)

---

## 🔄 CÁC QUY TRÌNH CHÍNH

### 2. **QUY TRÌNH NHẬP KHO & KIỂM TRA CHẤT LƯỢNG**

**Bước 1: Tiếp nhận hàng hóa**
- NCC giao hàng + chứng từ
- Tổ Kho đối chiếu PO
- Thông báo QA/QC kiểm tra
- Dán nhãn VÀNG "CHỜ KIỂM TRA"

**Bước 2: Kiểm tra chất lượng**
- QA/QC lấy mẫu & kiểm tra
- Lập Biên bản kiểm tra

**Bước 3a: Nếu ĐẠT**
- ✅ Nhập kho chính thức
- Xác nhận nhận hàng
- Đề xuất thanh toán

**Bước 3b: Nếu KHÔNG ĐẠT**
- 🚫 Cách ly hàng hóa
- Báo cáo SPKPH (Sản phẩm không phù hợp)
- Thương lượng NCC → Trả hàng/Đổi hàng/Giảm giá

---

### 3. **QUY TRÌNH CẤP PHÁT NVL & NHẬP KHO TP**

**Luồng 1: Cấp phát Nguyên vật liệu**
1. Phòng SX gửi Phiếu Yêu cầu Vật tư (BM-SXC-NVL-2025-001)
2. Kho kiểm tra tồn kho & Soạn hàng theo **FEFO**
3. Yêu cầu cử người nhận hàng
4. **KIỂM ĐẾM TAY BA** tại Kho (SX + Kho cùng đếm)
5. Lập Phiếu Xuất kho Nội bộ
6. Bàn giao vật tư cho SX

**Luồng 2: Nhập kho Thành phẩm**
1. SX thông báo có lô TP & Biên bản Bàn giao
2. **KIỂM ĐẾM TAY BA** tại Xưởng (SX + Kho cùng đếm)
3. Ký xác nhận Biên bản Bàn giao
4. Kho lập Phiếu Nhập kho & Cất hàng vào vị trí

---

### 4. **QUY TRÌNH GIAO HÀNG (PHỐI HỢP KINH DOANH - KHO - GIAO NHẬN)**

**Luồng 1: Yêu cầu & Lập kế hoạch**
1. Kinh doanh gửi YCGH đã duyệt (PH-KDO-BM-099)
2. Giao nhận kiểm tra tồn kho với Kho
3. Kho xác nhận tồn kho
    - ⚠️ Nếu thiếu hàng → Phản hồi Kinh doanh
    - ✅ Nếu đủ hàng → Lập Kế hoạch Giao hàng (TO-GNH-BM-2025-001)
4. Thông báo lịch giao dự kiến cho Kinh doanh

**Luồng 2: Thực hiện Giao hàng**
1. Thực hiện giao hàng theo kế hoạch
2. Bàn giao chứng từ có ký nhận
3. Xác nhận giao hàng thành công

**Luồng 3: Xử lý Sự cố**
1. Xử lý hàng trả về
2. Báo cáo giao không thành công
3. Làm việc lại với khách hàng
4. Tạo YCGH mới nếu cần

---

## 📍 HỆ THỐNG MÃ HOÁ VÀ LAYOUT

### 5. **MÃ ĐỊNH VỊ KHO**

**Cấu trúc: ZN-WHRM-01-A01-05-02**
- **ZN**: Công ty/Tên kho
- **WHRM**: Warehouse Raw Material (Kho NVL)
- **01**: Mã khu vực/Tầng
- **A01**: Dãy kệ A01
- **05**: Kệ số 05
- **02**: Tầng 02 của kệ

### 6. **LAYOUT KHO (Từ cửa nhập → cửa xuất SX)**

```
[CỬA NHẬP HÀNG - DOCK 1]
         ↓
[KHU NHẬN HÀNG] | [KHU QC]
    (Nhãn VÀNG)  |  (Kiểm tra)
         ↓
[═══ LỐI ĐI CHÍNH ═══]
         ↓
[DÃY A: Bao bì]     | [DÃY C: Gia vị & Topping]
(Hàng B, C)          | (Hàng B)
Kệ A01→A10           | Kệ C01→C10
         ↓
[═══ LỐI ĐI CHÍNH ═══]
         ↓
[DÃY B: Bao bì]     | [DÃY D: NVL CHÍNH]
(Hàng C)             | (Hàng A - Tần suất cao)
Kệ B01→B10           | Kệ D01→D10
         ↓
[═══ LỐI ĐI CHÍNH ═══]
         ↓
[KHU SOẠN HÀNG]     | [KHU CHỜ CẤP PHÁT]
         ↓
[CỬA XUẤT SANG XƯỞNG SX]
```

---

## 🏷️ HỆ THỐNG NHÃN HIỆU

### 7. **3 LOẠI NHÃN CHÍNH**

**A. Nhãn Vị trí (Cố định - trên beam kệ)**
- Màu: Xanh dương
- Nội dung: ZN-WHRM-01-A01-05-02
- Vị trí: Dán chính giữa thanh beam, dễ nhìn

**B. Nhãn Hàng hóa (Trên pallet/thùng)**
- Màu: Trắng, viền xám
- Nội dung:
    - Tên hàng: Gạo nếp hạt ngắn
    - Mã hàng: MAIN_gaon01
    - Số lô: 20251006
    - NSX: 01/10/2025
    - HSD: 01/10/2026
    - Số lượng: 50 bao x 25kg

**C. Nhãn Tình trạng (Tạm thời)**
- Màu: Đỏ (cảnh báo), Vàng (chờ kiểm)
- Nội dung: "HÀNG CHỜ KIỂM TRA"
- Vị trí: Đè lên nhãn hàng hóa hoặc dán bên cạnh

---

## 📋 NGUYÊN TẮC FIFO/FEFO

### 8. **NGUYÊN TẮC SẮP XẾP**

**Nhìn từ lối đi vào kệ:**
```
[SAU CÙNG - Hàng mới]
  (Date xa hơn)
         ↑
    Đặt vào sau
         ↑
[NGOÀI - Hàng cũ]
  (Date gần hơn)
         ↓
   Lấy ra trước
         ↓
    [LỐI ĐI]
```

**Quy tắc:**
- FIFO: First-In, First-Out (Hàng nhập trước xuất trước)
- FEFO: First-Expired, First-Out (Hàng hết hạn trước xuất trước)
- Hàng mới → Đặt SAU CÙNG
- Hàng cũ → Nằm NGOÀI, dễ lấy

---

## 🎯 ĐÁNH GIÁ HỆ THỐNG

### **ĐIỂM MẠNH:**
✅ Hệ thống mã hóa rõ ràng, dễ truy xuất
✅ Quy trình kiểm đếm tay ba (minh bạch)
✅ Phân loại kho rõ ràng theo chức năng
✅ Áp dụng FIFO/FEFO đúng chuẩn
✅ Layout kho tối ưu (hàng A gần cửa xuất)

### **GỢI Ý CẢI TIẾN:**
🔸 Triển khai WMS (Warehouse Management System)
🔸 Sử dụng mã vạch/QR code tự động
🔸 Lắp đặt camera giám sát kho
🔸 Áp dụng ABC analysis cho tồn kho
🔸 Thiết lập KPI cho từng quy trình

---

Bạn có muốn tôi phân tích sâu hơn về phần nào trong hệ thống này không?