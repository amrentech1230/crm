# CRM User Manual Documentation

## Files
- **CRM_User_Manual.html** - Complete CRM User Manual with flowcharts, diagrams, and code explanations

## How to Generate PDF

### Method 1: Browser Print (Recommended)
1. Open `CRM_User_Manual.html` in Google Chrome or any modern browser
2. Press `Ctrl+P` (or `Cmd+P` on Mac)
3. Select "Save as PDF" as the destination
4. Set paper size to A4, margins to Default
5. Click Save

### Method 2: Using wkhtmltopdf (Command Line)
```bash
wkhtmltopdf --page-size A4 --margin-top 20mm --margin-bottom 20mm CRM_User_Manual.html CRM_User_Manual.pdf
```

### Method 3: Using Chrome Headless
```bash
google-chrome --headless --print-to-pdf=CRM_User_Manual.pdf --no-margins CRM_User_Manual.html
```

## Document Contents
1. System Overview & Architecture
2. User Roles & Access Control
3. Authentication & Login Flow
4. Admin Panel Module
5. Broker Module
6. Load Management (Core Module)
7. Customer Management
8. Carrier Management
9. Shipper & Consignee Management
10. Accounting & Invoicing
11. Compliance Module
12. Bill of Lading (BOL)
13. Reporting & Analytics
14. Document Management & File Uploads
15. Email System
16. Database Schema
17. API Routes & Endpoints
