<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="/CSS/viewUsers.css">
</head>
<body>
    <div class="view-users-section">
        <h2>View Users</h2>
        <table class="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Contact No.</th>
                    <th></th> <!-- Empty header for Delete button -->
                </tr>
            </thead>
            <tbody>
                <!-- Example user data -->
                <tr>
                    <td>John Doe</td>
                    <td>johndoe@example.com</td>
                    <td>Admin</td>
                    <td>027282</td>
                    <td>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>janesmith@example.com</td>
                    <td>User</td>
                    <td>027282</td>
                    <td>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>


