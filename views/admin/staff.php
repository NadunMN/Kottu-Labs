<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff Member</title>
    <link rel="stylesheet" href="/CSS/admindashboard.css">
    <link rel="stylesheet" href="/CSS/managerDashboard.css">
</head>
<body>
    <div class="container">
        <div class="header">
        <h1>Update Staff Member</h1>
        <button id="toggleFormBtn" class="toggleFormBtn">Add Member</button>
        </div>

        <form id="staffForm" class="staff-form">
            <div class="form-body">
                
                <div class="details-section">
                    <div class="form-section">
                        <h2>Personal Information</h2>

                        <div class="form-group">
                            <label for="address">Photo</label>
                            <input type="file" id="photo" accept="image/*">
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" id="firstName" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" id="lastName" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" id="dob">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="nationality">Nationality</label>
                                    <select id="nationality">
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
                                    <select id="position" required>
                                        <option value="">Select Position</option>
                                        <option value="adim">Admin</option>
                                        <option value="manager">Manager</option>
                                        <option value="chef">Chef</option>
                                        <option value="steward">Steward</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="branch">Branch *</label>
                                    <select id="branch" required>
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
                                    <input type="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="tel" id="mobile">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">Add Staff Member</button>
        </form>
    </div>

    <table class="menu-table" id="menu-table">
                                                <thead>
                                                    <tr>
                                                        <th>Meal ID</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Price</th>
                                                        <th>Branch</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content"></tbody>
                                            </table>
                                        </div>

    

    <script src="/JavaScript/admin/staff.js"></script>
</body>
</html>