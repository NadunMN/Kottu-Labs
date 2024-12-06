<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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


    <div class="graph-container-wrapper">

        <div class="graph-container">
        <h2>Cashflow</h2>
        <div class="graph">
            <canvas id="cashflowChart"></canvas>
        </div>
        </div>
        
    </div>
    
    <script src="/JavaScript/adminDashboard.js"></script>
</body>
</html>