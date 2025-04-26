<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meals Report - Kottu-Labs</title>
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
            <h1>Reservations Report</h1>
        </div>
        
        <!-- Enhanced Filter Controls for Meals -->
        <div class="filter-controls">
            <!-- Date Range -->
            <div class="filter-group">
                <label for="mealStartDate">Start Date:</label>
                <input type="date" id="mealStartDate" name="mealStartDate">
            </div>
            <div class="filter-group">
                <label for="mealEndDate">End Date:</label>
                <input type="date" id="mealEndDate" name="mealEndDate">
            </div>
            
            <!-- Branch Filter -->
            <div class="filter-group">
                <label for="mealBranchFilter">Branch:</label>
                <select id="mealBranchFilter">
                    <option value="">All Branches</option>
                    <option value="1">Wattala</option>
                    <option value="2">Kelaniya</option>
                    <option value="3">Kotahena</option>
                </select>
            </div>
            
            <!-- Action Buttons -->
            <div class="filter-actions">
                <button id="applyMealFilters" class="filter-btn">Apply Filters</button>
                <button id="resetMealFilters" class="filter-btn">Reset</button>
                <button id="printMealReportBtn" class="print-btn"><img src="/Photo/icon/print.png" alt="Print"> Print Report</button>
            </div>
        </div>
        
        <div class="report-body">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Branch</th>
                        <th>Customer Name</th>
                        <th>Number of Guests</th>
                    </tr>
                </thead>
                <tbody id="mealReportTableBody">
                    
                </tbody>
            </table>
        </div>
    </div>

    <script src="/JavaScript/reservationReport.js"></script>
</body>
</html>