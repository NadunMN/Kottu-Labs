<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Restaurant Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #28a745;
            --background-gradient: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            --text-dark: #343a40;
            --text-light: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.6;
        }

        .error-container {
            padding: 3rem;
            border-radius: 1rem;
            max-width: 700px;
            width: 90%;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .error-icon {
            font-size: 4.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        .error-code {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .error-message {
            color: var(--text-dark);
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .error-details {
            background: rgba(220, 53, 69, 0.05);
            padding: 1.25rem;
            border-radius: 0.5rem;
            margin: 2rem 0;
            text-align: left;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary {
            background: var(--text-light);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 480px) {
            .error-container {
                padding: 2rem;
            }
            
            .error-message {
                font-size: 1.25rem;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .debug-info {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: var(--text-light);
        }
    </style>
</head>
<body>
    <?php
    // Ensure $exception is defined
    if (!isset($exception)) {
        $exception = new Exception('Unknown error', 500);
    }

    // Set proper HTTP response code
    if (isset($response_code) && is_numeric($response_code)) {
        http_response_code((int)$response_code); // Ensure the response code is an integer
    } else {
        http_response_code(500); // Default to 500 if the response code is invalid
    }
    
    // Configure error details
    $errorCode = $exception->getCode() ?: 500;
    $errorMessage = htmlspecialchars($exception->getMessage());
    $errorFile = htmlspecialchars($exception->getFile());
    $errorLine = $exception->getLine();
    
    // User-friendly messages
    $friendlyMessages = [
        400 => 'Bad Request - Invalid request received',
        401 => 'Unauthorized - Please authenticate',
        403 => 'Forbidden - Insufficient permissions',
        404 => 'Page Not Found - The requested resource is unavailable',
        500 => 'Internal Server Error - We\'re working to fix this',
        503 => 'Service Unavailable - Maintenance in progress'
    ];
    
    $friendlyMessage = $friendlyMessages[$errorCode] ?? 'An unexpected error occurred';
    ?>

    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <div class="error-code">
            HTTP <?php echo $errorCode; ?>
        </div>
        
        <h1 class="error-message">
            <?php echo $friendlyMessage; ?>
        </h1>

        <?php if (defined('APP_DEBUG')): ?>
        <div class="error-details">
            <strong>Technical Details:</strong><br>
            <?php echo $errorMessage; ?><br>
            <small>
                In <?php echo $errorFile; ?> on line <?php echo $errorLine; ?><br>
                <?php if (method_exists($exception, 'getTraceAsString')): ?>
                Stack Trace:<br>
                <pre><?php echo htmlspecialchars($exception->getTraceAsString()); ?></pre>
                <?php endif; ?>
            </small>
        </div>
        <?php endif; ?>

        <div class="action-buttons">
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Return Home
            </a>
            <a href="/contact" class="btn btn-secondary">
                <i class="fas fa-life-ring"></i>
                Contact Support
            </a>
        </div>

        <div class="debug-info">
            Request ID: <?php echo uniqid('RMS-'); ?> | 
            <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>
</body>
</html>