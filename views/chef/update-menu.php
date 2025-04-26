<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/stewardDashboard.css">

    <style>
        /* Main styling */
.view-branch-menu-section {
  padding: 20px;
  border-radius: 8px;
  max-width: 1200px;
  margin: 0 auto;
}

.new-menu-css {
  width: 100%;
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

/* Table styling */
.menu-table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 6px;
  overflow: hidden;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  background-color: white;
  margin-top: 20px;
}

.menu-table thead {
  background-color: #f2f2f2;
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

/* Meal ID styling */
.meal-id {
  font-weight: 600;
  color: #2c3e50;
}

/* Status button styling */
.status-btn {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
}

.available {
  background-color: #2ecc71;
  color: white;
}

.unavailable {
  background-color: #e74c3c;
  color: white;
}

.status-btn:hover {
  opacity: 0.9;
  transform: translateY(-1px);
}

/* Add item form styling */
.add-item-form {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
  z-index: 1000;
  width: 90%;
  max-width: 800px;
}

.add-item-form h3 {
  margin-top: 0;
  color: #2c3e50;
  border-bottom: 2px solid #3498db;
  padding-bottom: 10px;
  margin-bottom: 20px;
}

.form-group-main {
  display: flex;
  gap: 20px;
}

.form-group-main > div {
  flex: 1;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #34495e;
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group select {
  width: 100%;
  padding: 10px;
  border: 1px solid #dcdde1;
  border-radius: 4px;
  font-size: 14px;
  transition: border 0.3s ease;
}

.form-group input[type="text"]:focus,
.form-group input[type="number"]:focus,
.form-group select:focus {
  border-color: #3498db;
  outline: none;
  box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
}

/* Checkbox styling */
.check-box-container {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-top: 10px;
}

.branch-group {
  display: flex;
  align-items: center;
  gap: 5px;
}

.branch-group input[type="checkbox"] {
  cursor: pointer;
}

.branch-group label {
  margin-bottom: 0;
  cursor: pointer;
}

/* Image upload styling */
.image-upload-container {
  border: 2px dashed #dcdde1;
  border-radius: 6px;
  padding: 10px;
  text-align: center;
  position: relative;
  cursor: pointer;
  height: 200px;
  overflow: hidden;
  transition: border-color 0.3s ease;
}

.image-upload-container:hover {
  border-color: #3498db;
}

.image-preview {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

.image-preview img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.upload-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
}

.upload-icon {
  font-size: 2rem;
  margin-bottom: 10px;
  color: #3498db;
}

.image-input {
  opacity: 0;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  cursor: pointer;
  z-index: 2;
}

.image-help-text {
  display: block;
  font-size: 12px;
  color: #7f8c8d;
  margin-top: 8px;
}

.hidden-img {
  display: none;
}

.has-image .upload-placeholder {
  display: none;
}

/* Button styling */
.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
}

.save-item-btn, .cancel-item-btn {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.save-item-btn {
  background-color: #2ecc71;
  color: white;
}

.save-item-btn:hover {
  background-color: #27ae60;
}

.cancel-item-btn {
  background-color: #e0e0e0;
  color: #333;
}

.cancel-item-btn:hover {
  background-color: #bdc3c7;
}

.add-item-btn {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.add-item-btn:hover {
  background-color: #2980b9;
}

/* Hidden class */
.hidden {
  display: none;
}

/* Form overlay */
.add-item-form:not(.hidden)::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: -1;
}

/* Responsive design */
@media screen and (max-width: 768px) {
  .form-group-main {
    flex-direction: column;
  }
  
  .menu-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
  
  .menu-table th,
  .menu-table td {
    padding: 10px 15px;
  }
  
  .topic-bar h2 {
    font-size: 20px;
  }
  
  .add-item-form {
    width: 95%;
    padding: 15px;
  }
}
    </style>
</head>

<body>

    <div class="view-branch-menu-section" id="main-content">   
    </div>

    <script src="/JavaScript/chef/updateMenu.js"></script>
</body>

</html>