<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Page</title>
    <link rel="stylesheet" href="/foodbridge/public/assets/css/styles.css">
</head>
<body>
<?php include(ROOT . '/app/views/includes/header.php'); ?>

<!-- Centralized Donation Form Heading with Inline Style -->
<div class="donation-heading" style="margin-top: 50px; text-align: center;">
    <h1>Donation Form</h1>
</div>

<!-- Rounded Square Box under the Donation Form -->
<div class="donation-box">
    <!-- Contact Label and Input Field -->
    <div class="contact-container">
        <label for="contact" class="contact-label">Contact</label>
        <input type="text" id="contact" class="contact-input" placeholder="Enter your contact number">
    </div>

    <!-- Pickup or Delivery Dropdown -->
    <div class="delivery-container">
        <label for="delivery" class="delivery-label"></label>
        <select id="delivery" class="delivery-dropdown">
            <option value="pickup" selected>Pickup</option>
            <option value="delivery">Delivery</option>
        </select>
    </div>

    <!-- Address Label and Input Field -->
    <div class="address-container">
        <label for="address" class="address-label">Address</label>
        <input type="text" id="address" class="address-input" placeholder="Enter your address">
    </div>
</div>

<!-- Donation History Title Below the Rounded Box -->
<div class="donation-history">
    <h2>Donation History</h2>
</div>

<!-- Rounded Oval Search Bar Below Donation History -->
<div class="search-container">
    <input type="text" id="search" class="search-bar" placeholder="Search donation history">
    <button class="search-btn">
        <i class="fa fa-search"></i> <!-- FontAwesome search icon -->
    </button>
</div>

<!-- Six Rounded Rectangle Boxes (Two by Three Layout) -->
<div class="box-container">
    <div class="box">Donation 1</div>
    <div class="box">Donation 2</div>
    <div class="box">Donation 3</div>
    <div class="box">Donation 4</div>
    <div class="box">Donation 5</div>
    <div class="box">Donation 6</div>
</div>

<?php include(ROOT . '/app/views/includes/footer.php'); ?>
</body>
</html>
