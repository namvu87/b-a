# 📋 BUSINESS ANALYSIS - HỆ THỐNG ERP ĐẠI LONG
## Tài liệu phân tích nghiệp vụ toàn diện

---

## 📑 MỤC LỤC

1. [Tổng quan dự án](#overview)
2. [Wireframes & UI/UX đã thiết kế](#wireframes)
3. [User Stories chi tiết](#user-stories)
4. [Test Cases & Scenarios](#test-cases)
5. [Integration Requirements](#integration)
6. [Data Flow Diagrams](#data-flow)
7. [Business Rules Catalog](#business-rules)
8. [Implementation Roadmap](#roadmap)

---

<a name="overview"></a>
## 1. 📊 TỔNG QUAN DỰ ÁN

### 1.1. Mục tiêu kinh doanh

| Mục tiêu | Chỉ số đo lường | Mục tiêu |
|----------|-----------------|----------|
| Tăng năng suất sản xuất | OEE | Từ 75% → 85% |
| Giảm downtime | MTTR | Từ 6h → 3h |
| Cải thiện chất lượng | Defect Rate | Từ 5% → 2% |
| Tự động hóa báo cáo | Thời gian tạo báo cáo | Từ 4h → 5 phút |
| Truy xuất nguồn gốc | Thời gian truy xuất | Từ 2 ngày → 10 phút |

### 1.2. Phạm vi dự án

**Phase 1 (3 tháng):**
- ✅ Production Execution (MES Core)
- ✅ Basic Quality Management
- ✅ Real-time Dashboard
- ✅ Operator Station Interface

**Phase 2 (6 tháng):**
- ✅ Planning & Scheduling
- ✅ Inventory Management
- ✅ Maintenance (CMMS)
- ✅ Material Issue & Consumption

**Phase 3 (9 tháng):**
- ✅ Advanced Quality (NC, Root Cause)
- ✅ Procurement Integration
- ✅ HR & Timekeeping
- ✅ Advanced Analytics & BI

---

<a name="wireframes"></a>
## 2. 🎨 WIREFRAMES & UI/UX ĐÃ THIẾT KẾ

### 2.1. Operator Station Interface
**Mục đích:** Màn hình chính cho operator thực hiện work order

**Các tính năng chính:**
- ✓ Hiển thị thông tin Work Order đang thực hiện
- ✓ Nhập sản lượng OK/NG/Rework realtime
- ✓ Theo dõi tiến độ (progress bar)
- ✓ Timer hiển thị thời gian sản xuất
- ✓ KPI cards (OEE, Yield, Performance)
- ✓ Nút Start/Pause/Complete WO
- ✓ Báo cáo downtime
- ✓ Lịch sử hoạt động

**Design principles áp dụng:**
- Clean & minimal interface để operator dễ sử dụng
- Large fonts & buttons (touch-friendly)
- Color coding rõ ràng (green=OK, red=NG, orange=rework)
- Auto-save mọi 30 giây
- Real-time updates không cần refresh

### 2.2. Production Dashboard
**Mục đích:** Giám sát tổng quan toàn nhà máy cho managers

**Các tính năng chính:**
- ✓ KPI cards tổng hợp (Total Output, OEE, Quality, Downtime)
- ✓ Chart sản lượng theo giờ (Bar chart)
- ✓ Donut chart phân bổ trạng thái (Running/Idle/Down)
- ✓ Line status cards với metrics realtime
- ✓ Work Orders table với progress
- ✓ Live indicator
- ✓ Datetime display với auto-update

**Design principles:**
- Dark theme để giảm mỏi mắt khi xem lâu
- High contrast cho dễ đọc từ xa
- Animation subtle để thu hút sự chú ý
- Color gradient cho các metric quan trọng

### 2.3. Maintenance Management (CMMS)
**Mục đích:** Quản lý yêu cầu bảo trì & theo dõi thiết bị

**Các tính năng chính:**
- ✓ Stats cards (Critical requests, In progress, Completed, MTTR)
- ✓ Maintenance requests list với priority badges
- ✓ Equipment status cards với color coding
- ✓ PM schedule calendar
- ✓ Create maintenance request modal
- ✓ Assign technician workflow

**Design principles:**
- Card-based layout cho dễ scan thông tin
- Priority color coding rõ ràng
- Status indicators với animation
- Modal form validation

### 2.4. Quality Management
**Mục đích:** Kiểm soát chất lượng & xử lý NC

**Các tính năng chính:**
- ✓ Quality KPI cards (Yield, Defect Rate, FPY, NC count)
- ✓ Inspection queue với type badges (IQC/IPQC/OQC)
- ✓ NC list với severity levels
- ✓ Defect Pareto chart
- ✓ Inspection modal với pass/fail input
- ✓ Defect code selector

**Design principles:**
- Clean white background cho QC work
- Clear typography cho dễ đọc specifications
- Visual indicators cho pass/fail
- Grid layout cho form inputs

---

<a name="user-stories"></a>
## 3. 📝 USER STORIES CHI TIẾT

### Module: Production Execution

#### Epic 1: Work Order Management

**US-001: Start Work Order**
```
AS AN Operator
I WANT TO start a work order at my station
SO THAT I can begin production and the system tracks my work

ACCEPTANCE CRITERIA:
- Given I am logged in and there is a released WO assigned
- When I click "Start"
- Then system records start time with my operator ID
- And WO status changes to "In Progress"
- And I cannot start another WO until this completes
- And dashboard updates within 2 seconds
- And material consumption tracking begins

PRIORITY: P0 (Critical)
STORY POINTS: 5
DEPENDENCIES: Authentication, WO Release workflow
```

**US-002: Record Production Output**
```
AS AN Operator
I WANT TO record quantities produced (OK, NG, Rework)
SO THAT progress is tracked accurately

ACCEPTANCE CRITERIA:
- Given I have an active WO
- When I input OK/NG/Rework quantities
- Then system validates total ≤ planned quantity
- And calculates yield % automatically
- And if NG > 5% then alert QC supervisor
- And progress bar updates immediately
- And auto-save occurs every 30 seconds

PRIORITY: P0
STORY POINTS: 8
TEST CASES: TC-PR-001 to TC-PR-005
```

**US-003: Pause/Resume Work Order**
```
AS AN Operator
I WANT TO pause WO temporarily (break, meeting, material wait)
SO THAT downtime is tracked separately

ACCEPTANCE CRITERIA:
- Given I have active WO
- When I click Pause and select reason
- Then production timer stops, downtime timer starts
- And I can Resume later
- And all pause/resume events are logged
- And if pause > 15 min then reminder notification

PRIORITY: P1
STORY POINTS: 5
```

**US-004: Complete Work Order**
```
AS AN Operator
I WANT TO complete WO when finished
SO THAT system finalizes records and triggers QC

ACCEPTANCE CRITERIA:
- Given actual output ≥ 95% of planned OR supervisor approval
- When I click Complete
- Then confirmation dialog appears
- And after confirm: WO status → Completed
- And final yield calculated
- And QC inspection auto-created
- And station marked as available

PRIORITY: P0
STORY POINTS: 8
```

#### Epic 2: Downtime Management

**US-005: Log Unplanned Downtime**
```
AS AN Operator
I WANT TO log when machine stops unexpectedly
SO THAT issues can be tracked and resolved

ACCEPTANCE CRITERIA:
- Given production is running
- When machine stops (manual or auto-sensor)
- Then downtime alert appears
- And I select Category and Reason Code (hierarchical)
- And can add notes/photos (max 5MB)
- And if downtime > 5 min then auto-create Maintenance Request
- And OEE dashboard updates immediately

PRIORITY: P0
STORY POINTS: 8
DEPENDENCIES: Maintenance Request system
```

### Module: Maintenance (CMMS)

#### Epic 3: Corrective Maintenance

**US-006: Create Maintenance Request**
```
AS AN Operator/Supervisor
I WANT TO create maintenance request when equipment fails
SO THAT it gets fixed quickly

ACCEPTANCE CRITERIA:
- Given I have permission to create requests
- When I fill form with: Type, Equipment, Priority, Description
- Then system validates all required fields
- And assigns unique MR-ID
- And sends notification to maintenance team
- And if Critical priority then SMS to maintenance manager
- And request appears in maintenance queue

PRIORITY: P0
STORY POINTS: 5
```

**US-007: Accept & Execute Maintenance Work**
```
AS A Maintenance Technician
I WANT TO accept and work on maintenance requests
SO THAT I can track my work and time

ACCEPTANCE CRITERIA:
- Given there is an unassigned maintenance request
- When I click "Accept"
- Then request assigns to me
- And I can update status (In Progress, Waiting Parts, Completed)
- And I can log time spent and parts used
- And spare parts auto-deduct from inventory
- And equipment status updates accordingly

PRIORITY: P0
STORY POINTS: 13
```

#### Epic 4: Preventive Maintenance

**US-008: Auto-generate PM Work Orders**
```
AS THE System
I WANT TO automatically create PM work orders based on schedule
SO THAT preventive maintenance doesn't get missed

ACCEPTANCE CRITERIA:
- Given equipment has PM schedule defined
- When due date is 7 days away
- Then system creates PM work order
- And assigns to maintenance planner
- And sends notification
- And appears in PM calendar

PRIORITY: P1
STORY POINTS: 8
```

### Module: Quality Management

#### Epic 5: Inspection Management

**US-009: Perform IQC Inspection**
```
AS A QC Inspector
I WANT TO inspect incoming materials
SO THAT only good materials enter production

ACCEPTANCE CRITERIA:
- Given there is incoming material (GRN created)
- When I select inspection task
- Then system shows material details & specs
- And I can input Pass/Fail quantities
- And select defect codes if fail
- And upload photos
- And if Reject then material quarantined
- And supplier rating updated

PRIORITY: P0
STORY POINTS: 13
```

**US-010: Create Non-Conformance (NC)**
```
AS A QC Inspector
I WANT TO create NC when defects found
SO THAT they are investigated and resolved

ACCEPTANCE CRITERIA:
- Given I found defect during any QC stage
- When I create NC with: Severity, Description, Location
- Then system assigns NC-ID
- And auto-assigns to QC Manager for review
- And if Critical then email to Plant Manager
- And related WO/batch is put on hold
- And NC appears in open NC list

PRIORITY: P0
STORY POINTS: 8
```

---

<a name="test-cases"></a>
## 4. 🧪 TEST CASES & SCENARIOS

### TC-PR-001: Start Work Order - Happy Path
**Preconditions:**
- Operator "John" logged into Station 05
- WO-2025-0156 is Released and assigned to Station 05
- Required materials are available

**Test Steps:**
1. Click on WO-2025-0156 in the list
2. Verify WO details display correctly
3. Click "Start" button
4. Observe system response

**Expected Results:**
- ✓ Start button becomes disabled
- ✓ Timer starts counting from 00:00:00
- ✓ WO status badge changes to "ĐANG SẢN XUẤT" (green, pulsing)
- ✓ Progress bar shows 0%
- ✓ System logs: timestamp, operator_id, station_id
- ✓ Dashboard updates within 2 seconds
- ✓ Other WOs' Start buttons are disabled

**Test Data:**
- WO_ID: WO-2025-0156
- Operator: John (EMP-001)
- Station: ST-05

---

### TC-PR-002: Start WO - Insufficient Materials
**Preconditions:**
- Operator logged in
- WO exists but materials not available

**Test Steps:**
1. Attempt to start WO

**Expected Results:**
- ✗ Start button is disabled/greyed out
- ✓ Tooltip shows "Thiếu vật tư: RESISTOR-0402-100K (Need: 1000, Available: 0)"
- ✓ Alert notification appears
- ✓ Email sent to warehouse supervisor

---

### TC-PR-003: Record Output - Valid Input
**Preconditions:**
- WO is in progress
- Operator has produced some units

**Test Steps:**
1. Enter "100" in OK field
2. Enter "5" in NG field
3. Tab out or click elsewhere

**Expected Results:**
- ✓ Auto-save notification appears after 1-2 seconds
- ✓ Progress bar updates to: (100+5)/1000 = 10.5%
- ✓ Yield calculated: 100/(100+5) = 95.2%
- ✓ If yield < 90% then warning icon appears
- ✓ Database updated with timestamp

---

### TC-PR-004: Record Output - Invalid Input (Exceeds Plan)
**Test Steps:**
1. Enter "1500" in OK field (Plan is 1000)

**Expected Results:**
- ✗ Validation error: "Không thể vượt quá kế hoạch"
- ✓ Field border turns red
- ✓ OK value reverts to previous valid value

---

### TC-PR-005: Complete WO - Insufficient Quantity
**Preconditions:**
- WO planned: 1000
- Actual produced: 850 (85%)

**Test Steps:**
1. Click "Complete" button

**Expected Results:**
- ✓ Warning dialog: "Chỉ đạt 85% kế hoạch. Bạn có chắc muốn hoàn thành?"
- ✓ Options: "Cancel" / "Request Approval" / "Force Complete"
- ✓ If "Request Approval": notification to supervisor
- ✓ If "Force Complete": requires supervisor password

---

### TC-MT-001: Create Critical Maintenance Request
**Test Steps:**
1. Click "Tạo yêu cầu mới"
2. Select Type: "Corrective Maintenance"
3. Select Equipment: "CNC-A05"
4. Select Priority: "Critical"
5. Enter description: "Motor quá nhiệt, có mùi cháy"
6. Upload photo
7. Submit

**Expected Results:**
- ✓ MR-ID generated: MR-2025-0234
- ✓ SMS sent to maintenance manager (within 1 min)
- ✓ Email sent to maintenance team
- ✓ Request appears at top of queue with 🚨 icon
- ✓ Equipment status changes to "Down"
- ✓ Any active WO on that equipment auto-paused

---

### TC-QC-001: IQC Inspection - Reject Material
**Test Steps:**
1. Select inspection task QC-2025-0245
2. Enter Pass: 9000
3. Enter Fail: 1000
4. Select defect code: "D002 - Kích thước không đạt"
5. Upload photo of defect
6. Click "Reject"

**Expected Results:**
- ✓ Confirmation dialog appears
- ✓ Material status → "Quarantined"
- ✓ NC auto-created: NC-2025-0089
- ✓ Supplier rating decreases
- ✓ Email sent to procurement & supplier
- ✓ Cannot issue this material to production

---

### TC-INT-001: WO Complete → Auto QC Creation
**Test Steps:**
1. Complete WO-2025-0156 (1000 PCS)
2. Observe system behavior

**Expected Results:**
- ✓ WO status → "Completed"
- ✓ OQC inspection auto-created: QC-2025-0XXX
- ✓ QC inspector receives notification
- ✓ Products moved to "Pending QC" status
- ✓ Cannot ship until QC passes

---

<a name="integration"></a>
## 5. 🔗 INTEGRATION REQUIREMENTS

### 5.1. Module Integration Map

```
┌─────────────────────────────────────────────────────────┐
│                    PLANNING & SCHEDULING                 │
│  ┌────────────┐         ┌──────────────┐               │
│  │   MPS      │────────▶│  MRP         │               │
│  │  Master    │         │  Material    │               │
│  │  Schedule  │         │  Planning    │               │
│  └────────────┘         └──────┬───────┘               │
└────────────────────────────────┼─────────────────────────┘
                                 │
                    ┌────────────▼───────────┐
                    │   PRODUCTION ORDER     │
                    └────────────┬───────────┘
                                 │
                  ┌──────────────┴──────────────┐
                  │                             │
         ┌────────▼─────────┐        ┌─────────▼──────────┐
         │   INVENTORY      │        │   WORK ORDER       │
         │   Material Issue │        │   Execution        │
         └────────┬─────────┘        └─────────┬──────────┘
                  │                             │
                  │            ┌────────────────┼──────────┐
                  │            │                │          │
         ┌────────▼─────┐  ┌──▼─────┐  ┌──────▼────┐  ┌─▼──────┐
         │  PROCUREMENT │  │ QUALITY │  │MAINTENANCE│  │   HR   │
         └──────────────┘  └──┬──────┘  └─────┬─────┘  └────────┘
                              │                │
                              └────────┬───────┘
                                       │
                              ┌────────▼────────┐
                              │   DASHBOARD &   │
                              │   ANALYTICS     │
                              └─────────────────┘
```

### 5.2. API Integration Requirements

#### INT-REQ-001: Production → Inventory Integration
**Trigger:** Work Order started
**API Endpoint:** `POST /api/inventory/issue-materials`
**Payload:**
```json
{
  "wo_id": "WO-2025-0156",
  "bom_items": [
    {
      "material_code": "RESISTOR-0402-100K",
      "quantity": 1000,
      "uom": "PCS"
    }
  ],
  "station_id": "ST-05",
  "requested_by": "EMP-001"
}
```
**Expected Response:**
```json
{
  "status": "success",
  "transaction_id": "INV-TXN-2025-0456",
  "issued_items": [...],
  "timestamp": "2025-10-11T10:30:00Z"
}
```

#### INT-REQ-002: Production → Quality Integration
**Trigger:** Work Order completed
**API Endpoint:** `POST /api/quality/create-inspection`
**Payload:**
```json
{
  "wo_id": "WO-2025-0156",
  "inspection_type": "OQC",
  "product_code": "PCB-A100-V2",
  "quantity": 1000,
  "priority": "normal"
}
```

#### INT-REQ-003: Production → Maintenance Integration
**Trigger:** Downtime > 5 minutes
**API Endpoint:** `POST /api/maintenance/auto-create-request`
**Payload:**
```json
{
  "equipment_id": "CNC-A05",
  "downtime_reason": "Motor overheating",
  "priority": "critical",
  "created_from": "production_downtime",
  "wo_id": "WO-2025-0156"
}
```

#### INT-REQ-004: Maintenance → Inventory Integration
**Trigger:** Spare part used in maintenance
**API Endpoint:** `POST /api/inventory/consume-spare-part`
**Payload:**
```json
{
  "mr_id": "MR-2025-0234",
  "spare_parts": [
    {
      "part_code": "MOTOR-500W-24V",
      "quantity": 1,
      "equipment_id": "CNC-A05"
    }
  ]
}
```

### 5.3. External System Integration

#### EXT-INT-001: PLC/SCADA Integration
**Protocol:** OPC-UA
**Frequency:** Real-time (1-second intervals)
**Data Points:**
- Machine status (Running/Idle/Down)
- Production counter
- Speed (units/hour)
- Error codes
- Temperature, pressure sensors

**Implementation:**
```python
# Pseudo-code
opc_client.subscribe(
    node="ns=2;s=Machine.CNC_A05.Status",
    callback=update_machine_status
)
```

#### EXT-INT-002: ERP/Accounting Integration
**System:** SAP B1 / Odoo
**Integration Method:** REST API / File Exchange (CSV)
**Frequency:** Daily batch (End of day)
**Data Exchange:**
- Production Orders → from ERP
- Material Consumption → to ERP
- Finished Goods → to ERP
- Cost Centers data

#### EXT-INT-003: Email/SMS Gateway
**Service:** SendGrid / Twilio
**Use Cases:**
- Critical maintenance alerts
- NC notifications
- Daily reports
- Approval workflows

---

<a name="data-flow"></a>
## 6. 🔄 DATA FLOW DIAGRAMS

### 6.1. Work Order Lifecycle Flow

```
START
  │
  ▼
[Sales Order] → [MPS] → [Production Order Created]
  │
  ▼
[MRP Check] → Materials Available?
  │                │
  NO               YES
  │                │
  ▼                ▼
[Create PR]    [Create Work Order]
  │                │
  ▼                ▼
[PO→GRN]      [Release WO]
  │                │
  └────────────────┤
                   ▼
           [Operator Starts WO]
                   │
                   ▼
           [Production Execution]
              │    │    │
         OK   NG  Rework
              │    │    │
              └────┴────┘
                   │
                   ▼
        [Complete WO] → [Create QC Inspection]
                              │
                         Pass │ Fail
                              │
                   ┌──────────┴─────────┐
                   ▼                    ▼
         [Move to FG]            [Create NC]
                   │                    │
                   ▼                    ▼
              [Ship]              [Rework/Scrap]
                   │
                  END
```

### 6.2. Downtime Resolution Flow

```
[Machine Down Detected]
       │
       ▼
[Operator Logs Downtime]
   │          │
   ▼          ▼
[Select]  [Auto-detect]
[Reason]  [from sensor]
   │          │
   └────┬─────┘
        │
        ▼
  Duration > 5min?
        │
       YES
        │
        ▼
[Auto-create MR]
        │
        ▼
[Notify Maintenance Team]
        │
        ▼
[Technician Accepts]
        │
        ▼
[Diagnose & Repair]
        │
   Need parts?
    │       │
   YES      NO
    │       │
    ▼       │
[Request]   │
[Spare]     │
[Parts]     │
    │       │
    └───┬───┘
        │
        ▼
[Complete Repair]
        │
        ▼
[Test Equipment]
        │
        ▼
[Update Status → Ready]
        │
        ▼
[Calculate MTTR]
        │
       END
```

---

<a name="business-rules"></a>
## 7. ⚖️ BUSINESS RULES CATALOG

### Production Rules

| Rule ID | Rule Description | Type | Priority |
|---------|-----------------|------|----------|
| BR-PR-001 | Một operator chỉ được Start 1 WO tại 1 thời điểm | Constraint | Mandatory |
| BR-PR-002 | WO không thể Start nếu chưa được Released | Constraint | Mandatory |
| BR-PR-003 | Downtime > 5 phút bắt buộc nhập Reason Code | Validation | Mandatory |
| BR-PR-004 | Sản lượng NG không được âm hoặc > tổng sản lượng | Validation | Mandatory |
| BR-PR-005 | WO tự động Complete khi đạt 100% + QC approved | Automation | Optional |
| BR-PR-006 | Nếu NG rate > 10% → Auto-pause WO + alert QC Manager | Alert | Mandatory |
| BR-PR-007 | Material consumption không được vượt quá BOM + 10% tolerance | Validation | Warning |

### Planning Rules

| Rule ID | Rule Description | Type | Priority |
|---------|-----------------|------|----------|
| BR-PL-001 | Một PO phải có ít nhất 1 WO | Constraint | Mandatory |
| BR-PL-002 | WO chỉ được Release khi đủ vật tư hoặc có approval | Authorization | Mandatory |
| BR-PL-003 | Công suất Line không vượt quá 100% trong 1 ca | Validation | Warning |
| BR-PL-004 | Changeover time tối thiểu giữa 2 WO khác SKU: 30 phút | Calculation | Mandatory |
| BR-PL-005 | Lead time tối thiểu: 1 ngày (trừ Rush Orders) | Policy | Optional |

### Quality Rules

| Rule ID | Rule Description | Type | Priority |
|---------|-----------------|------|----------|
| BR-QM-001 | Vật tư IQC "Reject" không được sử dụng cho sản xuất | Constraint | Mandatory |
| BR-QM-002 | NC phải được assign trong 4h từ lúc tạo | SLA | Mandatory |
| BR-QM-003 | NC không thể Close nếu chưa có Root Cause | Validation | Mandatory |
| BR-QM-004 | Sản phẩm lỗi Critical phải cách ly ngay (Quarantine) | Policy | Mandatory |
| BR-QM-005 | Sample size cho QC theo AQL standard (ISO 2859) | Calculation | Mandatory |

### Maintenance Rules

| Rule ID | Rule Description | Type | Priority |
|---------|-----------------|------|----------|
| BR-MT-001 | PM quá hạn > 7 ngày → Alert Manager | Alert | Mandatory |
| BR-MT-002 | Equipment "Down" không được Start WO | Constraint | Mandatory |
| BR-MT-003 | Mỗi Maintenance Work phải log thời gian thực tế | Audit | Mandatory |
| BR-MT-004 | Spare Part xuất kho phải link với MR | Traceability | Mandatory |
| BR-MT-005 | Critical MR phải có response trong 30 phút | SLA | Mandatory |

### Inventory Rules

| Rule ID | Rule Description | Type | Priority |
|---------|-----------------|------|----------|
| BR-IM-001 | Không xuất kho số lượng > Available stock | Constraint | Mandatory |
| BR-IM-002 | Vật tư có expiry date phải xuất theo FEFO | Policy | Mandatory |
| BR-IM-003 | Stock Adjustment > 5% phải có Manager approval | Authorization | Mandatory |
| BR-IM-004 | Min Stock = 10 ngày tiêu hao trung bình | Calculation | Configurable |
| BR-IM-005 | Reorder Point = Min Stock + Lead Time consumption | Calculation | Mandatory |

---

<a name="roadmap"></a>
## 8. 🗺️ IMPLEMENTATION ROADMAP

### Phase 1: MVP (Months 1-3)

**Sprint 1-2 (Weeks 1-4): Core Production**
- [ ] Authentication & Authorization
- [ ] Operator Station UI
- [ ] Work Order CRUD
- [ ] Start/Stop/Complete WO
- [ ] Production logging (OK/NG)
- [ ] Basic Dashboard

**Sprint 3-4 (Weeks 5-8): Quality & Downtime**
- [ ] Downtime logging
- [ ] Defect code management
- [ ] Basic QC inspection
- [ ] Real-time OEE calculation
- [ ] Alert system

**Sprint 5-6 (Weeks 9-12): Integration & Testing**
- [ ] PLC integration (pilot line)
- [ ] Material consumption tracking
- [ ] Reports (daily production)
- [ ] UAT with operators
- [ ] Production deployment (1 line)

**Deliverables:**
✅ Working MES for 1 production line
✅ Real-time monitoring dashboard
✅ Basic KPI tracking

### Phase 2: Scale-up (Months 4-6)

**Sprint 7-8: Planning & Scheduling**
- [ ] MPS/MRP engine
- [ ] Work Order scheduling
- [ ] Capacity planning
- [ ] BOM management

**Sprint 9-10: Maintenance**
- [ ] CMMS core (Create/Assign MR)
- [ ] PM scheduling
- [ ] Spare parts inventory
- [ ] Equipment status tracking

**Sprint 11-12: Inventory**
- [ ] Warehouse management
- [ ] Material issue/return
- [ ] Stock alerts
- [ ] FIFO/FEFO control

**Deliverables:**
✅ Full planning system
✅ CMMS operational
✅ Inventory integrated

### Phase 3: Advanced Features (Months 7-9)

**Sprint 13-14: Advanced Quality**
- [ ] NC workflow with approvals
- [ ] Root Cause Analysis tools (5 Why, Fishbone)
- [ ] Supplier quality rating
- [ ] Quality trends & SPC charts
- [ ] CAPA (Corrective/Preventive Action)

**Sprint 15-16: Procurement & HR**
- [ ] Purchase Request/Order
- [ ] Supplier management
- [ ] Delivery tracking
- [ ] HR timekeeping integration
- [ ] Operator productivity tracking

**Sprint 17-18: Advanced Analytics**
- [ ] Custom dashboards
- [ ] Advanced reports (Pivot)
- [ ] Predictive analytics (ML for downtime)
- [ ] Mobile app for managers
- [ ] API for third-party integration

**Deliverables:**
✅ Complete ERP system
✅ Advanced analytics & BI
✅ Mobile monitoring

---

## 9. �