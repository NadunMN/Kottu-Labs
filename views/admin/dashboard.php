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
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --text-dark: #333;
            --text-light: #666;
            --background-light: #f5f5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            /* background-color: var(--background-light); */
            color: var(--text-dark);
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            /* gap: 20px; */
            width: 100%;
            margin: 5px auto;
        }

        .left-column{
          width: 70%;
        }

        .right-column{
          width: 30%;
        }

        .section {
            background: white;
            border-radius: 10px;
            /* box-shadow: 0 0px 6px rgba(0,0,0,0.1); */
            padding: 25px;
            transition: transform 0.3s ease;
            
        }

        .card-part-main{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            width: 100%;
            height: auto;
              gap:20px;
        }

        .card-part{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            width: 60%;
            height: auto;
            gap:20px;

        }

        .upper-card{
            /* margin-top: -50px; */
            width: 100%;
            height: 330px;
            /* background-color: var(--primary-color); */
            padding: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
                        box-shadow: 0 0px 6px rgba(0,0,0,0.1);
        }

      

        .card-part-2{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            width: 40%;
            height: 330px;
            padding-bottom: 20px;
            /* background-color: black; */
            border-radius: 10px;
            box-shadow: 0 0px 6px rgba(0,0,0,0.1);

            /* background-color: var(--primary-color); */

            gap:20px;

        }

        /* .section:hover {
            transform: translateY(-5px);
        } */

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-title {
            color:black;
            margin-bottom: 20px;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 60px;
        }

        .stat-card {
            background-color: var(--background-light);
            background-image: url('/Photo/13682.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 8px;
            padding: 20px;
            width: 95%;
            text-align: left;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

        .stat-card h3 {
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .stat-card:hover {
            transform: scale(1.02);
        }

        .stat-card .value {
            font-size: 20px;
            font-weight: bold;
            color: var(--primary-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border-bottom: 1px solid #eee;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: var(--background-light);
            color: var(--text-light);
        }

        .chart-container {
            height: 300px;
            margin-top: 20px;
        }

        .highlight {
            color: var(--secondary-color);
            font-weight: bold;
        }

        .negative {
            color: #e74c3c;
        }

        .activity-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .activity-item {
            background-color: var(--background-light);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }


        /* chart */
        .chart-container {
          width: 300px;
          max-width: 90%;
          height: 100%;
          /* position: relative; */
        }

        .chart-container-bar {
          width: 100%;
          height: 300px;
          /* position: relative; */
        }

      
        /* chart */
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Column -->
        <div class="left-column">
            <div class="section">
                <div class="dashboard-header">
                    <h1 class="dashboard-title">Admin Dashboard</h1>
                    <span class="highlight">September 2023</span>
                </div>

                <div class="quick-stats">
                    <div class="stat-card">
                      <div>
                        <h3>Wattala</h3>
                        <div class="value">75</div>
                      </div>
                      <div>
                        <img src="/Photo/icon/group.png" alt="Wattala" style="width: 50px; height: 50px;">
                      </div>
                    </div>

                    <div class="stat-card">
                      <div>
                        <h3>Kelaniya</h3>
                        <div class="value">80</div>
                      </div>
                      <div>
                        <img src="/Photo/icon/group.png" alt="Kelaniya" style="width: 50px; height: 50px;">
                      </div>
                    </div>

                    <div class="stat-card">
                      <div>
                        <h3>Kotahena</h3>
                        <div class="value">80</div>
                      </div>
                      <div>
                        <img src="/Photo/icon/group.png" alt="Kotahena" style="width: 50px; height: 50px;">
                      </div>
                    </div>
                </div>

                <h2>Recent Activities</h2>


              <div class="card-part-main">
                <div class="card-part">

                    <div class="upper-card">
                    <div class="chart-container-bar">
                      <canvas id="lineChart"></canvas>
                    </div>
                    </div>
                </div>

                <div class="card-part-2">

                <div class="chart-container">
                  <canvas id="pieChart"></canvas>
                </div>

                </div>
                
              </div>

                

            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <div class="section">
                <h2>Financial Summary</h2>
                
                <div class="activity-section">
                    <div class="activity-item">
                        <h3>Income</h3>
                        <div class="value highlight">$78,500</div>
                        <small>+12% from last month</small>
                    </div>
                    <div class="activity-item">
                        <h3>Expenses</h3>
                        <div class="value negative">$45,200</div>
                        <small>-5% from last month</small>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="expenseChart"></canvas>
                </div>

                <h2>Top Categories</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Revenue</th>
                            <th>Growth</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Technology</td>
                            <td>$89,500</td>
                            <td class="highlight">+15%</td>
                        </tr>
                        <tr>
                            <td>Consulting</td>
                            <td>$67,300</td>
                            <td class="highlight">+10%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>

        // Expense Chart
        new Chart(document.getElementById('expenseChart'), {
            type: 'bar',
            data: {
                labels: ['Marketing', 'Operations', 'R&D', 'HR'],
                datasets: [{
                    label: 'Expenses',
                    data: [15000, 25000, 12000, 10000],
                    backgroundColor: ['#e74c3c', '#3498db', '#2ecc71', '#f39c12']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: 'Expense Breakdown' },
                    legend: { display: false }
                }
            }
        });


        // Radar Chart
        // Chart.js Radar Chart Configuration
        // Get the canvas context
    const ctx = document.getElementById('pieChart').getContext('2d');

// Create a gradient to simulate lighting effect
const gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
gradient1.addColorStop(0, "#1E90FF");  // Blue
gradient1.addColorStop(1, "#187bcd");

const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
gradient2.addColorStop(0, "#2ECC71");  // Green
gradient2.addColorStop(1, "#1f9b50");

const gradient3 = ctx.createLinearGradient(0, 0, 0, 400);
gradient3.addColorStop(0, "#E74C3C");  // Red
gradient3.addColorStop(1, "#b52d22");

// Data
const data = {
  labels: ["Wattala", "Kelaniya", "Kotahena"],
  datasets: [{
    data: [300, 150, 100],
    backgroundColor: [gradient1, gradient2, gradient3],
    hoverOffset: 10,
    borderColor: "#ccc",
    borderWidth: 0,
  }]
};

// Options
const options = {
  responsive: true,
  cutout: '40%',  // Creates the donut shape for a 3D illusion
  plugins: {
    legend: {
      display:false,
    },
    title: {
      display: true,
      text: "Registration Statistics",
      font: {
        size: 18
      }
    }
  },
  animation: {
    animateRotate: true,
    animateScale: true
  }
};

// Create Chart
new Chart(ctx, {
  type: 'doughnut',  // Doughnut instead of Pie to create depth
  data: data,
  options: options
});






//line chart
 // --------------- Yearly Line Chart ---------------
 const lineCtx = document.getElementById('lineChart').getContext('2d');

// Abbreviated day labels
const weekDays = ["M", "T", "W", "T", "F", "S", "S"];

const lineData = {
    labels: weekDays,
    datasets: [{
        label: "Orders",
        data: [60, 50, 60, 50, 30, 40, 10],
        backgroundColor: "rgb(182, 33, 33)",
        borderWidth: 0,
        borderRadius: 5,
        tension: 0.4,
        fill: true,
        pointRadius: 0
    }]
};

const lineOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: "Order Statistics",
            padding: 20,
            font: {
                size: 18,
                weight: '600'
            }
        }
    },
    scales: {
        x: {
            grid: {
                display: false
            },
            ticks: {
                color: "#666"
            }
        },
        y: {
            beginAtZero: true,
            grid: {
                display: false
            },
            ticks: {
                color: "#666",
                stepSize: 50,
                callback: function(value) {
                    return value === 100 ? '100' : value;
                }
            }
        }
    }
};

new Chart(lineCtx, {
    type: 'bar',
    data: lineData,
    options: lineOptions
});
    </script>
</body>
</html>