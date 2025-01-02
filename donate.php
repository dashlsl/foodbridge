<?php

include 'includes/header.php';
require_once 'classes/Session.php';

Session::init();

if (Session::get('id') == null) {
  header("Location: login");
  return;
}

if (Session::get('role') !== 'donor') {
  header("Location: get-involved");
  return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // call createDonation method
  $result = $donations->createDonation($_POST);
}

$userDonations = $donations->getDonationsByDonorId(Session::get('id'));

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donate | FoodBridge</title>
  <!-- Get the stylesheet from /css -->
  <link rel="stylesheet" href="css/pages/login.css">
</head>

<body>
  <?php include 'includes/nav.php'; ?>

  <section class="container">
    <image src="./images/foodbridge_logo_row.png" alt="FoodBridge Logo" class="form-logo" />
    <form action="" method="post">
      <section class="form-container">
        <span class="input-container">
          <label class=" input-label">Food Description</label>
          <input class="input-item" type="text" name="food_desc" placeholder="Food description"
            value="<?php echo htmlspecialchars($foodDesc ?? ''); ?>">
        </span>
        <span class="input-container">
          <label class="input-label">Quantity</label>
          <input class="input-item" type="text" name="quantity" placeholder="e.g., 10kg, 20 packets"
            value="<?php echo htmlspecialchars($quantity ?? ''); ?>">
        </span>
        <span class="input-container">
          <label class="input-label">Pickup Time</label>
          <input class="input-item" type="datetime-local" name="pickup_time"
            value="<?php echo htmlspecialchars($pickupTime ?? ''); ?>">
        </span>
        <button type="submit" class="login-btn" style="cursor:pointer">Donate</button>
        <span class="input-container" style="text-align: center;">
          <a href=" #" class="outbound-url">Need Help?</a>
          <a href="register" class="outbound-url">Contact Us</a>
        </span>
        <div id="error-alert"><?php echo $result ?? ''; ?></div>
      </section>
    </form>
  </section>

  <h2>Your Donations</h2>
  <section style="
  /* display flex, flex 1 per item */
  display: flex;
  width: 70%;
  gap: 1rem;
  flex-wrap: wrap;
  margin-bottom: 2rem;
  ">
    <!-- map out all the donations -->
    <?php
    foreach ($userDonations as $donation) {
      echo "<article style='
      display: flex; 
      flex-direction: 
      column; 
      justify-content: center; 
      align-items: flex-center; 
      gap: 1rem; 
      flex: 1; 
      flex-shrink: 0; 
      border: 1px solid var(--primary); 
      padding: 2rem;
      border-radius: 1rem;
      '>";
      echo "<div style='font-weight:bold;'>" . $donation['food_description'] . "</div>";
      echo "<div>" . $donation['quantity'] . "</div>";
      echo "<div>" . $donation['pickup_time'] . "</div>";
      echo "<div>" . $donation['status'] . "</div>";
      echo "</article>";
    }
    ?>
  </section>

  <?php include 'includes/footer.php'; ?>
</body>


</html>