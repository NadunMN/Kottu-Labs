<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #7209b7;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --text-dark: #2b2d42;
            --text-medium: #555b6e;
            --text-light: #8d99ae;
            --background-light: #f8f9fa;
            --card-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            --hover-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            /* background-color: var(--background-light); */
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            /* margin: 20px auto; */
            gap: 24px;
            /* padding: 0 16px; */
        }

        .left-column {
            flex: 1 1 65%;
            min-width: 600px;
        }

        .right-column {
            flex: 1 1 30%;
            min-width: 300px;
        }

        .section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 25px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .section:hover {
            box-shadow: var(--hover-shadow);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .dashboard-title {
            color: black;
            font-size: 26px;
            font-weight: 600;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(145deg, #ffffff, #f5f5f5);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #EE3E3F;
        }

        .stat-card:nth-child(2) {
            border-left: 4px solid black;
        }

        .stat-card:nth-child(3) {
            border-left: 4px solid #F4C430;
        }

        .stat-card h3 {
            color: var(--text-dark);
            margin-bottom: 10px;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #EE3E3F;
        }

        .stat-card:nth-child(2) .value {
            color: black;
        }

        .stat-card:nth-child(3) .value {
            color: #F4C430;
        }

        .stat-card .icon-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(67, 97, 238, 0.1);
        }

        .stat-card:nth-child(2) .icon-container {
            background-color: rgba(58, 12, 163, 0.1);
        }

        .stat-card:nth-child(3) .icon-container {
            background-color: rgba(114, 9, 183, 0.1);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .chart-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            display: flex;
            height: 450px;
            flex-direction: column;
            padding: 0;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .chart-header {
            padding: 20px 20px 10px 20px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .chart-description {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .chart-body {
            flex: 1;
            padding: 0 15px 15px 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chart-container {
            width: 100%;
            height: 100%;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color:rgba(238, 62, 62, 0.08);
            color:#EE3E3F;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            border-bottom: 1px solid #f0f0f0;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8f9fa;
        }

        .highlight {
            color: var(--success-color);
            font-weight: bold;
        }

        .negative {
            color: var(--danger-color);
        }

        .activity-section {
            margin-bottom: 30px;
        }

        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .activity-item:hover {
            transform: translateY(-3px);
        }

        .activity-content h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .activity-content .value {
            font-size: 22px;
            font-weight: bold;
            color: #EE3E3F;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #ee3e3f;
        }

        @media (max-width: 1200px) {
            .card-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .left-column, .right-column {
                width: 100%;
                min-width: auto;
            }
            
            .quick-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                    <div class="chart-card ">
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
                            <div class="value highlight" id="registrations">85</div>
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
                            <td>Technology</td>
                            <td>$89,500</td>
                            <td class="highlight">+15%</td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="/JavaScript/chart.js"></script>
    <script src="/JavaScript/admin/dashboard.js"></script>
</body>
</html>