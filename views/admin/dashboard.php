<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/CSS/admindashboard.css">

</head>
<body>
    <!-- <div class="upper-content">
        <div class="button-wrapper-stat">
            <button class="button-stat">Registrations</button>
            <button class="button-stat">Reservations</button>
            <button class="button-stat">Orders</button>
        </div>

        
    </div> -->

    <div class="details-card-wrapper">
      
      <div class="card-container">
        <div class="card">
            <div class="card-body">
                <img src="/Photo/icon/wallet.png" alt="">
                <h1 class="card-text">Wattala</h1>
                <h1 class="card-title">Rs. 150,000.00</h1>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <img src="/Photo/icon/wallet.png" alt="">
                <h1 class="card-text">Keleniya</h1>
                <h1 class="card-title">Rs.200,000.00</h1>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <img src="/Photo/icon/wallet.png" alt="">
                <h1 class="card-text">Kotahena</h1>
                <h1 class="card-title">Rs.90,000.00</h1>
            </div>
        </div>
      </div>

    </div>


    <!-- Charts Section -->
<div class="chart-container-wrapper">
    <div class="chart-container" style="border-radius: 10px; ">
      <div class="chart-topic">
          <h2 style="margin-top: 0; margin-bottom:5px">Rate of Ragistrations</h2>
          <p style="margin-bottom:10px; margin-top:0;">2024</p>
      </div>
      <canvas id="myChart" style="width: 100%; height:100%;"></canvas>
    </div>

    <div class="chart-container" style="border-radius: 10px; ">
    <div class="chart-topic">
    <h2 style="margin-top: 0; margin-bottom:5px">Rate of Orders</h2>
    <p style="margin-bottom:10px; margin-top:0;">2024</p>
      </div>
      <canvas id="myChart2" style="width: 100%; height:100%;"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [
      {
        label: 'Wattala',
        data: [12, 55, 53, 58, 60, 62, 61, 63, 64, 65, 67, 69],
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderWidth: 2,
        fill: false,
        tension: 0.4,
        pointRadius: 6,
        pointStyle: 'circle', // Change this to 'circle'
        pointBackgroundColor: 'white',
        pointBorderColor: 'rgba(54, 162, 235, 1)',
        pointHoverRadius: 8
      },
      {
        label: 'Kelaniya',
        data: [30, 35, 33, 32, 34, 36, 35, 37, 38, 40, 39, 42],
        borderColor: 'rgba(255, 165, 0, 1)',
        backgroundColor: 'rgba(255, 165, 0, 0.2)',
        borderWidth: 2,
        fill: false,
        tension: 0.4,
        pointRadius: 6,
        pointStyle: 'circle', // Change this to 'circle'
        pointBackgroundColor: 'white',
        pointBorderColor: 'rgba(255, 165, 0, 1)',
        pointHoverRadius: 8
      },
      {
        label: 'Kotahena',
        data: [30, 35, 3, 2, 36, 1, 30, 30, 38, 4, 39, 42],
        borderColor: 'rgb(55, 39, 10)',
        backgroundColor: 'rgba(109, 73, 5, 0.2)',
        borderWidth: 2,
        fill: false,
        tension: 0.4,
        pointRadius: 6,
        pointStyle: 'circle', // Change this to 'circle'
        pointBackgroundColor: 'white',
        pointBorderColor: 'rgb(111, 96, 68)',
        pointHoverRadius: 8
      }
    ]
    },
    options: {
    responsive: true,
    plugins: {
      legend: {
        display: true,
        align: 'end',
        labels: {
          color: '#4a4a4a',
          font: {
            size: 10
          },
          pointStyle: 'circle' // Correct placement of pointStyle
        }
      },
      tooltip: {
        backgroundColor: '#fff', // White tooltip
        titleColor: '#000', // Black title
        bodyColor: '#000', // Black text
        borderWidth: 1,
        borderColor: 'rgba(0, 0, 0, 0.1)', // Subtle border
        callbacks: {
          label: function(context) {
            const value = context.raw.toLocaleString('en-US'); // Return just the number
            return `${context.dataset.label}: ${value}`;
          }
        }
      }
    },
    scales: {
      x: {
        ticks: {
          color: '#4a4a4a' // Dark gray x-axis labels
        },
        grid: {
          display: false // Hides vertical grid lines for a cleaner look
        }
      },
      y: {
        ticks: {
          color: '#4a4a4a', // Dark gray y-axis labels
          callback: function(value) {
            return value; 
          }
        },
        grid: {
          color: 'rgba(0, 0, 0, 0.05)' // Subtle horizontal grid lines
        },
        beginAtZero: true
      }
    }
  }
  });
</script>

<script>
  const ctx2 = document.getElementById('myChart2');
  new Chart(ctx2, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [
      {
        label: 'Wattala',
        data: [50, 55, 53, 58, 60, 62, 61, 63, 64, 65, 67, 69],
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderWidth: 2,
        fill: false,
        tension: 0.4,
        pointRadius: 6,
        pointStyle: 'circle', // Change this to 'circle'
        pointBackgroundColor: 'white',
        pointBorderColor: 'rgba(54, 162, 235, 1)',
        pointHoverRadius: 8
      },
      {
        label: 'Kelaniya',
        data: [30, 35, 33, 32, 34, 36, 35, 37, 38, 40, 39, 42],
        borderColor: 'rgba(255, 165, 0, 1)',
        backgroundColor: 'rgba(255, 165, 0, 0.2)',
        borderWidth: 2,
        fill: false,
        tension: 0.4,
        pointRadius: 6,
        pointStyle: 'circle', // Change this to 'circle'
        pointBackgroundColor: 'white',
        pointBorderColor: 'rgba(255, 165, 0, 1)',
        pointHoverRadius: 8
      },
      {
        label: 'Kotahena',
        data: [30, 35, 33, 25, 36, 15, 30, 30, 38, 40, 39, 42],
        borderColor: 'rgb(55, 39, 10)',
        backgroundColor: 'rgba(109, 73, 5, 0.2)',
        borderWidth: 2,
        fill: false,
        tension: 0.4,
        pointRadius: 6,
        pointStyle: 'circle', // Change this to 'circle'
        pointBackgroundColor: 'white',
        pointBorderColor: 'rgb(111, 96, 68)',
        pointHoverRadius: 8
      }
    ]
    },
    options: {
    responsive: true,
    plugins: {
      legend: {
        display: true,
        align: 'end',
        labels: {
          color: '#4a4a4a',
          font: {
            size: 10
          },
          pointStyle: 'circle' // Correct placement of pointStyle
        }
      },
      tooltip: {
        backgroundColor: '#fff', // White tooltip
        titleColor: '#000', // Black title
        bodyColor: '#000', // Black text
        borderWidth: 1,
        borderColor: 'rgba(0, 0, 0, 0.1)', // Subtle border
        callbacks: {
          label: function(context) {
            const value = context.raw.toLocaleString('en-US'); // Return just the number
            return `${context.dataset.label}: ${value}`;
          }
        }
      }
    },
    scales: {
      x: {
        ticks: {
          color: '#4a4a4a' // Dark gray x-axis labels
        },
        grid: {
          display: false // Hides vertical grid lines for a cleaner look
        }
      },
      y: {
        ticks: {
          color: '#4a4a4a', // Dark gray y-axis labels
          callback: function(value) {
            return value; // Display in 'K' format
          }
        },
        grid: {
          color: 'rgba(0, 0, 0, 0.05)' // Subtle horizontal grid lines
        },
        beginAtZero: true
      }
    }
  }
  });
</script>


</body>
</html>