<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kottu Lab - Branch Selection & Takeaway Reservation</title>
    <style>
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container-selec {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            padding: 20px 0;
        }
        
        .logo-selec {
            font-size: 2.5rem;
            font-weight: bold;
            color: #e63946;
            margin-bottom: 10px;
        }
        
        .tagline {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
        }
        
        .main-content {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            padding-bottom: 20px;
        }
        
        .branch-selection {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
            transition: all 0.5s ease-in-out;
        }
        
        .branch-selection.hidden {
            display: none;
        }
        
        .branch-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 350px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            position: relative;
        }
        
        .branch-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .branch-image {
            height: 200px;
            overflow: hidden;
        }
        
        .branch-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .branch-card:hover .branch-image img {
            transform: scale(1.05);
        }
        
        .branch-details {
            padding: 20px;
        }
        
        .branch-name {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #e63946;
        }
        
        .branch-address {
            color: #555;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
        
        .branch-description {
            margin-bottom: 20px;
            color: #666;
        }
        
        .select-btn {
            background-color: #e63946;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        
        .select-btn:hover {
            background-color: #c1121f;
        }
        
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        
        .modal.active {
            opacity: 1;
            pointer-events: all;
        }
        
        .modal-content {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            max-width: 500px;
            width: 90%;

        }
        
        .modal-title {
            font-size: 2rem;
            color: #e63946;
            margin-bottom: 20px;
        }
        
        .modal-message {
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .continue-btn, .change-btn, .submit-btn, .back-btn {
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .continue-btn, .submit-btn {
            background-color: #e63946;
            color: white;
            border: none;
        }
        
        .continue-btn:hover, .submit-btn:hover {
            background-color: #c1121f;
        }
        
        .change-btn, .back-btn {
            background-color: transparent;
            color: #555;
            border: 1px solid #ddd;
        }
        
        .change-btn:hover, .back-btn:hover {
            background-color: #f5f5f5;
        }
        
        /* Takeaway Form Styles */
        .reservation-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            display: none;
            width: 750px;
            max-width: 100%;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .reservation-form.active {
            display: block;
        }
        
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .form-title {
            font-size: 1.5rem;
            color: #e63946;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #e63946;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
            width: 500px;
            max-width: 100%;
        }
        
        .success-message.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .confirmation-note {
            font-size: 0.85rem;
            color: #666;
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
        
        .branch-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #e63946;
        }
        
        .branch-info-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #e63946;
        }

        @media (max-width: 768px) {
            .branch-selection {
                flex-direction: column;
                align-items: center;
            }
            
            .branch-card {
                width: 100%;
                max-width: 350px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .reservation-form {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-selec">
        <header id="header">
            <div class="logo-selec">Kottu Lab</div>
            <div class="tagline">Experience the authentic taste of Sri Lanka</div>
        </header>
        
        <main class="main-content">
            <div id="selectionSection">
                <h2 style="text-align: center; margin-bottom: 20px;">Select a Branch Location</h2>
                <div class="branch-selection" id="branchSelection">
                    <div class="branch-card" data-branch="wattala">
                        <div class="branch-image">
                            <img src="/Photo/Thirani_pics/Wattala.png" alt="Wattala Branch">
                        </div>
                        <div class="branch-details">
                            <h3 class="branch-name">Wattala Branch</h3>
                            <p class="branch-address">123 Main Street, City Center</p>
                            <p class="branch-description">Our flagship location with indoor and outdoor seating in the heart of the city.</p>
                            <button class="select-btn">Select This Branch</button>
                        </div>
                    </div>
                    
                    <div class="branch-card" data-branch="kotahena">
                        <div class="branch-image">
                            <img src="/Photo/Thirani_pics/Kotahena.jpg" alt="Kotahena Branch">
                        </div>
                        <div class="branch-details">
                            <h3 class="branch-name">Kotahena Branch</h3>
                            <p class="branch-address">45 Harbor View, Marina Bay</p>
                            <p class="branch-description">Enjoy our delicious kottu with a stunning view of the waterfront.</p>
                            <button class="select-btn">Select This Branch</button>
                        </div>
                    </div>
                    
                    <div class="branch-card" data-branch="kelaniya">
                        <div class="branch-image">
                            <img src="/Photo/Thirani_pics/Kelaniya.jpg" alt="Kelaniya Branch">
                        </div>
                        <div class="branch-details">
                            <h3 class="branch-name">Kelaniya Branch</h3>
                            <p class="branch-address">78 Highland Road, Uptown District</p>
                            <p class="branch-description">Our newest location featuring our expanded menu and private dining options.</p>
                            <button class="select-btn">Select This Branch</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="success-message" id="successMessage">
                Your takeaway order has been successfully placed! We'll see you at the selected time.
            </div>
            
            <div class="reservation-form" id="takeawayForm">
                <div class="form-header">
                    <h2 class="form-title">Takeaway Reservation</h2>
                    <button class="back-btn" id="backToSelection">Change Branch</button>
                </div>
                
                <div class="branch-info">
                    <div class="branch-info-title">Selected Branch</div>
                    <div id="selectedBranchDisplay">Downtown</div>
                    <div id="selectedBranchAddress" style="font-size: 0.9rem; color: #666; margin-top: 5px;">123 Main Street, City Center</div>
                </div>
                
                <form id="reservationForm" action="/reservationNumber" method="POST">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="reservation_name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pickupDate">Pickup Date</label>
                            <input type="date" id="pickupDate" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="pickupTime">Pickup Time</label>
                            <input type="time" id="pickupTime" class="form-control" required>
                        </div>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="notes">Special Instructions (Optional)</label>
                        <textarea id="notes" class="form-control" rows="3"></textarea>
                    </div> -->
                    
                    <div style="text-align: center; margin-top: 30px;">
                        <button type="submit" class="submit-btn">Place Takeaway Order</button>
                    </div>
                    
                    <div class="confirmation-note">
                        A confirmation email will be sent to your email address with your reservation number, pickup date and time. Please keep this information for reference.
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <script src="/JavaScript/menu.js"></script>
</body>
</html>