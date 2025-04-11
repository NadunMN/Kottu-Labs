let monthlyUserCounts = [];
let result = {};

// --- Registration Bar Chart ---
fetch("/dashboard/getRegistration")
  .then((response) => response.json())
  .then((data) => {
    const currentYear = new Date().getFullYear();
    monthlyUserCounts = Array(12).fill(0);

    data.forEach(item => {
      if (item.year === currentYear) {
        const index = item.month - 1;
        monthlyUserCounts[index] = item.user_count;
      }
    });

    const registrationCtx = document.getElementById('registrationBarChart').getContext('2d');
    new Chart(registrationCtx, {
      type: 'bar',
      data: {
        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
        datasets: [{
          label: `Registrations (${currentYear})`,
          data: monthlyUserCounts,
          backgroundColor: 'rgba(255, 99, 132, 0.8)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 0,
          borderRadius: 6,
          barPercentage: 0.7,
          categoryPercentage: 0.8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 12, padding: 20, font: { size: 11 } }
          },
          tooltip: {
            mode: 'index',
            intersect: false,
            backgroundColor: 'rgba(255, 255, 255, 0.9)',
            titleColor: '#333',
            bodyColor: '#666',
            borderColor: '#ddd',
            borderWidth: 1,
            padding: 10,
            callbacks: {
              label: function (context) {
                return `${context.dataset.label}: ${context.raw}`;
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false, drawBorder: false },
            ticks: { font: { size: 10 } }
          },
          y: {
            position: 'right',
            grid: { color: 'rgba(200, 200, 200, 0.2)', drawBorder: false },
            ticks: { stepSize: 10, font: { size: 10 } }
          }
        }
      }
    });
  })
  .catch((error) => console.error("Error fetching registration data:", error));

// --- Order Count Line Chart ---
fetch("/dashboard/orderCount")
  .then((response) => response.json())
  .then((data) => {
    const currentYear = new Date().getFullYear();
    const branches = ["Kelaniya", "Wattala", "Kotahena"];
    const result = {};

    branches.forEach(branch => {
      result[branch] = Array(12).fill(0);
    });

    const currentYearData = data.filter(item => item.orderYear === currentYear);

    currentYearData.forEach(({ branchName, orderMonth, order_count }) => {
      if (result[branchName]) {
        result[branchName][orderMonth - 1] = order_count;
      }
    });

    const allValues = [].concat(...Object.values(result));
    const maxValue = Math.max(...allValues);
    const suggestedMax = maxValue + 1;

    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
      type: 'bar',
      data: {
        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
        datasets: [
          {
            label: 'Wattala',
            data: result["Wattala"],
            backgroundColor: 'rgba(255, 99, 132, 0.3)',
            borderColor: 'rgba(255, 99, 132, 1)',
            fill: true,
            tension: 0.4,
            pointRadius: 0,
            pointHoverRadius: 5
          },
          {
            label: 'Kelaniya',
            data: result["Kelaniya"],
            backgroundColor: 'rgba(54, 162, 235, 0.3)',
            borderColor: 'rgba(54, 162, 235, 1)',
            fill: true,
            tension: 0.4,
            pointRadius: 0,
            pointHoverRadius: 5
          },
          {
            label: 'Kotahena',
            data: result["Kotahena"],
            backgroundColor: 'rgba(75, 192, 192, 0.3)',
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: true,
            tension: 0.4,
            pointRadius: 0,
            pointHoverRadius: 5
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12,
              padding: 20,
              font: { size: 11 }
            }
          },
          tooltip: {
            mode: 'index',
            intersect: false,
            backgroundColor: 'rgba(255, 255, 255, 0.9)',
            titleColor: '#333',
            bodyColor: '#666',
            borderColor: '#ddd',
            borderWidth: 1,
            padding: 10,
            callbacks: {
              label: function (context) {
                return `${context.dataset.label}: ${context.raw}`;
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false, drawBorder: false },
            ticks: { font: { size: 10 } }
          },
          y: {
            position: 'right',
            grid: {
              color: 'rgba(200, 200, 200, 0.2)',
              drawBorder: false
            },
            ticks: {
              stepSize: 10,
              font: { size: 10 }
            },
            suggestedMax: suggestedMax
          }
        }
      }
    });
  })
  .catch((error) => console.error("Error fetching order count:", error));

// --- Display current date ---
document.addEventListener('DOMContentLoaded', function () {
  const dateElement = document.getElementById('current-date');
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  dateElement.textContent = new Date().toLocaleDateString(undefined, options);
});
