<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Account Type</title>
    <link rel="stylesheet" href="/foodbridge/public/assets/css/styles.css"> <!-- Update path -->
</head>
<body>
    <?php include(ROOT . '/app/views/includes/header.php'); ?>

    <!-- Page Content -->
    <div class="account-type-container">
        <!-- Logo Image -->
        <div class="logo-container">
            <img src="/foodbridge/public/assets/images/foodbridge-logo-ver1.png" alt="FoodBridge Logo" class="logo">
        </div>

        <!-- Heading -->
        <h1 class="account-type-heading">Choose the Account Type</h1>

        <!-- Buttons arranged in a pyramid shape -->
        <div class="button-pyramid">
            <!-- Updated links for redirecting -->
            <a href="/foodbridge/app/views/signup?account_type=donor" class="account-button">Donor</a>
            <div class="row">
                <a href="/foodbridge/app/views/signup?account_type=volunteer" class="account-button">Volunteer</a>
                <a href="/foodbridge/app/views/signup?account_type=receiving_agency" class="account-button">Receiving Agency</a>
            </div>
        </div>
    </div>

    <?php include(ROOT . '/app/views/includes/footer.php'); ?>
</body>
</html>
