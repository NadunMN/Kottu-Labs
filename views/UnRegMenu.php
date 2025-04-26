<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>String Validation</title>
    <link rel="stylesheet" href="/CSS/enterpin.css">

    <style>

/* General styling and reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}


.container-mainwraaper {
  width: 100%;
    height: 90vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container-aa {
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  padding: 40px;
  width: 90%;
  max-width: 600px;
  text-align: center;
}

/* Header styling */
h1 {
  color: #2c3e50;
  margin-bottom: 30px;
  font-weight: 600;
  font-size: 28px;
}

/* Setup section styling */
.setup-section {
  display: flex;
  gap: 12px;
  margin-bottom: 30px;
}

.input-field {
  flex: 1;
  padding: 14px 16px;
  border: 2px solid #e0e5ec;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s, box-shadow 0.3s;
  outline: none;
}

.input-field:focus {
  border-color: black;
  box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
}

.input-field::placeholder {
  color: #b2b9c5;
}

.action-btn {
  background-color: black;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 14px 28px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s;
}

.action-btn:hover {
  background-color: #EE3E3F;
}

.action-btn:active {
  transform: translateY(2px);
}

/* Verification messages styling */
.verification-message {
  padding: 16px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 500;
  margin-top: 10px;
  display: none; /* Hidden by default */
}

.success {
  background-color: #e8f8f5;
  color: #27ae60;
  border-left: 4px solid #27ae60;
}

.error {
  background-color: #fdedeb;
  color: #e74c3c;
  border-left: 4px solid #e74c3c;
}

/* Responsive adjustments */
@media (max-width: 600px) {
  .container-aa {
    padding: 30px 20px;
  }
  
  .setup-section {
    flex-direction: column;
  }
  
  .action-btn {
    width: 100%;
  }
}
    </style>
</head>
<body>

<div class="container-mainwraaper" id="container-mainwraaper">
    <div class="container-aa">
        <h1>Menu Access</h1>
        
        <div class="setup-section">
            <input type="text" id="input-string" class="input-field" placeholder="Enter Reservation Number">
            <button id="verify-btn" class="action-btn">Verify</button>
        </div>
        
        <div class="verification-message success" id="success-message">
            Validation successful!
        </div>
        
        <div class="verification-message error" id="error-message">
            Invalid string. Please try again.
        </div>
    </div>
    </div>











    
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>

    <script src="/JavaScript/UnRegMenu.js"></script>
    <!-- <script src="/JavaScript/enterpin.js"></script> -->

</body>
</html>