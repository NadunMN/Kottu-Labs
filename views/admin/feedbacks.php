<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
   /* Modern CSS for Staff Management Interface */

/* General Reset and Base Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
  color: #333;
  line-height: 1.6;
  padding: 1.5rem;
}

/* Header Styles */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 1.2rem;
  border-bottom: 1px solid #e0e5eb;
}

.header h1 {
  color: #1e293b;
  font-size: 1.8rem;
  font-weight: 600;
  letter-spacing: -0.01em;
}

.toggleFormBtn {
  background-color: #3b82f6;
  color: white;
  border: none;
  padding: 0.7rem 1.5rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.2s ease;
  box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

.toggleFormBtn:hover {
  background-color: #2563eb;
  transform: translateY(-1px);
  box-shadow: 0 4px 6px rgba(59, 130, 246, 0.4);
}

.toggleFormBtn:active {
  transform: translateY(0);
  box-shadow: 0 1px 2px rgba(59, 130, 246, 0.3);
}

/* Table Styles */
.menu-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background-color: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  margin-top: 2rem;
}

.menu-table thead {
  background-color: #f1f5f9;
}

.menu-table th {
  padding: 1.2rem 1rem;
  text-align: left;
  font-weight: 600;
  color: #334155;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
}

.menu-table td {
  padding: 1rem;
  border-bottom: 1px solid #e2e8f0;
  color: #475569;
  text-align: left;
  vertical-align: middle;
}

.menu-table tbody tr {
  transition: background-color 0.15s ease;
}

.menu-table tbody tr:hover {
  background-color: #f8fafc;
}

.menu-table tbody tr:last-child td {
  border-bottom: none;
}

/* Photo column styling */
.menu-table td img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e2e8f0;
}

/* Action Buttons styles */
.menu-table .action-btn {
  padding: 0.5rem 0.9rem;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  margin-right: 0.5rem;
  font-size: 0.85rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.menu-table .edit-btn {
  background-color: #3b82f6;
  color: white;
}

.menu-table .edit-btn:hover {
  background-color: #2563eb;
}

.menu-table .delete-btn {
  background-color: #ef4444;
  color: white;
}

.menu-table .delete-btn:hover {
  background-color: #dc2626;
}

.menu-table .view-btn {
  background-color: #10b981;
  color: white;
}

.menu-table .view-btn:hover {
  background-color: #059669;
}

/* Submit button styling */
.submit-btn {
  background-color: #10b981;
  color: white;
  border: none;
  padding: 0.9rem 1.8rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.2s ease;
  margin-top: 1.5rem;
  box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
}

.submit-btn:hover {
  background-color: #059669;
  transform: translateY(-1px);
  box-shadow: 0 4px 6px rgba(16, 185, 129, 0.4);
}

.submit-btn:active {
  transform: translateY(0);
  box-shadow: 0 1px 2px rgba(16, 185, 129, 0.3);
}

/* Responsive Adjustments */
@media (max-width: 1024px) {
  .menu-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
}

@media (max-width: 768px) {
  .header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  
  body {
    padding: 1rem;
  }
  
  .toggleFormBtn, .submit-btn {
    width: 100%;
  }
}


/* Base styling for all staff-created divs */
.staff-created {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  border-radius: 5px;
  padding: 5px 10px;
  font-size: 0.85rem;
  font-weight: 500;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Position-specific colors */
/* Admin - Blue theme */
.staff-created[data-position="admin"] {
  background-color: #e6f0ff;
  color: #2557a7;
  border-left: 3px solid #4285f4;
}

/* Manager - Green theme */
.staff-created[data-position="manager"] {
  background-color: #e6f7ed;
  color: #0a6c40;
  border-left: 3px solid #0f9d58;
}

/* Chef - Orange theme */
.staff-created[data-position="chef"] {
  background-color: #fff0e6;
  color: #b35900;
  border-left: 3px solid #ff9800;
}

/* Steward - Purple theme */
.staff-created[data-position="steward"] {
  background-color: #f0e6ff;
  color: #6200b3;
  border-left: 3px solid #9c27b0;
}

/* Hover effects */
.staff-created:hover {
  opacity: 0.9;
}

.topic-bar{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: #f8fafc;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

</style>

</head>

<body>

    <div class="view-branch-menu-section" id="main-content">   
    </div>

    <script src="/JavaScript/admin/feedbacks.js"></script>
</body>

</html>