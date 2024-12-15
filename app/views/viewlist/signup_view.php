<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/foodbridge/public/assets/css/styles.css">
</head>
<body>
    <!-- Header Section -->
    <?php include(ROOT . '/app/views/includes/header.php'); ?>

    <!-- Sign Up Section -->
    <div class="signup-container">
        <h1>Sign Up</h1>
        <div class="signup-box">
            <form class="signup-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include(ROOT . '/app/views/includes/footer.php'); ?>
</body>
</html>
