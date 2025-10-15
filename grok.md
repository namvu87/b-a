### Phân Tích Quy Trình Quản Lý Kho Của Công Ty Đại Long

Dựa trên ba tài liệu được cung cấp (ZN-WHRM-01_Bo_Nhan_Kho_DaiLong.xlsx, ZN-WHRM-01_Layout_Kho_NVL_DaiLong.xlsx, và ST-KHV-01 - SỔ TAY QUẢN TRỊ KHO VẬN CHUYÊN NGHIỆP.docx), tôi đã phân tích quy trình quản lý kho của Công ty Đại Long (chuyên sản xuất và thương mại thực phẩm từ gạo, như cơm cháy, ruốc). Quy trình này được thiết kế chuyên nghiệp, tuân thủ các nguyên tắc như FIFO/FEFO (First Expired First Out), 5S, an toàn lao động, và tích hợp với các bộ phận khác. Nó tập trung vào việc quản lý nguyên vật liệu (NVL), bán thành phẩm (BTP), và thành phẩm (TP), với trọng tâm là kho NVL (Nguyên Vật Liệu) và kho vật tư.

Quy trình được mô tả chi tiết nhất trong sổ tay (docx), trong khi hai file Excel cung cấp dữ liệu hỗ trợ về layout kho, vị trí hàng hóa, danh mục NVL, và nhãn mác. Tổng quan, quy trình quản lý kho được chia thành các giai đoạn chính: **Nhập kho**, **Lưu trữ và sắp xếp**, **Cấp phát/Xuất kho**, **Kiểm kê**, và **Xử lý sự cố (hàng trả, hư hỏng)**. Nó nhấn mạnh tính chính xác, an toàn, và phối hợp liên bộ phận, với hệ thống mã hóa vị trí (ví dụ: A-01-01-T1) và nhãn mác (xanh/vàng/đỏ cho tình trạng).

#### 1. Tổng Quan Quy Trình Quản Lý Kho
- **Mục tiêu chính**: Bảo vệ tài sản, đảm bảo dòng chảy vật chất chính xác, tuân thủ chất lượng (QA/QC), và hỗ trợ sản xuất/kinh doanh. Kho được coi là "người gác đền" của chuỗi cung ứng.
- **Cấu trúc kho**:
    - Kho NVL (ZN-WHRM-01): Quản lý gạo, gia vị, topping, dầu, bao bì (phân loại theo nhóm: MAIN, SPIC, TOPP, OILF, PKG1/2/3, LABL, v.v.).
    - Kho Vật tư & Phụ tùng (ZN-WHSP-01): Hóa chất, công cụ, phụ tùng bảo trì.
    - Phân khu: A (NVL chính như gạo, dầu), B (Gia vị & Topping), C (Bao bì cấp 1, tem nhãn), D (Bao bì cấp 2-3), IQC (Kiểm tra đầu vào), lối đi (8% diện tích).
    - Layout: Diện tích tổng ~250m², phân theo ABC (A: tần suất cao gần cửa xuất; B/C: xa hơn). Mã vị trí: [Khu]-[Dãy]-[Kệ]-[Tầng] (ví dụ: A-01-01-T1 cho gạo lứt).
- **Nguyên tắc bất biến (từ sổ tay)**:
    - Chính xác tuyệt đối (số liệu khớp thực tế).
    - FIFO/FEFO (xuất lô hết hạn trước).
    - Sẵn sàng truy xuất (mọi hàng có nhãn: vị trí, hàng hóa, tình trạng - xanh: passed, vàng: hold, đỏ: rejected).
    - An toàn trên hết (PCCC, bảo hộ lao động, xe nâng).
    - 5S (Sàng lọc, Sắp xếp, Sạch sẽ, Sẵn sàng, Săn sóc).
- **Công cụ hỗ trợ**: Thẻ kho (template cho nhập/xuất/tồn), nhãn mác (màu sắc quy định), biểu mẫu (ví dụ: Phiếu Nhập/Xuất kho), hệ thống AMIS (phần mềm quản lý tồn kho).
- **Tổ chức**: Tổ Kho (TO-KHO: nhập/lưu/cấp phát/kiểm kê) và Tổ Giao nhận (TO-GNH: soạn/đóng gói/bàn giao/xử lý trả hàng). Phối hợp với Mua hàng, QA/QC, Sản xuất, Kinh doanh, Kế toán.

#### 2. Chi Tiết Các Giai Đoạn Quy Trình
Dựa trên sổ tay (Phần C: Hướng dẫn thực hành), quy trình được "cầm tay chỉ việc" với các bước cụ thể.

- **Nhập Kho NVL/TP (7 bước cho NVL, 4 bước cho TP)**:
    1. Tiếp nhận thông tin (từ Mua hàng: Thông báo hàng về; kiểm tra chứng từ như Hóa đơn, Giấy kiểm dịch).
    2. Kiểm tra cảm quan (số lượng, bao bì, hạn sử dụng; từ chối nếu hư hỏng).
    3. Lấy mẫu QA/QC (bộ phận QA kiểm tra chất lượng; dán nhãn vàng nếu hold).
    4. Cập nhật hệ thống (lập Phiếu Nhập kho trên AMIS; cập nhật thẻ kho).
    5. Sắp xếp lên kệ (theo vị trí mã hóa từ file Excel).
    6. Ký bàn giao (với nhà cung cấp/tài xế).
    7. Lưu chứng từ (bàn giao Kế toán).
    - Ví dụ: Nhập gạo (MAIN_gaot03) vào vị trí A-01-02-T1, cập nhật So_Lo, HSD, Ngay_Nhap.

- **Lưu Trữ Và Sắp Xếp**:
    - Sử dụng pallet, xếp chồng khoa học (nặng dưới, nhẹ trên; chèn lót chống đổ).
    - Tuân thủ FEFO; khu vực riêng cho hàng hold/rejected.
    - Áp dụng 5S: Sắp xếp theo nhóm NVL (từ file layout: MAIN ở A, SPIC ở B).
    - Giám sát: Quạt hút ẩm (khu B), khay chống tràn (dầu ở A).

- **Cấp Phát Vật Tư Cho Sản Xuất / Xuất Kho Bán Hàng (5 bước cấp phát, 5 bước xuất)**:
    - Nhận yêu cầu (từ Sản xuất: Yêu cầu cấp NVL; từ Kinh doanh: Yêu cầu giao hàng).
    - Kiểm tra tồn kho (trên AMIS/thẻ kho).
    - Soạn hàng (picking theo FEFO; kiểm đếm chéo).
    - Đóng gói/dán nhãn (niêm phong nếu cần).
    - Bàn giao (ký Biên bản bàn giao; cập nhật AMIS: Xuất kho, giảm tồn).
    - Ví dụ: Cấp gạo ST25 (MAIN_gaot03) từ vị trí A-01-01-T1, ghi Nhap/Xuat/Ton trên thẻ kho.

- **Kiểm Kê**:
    - Hàng ngày/định kỳ: Đếm tay, đối chiếu AMIS vs thực tế (sử dụng Phiếu Kiểm kê).
    - Xử lý chênh lệch: Báo cáo Kế toán/QA nếu phát hiện mất mát/hư hỏng.

- **Xử Lý Hàng Trả Về / Hư Hỏng**:
    - Tiếp nhận (từ tài xế: Biên bản trả về).
    - Phân loại (xanh: tái nhập; vàng: chờ QA; đỏ: hủy).
    - Cập nhật AMIS (nhập kho tạm/ảo nếu chờ xử lý).
    - Hủy hàng: Lập Phiếu Xuất hủy, bàn giao Kế toán.

- **Phối Hợp Liên Bộ Phận (từ Phần D sổ tay)**:
    - Với Mua hàng/QA: Kiểm tra đầu vào (QA quyết định chất lượng).
    - Với Sản xuất: Cấp NVL (dựa lệnh sản xuất), nhận TP.
    - Với Kinh doanh: Xuất hàng (theo yêu cầu giao, giờ cut-off).
    - Với Kế toán: Bàn giao chứng từ (hàng ngày), kiểm kê chung.

#### 3. Đánh Giá Quy Trình
- **Ưu điểm**: Chuẩn hóa cao (mã hóa, nhãn mác, biểu mẫu), tích hợp an toàn/5S, hỗ trợ truy xuất nhanh (FEFO cho thực phẩm). Dữ liệu từ Excel dễ in ấn/in nhãn.
- **Hạn chế**: Phụ thuộc thủ công (thẻ kho viết tay, kiểm đếm tay), rủi ro lỗi con người nếu không tuân thủ. Layout cố định có thể kém linh hoạt nếu thay đổi sản phẩm.

### Phân Tích Nghiệp Vụ Của Phần Mềm Quản Lý Kho
Dựa trên quy trình trên, phần mềm quản lý kho (giả sử là AMIS như đề cập trong sổ tay, hoặc một hệ thống tương tự) cần hỗ trợ các nghiệp vụ để tự động hóa, giảm lỗi thủ công, và tích hợp dữ liệu. Nghiệp vụ được phân tích theo module chính, dựa trên nhu cầu từ quy trình: Theo dõi tồn kho thời gian thực, mã hóa vị trí, tích hợp QA/QC, và báo cáo. Phần mềm phải hỗ trợ FEFO, mã QR/Barcode cho nhãn, và tích hợp với ERP (như AMIS cho hạch toán).

#### 1. Tổng Quan Nghiệp Vụ Phần Mềm
- **Mục tiêu**: Thay thế/thêm vào thủ công (thẻ kho, Excel), đảm bảo dữ liệu đồng bộ, truy xuất nhanh, cảnh báo (hết hạn, tồn thấp).
- **Yêu cầu cốt lõi**: Hỗ trợ đa kho (NVL, Vật tư), mã hóa vị trí (tích hợp layout từ Excel), quản lý lô (So_Lo, HSD), và tích hợp API với các bộ phận (QA, SX, KD, KT).
- **Công nghệ gợi ý**: Web/mobile app với barcode scanner; database SQL cho tồn kho; AI cho dự báo tồn.

#### 2. Các Module Nghiệp Vụ Chính
Dựa trên quy trình, tôi phân loại thành các module với chức năng cụ thể:

| Module | Nghiệp Vụ Chính | Dựa Trên Quy Trình | Tích Hợp |
|--------|----------------|---------------------|----------|
| **Quản Lý Danh Mục & Layout** | - Quản lý danh mục NVL (tên, mã, nhóm, DVT từ file Excel: MAIN_gaot03, SPIC_muoi01).<br>- Thiết lập layout kho (vị trí: A-01-01-T1; phân khu A/B/C/D).<br>- In nhãn (vị trí, hàng hóa, tình trạng: xanh/vàng/đỏ).<br>- Cập nhật tự động từ Excel import. | Dựa trên file layout và danh mục NVL; hỗ trợ mã hóa vị trí để tìm kiếm nhanh. | Import/Export Excel; tích hợp in ấn (QR code cho vị trí). |
| **Nhập Kho** | - Tạo Phiếu Nhập (tự động kiểm tra chứng từ từ Mua hàng).<br>- Quét barcode/lô để cập nhật So_Lo, HSD, Ngay_Nhap.<br>- Cảnh báo nếu hàng hold (tích hợp QA).<br>- Cập nhật tồn kho thời gian thực. | 7 bước nhập NVL; hỗ trợ lấy mẫu QA. | Tích hợp QA/QC (gửi yêu cầu kiểm tra); AMIS cho hạch toán nhập. |
| **Lưu Trữ & Sắp Xếp** | - Gợi ý vị trí lưu (dựa FEFO, nhóm NVL; tránh đầy kệ).<br>- Theo dõi tình trạng (hold/passed/rejected).<br>- Cảnh báo ẩm/môi trường (nếu tích hợp sensor). | Sắp xếp theo layout; 5S kiểm tra định kỳ. | Mobile app cho nhân viên kho (quét vị trí để xác nhận). |
| **Cấp Phát / Xuất Kho** | - Xử lý yêu cầu từ SX/KD (tạo Phiếu Xuất tự động).<br>- Picking theo FEFO (gợi ý lô hết hạn trước).<br>- Kiểm đếm chéo (app xác nhận số lượng).<br>- In Biên bản bàn giao. | 5 bước cấp phát/xuất; soạn hàng, đóng gói. | Tích hợp SX (lệnh sản xuất), KD (yêu cầu giao); AMIS giảm tồn. |
| **Kiểm Kê & Báo Cáo** | - Lập kế hoạch kiểm kê (hàng ngày/định kỳ).<br>- So sánh tồn thực tế vs hệ thống (quét barcode).<br>- Báo cáo chênh lệch, tồn kho (biểu đồ, bảng).<br>- Dự báo tồn thấp/hết hạn. | Kiểm kê tay; báo cáo hàng hỏng. | Tích hợp KT (báo cáo tài chính); export Excel/PDF. |
| **Xử Lý Sự Cố** | - Quản lý hàng trả/hỏng (nhập kho tạm, phân loại xanh/vàng/đỏ).<br>- Tạo Phiếu Hủy; theo dõi lý do trả hàng.<br>- Cảnh báo rủi ro (mất mát, hư hỏng). | 4 bước xử lý trả hàng; hủy theo QA. | Tích hợp QA (kết luận chất lượng); KD (xử lý khiếu nại). |
| **An Toàn & Phối Hợp** | - Checklist 5S/an toàn (nhắc nhở PCCC, bảo hộ).<br>- Portal phối hợp (gửi thông báo đến bộ phận khác).<br>- Quyền truy cập (Thủ kho: cập nhật; KT: xem báo cáo). | Nguyên tắc an toàn; phối hợp liên bộ. | API với AMIS/ERP; email/SMS cảnh báo. |

#### 3. Đánh Giá Và Gợi Ý Cải Tiến Phần Mềm
- **Ưu điểm dựa trên quy trình**: Phần mềm có thể tự động hóa 70-80% thủ công (thẻ kho -> digital; Excel -> database), giảm lỗi, hỗ trợ FEFO tự động.
- **Hạn chế tiềm ẩn**: Nếu không tích hợp tốt với AMIS, có thể dẫn đến dữ liệu không đồng bộ. Cần mobile app cho nhân viên kho để quét barcode thời gian thực.
- **Gợi ý**: Thêm AI dự báo nhu cầu NVL dựa trên lịch SX; tích hợp IoT cho giám sát nhiệt độ/ẩm (đặc biệt khu B: gia vị). Chi phí phát triển: Tập trung module cốt lõi (Nhập/Xuất/Tồn) trước, sau mở rộng.