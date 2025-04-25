<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard - Kottu-Labs</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="/CSS/admin/dashboard.css">
</head>

<body>
    <div class="container">
        <!-- Left Column -->
        <div class="left-column">
            <div class="section">
                <div class="dashboard-header">
                    <h1 class="dashboard-title">Admin Dashboard</h1>
                    <span id="current-date"></span>
                </div>

                <div class="quick-stats">
                    <div class="stat-card">
                        <div>
                            <h3>Wattala</h3>
                            <div class="value" id="value-wattala">Rs.00</div>
                        </div>
                        <div class="icon-container">
                            <img src="/Photo/icon/statistics.png" alt="Wattala" style="width: 30px; height: 30px;">
                        </div>
                    </div>

                    <div class="stat-card">
                        <div>
                            <h3>Kelaniya</h3>
                            <div class="value" id="value-kelaniya">Rs.00</div>
                        </div>
                        <div class="icon-container">
                            <img src="/Photo/icon/statistics.png" alt="Kelaniya" style="width: 30px; height: 30px;">
                        </div>
                    </div>

                    <div class="stat-card">
                        <div>
                            <h3>Kotahena</h3>
                            <div class="value" id="value-kotahena">Rs.00</div>
                        </div>
                        <div class="icon-container">
                            <img src="/Photo/icon/statistics.png" alt="Kotahena" style="width: 30px; height: 30px;">
                        </div>
                    </div>
                </div>

                <div class="card-container">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h2 class="chart-title">Registration Statistics</h2>
                            <p class="chart-description">Monthly registration numbers across all branches showing growth patterns.</p>
                        </div>
                        <div class="chart-body">
                            <div class="chart-container">
                                <canvas id="registrationBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-container">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h2 class="chart-title">Orders</h2>
                            <p class="chart-description">Track and analyze order trends with the Order Statistics Chart, providing real-time insights into sales performance.</p>
                        </div>
                        <div class="chart-body">
                            <div class="chart-container">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <div class="section">
                <h2 class="section-title">Financial Summary</h2>
                
                <div class="activity-section">
                    <div class="activity-item">
                        <div class="activity-content">
                            <h3>Registrations</h3>
                            <div class="value highlight" id="registrations">0</div>
                        </div>
                        <div>
                            <img src="/Photo/icon/partners.png" alt="Registrations" style="width: 50px; height: 50px;">
                        </div>
                    </div>
                </div>

                <h2 class="section-title">Top Customers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Branch name</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody id="customerTableBody">
                        <tr>
                            <td colspan="3">Loading data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="section">
                <h2 class="section-title">Reports</h2>
                <button class="report-btn" onclick="window.location.href='/orderReport'">Get Orders Report</button>
                <button class="report-btn" onclick="window.location.href='/mealReport'">Get Meals Report</button>
            </div>
        </div>
    </div>

    <script src="/JavaScript/chart.js"></script>
    <script src="/JavaScript/admin/dashboard.js"></script>
</body>
</html>