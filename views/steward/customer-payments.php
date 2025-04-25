<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/stewardDashboard.css">

    <style>
        /* Main section styling */
.main-section {
  padding: 24px;
  background-color: #f8f9fa;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  max-width: 1200px;
  margin: 0 auto;
}

/* Topic bar styling */
.topic-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e0e0e0;
}

.topic-bar-text h2 {
  margin: 0;
  color: #2c3e50;
  font-size: 26px;
  font-weight: 600;
}

.topic-bar-text span {
  color: #7f8c8d;
  font-size: 15px;
  display: block;
  margin: 6px 0;
}

.topic-bar-text h4 {
  margin: 10px 0 0;
  color: #34495e;
  font-weight: 500;
  font-size: 16px;
}

/* Table styling */
.menu-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  background-color: white;
}

.menu-table thead {
  background-color: #3867d6;
  color: black;
}

.menu-table th {
  padding: 16px 20px;
  text-align: left;
  font-weight: 600;
  font-size: 15px;
  letter-spacing: 0.5px;
}

.menu-table tbody tr {
  border-bottom: 1px solid #e9ecef;
  transition: all 0.2s ease;
}

.menu-table tbody tr:hover {
  background-color: #f1f8fe;
}

.menu-table tbody tr:last-child {
  border-bottom: none;
}

.menu-table td {
  padding: 16px 20px;
  color: #333;
  vertical-align: middle;
}

/* Payment ID styling */
.payment-id {
  font-weight: 600;
  color: #2c3e50;
}

/* Status styling */
.status {
  display: flex;
  align-items: center;
  gap: 12px;
}

.status span {
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
  display: inline-block;
}

.status-0 {
  background-color: #f39c12;
  color: white;
}

.status-1 {
  background-color: #3498db;
  color: white;
}

.status-2 {
  background-color: #2ecc71;
  color: white;
}

/* Confirm button styling */
.confirm-btn {
  background-color: #3867d6;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 6px 12px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
}

.confirm-btn:hover {
  background-color: #2e59c9;
}

.confirm-btn:active {
  transform: translateY(1px);
}

/* Responsive design */
@media screen and (max-width: 768px) {
  .main-section {
    padding: 16px;
  }
  
  .menu-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
  
  .menu-table th, 
  .menu-table td {
    padding: 12px 15px;
  }
  
  .topic-bar-text h2 {
    font-size: 22px;
  }
  
  .confirm-btn {
    padding: 5px 10px;
    font-size: 12px;
  }
}
    </style>
</head>

<body>

    <div class="view-branch-menu-section" id="main-content">   
    </div>

    <script src="/JavaScript/steward/customer-payments.js"></script>
</body>

</html>