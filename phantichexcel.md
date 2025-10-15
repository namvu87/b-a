# 📋 Business Analysis (BA) cho Hệ thống ERP Đại Long

Tôi sẽ thực hiện phân tích nghiệp vụ theo chuẩn BA chuyên nghiệp, bao gồm: **Requirements Analysis, Use Cases, Business Rules, Process Flows, và Acceptance Criteria**.

---

## 🎯 1. PHÂN TÍCH YÊU CẦU (Requirements Analysis)

### 1.1. Business Requirements (BR)

| ID | Yêu cầu nghiệp vụ | Mục tiêu | Stakeholder |
|---|---|---|---|
| BR-001 | Chuẩn hóa quy trình sản xuất | Giảm sai sót, tăng tính nhất quán | Ban lãnh đạo |
| BR-002 | Đồng bộ dữ liệu thời gian thực | Ra quyết định nhanh, giảm downtime | Giám đốc sản xuất |
| BR-003 | Tự động hóa báo cáo KPI | Giảm công việc thủ công, tăng độ chính xác | Quản lý các phòng ban |
| BR-004 | Tích hợp thiết bị IoT/PLC | Thu thập dữ liệu tự động | Phòng kỹ thuật |
| BR-005 | Truy xuất nguồn gốc sản phẩm | Đáp ứng ISO, audit | Phòng QA/QC |

### 1.2. Functional Requirements (FR) - Theo Module

#### 📊 Module: Planning & Scheduling

| ID | Chức năng | Mô tả chi tiết | Priority |
|---|---|---|---|
| FR-PL-001 | Tạo kế hoạch sản xuất tổng | Nhập đơn hàng/dự báo → tạo Production Order | High |
| FR-PL-002 | MRP tự động | Tính toán nhu cầu vật tư dựa trên BOM + tồn kho | High |
| FR-PL-003 | Điều độ Work Order | Phân bổ WO xuống Line/Station/Ca | High |
| FR-PL-004 | Quản lý năng lực | Theo dõi công suất, tải, bottleneck | Medium |
| FR-PL-005 | Xử lý thay đổi kế hoạch | Reschedule, cancel, merge WO | Medium |

**Business Rules:**
- **BR-PL-001**: Một PO phải có ít nhất 1 WO
- **BR-PL-002**: WO chỉ được phát hành khi đủ vật tư (hoặc có approval ngoại lệ)
- **BR-PL-003**: Công suất Line không vượt quá 100% trong 1 ca
- **BR-PL-004**: Thời gian changeover tối thiểu giữa 2 WO khác SKU: 30 phút

#### 🏭 Module: Production Execution (MES)

| ID | Chức năng | Mô tả chi tiết | Priority |
|---|---|---|---|
| FR-PR-001 | Start/Stop Work Order | Operator bắt đầu/kết thúc WO | High |
| FR-PR-002 | Ghi nhận sản lượng | Nhập số lượng OK, NG, Rework | High |
| FR-PR-003 | Theo dõi trạng thái Line | Real-time: Running, Idle, Down, Maintenance | High |
| FR-PR-004 | Ghi nhận Downtime | Chọn reason code, thời gian bắt đầu/kết thúc | High |
| FR-PR-005 | Tích hợp PLC/Sensor | Tự động đọc counter, speed, status | Medium |
| FR-PR-006 | Material consumption tracking | Ghi nhận vật tư tiêu hao thực tế | Medium |

**Business Rules:**
- **BR-PR-001**: Một Operator chỉ được Start 1 WO tại 1 thời điểm
- **BR-PR-002**: WO không thể Start nếu chưa được phát hành
- **BR-PR-003**: Downtime > 5 phút bắt buộc nhập Reason Code
- **BR-PR-004**: Sản lượng NG không được âm hoặc vượt quá tổng sản lượng
- **BR-PR-005**: WO tự động chuyển trạng thái "Completed" khi đạt 100% kế hoạch

#### ✅ Module: Quality Management

| ID | Chức năng | Mô tả chi tiết | Priority |
|---|---|---|---|
| FR-QM-001 | IQC - Kiểm tra đầu vào | Kiểm tra vật tư khi nhập kho | High |
| FR-QM-002 | IPQC - Kiểm tra quá trình | Kiểm tra tại các checkpoint trong line | High |
| FR-QM-003 | OQC - Kiểm tra đầu ra | Kiểm tra sản phẩm hoàn thiện | High |
| FR-QM-004 | Defect logging | Ghi nhận lỗi, phân loại, severity | High |
| FR-QM-005 | Non-conformance (NC) | Tạo, phân công, xử lý, đóng NC | High |
| FR-QM-006 | Root Cause Analysis | Công cụ phân tích nguyên nhân gốc (5 Why, Fishbone) | Medium |

**Business Rules:**
- **BR-QM-001**: Vật tư IQC "Reject" không được sử dụng cho sản xuất
- **BR-QM-002**: NC phải được phân công trong 4h từ lúc tạo
- **BR-QM-003**: NC không thể đóng nếu chưa có Root Cause
- **BR-QM-004**: Sản phẩm lỗi nghiêm trọng (Critical) phải cách ly ngay

#### 🔧 Module: Maintenance (CMMS)

| ID | Chức năng | Mô tả chi tiết | Priority |
|---|---|---|---|
| FR-MT-001 | Quản lý tài sản | Danh mục thiết bị, vị trí, specifications | High |
| FR-MT-002 | Preventive Maintenance | Lịch bảo trì định kỳ theo thời gian/counter | High |
| FR-MT-003 | Corrective Maintenance | Xử lý sự cố đột xuất | High |
| FR-MT-004 | Work Request | Tạo yêu cầu bảo trì từ Production/QC | High |
| FR-MT-005 | Spare Parts tracking | Quản lý phụ tùng, lịch sử thay thế | Medium |
| FR-MT-006 | Maintenance History | Lưu trữ lịch sử sửa chữa, chi phí | Medium |

**Business Rules:**
- **BR-MT-001**: PM quá hạn > 7 ngày → gửi alert cho Manager
- **BR-MT-002**: Thiết bị trong trạng thái "Down" không được Start WO
- **BR-MT-003**: Mỗi Maintenance Work phải ghi nhận thời gian thực tế
- **BR-MT-004**: Spare Part xuất kho phải link với Maintenance Work Order

#### 📦 Module: Inventory Management

| ID | Chức năng | Mô tả chi tiết | Priority |
|---|---|---|---|
| FR-IM-001 | Nhập/Xuất/Chuyển kho | Các giao dịch kho cơ bản | High |
| FR-IM-002 | Stock tracking | Theo dõi tồn kho theo Location/Lot/Batch | High |
| FR-IM-003 | Min/Max Stock Alert | Cảnh báo khi dưới min hoặc quá max | High |
| FR-IM-004 | Material Issue for WO | Cấp vật tư theo BOM cho Work Order | High |
| FR-IM-005 | Inventory Adjustment | Điều chỉnh tồn kho (kiểm kê, hao hụt) | Medium |
| FR-IM-006 | FIFO/FEFO Control | Quản lý xuất kho theo nguyên tắc | Medium |

**Business Rules:**
- **BR-IM-001**: Không được xuất kho số lượng > tồn kho available
- **BR-IM-002**: Vật tư có hạn sử dụng phải xuất theo FEFO
- **BR-IM-003**: Adjustment phải có lý do và approval (nếu > threshold)
- **BR-IM-004**: Min Stock = 10 ngày tiêu hao trung bình

#### 💰 Module: Procurement

| ID | Chức năng | Mô tả chi tiết | Priority |
|---|---|---|---|
| FR-PC-001 | Purchase Request | Tạo đề nghị mua hàng | High |
| FR-PC-002 | Purchase Order | Tạo, phê duyệt, gửi PO | High |
| FR-PC-003 | Delivery Tracking | Theo dõi tiến độ giao hàng | Medium |
| FR-PC-004 | GRN - Goods Receipt | Nhận hàng, nhập kho | High |
| FR-PC-005 | Supplier Management | Quản lý nhà cung cấp, đánh giá | Medium |

**Business Rules:**
- **BR-PC-001**: PR > 50 triệu phải được Director approve
- **BR-PC-002**: PO phải có ít nhất 2 nhà cung cấp quote (trừ single source)
- **BR-PC-003**: GRN phải match với PO (số lượng, chất lượng)

#### 👥 Module: HR & Timekeeping

| ID | Chức năng | Mô tả chi tiết | Priority |
|---|---|---|---|
| FR-HR-001 | Quản lý ca làm việc | Định nghĩa shift, lịch làm việc | High |
| FR-HR-002 | Phân công Operator | Gán nhân viên vào Line/Station | High |
| FR-HR-003 | Chấm công tự động | Tích hợp RFID/vân tay/MES login | High |
| FR-HR-004 | Productivity tracking | Ghi nhận năng suất cá nhân/tổ | Medium |

**Business Rules:**
- **BR-HR-001**: Một Operator không được phân công > 1 Line cùng lúc
- **BR-HR-002**: Overtime > 2h/ngày phải được approve

---

## 📝 2. USE CASES CHI TIẾT

### Use Case 1: Tạo và Thực Hiện Work Order

**Actor**: Planner (Primary), Operator (Primary), System (Secondary)

**Preconditions**:
- Production Order đã được tạo
- Đủ nguyên vật liệu trong kho
- Line sẵn sàng (không Down)

**Main Flow**:
1. Planner tạo Work Order từ Production Order
2. System kiểm tra điều kiện (vật tư, công suất)
3. Planner phê duyệt và phát hành WO
4. System gửi WO xuống Line/Station
5. Operator đăng nhập vào Station
6. Operator Start WO
7. System ghi nhận thời gian bắt đầu
8. Operator thực hiện sản xuất
9. Operator nhập sản lượng (OK/NG)
10. System cập nhật progress
11. Khi đủ số lượng, Operator Complete WO
12. System chuyển trạng thái WO → "Completed"
13. System tự động tạo QC Inspection Request

**Alternative Flows**:
- **A1**: Thiếu vật tư → System block Start, gửi alert cho Warehouse
- **A2**: Máy Down giữa chừng → Operator tạo Downtime Log → gọi Maintenance
- **A3**: Sản lượng NG cao → System alert QC Engineer

**Postconditions**:
- WO hoàn thành, data được ghi nhận
- Vật tư được trừ khỏi tồn kho
- Dashboard cập nhật real-time

**Business Rules Applied**:
- BR-PR-001, BR-PR-002, BR-PR-003, BR-PR-005

---

### Use Case 2: Xử Lý Non-conformance (NC)

**Actor**: QC Inspector (Primary), Production Manager (Secondary), Operator (Secondary)

**Preconditions**:
- Phát hiện lỗi trong quá trình IQC/IPQC/OQC

**Main Flow**:
1. QC Inspector phát hiện lỗi
2. QC tạo NC record (mã NC, severity, description)
3. System gửi notification cho QC Manager
4. QC Manager phân công xử lý NC
5. Assigned person điều tra nguyên nhân (Root Cause Analysis)
6. Đề xuất hành động: Rework / Scrap / Deviation
7. Manager approve hành động
8. Thực hiện hành động (Rework → quay lại Production)
9. QC verify kết quả
10. Đóng NC
11. System cập nhật metrics (NC count, response time)

**Alternative Flows**:
- **A1**: Lỗi Critical → ngay lập tức stop Line + alert Director
- **A2**: Không tìm ra Root Cause → escalate cho Technical Team

**Postconditions**:
- NC được xử lý và đóng
- Lessons learned được lưu trữ
- KPI được cập nhật

---

### Use Case 3: Preventive Maintenance Execution

**Actor**: Maintenance Planner (Primary), Technician (Primary)

**Preconditions**:
- Thiết bị đến kỳ bảo trì theo schedule

**Main Flow**:
1. System tự động tạo PM Work Order (7 ngày trước due date)
2. Maintenance Planner xem danh sách PM
3. Planner phân công Technician
4. System gửi notification cho Technician
5. Technician nhận task
6. Technician thực hiện PM (checklist, đo đạc)
7. Ghi nhận kết quả, thay thế spare parts (nếu có)
8. System trừ spare parts khỏi kho
9. Technician hoàn thành, cập nhật trạng thái thiết bị
10. System tính toán PM kỳ tiếp theo
11. Thiết bị chuyển về trạng thái "Ready"

**Alternative Flows**:
- **A1**: Phát hiện thiết bị hỏng trong PM → chuyển sang Corrective Maintenance
- **A2**: Thiếu spare part → tạo Purchase Request

---

## 🔄 3. BUSINESS PROCESS FLOWS

### Process 1: Order-to-Delivery Flow

```
[Nhận Đơn Hàng] 
    ↓
[Tạo Production Order] 
    ↓
[MRP Check] → Thiếu vật tư? → [Tạo PR] → [PO] → [GRN]
    ↓ Đủ
[Điều độ WO xuống Line]
    ↓
[Thực hiện Sản xuất]
    ↓
[QC Inspection]
    ↓ Pass
[Nhập kho thành phẩm]
    ↓
[Xuất hàng giao khách]
```

### Process 2: Downtime Resolution Flow

```
[Máy Down]
    ↓
[Operator tạo Downtime Log + Reason]
    ↓
[System check: Cần Maintenance?]
    ↓ Yes
[Tạo Maintenance Request]
    ↓
[Assign Technician]
    ↓
[Sửa chữa + ghi nhận]
    ↓
[Máy Ready]
    ↓
[Operator Resume WO]
```

---

## ✅ 4. ACCEPTANCE CRITERIA (Tiêu chí Chấp nhận)

### Epic: Production Execution Module

**Story 1**: Operator Start Work Order

**Acceptance Criteria**:
- [ ] Operator có thể login bằng RFID/barcode
- [ ] Hiển thị danh sách WO assigned cho Station
- [ ] Chỉ cho phép Start 1 WO tại 1 thời điểm
- [ ] System ghi nhận timestamp chính xác đến giây
- [ ] Nếu thiếu vật tư → hiển thị thông báo rõ ràng, không cho Start
- [ ] Sau Start → trạng thái WO chuyển "In Progress"
- [ ] Dashboard real-time cập nhật ngay

**Story 2**: Ghi nhận Downtime

**Acceptance Criteria**:
- [ ] Hiển thị danh sách Reason Code phân cấp (Mechanical, Electrical, Material, Operator...)
- [ ] Bắt buộc chọn Reason nếu downtime > 5 phút
- [ ] Ghi nhận thời gian Start/End tự động hoặc thủ công
- [ ] Tính toán duration chính xác
- [ ] Nếu là Maintenance → tự động tạo Maintenance Request
- [ ] Lưu vào history, cập nhật OEE ngay lập tức

---

## 📊 5. DATA REQUIREMENTS

### Master Data

| Entity | Key Attributes | Source | Update Frequency |
|---|---|---|---|
| Product | SKU, Name, BOM, Routing | Product Team | Weekly |
| Machine | Asset Code, Location, Specs | Engineering | Monthly |
| Operator | Employee ID, Skill Level | HR | Daily |
| Supplier | Supplier Code, Rating, Lead Time | Procurement | Monthly |

### Transactional Data

| Entity | Volume/Day | Retention | Backup |
|---|---|---|---|
| Work Order | 200-500 | 3 years | Daily |
| Production Log | 5,000-10,000 | 2 years | Daily |
| Quality Record | 1,000-2,000 | 5 years | Daily |
| Maintenance Log | 50-100 | 5 years | Daily |

---

## 🎭 6. USER ROLES & PERMISSIONS

| Role | Modules Access | Key Permissions |
|---|---|---|
| **Plant Manager** | All | View all reports, approve budget |
| **Production Manager** | Planning, MES, Dashboard | Create PO, approve WO changes |
| **Planner** | Planning, MES | Create/edit WO, reschedule |
| **Operator** | MES | Start/Stop WO, input data |
| **QC Inspector** | Quality, MES | Create NC, approve/reject |
| **Maintenance Tech** | Maintenance, Assets | Execute PM/CM, update asset status |
| **Warehouse Staff** | Inventory, Procurement | GRN, issue materials |
| **Procurement** | Procurement, Inventory | Create PR/PO, manage suppliers |

---

## 📈 7. KPI & METRICS TRACKING

### Production KPIs

| KPI | Formula | Target | Frequency |
|---|---|---|---|
| OEE | Availability × Performance × Quality | ≥ 85% | Real-time |
| Plan Achievement | Actual Output / Planned × 100% | ≥ 95% | Daily |
| Yield Rate | Good Units / Total Units × 100% | ≥ 98% | Shift |
| Cycle Time | Total Time / Units Produced | ≤ Target | Real-time |

### Quality KPIs

| KPI | Formula | Target | Frequency |
|---|---|---|---|
| Defect Rate | NG Units / Total × 100% | ≤ 2% | Shift |
| FPY | First Pass / Total × 100% | ≥ 95% | Daily |
| NC Response Time | Close Time - Create Time | ≤ 24h | Weekly |

### Maintenance KPIs

| KPI | Formula | Target | Frequency |
|---|---|---|---|
| MTBF | Operating Time / Failures | ≥ 500h | Monthly |
| MTTR | Repair Time / Failures | ≤ 4h | Monthly |
| PM Compliance | PM Done / PM Planned × 100% | ≥ 90% | Monthly |

---

## 🚀 8. IMPLEMENTATION PRIORITIES

### Phase 1 (MVP - 3 tháng):
- ✅ Production Execution (MES Core)
- ✅ Basic Quality (Defect logging)
- ✅ Simple Dashboard (OEE, Output)

### Phase 2 (6 tháng):
- ✅ Full Planning & Scheduling
- ✅ Inventory Management
- ✅ Maintenance (CMMS)

### Phase 3 (9 tháng):
- ✅ Advanced Quality (Root Cause Analysis)
- ✅ Procurement Integration
- ✅ HR & Timekeeping
- ✅ Advanced Analytics

---

## 📋 9. ASSUMPTIONS & CONSTRAINTS

**Assumptions**:
- Nhà máy có kết nối mạng ổn định tại các line
- Thiết bị PLC/Sensor có thể giao tiếp qua OPC-UA hoặc Modbus
- Nhân viên có thiết bị (tablet/PC) tại Station
- Data từ hệ thống cũ có thể export/migrate

**Constraints**:
- Budget giới hạn cho hardware (sensors, tablets)
- Không được gián đoạn sản xuất trong triển khai
- Tuân thủ ISO 9001, ISO 14001 hiện tại
- Bảo mật dữ liệu sản xuất

---

## 💬 Tiếp theo bạn muốn:

1. **Chi tiết hóa Use Cases** cho từng module cụ thể?
2. **User Stories & Sprint Planning** theo Agile/Scrum?
3. **Mockups/Wireframes** cho giao diện chính?
4. **Integration Requirements** với hệ thống kế toán/ERP hiện tại?
5. **Test Cases** và Test Scenarios chi tiết?

Bạn muốn đi sâu vào phần nào? 🎯