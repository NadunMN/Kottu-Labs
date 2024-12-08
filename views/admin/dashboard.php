<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/CSS/admindashboard.css">

</head>
<body>
    <div class="upper-content">
        <div class="button-wrapper-stat">
            <button class="button-stat">Registrations</button>
            <button class="button-stat">Reservations</button>
            <button class="button-stat">Orders</button>
        </div>

        <div class="branch-selection-wrapper">

        <label for="branch">Branch</label>
                    <select id="branch" name="branch">
                        <option value="">All</option>
                        <option value="1">Wattala</option>
                        <option value="2">Kotahena</option>
                        <option value="3">Kelaniya</option>
                    </select>

        </div>
    </div>

    <div class="details-card-wrapper">

        <div class="card">
            <div class="card-header">
                Headcount
            </div>
            <div class="card-body">
                <h1 class="card-title">750</h1>
                <p class="card-text">↑7% vs last year</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Headcount
            </div>
            <div class="card-body">
                <h1 class="card-title">750</h1>
                <p class="card-text">↑7% vs last year</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Headcount
            </div>
            <div class="card-body">
                <h1 class="card-title">750</h1>
                <p class="card-text">↑7% vs last year</p>
            </div>
        </div>

    </div>


    <!-- Charts Section -->
    <div id="columnchart_material" style="width: 800px; height: 500px; background-color:black"></div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses', 'Profit'],
                ['2014', 1000, 400, 200],
                ['2015', 1170, 460, 250],
                ['2016', 660, 1120, 300],
                ['2017', 1030, 540, 350]
            ]);

            var options = {
                chart: {
                    title: 'Company Performance',
                    subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    });
</script>

</body>
</html>