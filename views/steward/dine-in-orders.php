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
  padding: 25px;
  background-color: #f8f9fa;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  max-width: 1200px;
  margin: 0 auto;
}

/* Topic bar styling */
.topic-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 1px solid #dee2e6;
}

.topic-bar-text h2 {
  margin: 0;
  color: #2c3e50;
  font-size: 26px;
  font-weight: 600;
}

.topic-bar-text span {
  color: #6c757d;
  font-size: 15px;
  display: block;
  margin: 6px 0;
}

.topic-bar-text h4 {
  margin: 10px 0 0;
  color: #495057;
  font-weight: 500;
  font-size: 16px;
}

/* Table styling */
.menu-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 8px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  background-color: white;
}

.menu-table thead {
  background-color: #4361ee;
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
  background-color: #f0f5ff;
}

.menu-table tbody tr:last-child {
  border-bottom: none;
  padding-bottom:10px ;
}

.menu-table td {
  padding: 16px 20px;
  color: #333;
  vertical-align: middle;
}

/* Order item styling */
.order-item {
  position: relative;
}

.name {
  font-weight: 500;
  color: #2c3e50;
}

.order_id {
  font-weight: 600;
  color: #3a506b;
}

/* Dropdown styling */
details {
  position: relative;
  width: fit-content;
}

summary {
  padding: 8px 14px;
  background-color: #ebedf2;
  border-radius: 6px;
  color: #4361ee;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  list-style: none;
  display: flex;
  align-items: center;
}

summary::-webkit-details-marker {
  display: none;
}

summary::after {
  content: "▼";
  font-size: 10px;
  margin-left: 8px;
  transition: transform 0.3s;
}

details[open] summary::after {
  transform: rotate(180deg);
}

summary:hover {
  background-color: #dbe1ff;
}

details ul {
  position: absolute;
  z-index: 10;
  margin-top: 8px;
  padding: 10px 15px;
  list-style-type: none;
  background-color: white;
  border-radius: 6px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  min-width: 180px;
}

details ul li {
  padding: 6px 0;
  border-bottom: 1px solid #f0f0f0;
  color: #495057;
}

details ul li:last-child {
  border-bottom: none;
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
  background-color: #4361ee;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 7px 14px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.confirm-btn:hover {
  background-color: #3249c2;
  transform: translateY(-1px);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.confirm-btn:active {
  transform: translateY(1px);
  box-shadow: none;
}

/* Responsive design */
@media screen and (max-width: 768px) {
  .main-section {
    padding: 16px;
  }
  
  .menu-table {
    display: block;
    /* overflow-x: auto; */
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
  
  summary {
    padding: 6px 10px;
    font-size: 13px;
  }
}
    </style>
</head>

<body>

    <div class="view-branch-menu-section" id="main-content">   
    </div>

    <script src="/JavaScript/steward/dine-in-orders.js"></script>
</body>

</html>