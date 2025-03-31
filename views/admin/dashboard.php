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
            /* margin-top: -50px; */
            width: 100%;
            height: auto;
              gap:20px;
        }

        .card-part{
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: left;
            width: 50%;
            height: 350px;
            gap:20px;
            box-shadow: 0 0px 20px rgba(0,0,0,0.1);
            border-radius: 10px;


        }

        .upper-card{
            /* margin-top: -50px; */
            width: 100%;
            height: 280px;
            /* background-color: var(--primary-color); */
            padding: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
        }

      

        .card-part-2{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            width: 50%;
            height: 350px;
            padding-bottom: 20px;
            /* background-color: black; */
            border-radius: 10px;
            box-shadow: 0 0px 20px rgba(0,0,0,0.1);

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
            cursor: pointer;
            background-color: white;
            
            /* background-image: url('/Photo/13682.jpg'); */
            /* background-size: cover;
            background-position: center;
            background-repeat: no-repeat; */
            border-radius: 8px;
            padding: 20px;
            width: 95%;
            text-align: left;
            box-shadow: 0 0px 20px rgba(0,0,0,0.1);
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
            margin-top: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            
        }

        .activity-item {
            display: flex;
            /* flex-direction: column; */
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            background-color: var(--background-light);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            height: 100px;
        }


        /* chart */
        .chart-container {
            width: 100%;
            /* height: 300px; */
        
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
                    <!-- <span class="highlight">September 2023</span> -->
                </div>

                <div class="quick-stats">
                    <div class="stat-card">
                      <div>
                        <h3>Wattala</h3>
                        <div class="value" style="font-size: 1.5rem;">Rs.75,000</div>
                      </div>
                      <div>
                        <img src="/Photo/icon/statistics.png" alt="Wattala" style="width: 60px; height: 60px;">
                      </div>
                    </div>

                    <div class="stat-card">
                      <div>
                        <h3>Kelaniya</h3>
                        <div class="value" style="font-size: 1.5rem;">Rs.80,000</div>
                      </div>
                      <div>
                        <img src="/Photo/icon/statistics.png" alt="Kelaniya" style="width: 60px; height: 60px;">
                      </div>
                    </div>

                    <div class="stat-card">
                      <div>
                        <h3>Kotahena</h3>
                        <div class="value" style="font-size: 1.5rem;">Rs.80,000</div>
                      </div>
                      <div>
                        <img src="/Photo/icon/statistics.png" alt="Kotahena" style="width: 60px; height: 60px;">
                      </div>
                    </div>
                </div>

                
                
                <div class="card-part-main">
                
                <div class="card-part-2">
                
                <div style="padding-top: 10px; padding-left:20px; padding-right :20px; width:100%; text-align:left" >
                <h2>Reservation Statistics</h2>
                <p style="margin-top:10px; font-size:0.9rem; opacity:0.5;">Visual representation of reservation trends, 
                    showing booking patterns over time for better management.</p>
                </div>

                <div>
                <div class="chart-container" style=" width: 430px; height: 200px;">
                  <canvas id="pieChart" style="width: 100%;"></canvas>
                </div>
                </div>

                </div>

                <div class="card-part">
                    <h2 style="margin-top: 20px; margin-left:20px">Order Wattala</h2>
                    <p style="margin:0 20px; font-size:0.9rem; opacity:0.5">Track and analyze order trends with the Order Statistics Chart, 
                        providing real-time insights into sales performance.</p>

                    <div class="upper-card">
                    <div class="chart-container-bar"  style="height: 200px">
                      <canvas id="lineChart"></canvas>
                    </div>
                    </div>
                </div>

                
              </div>



              
              <div class="card-part-main">
                <div class="card-part">
                    <h2 style="margin-top: 20px; margin-left:20px">Order Kaleniya</h2>
                    <p style="margin:0 20px; font-size:0.9rem; opacity:0.5">Track and analyze order trends with the Order Statistics Chart, 
                        providing real-time insights into sales performance.</p>

                    <div class="upper-card">
                    <div class="chart-container-bar"  style="height: 200px">
                      <canvas id="lineChart-2"></canvas>
                    </div>
                    </div>
                </div>

                <div class="card-part">
                    <h2 style="margin-top: 20px; margin-left:20px">Order Kotahena</h2>
                    <p style="margin:0 20px; font-size:0.9rem; opacity:0.5">Track and analyze order trends with the Order Statistics Chart, 
                        providing real-time insights into sales performance.</p>

                    <div class="upper-card">
                    <div class="chart-container-bar"  style="height: 200px">
                      <canvas id="lineChart-3"></canvas>
                    </div>
                    </div>
                </div>
                
                
              </div>



            
                

            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <div class="section" style="box-shadow: 0 0px 20px rgba(0,0,0,0.1); margin-right: 10px;">
                <h2>Financial Summary</h2>
                
                <div class="activity-section">
                    <div class="activity-item">
                        <div class="money-first">
                        <h3 style="margin-bottom: 5px;">Registrations</h3>
                        <div class="value highlight" style="font-size: 1.2rem;">85</div>
                        </div>

                        <div>
                        <img src="/Photo/icon/partners.png" alt="Income" style="width: 50px; height: 50px;">
                        </div>
                        <!-- <small>+12% from last month</small> -->
                    </div>
                    
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

  

         // Get the canvas context
  const ctx = document.getElementById('pieChart').getContext('2d');

// Data
const data = {
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"], // X-axis labels
  datasets: [
    {
      label: "Wattala",
      data: [65, 59, 80, 81, 56, 55, 40], // Y-axis data
      borderColor: "#1E90FF", // Blue
      backgroundColor: "rgb(30, 143, 255)",
      fill: true,
      borderRadius: 5,
      tension: 0.4, // Smooth curve
    },
    {
      label: "Kelaniya",
      data: [28, 48, 40, 19, 86, 27, 90],
      borderColor: "#2ECC71", // Green
      backgroundColor: "rgb(46, 204, 112)",
      fill: true,
      borderRadius: 5,
      tension: 0.4,
    },
    {
      label: "Kotahena",
      data: [18, 32, 70, 45, 76, 65, 55],
      borderColor: "#E74C3C", // Red
      backgroundColor: "rgb(231, 77, 60)",
      fill: true,
      borderRadius: 5,
      tension: 0.4,
    }
  ]
};

// Options
const options = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false,
      position: "top",
    },
    title: {
      display: false,
      text: "Registration Trends Over Time",
      font: { size: 18 }
    }
  },
  scales: {
    x: {
      grid: { display: false },
      title: {
        display: false,
        text: "Months",
        font: { size: 14 }
      }
    },
    y: {
    grid: { display: false },
      beginAtZero: false,
      title: {
        display: false,
        text: "Registrations",
        font: { size: 14 }
      },
      ticks: {
                color: "#666",
                stepSize: 20,
                callback: function(value) {
                    return value === 100 ? '100' : value;
                }
            }

    }
  }
};

// Create Chart
new Chart(ctx, {
  type: 'bar',
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
            display: false,
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
                stepSize: 20,
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


//line-2 chart
    // --------------- Yearly Line Chart ---------------
     // --------------- Yearly Line Chart ---------------
 const lineCtx2 = document.getElementById('lineChart-2').getContext('2d');

// Abbreviated day labels
const weekDays_2 = ["M", "T", "W", "T", "F", "S", "S"];

const lineData2 = {
    labels: weekDays_2,
    datasets: [{
        label: "Orders",
        data: [60, 50, 60, 50, 30, 40, 10],
        backgroundColor: "#2ecc71",
        borderWidth: 0,
        borderRadius: 5,
        tension: 0.4,
        fill: true,
        pointRadius: 0
    }]
};

const lineOptions2 = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        },
        title: {
            display: false,
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
                stepSize: 20,
                callback: function(value) {
                    return value === 100 ? '100' : value;
                }
            }
        }
    }
};

new Chart(lineCtx2, {
    type: 'bar',
    data: lineData2,
    options: lineOptions2
});


//line-3 chart
 // --------------- Yearly Line Chart ---------------
 const lineCtx3 = document.getElementById('lineChart-3').getContext('2d');

// Abbreviated day labels
const weekDays_3 = ["M", "T", "W", "T", "F", "S", "S"];

const lineData3 = {
    labels: weekDays_3,
    datasets: [{
        label: "Orders",
        data: [60, 50, 60, 50, 30, 40, 10],
        backgroundColor: "#3498db",
        borderWidth: 0,
        borderRadius: 5,
        tension: 0.4,
        fill: true,
        pointRadius: 0
    }]
};

const lineOptions3 = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        },
        title: {
            display: false,
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
                stepSize: 20,
                callback: function(value) {
                    return value === 100 ? '100' : value;
                }
            }
        }
    }
};

new Chart(lineCtx3, {
    type: 'bar',
    data: lineData3,
    options: lineOptions3
});
    </script>
</body>
</html>