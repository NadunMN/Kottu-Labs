<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff Member</title>
    <link rel="stylesheet" href="/CSS/admindashboard.css">
    <!-- <link rel="stylesheet" href="/CSS/managerDashboard.css"> -->

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
    <div class="container">
        <div class="topic-bar">
        <h1>Update Staff Member</h1>
        <button id="toggleFormBtn" class="toggleFormBtn">Add Member</button>
        </div>

        <form id="staffForm" class="staff-form">
            <div class="form-body">
                
                <div class="details-section">
                    <div class="form-section">
                        <h2>Personal Information</h2>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" accept="image/*">
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" name="firstname" id="firstName" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" name="lastname" id="lastName" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" name='date_of_birth' id="dob">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="nationality">Nationality</label>
                                    <select id="nationality" name="nationality">
                                        <option value="">Select Nationality</option>
                                        <option value="sl">Sri Lankan</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Gender</label>
                            <div class="radio-group">
                                <label class="radio-item">
                                    <input type="radio" name="gender" value="male"> Male
                                </label>
                                <label class="radio-item">
                                    <input type="radio" name="gender" value="female"> Female
                                </label>
                                <label class="radio-item">
                                    <input type="radio" name="gender" value="other"> Other
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Employment Details</h2>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="position">Position *</label>
                                    <select id="position" name="position" required>
                                        <option value="">Select Position</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Chef">Chef</option>
                                        <option value="Steward">Steward</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="branch">Branch *</label>
                                    <select id="branch_id" name="branch_id" required>
                                        <option value="">Select Branch</option>
                                        <option value="1">Wattala</option>
                                        <option value="2">Kelaniya</option>
                                        <option value="3">Kotahena</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Contact Information</h2>
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" name="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="tel" name="mobile_number" id="mobile">
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                           <div class="form-col">
                                <div class="form-group">
                                    <label for="email">Password *</label>
                                    <input type="text" name="password" id="password" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="mobile">Confirmation Password *</label>
                                    <input type="text" name="confirmPassword" id="confirmPassword" required>
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>

    <table class="menu-table" id="menu-table">
                                                <thead>
                                                    <tr>
                                                        <th>Member ID</th>
                                                        <th>Photo</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile Number</th>
                                                        <th>Position</th>
                                                        <th>Branch</th>
                                                        <th>Join Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content"></tbody>
                                            </table>
                                        </div>

    

    <script src="/JavaScript/admin/staff.js"></script>
</body>
</html>