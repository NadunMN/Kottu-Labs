<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Modal</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .modal {
            background-color: white;
            width: 90%;
            max-width: 480px;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .close-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #888;
            padding: 5px;
        }
        
        .modal-content {
            text-align: center;
            margin: 15px 0 25px;
        }
        
        .modal-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 12px;
            color: #222;
        }
        
        .modal-message {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }
        
        .modal-actions {
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }
        
        .button {
            flex: 1;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            border: none;
        }
        
        .button-cancel {
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .button-cancel:hover {
            background-color: #e5e5e5;
        }
        
        .button-delete {
            background-color: #ff4088;
            color: white;
        }
        
        .button-delete:hover {
            background-color: #e63679;
        }
    </style>
</head>
<body>
    <div class="modal-overlay" id="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <div></div>
                <button class="close-button" id="close-button">&times;</button>
            </div>
            <div class="modal-content">
                <h2 class="modal-title">Are you sure?</h2>
                <p class="modal-message">Are you sure you want to delete this item? This action cannot be undone.</p>
            </div>
            <div class="modal-actions">
                <button class="button button-cancel" id="cancel-button">Cancel</button>
                <button class="button button-delete" id="delete-button">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Get modal elements
        const modalOverlay = document.getElementById('modal-overlay');
        const closeButton = document.getElementById('close-button');
        const cancelButton = document.getElementById('cancel-button');
        const deleteButton = document.getElementById('delete-button');

        // Close modal function
        function closeModal() {
            modalOverlay.style.display = 'none';
        }

        // Event listeners
        closeButton.addEventListener('click', closeModal);
        cancelButton.addEventListener('click', closeModal);
        deleteButton.addEventListener('click', function() {
            alert('Item deleted!');
            closeModal();
        });

        // Optional: Function to open the modal
        function openModal() {
            modalOverlay.style.display = 'flex';
        }

        function showConfirmationModal(message) {
        return new Promise((resolve) => {
            document.querySelector(".modal-message").textContent = message;
            modalOverlay.style.display = 'flex';

            deleteButton.onclick = () => {
            closeModal();
            resolve(true);
            };

            cancelButton.onclick = closeButton.onclick = () => {
            closeModal();
            resolve(false);
            };
        });
        }


        // To show the modal programmatically, call:
        // openModal();
        
    </script>

    <script src="/JavaScript/admin/staff.js"></script>
</body>
</html>