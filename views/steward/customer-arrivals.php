<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/stewardDashboard.css">
    <!-- <link rel="stylesheet" href="/CSS/managerDashboard.css"> -->

    <style>
        /* Main section styling */
.main-section {
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  max-width: 1200px;
  margin: 0 auto;
}

/* Topic bar styling */
.topic-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #e0e0e0;
}

.topic-bar-text h2 {
  margin: 0;
  color: #2c3e50;
  font-size: 24px;
}

.topic-bar-text span {
  color: #7f8c8d;
  font-size: 14px;
  display: block;
  margin: 5px 0;
}

.topic-bar-text h4 {
  margin: 10px 0 0;
  color: #34495e;
  font-weight: 500;
}

/* Table styling */
.menu-table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 6px;
  overflow: hidden;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  background-color: white;
}

.menu-table thead {
  background-color: #3498db;
  color: black;
}

.menu-table th {
  padding: 14px 20px;
  text-align: left;
  font-weight: 600;
  font-size: 15px;
}

.menu-table tbody tr {
  border-bottom: 1px solid #e0e0e0;
  transition: background-color 0.2s ease;
}

.menu-table tbody tr:hover {
  background-color: #f1f8fe;
}

.menu-table tbody tr:last-child {
  border-bottom: none;
}

.menu-table td {
  padding: 14px 20px;
  color: #333;
}

/* Reservation number styling */
.reservation-id {
  font-weight: 600;
  color: #2c3e50;
}

/* Status styling */
.status {
  text-align: center;
}

.status span {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
  display: inline-block;
}

.status-1 {
  background-color: #2ecc71;
  color: white;
}

.status-0 {
  background-color: #f39c12;
  color: white;
}

/* Responsive design */
@media screen and (max-width: 768px) {
  .menu-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
  
  .menu-table th, 
  .menu-table td {
    padding: 10px 15px;
  }
  
  .topic-bar-text h2 {
    font-size: 20px;
  }
}
    </style>

</head>

<body>
    <div class="view-branch-menu-section" id="main-content">   
    </div>

    <script src="/JavaScript/steward/customer-arrivals.js"></script>
</body>

</html>