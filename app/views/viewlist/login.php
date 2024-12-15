<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
  
    <link rel="stylesheet" href="/foodbridge/public/assets/css/styles.css">
</head>
<body>
<?php include(ROOT . '/app/views/includes/header.php'); ?>

    
    <div class="space-below-header"></div>

    
    <div class="logo-container">
        <img src="/foodbridge/public/assets/images/foodbridge-logo-ver1.png" alt="FoodBridge Logo" class="logo">
    </div>

    
    <div class="combined-square">
       
        <div class="input-container">
            <label class="label">Email</label>
            <input type="email" class="input-field" placeholder="Enter your email">
        </div>

      
        <div class="input-container">
            <label class="label">Password</label>
            <input type="password" class="input-field" placeholder="Enter your password">
        </div>

        
        <button class="login-button">Login</button>

       
        <div class="forgot-password">
            <a href="#" class="forgot-password-link">Forgot Password?</a>
        </div>

       
        <div class="sign-up-prompt">
            <span>Don't have an account? <a href="/foodbridge/option">Sign up now</a></span>
        </div>
    </div>

<?php include(ROOT . '/app/views/includes/footer.php'); ?>
</body>
</html>
