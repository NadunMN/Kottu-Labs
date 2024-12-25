<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/CSS/admindashboard.css">

</head>
<body>

<div class="details-card-wrapper">
      
      <div class="card-container">
        <div class="card">
            <div class="card-body">
              <div class="card-header">
                <img src="/Photo/icon/wallet.png" alt="">
                <p class="card-text">Wattala</p>

                <div class="stat">
                  <p>2.5%</p>
                </div>
              </div>
                <p class="card-title">Rs. 150,000.00</p>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
              <div class="card-header">
                <img src="/Photo/icon/wallet.png" alt="">
                <p class="card-text">Kelaniya</p>
                <div class="stat">
                  <p>2.5%</p>
                </div>
              </div>
                <p class="card-title">Rs. 100,000.00</p>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
              <div class="card-header">
                <img src="/Photo/icon/wallet.png" alt="">
                <p class="card-text">Kotahena</p>
                <div class="stat">
                  <p>2.5%</p>
                </div>
              </div>
                <p class="card-title">Rs. 90,000.00</p>
            </div>
        </div>

        
      </div>

    </div>

    <!-- Charts Section -->
<div class="chart-container-wrapper">
    <div class="chart-container-1" style="border-radius: 10px; ">
      <div class="chart-topic">
          <p class="graph-topics">Number of Ragistrations</p>
      </div>
      <canvas id="myChart" style="width: 100%; height:250px;padding: 10px;"></canvas>
    </div>

    <div class="chart-container-2" style="border-radius: 10px; ">
    <div class="chart-topic">
    <p class="graph-topics">Rate of Orders</p>
    </div>
      <canvas id="myChart2" style="width: 100%; height:300px;padding: 10px;"></canvas>
    </div>
</div>


<div class="another-part">

  <div class="top-header">
    <p>Top Meals</p>
  </div>

  <div class="top-body">
    <p>Cheese Kottu</p>
  </div>



</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  
  const ctx = document.getElementById('myChart');

  
  new Chart(ctx, {
    type: 'bar', 
    data: {
      labels: [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
      ],
      datasets: [
        {
          label: 'New Jobs by Company Size', 
          data: [100,50,150,200,75,100,150,200,75,100,150,200], 
          backgroundColor: 'rgb(203, 53, 53)', 
          hoverBackgroundColor: 'rgb(238, 62, 63)', 
          borderRadius: 5,
          barThickness: 30 
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: '#fff', // Tooltip background color
          titleColor: '#000', // Tooltip title color
          bodyColor: '#000', // Tooltip text color
          borderWidth: 1, // Tooltip border width
          borderColor: 'rgba(0, 0, 0, 0.1)' // Tooltip border color
        }
      },
      scales: {
        x: {
          ticks: {
            color: '#6b7280', // Gray color for x-axis labels
            font: {
              size: 12 // Font size for x-axis labels
            }
          },
          grid: {
            display: false // Hide vertical grid lines
          }
        },
        y: {
          ticks: {
            color: '#6b7280', // Gray color for y-axis labels
            font: {
              size: 12 // Font size for y-axis labels
            },
            callback: function(value) {
              return value; // Default format for y-axis values
            }
          },
          grid: {
            color: 'rgba(0, 0, 0, 0.05)', // Subtle horizontal grid lines
            drawBorder: false // Remove border lines around the chart
          },
          beginAtZero: true // Start y-axis at zero
        }
      }
    }
  });
</script>


<script>
        const ctx2 = document.getElementById('myChart2');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Wattala', 'Kelaniya', 'Kotahena'],
                datasets: [{
                    data: [45, 35, 20],
                    backgroundColor: [
                        'rgb(238, 62, 63)',
                        'rgb(191, 62, 238)',
                        'rgb(147, 62, 238)'
                    ],
                    borderColor: [
                        '#ffffff',
                        '#ffffff',
                        '#ffffff'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderWidth: 1,
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${context.label}: ${percentage}%`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    </script>

</body>
</html>