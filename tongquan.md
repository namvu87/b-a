# 🏗️ PHÂN TÍCH & THIẾT KẾ HỆ THỐNG ERP ĐẠI LONG

## Tài liệu Kiến trúc & Thiết kế Hệ thống (System Design Document)

---

## 📑 MỤC LỤC

1. [Tổng quan hệ thống](#overview)
2. [Kiến trúc tổng thể](#architecture)
3. [Phân tích Module & Chức năng](#modules)
4. [Thiết kế Database Schema](#database)
5. [API Design & Integration](#api)
6. [Thiết kế UI/UX Framework](#uiux)
7. [Tech Stack & Công nghệ](#techstack)
8. [Security & Performance](#security)
9. [Deployment & Infrastructure](#deployment)
10. [Development Roadmap](#roadmap)

---

<a name="overview"></a>
## 1. 🎯 TỔNG QUAN HỆ THỐNG

### 1.1. Vision & Positioning

**Vision:**
> Xây dựng hệ thống ERP sản xuất **Made in Vietnam** với trải nghiệm người dùng tương đương MISA AMIS, tối ưu hóa cho nhà máy sản xuất điện tử.

**Positioning:**
- **Đối thủ tham khảo:** MISA AMIS Manufacturing, SAP Business One, Odoo Manufacturing
- **Điểm khác biệt:**
    - Tập trung sâu vào sản xuất (không phải ERP tổng quát)
    - Tích hợp IoT/PLC ngay từ đầu
    - UI/UX hiện đại hơn (học từ Notion, Linear, Figma)
    - Giá thành phù hợp doanh nghiệp Việt Nam

### 1.2. Phạm vi Hệ thống

```
┌─────────────────────────────────────────────────────────────┐
│                    ĐẠI LONG ERP SYSTEM                       │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌────────────────┐  ┌────────────────┐  ┌──────────────┐  │
│  │   PLANNING     │  │   PRODUCTION   │  │   QUALITY    │  │
│  │                │  │                │  │              │  │
│  │ • MPS/MRP      │  │ • MES Core     │  │ • IQC/IPQC   │  │
│  │ • Scheduling   │  │ • Work Orders  │  │ • OQC        │  │
│  │ • Capacity     │  │ • Real-time    │  │ • NC         │  │
│  └────────────────┘  └────────────────┘  └──────────────┘  │
│                                                              │
│  ┌────────────────┐  ┌────────────────┐  ┌──────────────┐  │
│  │  MAINTENANCE   │  │   INVENTORY    │  │      HR      │  │
│  │                │  │                │  │              │  │
│  │ • CMMS         │  │ • Warehouse    │  │ • Timekeeping│  │
│  │ • PM/CM        │  │ • Material     │  │ • Shift Mgmt │  │
│  │ • Spare Parts  │  │ • Issue/Return │  │ • Attendance │  │
│  └────────────────┘  └────────────────┘  └──────────────┘  │
│                                                              │
│  ┌────────────────┐  ┌────────────────┐  ┌──────────────┐  │
│  │  PROCUREMENT   │  │   ANALYTICS    │  │    ADMIN     │  │
│  │                │  │                │  │              │  │
│  │ • PR/PO        │  │ • Dashboard    │  │ • Settings   │  │
│  │ • Supplier     │  │ • Reports      │  │ • Users      │  │
│  │ • GRN          │  │ • KPI/OEE      │  │ • Workflow   │  │
│  └────────────────┘  └────────────────┘  └──────────────┘  │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### 1.3. Target Users

| User Role | Số lượng | Use Cases chính | Device |
|-----------|----------|-----------------|--------|
| **Operators** | 50-100 | Start/Stop WO, Record output, Report issues | Tablet/Touch PC |
| **QC Inspectors** | 10-15 | Inspections, Create NC, Report | Tablet/PC |
| **Maintenance Technicians** | 8-12 | Accept MR, Log repairs, Parts | Mobile/PC |
| **Supervisors** | 5-10 | Monitor, Approve, Exception handling | PC/Mobile |
| **Planners** | 3-5 | MPS/MRP, Scheduling, Capacity | PC |
| **Managers** | 5-8 | Dashboard, Reports, Decisions | PC/Mobile |
| **Admins** | 2-3 | System config, Users, Integration | PC |

---

<a name="architecture"></a>
## 2. 🏛️ KIẾN TRÚC TỔNG THỂ

### 2.1. System Architecture Overview

```
┌───────────────────────────────────────────────────────────────┐
│                     CLIENT LAYER                               │
├───────────────────────────────────────────────────────────────┤
│                                                                │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐          │
│  │   Web App   │  │ Mobile App  │  │ Tablet App  │          │
│  │  (React)    │  │(React Native│  │  (PWA)      │          │
│  └─────────────┘  └─────────────┘  └─────────────┘          │
│         │                 │                 │                  │
└─────────┼─────────────────┼─────────────────┼─────────────────┘
          │                 │                 │
          └─────────────────┴─────────────────┘
                            │
          ┌─────────────────▼─────────────────┐
          │         API GATEWAY                │
          │    (Authentication, Routing)       │
          └─────────────────┬─────────────────┘
                            │
          ┌─────────────────▼─────────────────────────────┐
          │            APPLICATION LAYER                   │
          ├───────────────────────────────────────────────┤
          │                                                │
          │  ┌────────────┐  ┌────────────┐  ┌─────────┐ │
          │  │ Production │  │  Quality   │  │Planning │ │
          │  │  Service   │  │  Service   │  │Service  │ │
          │  └────────────┘  └────────────┘  └─────────┘ │
          │                                                │
          │  ┌────────────┐  ┌────────────┐  ┌─────────┐ │
          │  │Maintenance │  │ Inventory  │  │   HR    │ │
          │  │  Service   │  │  Service   │  │Service  │ │
          │  └────────────┘  └────────────┘  └─────────┘ │
          │                                                │
          │  ┌────────────┐  ┌────────────┐              │
          │  │Procurement │  │ Analytics  │              │
          │  │  Service   │  │  Service   │              │
          │  └────────────┘  └────────────┘              │
          │                                                │
          └────────────────────┬───────────────────────────┘
                               │
          ┌────────────────────▼───────────────────────────┐
          │              DATA LAYER                         │
          ├─────────────────────────────────────────────────┤
          │                                                 │
          │  ┌──────────────┐  ┌──────────────┐           │
          │  │  PostgreSQL  │  │    Redis     │           │
          │  │  (Main DB)   │  │   (Cache)    │           │
          │  └──────────────┘  └──────────────┘           │
          │                                                 │
          │  ┌──────────────┐  ┌──────────────┐           │
          │  │  TimescaleDB │  │  Minio/S3    │           │
          │  │ (Time-series)│  │   (Files)    │           │
          │  └──────────────┘  └──────────────┘           │
          │                                                 │
          └─────────────────────────────────────────────────┘
                               │
          ┌────────────────────▼───────────────────────────┐
          │          INTEGRATION LAYER                      │
          ├─────────────────────────────────────────────────┤
          │                                                 │
          │  ┌──────────────┐  ┌──────────────┐           │
          │  │   PLC/SCADA  │  │   ERP/SAP    │           │
          │  │   (OPC-UA)   │  │  (REST API)  │           │
          │  └──────────────┘  └──────────────┘           │
          │                                                 │
          │  ┌──────────────┐  ┌──────────────┐           │
          │  │  Email/SMS   │  │   Barcode    │           │
          │  │   Gateway    │  │   Scanner    │           │
          │  └──────────────┘  └──────────────┘           │
          │                                                 │
          └─────────────────────────────────────────────────┘
```

### 2.2. Architecture Patterns

**Microservices-based Architecture**
- Mỗi module là một service độc lập
- Giao tiếp qua REST API + Message Queue
- Có thể scale độc lập từng service

**Event-Driven Architecture**
- Sử dụng Message Broker (RabbitMQ/Kafka)
- Real-time updates qua WebSocket
- Event sourcing cho audit trail

**CQRS (Command Query Responsibility Segregation)**
- Tách riêng read/write operations
- Optimize performance cho reporting
- Better scalability

### 2.3. Technology Stack Decisions

```
┌─────────────────────────────────────────────────────────┐
│                    TECH STACK                            │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  FRONTEND                                                │
│  ├─ Framework:     React 18 + TypeScript                │
│  ├─ State:         Redux Toolkit + RTK Query            │
│  ├─ UI Library:    Material-UI / Ant Design             │
│  ├─ Charts:        Recharts / ApexCharts                │
│  ├─ Build:         Vite                                  │
│  └─ Mobile:        React Native (share code)            │
│                                                          │
│  BACKEND                                                 │
│  ├─ Language:      Node.js + TypeScript                 │
│  ├─ Framework:     NestJS (enterprise-grade)            │
│  ├─ API:           REST + GraphQL (optional)            │
│  ├─ Validation:    class-validator                      │
│  ├─ ORM:           Prisma / TypeORM                     │
│  └─ Authentication: JWT + Passport                       │
│                                                          │
│  DATABASE                                                │
│  ├─ Primary:       PostgreSQL 15+                       │
│  ├─ Cache:         Redis 7+                             │
│  ├─ Time-series:   TimescaleDB (for sensors)           │
│  ├─ Search:        Elasticsearch (optional)             │
│  └─ File Storage:  MinIO / AWS S3                       │
│                                                          │
│  MESSAGE QUEUE                                           │
│  ├─ Broker:        RabbitMQ / Apache Kafka             │
│  └─ Real-time:     Socket.io / Server-Sent Events      │
│                                                          │
│  DEVOPS                                                  │
│  ├─ Container:     Docker + Docker Compose              │
│  ├─ Orchestration: Kubernetes (production)              │
│  ├─ CI/CD:         GitLab CI / GitHub Actions           │
│  ├─ Monitoring:    Prometheus + Grafana                 │
│  └─ Logging:       ELK Stack (Elasticsearch/Logstash)  │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

<a name="modules"></a>
## 3. 🧩 PHÂN TÍCH MODULE & CHỨC NĂNG

### 3.1. Module Map

```
ĐẠI LONG ERP
│
├─ 📊 PLANNING & SCHEDULING
│  ├─ Master Production Schedule (MPS)
│  ├─ Material Requirements Planning (MRP)
│  ├─ Work Order Scheduling
│  ├─ Capacity Planning
│  └─ Load Balancing
│
├─ 🏭 PRODUCTION EXECUTION (MES)
│  ├─ Work Order Management
│  ├─ Operator Station Interface
│  ├─ Production Logging (OK/NG/Rework)
│  ├─ Downtime Management
│  ├─ Material Consumption Tracking
│  └─ Real-time Monitoring Dashboard
│
├─ ✅ QUALITY MANAGEMENT
│  ├─ IQC (Incoming Quality Control)
│  ├─ IPQC (In-Process Quality Control)
│  ├─ OQC (Outgoing Quality Control)
│  ├─ Non-Conformance (NC) Management
│  ├─ Root Cause Analysis
│  ├─ CAPA (Corrective/Preventive Action)
│  └─ Quality Reports & Trends
│
├─ 🔧 MAINTENANCE (CMMS)
│  ├─ Equipment/Asset Management
│  ├─ Preventive Maintenance (PM)
│  ├─ Corrective Maintenance (CM)
│  ├─ Maintenance Request Workflow
│  ├─ Spare Parts Inventory
│  └─ MTTR/MTBF Analytics
│
├─ 📦 INVENTORY MANAGEMENT
│  ├─ Warehouse Management
│  ├─ Material Master Data
│  ├─ Stock Tracking (Location/Lot/Batch)
│  ├─ Material Issue/Return
│  ├─ Min/Max Stock Alerts
│  ├─ FIFO/FEFO Control
│  └─ Cycle Counting
│
├─ 💰 PROCUREMENT
│  ├─ Purchase Request (PR)
│  ├─ Purchase Order (PO)
│  ├─ Supplier Management
│  ├─ Delivery Tracking
│  ├─ Goods Receipt Note (GRN)
│  └─ Supplier Performance Rating
│
├─ 👥 HR & TIMEKEEPING
│  ├─ Employee Master Data
│  ├─ Shift Management
│  ├─ Attendance & Timekeeping
│  ├─ Operator Assignment
│  ├─ Skill Matrix
│  └─ Productivity Tracking
│
├─ 📈 ANALYTICS & REPORTING
│  ├─ Executive Dashboard
│  ├─ Production Reports
│  ├─ Quality Reports
│  ├─ Maintenance Reports
│  ├─ Inventory Reports
│  ├─ Custom Report Builder
│  └─ KPI/OEE Tracking
│
└─ ⚙️ SYSTEM ADMINISTRATION
   ├─ User & Role Management
   ├─ Workflow Configuration
   ├─ System Settings
   ├─ Audit Trail
   ├─ Data Import/Export
   └─ Integration Management
```

### 3.2. Module Prioritization Matrix

| Module | Priority | Complexity | Business Value | Phase |
|--------|----------|------------|----------------|-------|
| **Production Execution (MES)** | P0 | High | Very High | Phase 1 |
| **Quality Management** | P0 | Medium | Very High | Phase 1 |
| **Real-time Dashboard** | P0 | Medium | High | Phase 1 |
| **Planning & Scheduling** | P1 | Very High | High | Phase 2 |
| **Maintenance (CMMS)** | P1 | Medium | High | Phase 2 |
| **Inventory Management** | P1 | Medium | High | Phase 2 |
| **Procurement** | P2 | Low | Medium | Phase 3 |
| **HR & Timekeeping** | P2 | Low | Medium | Phase 3 |
| **Advanced Analytics** | P2 | High | Medium | Phase 3 |

### 3.3. Feature Breakdown - Production Module (Ví dụ chi tiết)

**Production Execution Module**

```
📦 Production Execution (MES)
│
├─ 📋 Work Order Management
│  ├─ Create WO from Production Order
│  ├─ Release WO to production
│  ├─ View WO details (BOM, routing, materials)
│  ├─ Update WO status (Pending → Released → In Progress → Completed)
│  ├─ Split/Merge WO
│  ├─ Cancel/Close WO
│  └─ WO history & audit trail
│
├─ 👤 Operator Station Interface
│  ├─ Login/Logout (RFID/Barcode/Password)
│  ├─ View assigned WO list
│  ├─ Start WO
│  │  ├─ Check material availability
│  │  ├─ Check equipment status
│  │  ├─ Record start time & operator
│  │  └─ Start production timer
│  │
│  ├─ Record Production Output
│  │  ├─ Input quantity OK
│  │  ├─ Input quantity NG (with defect codes)
│  │  ├─ Input quantity Rework
│  │  ├─ Auto-save every 30 seconds
│  │  ├─ Calculate yield %
│  │  └─ Alert if NG rate > threshold
│  │
│  ├─ Pause/Resume WO
│  │  ├─ Select pause reason (break, meeting, material wait, changeover)
│  │  ├─ Track pause duration
│  │  └─ Resume production
│  │
│  ├─ Report Downtime
│  │  ├─ Select downtime category (Mechanical, Electrical, Material, etc.)
│  │  ├─ Select specific reason code
│  │  ├─ Add notes/photos
│  │  ├─ Auto-create Maintenance Request if > 5 minutes
│  │  └─ Log downtime for OEE calculation
│  │
│  ├─ Complete WO
│  │  ├─ Validate completion criteria
│  │  ├─ Final count confirmation
│  │  ├─ Auto-create QC inspection request
│  │  ├─ Update WO status to Completed
│  │  └─ Mark station as available
│  │
│  └─ View Station Dashboard
│     ├─ Current WO progress
│     ├─ Production timer
│     ├─ Target vs Actual
│     ├─ OEE/Yield metrics
│     └─ Recent activity log
│
├─ 📊 Real-time Monitoring Dashboard
│  ├─ Overall production KPIs
│  │  ├─ Total output today
│  │  ├─ Average OEE
│  │  ├─ Yield rate
│  │  └─ Downtime total
│  │
│  ├─ Line status cards
│  │  ├─ Status indicator (Running/Idle/Down)
│  │  ├─ Current WO
│  │  ├─ Progress %
│  │  ├─ OEE
│  │  └─ Operator assigned
│  │
│  ├─ Charts & Graphs
│  │  ├─ Production output by hour
│  │  ├─ OEE trend
│  │  ├─ Downtime Pareto
│  │  └─ Quality metrics
│  │
│  └─ Active WO list
│     ├─ WO ID, Product, Line
│     ├─ Plan vs Actual
│     ├─ Progress bar
│     └─ Status
│
├─ 🔄 Material Consumption Tracking
│  ├─ Auto-issue materials on WO start
│  ├─ Track actual consumption
│  ├─ Compare vs BOM standard
│  ├─ Record scrap/waste
│  └─ Return excess materials
│
└─ 🎯 Production Analytics
   ├─ OEE calculation (Availability × Performance × Quality)
   ├─ Downtime analysis
   ├─ Cycle time analysis
   ├─ Operator productivity
   └─ Production variance reports
```

---

<a name="database"></a>
## 4. 💾 THIẾT KẾ DATABASE SCHEMA

### 4.1. Entity Relationship Diagram (ERD) - Core Entities

```
┌─────────────────┐         ┌─────────────────┐
│    CUSTOMER     │────┬────│ SALES_ORDER     │
└─────────────────┘    │    └─────────────────┘
                       │            │
                       │            │ 1:N
                       │            ▼
                       │    ┌─────────────────┐
                       │    │PRODUCTION_ORDER │
                       │    └─────────────────┘
                       │            │
                       │            │ 1:N
                       │            ▼
                       │    ┌─────────────────┐         ┌─────────────────┐
                       │    │   WORK_ORDER    │────────│  WO_OPERATION   │
                       │    └─────────────────┘   1:N   └─────────────────┘
                       │            │                            │
                       │            │ N:1                        │
                       │            ▼                            │
┌─────────────────┐   │    ┌─────────────────┐                 │
│    PRODUCT      │───┼────│    ROUTING      │                 │
└─────────────────┘   │    └─────────────────┘                 │
        │             │                                         │
        │ 1:N         │                                         │
        ▼             │                                         │
┌─────────────────┐   │                                         │
│      BOM        │   │                                         │
│   (Bill of      │   │                                         │
│   Materials)    │   │                                         │
└─────────────────┘   │                                         │
        │             │                                         │
        │ N:M         │                                         │
        ▼             │                                         │
┌─────────────────┐   │    ┌─────────────────┐                 │
│    MATERIAL     │───┴────│  MATERIAL_ISSUE │◀────────────────┘
└─────────────────┘        └─────────────────┘
        │                          │
        │                          │
        ▼                          ▼
┌─────────────────┐        ┌─────────────────┐
│ INVENTORY_TXN   │        │PRODUCTION_LOG   │
└─────────────────┘        └─────────────────┘
                                   │
                                   │ 1:N
                                   ▼
                           ┌─────────────────┐         ┌─────────────────┐
                           │  DEFECT_RECORD  │────────│   DEFECT_CODE   │
                           └─────────────────┘   N:1   └─────────────────┘
                                   │
                                   │ triggers
                                   ▼
                           ┌─────────────────┐
                           │NON_CONFORMANCE  │
                           └─────────────────┘
```

### 4.2. Key Database Tables

**Production Domain**

```sql
-- Production Order
CREATE TABLE production_orders (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    po_number VARCHAR(50) UNIQUE NOT NULL,
    sales_order_id UUID REFERENCES sales_orders(id),
    product_id UUID NOT NULL REFERENCES products(id),
    quantity_planned DECIMAL(12,3) NOT NULL,
    quantity_completed DECIMAL(12,3) DEFAULT 0,
    status VARCHAR(20) NOT NULL, -- Draft, Released, InProgress, Completed, Cancelled
    priority VARCHAR(20), -- Normal, High, Urgent
    planned_start_date TIMESTAMP,
    planned_end_date TIMESTAMP,
    actual_start_date TIMESTAMP,
    actual_end_date TIMESTAMP,
    created_by UUID NOT NULL REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_qty CHECK (quantity_completed <= quantity_planned)
);

-- Work Order
CREATE TABLE work_orders (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    wo_number VARCHAR(50) UNIQUE NOT NULL,
    production_order_id UUID NOT NULL REFERENCES production_orders(id),
    product_id UUID NOT NULL REFERENCES products(id),
    line_id UUID REFERENCES production_lines(id),
    station_id UUID REFERENCES stations(id),
    quantity_planned DECIMAL(12,3) NOT NULL,
    quantity_ok DECIMAL(12,3) DEFAULT 0,
    quantity_ng DECIMAL(12,3) DEFAULT 0,
    quantity_rework DECIMAL(12,3) DEFAULT 0,
    status VARCHAR(20) NOT NULL, -- Pending, Released, InProgress, Paused, Completed, Cancelled
    priority VARCHAR(20),
    shift_id UUID REFERENCES shifts(id),
    planned_start_time TIMESTAMP,
    planned_end_time TIMESTAMP,
    actual_start_time TIMESTAMP,
    actual_end_time TIMESTAMP,
    operator_id UUID REFERENCES users(id),
    created_by UUID NOT NULL REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_quantities CHECK (
        quantity_ok >= 0 AND 
        quantity_ng >= 0 AND 
        quantity_rework >= 0 AND
        (quantity_ok + quantity_ng + quantity_rework) <= quantity_planned
    )
);

-- Production Log (Time-series data)
CREATE TABLE production_logs (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    wo_id UUID NOT NULL REFERENCES work_orders(id),
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    event_type VARCHAR(50) NOT NULL, -- START, PAUSE, RESUME, OUTPUT_RECORD, COMPLETE, etc.
    quantity_ok DECIMAL(12,3),
    quantity_ng DECIMAL(12,3),
    quantity_rework DECIMAL(12,3),
    operator_id UUID REFERENCES users(id),
    station_id UUID REFERENCES stations(id),
    notes TEXT,
    metadata JSONB, -- flexible field for additional data
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Downtime Log
CREATE TABLE downtime_logs (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    wo_id UUID NOT NULL REFERENCES work_orders(id),
    equipment_id UUID REFERENCES equipment(id),
    downtime_category_id UUID NOT NULL REFERENCES downtime_categories(id),
    downtime_reason_id UUID NOT NULL REFERENCES downtime_reasons(id),
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP,
    duration_minutes INT GENERATED ALWAYS AS (
        EXTRACT(EPOCH FROM (end_time - start_time))/60
    ) STORED,
    description TEXT,
    photos TEXT[], -- array of file URLs
    created_by UUID NOT NULL REFERENCES users(id),
    maintenance_request_id UUID REFERENCES maintenance_requests(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_time CHECK (end_time IS NULL OR end_time > start_time)
);

-- Material Consumption
CREATE TABLE material_consumption (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    wo_id UUID NOT NULL REFERENCES work_orders(id),
    material_id UUID NOT NULL REFERENCES materials(id),
    quantity_planned DECIMAL(12,3) NOT NULL,
    quantity_actual DECIMAL(12,3),
    uom VARCHAR(20),
    batch_number VARCHAR(50),
    lot_number VARCHAR(50),
    issued_at TIMESTAMP,
    returned_quantity DECIMAL(12,3) DEFAULT 0,
    scrap_quantity DECIMAL(12,3) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Quality Domain**

```sql
-- Quality Inspection
CREATE TABLE quality_inspections (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    qc_number VARCHAR(50) UNIQUE NOT NULL,
    inspection_type VARCHAR(20) NOT NULL, -- IQC, IPQC, OQC
    source_type VARCHAR(20) NOT NULL, --