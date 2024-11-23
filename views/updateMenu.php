<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu</title>
    <link rel="stylesheet" href="/CSS/update-menu.css">
</head>
<body>
    <div class="update-menu-section">
        <h2>Update Menu</h2>
        
        <!-- Form for Adding/Editing Menu Items -->
        <form id="update-menu-form" method="POST" action="update-menu-handler.php">
            <div class="form-group">
                <label for="menu-item-name">Item Name:</label>
                <input type="text" id="menu-item-name" name="item_name" required placeholder="Enter item name">
            </div>
            
            <div class="form-group">
                <label for="menu-item-description">Description:</label>
                <textarea id="menu-item-description" name="description" required placeholder="Enter item description"></textarea>
            </div>
            
            <div class="form-group">
                <label for="menu-item-price">Price:</label>
                <input type="number" id="menu-item-price" name="price" required placeholder="Enter item price">
            </div>
            
            <div class="form-group">
                <label for="menu-item-category">Category:</label>
                <select id="menu-item-category" name="category" required>
                    <option value="Kottu">Kottu</option>
                    <option value="Rice">Rice</option>
                    <option value="Roti">Roti</option>
                    <option value="Beverages">Beverages</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="update-btn">Update Item</button>
            </div>
        </form>

        <div class="menu-items-list">
            <h3>Current Menu Items</h3>
            <!-- Example Menu Items -->
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kottu Special</td>
                        <td>Spicy and tasty Kottu</td>
                        <td>1500</td>
                        <td>Kottu</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Chicken Rice</td>
                        <td>Fried rice with chicken</td>
                        <td>1200</td>
                        <td>Rice</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
