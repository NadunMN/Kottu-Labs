<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Report - Kottu-Labs</title>
    <link rel="stylesheet" href="/CSS/admin/dashboard.css">
    <link rel="stylesheet" href="/CSS/admin/reports.css">
    <style>
        /* Additional print-specific styles */
        @media print {
            .filter-controls, .back-btn, .filter-btn, .print-btn {
                display: none !important;
            }
            
            .report-container {
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            
            .print-only {
                display: block !important;
            }
            
            .total-row {
                background-color: #f9f9f9 !important;
                font-weight: bold !important;
            }
            
            .print-header, .print-footer {
                padding: 10px 0;
                text-align: center;
            }
            
            .print-filters {
                margin: 15px 0;
                padding: 10px;
                background-color: #f9f9f9;
                border-radius: 5px;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
            }
            
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
        }
        
        /* Hide print elements when not printing */
        .print-only {
            display: none;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <h1>Orders Report</h1>
        </div>
        
        <!-- Enhanced Filter Controls -->
        <div class="filter-controls">
            <!-- Date Filter -->
            <div class="filter-group">
                <label for="reportDate">Date:</label>
                <input type="date" id="reportDate" name="reportDate">
            </div>
            
            <!-- Branch Filter -->
            <div class="filter-group">
                <label for="branchFilter">Branch:</label>
                <select id="branchFilter">
                    <option value="">All Branches</option>
                    <option value="Wattala">Wattala</option>
                    <option value="Kelaniya">Kelaniya</option>
                    <option value="Kotahena">Kotahena</option>
                </select>
            </div>
            
            <!-- Price Range Filter -->
            <div class="filter-group">
                <label for="minPrice">Price Range:</label>
                <input type="number" id="minPrice" placeholder="Min" min="0">
                <span>to</span>
                <input type="number" id="maxPrice" placeholder="Max" min="0">
            </div>
            
            <!-- Action Buttons -->
            <div class="filter-actions">
                <button id="applyFilters" class="filter-btn">Apply Filters</button>
                <button id="resetFilters" class="filter-btn">Reset All</button>
                <button id="printReportBtn" class="print-btn"><img src="/Photo/icon/print.png" alt="Print"> Print Report</button>
            </div>
        </div>
        
        <div class="report-body">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Branch</th>
                        <th>Type</th>
                        <th>Total (Rs.)</th>
                    </tr>
                </thead>
                <tbody id="orderReportTableBody">
                    <!-- Data will be populated via JavaScript -->
                    
                </tbody>
            </table>
        </div>
    </div>

    <script src="/JavaScript/orderReport.js"></script>
</body>
</html>