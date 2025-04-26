<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/stewardDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Main section styling */
.main-section {
  padding: 22px;
  background-color: #f8f9fa;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
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
  font-weight: 600;
}

.topic-bar-text span {
  color: #6c757d;
  font-size: 14px;
  display: block;
  margin: 5px 0;
}

.topic-bar-text h4 {
  margin: 8px 0 0;
  color: #495057;
  font-weight: 500;
  font-size: 15px;
}

/* Filter section styling */
.filter-section {
  display: flex;
  gap: 8px;
  align-items: center;
}

.filter-section input {
  padding: 8px 12px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 14px;
  width: 180px;
}

.filter-section button {
  padding: 8px 14px;
  background-color: #4b6bfb;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.filter-section button:hover {
  background-color: #3951cf;
}

.filter-section button:last-child {
  background-color: #6c757d;
}

.filter-section button:last-child:hover {
  background-color: #5a6268;
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
  background-color: #4b6bfb;
  color: black;
}

.menu-table th {
  padding: 14px 16px;
  text-align: left;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.5px;
}

.menu-table tbody tr {
  border-bottom: 1px solid #e9ecef;
  transition: all 0.2s ease;
}

.menu-table tbody tr:hover {
  background-color: #f1f6ff;
}

.menu-table tbody tr:last-child {
  border-bottom: none;
}

.menu-table td {
  padding: 14px 16px;
  color: #333;
  font-size: 14px;
  vertical-align: middle;
}

/* Order item styling */
.order-item {
  position: relative;
}

.order-id {
  font-weight: 600;
  color: #2c3e50;
}

/* Status styling - enhanced */
.status-0 { 
  color: #e74c3c; 
  font-weight: bold;
  padding: 5px 10px;
  background-color: rgba(231, 76, 60, 0.1);
  border-radius: 4px;
}

.status-1 { 
  color: #f39c12; 
  font-weight: bold;
  padding: 5px 10px;
  background-color: rgba(243, 156, 18, 0.1);
  border-radius: 4px;
}

.status-2 { 
  color: #27ae60; 
  font-weight: bold;
  padding: 5px 10px;
  background-color: rgba(39, 174, 96, 0.1);
  border-radius: 4px;
}

.status-3 { 
  color: #7f8c8d;
  padding: 5px 10px;
  background-color: rgba(127, 140, 141, 0.1);
  border-radius: 4px;
}

/* Dropdown styling */
details {
  position: relative;
  width: fit-content;
}

summary {
  padding: 8px 14px;
  background-color: #edf2ff;
  border-radius: 6px;
  color: #4b6bfb;
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
  background-color: #dbe4ff;
}

details ul {
  position: absolute;
  z-index: 10;
  margin-top: 8px;
  padding: 0;
  list-style-type: none;
  background-color: white;
  border-radius: 6px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  min-width: 220px;
  border: 1px solid #e9ecef;
}

details ul li {
  padding: 10px 14px;
  border-bottom: 1px solid #f0f0f0;
  color: #495057;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

details ul li:last-child {
  border-bottom: none;
}

/* Action buttons styling */
.action-buttons {
  display: flex;
  gap: 8px;
}

.action-buttons button {
  padding: 7px 12px;
  border: none;
  border-radius: 4px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.accept-btn {
  background-color: #4b6bfb;
  color: white;
}

.accept-btn:hover:not(:disabled) {
  background-color: #3951cf;
}

.done-btn {
  background-color: #2ecc71;
  color: white;
}

.done-btn:hover:not(:disabled) {
  background-color: #27ae60;
}

.action-buttons button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Meal done button styling */
.meal-done-btn {
  background-color: #2ecc71;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 4px 8px;
  font-size: 12px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.meal-done-btn:hover:not(:disabled) {
  background-color: #27ae60;
}

.meal-done-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Responsive design */
@media screen and (max-width: 992px) {
  .topic-bar {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .filter-section {
    margin-top: 15px;
    width: 100%;
  }
  
  .filter-section input {
    flex-grow: 1;
  }
}

@media screen and (max-width: 768px) {
  .main-section {
    padding: 15px;
  }
  
  .menu-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
  
  .menu-table th, 
  .menu-table td {
    padding: 12px;
  }
  
  .topic-bar-text h2 {
    font-size: 20px;
  }
  
  .filter-section {
    flex-wrap: wrap;
  }
  
  .filter-section input {
    width: 100%;
    margin-bottom: 8px;
  }
  
  .filter-section button {
    flex: 1;
  }
  
  .action-buttons {
    flex-direction: column;
  }
  
  details ul {
    position: static;
    width: 100%;
  }
}
    </style>
    
</head>

<body>

    <div class="view-branch-menu-section" id="main-content">   
    </div>

    <script src="/JavaScript/chef/viewOrder.js"></script>
</body>

</html>