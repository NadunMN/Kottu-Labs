<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/stewardDashboard.css">

    <style>
        /* Main section styling */
/* Main container styling */

.main-section {
  font-family: 'Roboto', 'Segoe UI', sans-serif;
  max-width: 1200px;
  margin: 0 auto;
  border-radius: 8px;
  overflow: hidden;
}

/* Topic bar styling */
.topic-bar {
  background-image: url('/Photo/700f5af3-b1b6-417b-bb47-ee21ac8fb270.webp');
  background-size: cover;
  background-position: center;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  color: white;
  padding: 16px 24px;
  position: relative;
}

.topic-bar-text {
  display: flex;
  flex-direction: column;
}

/* Heading styles */
.topic-bar h2 {
  margin: 0 0 4px 0;
  font-size: 24px;
  font-weight: 600;
  letter-spacing: 0.5px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
  color: white;
  filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.5));

}

.topic-bar span {
  font-size: 14px;
  opacity: 0.9;
  margin-bottom: 12px;
  color: white;
  filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.75));
}

.topic-bar h4 {
  margin: 8px 0 0 0;
  font-weight: 500;
  font-size: 16px;
  background-color: rgba(255, 255, 255, 0.06);
  padding: 8px 12px;
  border-radius: 4px;
  display: inline-block;
  color: white;
  filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.5));
}

/* Add a subtle accent border */
.topic-bar::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: linear-gradient(to right, black, #EE3E3F);
}

/* Media query for responsive design */
@media (max-width: 768px) {
  .topic-bar {
    padding: 12px 16px;
  }
  
  .topic-bar h2 {
    font-size: 20px;
  }
  
  .topic-bar h4 {
    font-size: 14px;
  }
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
  align-items: center;
  gap: 12px;
}

/*list style*/
ul {
  padding: 0;
  margin: 0;
  list-style-type: none;
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  max-width: 100%;
}

ul li {
  display: inline-flex;
  align-items: center;
  background-color: #f0f0f0;
  border-radius: 20px;
  padding: 8px 16px;
  font-size: 14px;
  color: #333;
  border: 1px solid #e0e0e0;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  margin-bottom: 8px;
  transition: all 0.2s ease;
}

ul li:hover {
  background-color: #e8e8e8;
  transform: translateY(-2px);
  box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
}

/* Styling for the confirm button */
.confirm-meal-btn {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 15px;
  padding: 4px 10px;
  margin-left: 10px;
  cursor: pointer;
  font-size: 12px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.confirm-meal-btn:hover {
  background-color: #3d8b40;
}

/* Styling for the done text */
.meal-done-text {
  background-color: #e0e0e0;
  color: #666;
  border-radius: 15px;
  padding: 4px 10px;
  margin-left: 10px;
  font-size: 12px;
  font-weight: 500;
}
/*list style*/





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
.confirm-btn, .confirm-meal-btn {
  background-color: #4361ee;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 7px 14px;
  font-size: 13px;
  font-weight: 500;
  align-items: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.confirm-btn:hover, .confirm-meal-btn:hover  {
  background-color: #3249c2;
  transform: translateY(-1px);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.confirm-btn:active, .confirm-meal-btn:active  {
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



/*no orders*/


        
        .empty-state {
          position: fixed;

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 40px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            
            /* transition: transform 0.3s ease; */
        }
        
        /* .empty-state:hover {
            transform: translateY(-5px);
        }
         */
        .icon-container {
            margin-bottom: 24px;
        }
        
        .icon {
            width: 120px;
            height: 120px;
            background-color: #f3f4f6;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
        
        .icon svg {
            width: 60px;
            height: 60px;
            color: #6b7280;
        }
        
        h2 {
            font-size: 24px;
            color: #1f2937;
            margin-bottom: 16px;
        }
        
        p {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 32px;
            line-height: 1.5;
        }
        
        .btn {
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            background-color: #4338ca;
        }
        
        .secondary-text {
            margin-top: 16px;
            font-size: 14px;
            color: #9ca3af;
        }
        
        .secondary-link {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }
        
        .secondary-link:hover {
            text-decoration: underline;
        }
/*no orders*/


    </style>
</head>

<body>

    <div class="view-branch-menu-section" id="main-content">   
    </div>

    <script src="/JavaScript/steward/dine-in-orders.js"></script>
</body>

</html>