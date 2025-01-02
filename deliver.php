<?php

include 'includes/header.php';
require_once 'classes/Session.php';

Session::init();

if (Session::get('id') == null) {
  header("Location: login");
  return;
}

if (Session::get('role') !== 'volunteer') {
  header("Location: get-involved");
  return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['select_delivery'])) {
  if (isset($_POST['delivery_id']) && !empty($_POST['delivery_id'])) {
    $deliveryId = $_POST['delivery_id'];

    // Call the selectDelivery function
    $result = $deliveries->selectDelivery($deliveryId);

    if ($result) {
      echo "<p style='color: green; text-align: center;'>Delivery selected successfully!</p>";
    } else {
      echo "<p style='color: red; text-align: center;'>Failed to select delivery. Please try again.</p>";
    }
  } else {
    echo "<p style='color: red; text-align: center;'>Invalid delivery ID.</p>";
  }
}

$userDonationsUndelivered = $donations->getDonationsByStatus('pending');

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
      <section class="form-container" style="
  overflow-y: auto; 
  padding: 1rem; 
  padding-top: 1.5rem;
">
        <?php if (!empty($userDonationsUndelivered)): ?>
        <?php foreach ($userDonationsUndelivered as $donation): ?>
        <form method="post" action="">
          <div style="
          display: flex;
          flex-direction: column;
          background-color: white;
          border: 1px solid var(--primary);
          border-radius: 0.5rem;
          padding: 1rem;
          margin-bottom: 1rem;
        ">
            <strong style="margin-bottom: 0.5rem;">
              <?php echo isset($donation['food_description']) ? htmlspecialchars($donation['food_description']) : 'No description available'; ?>
            </strong>
            <span style="margin-bottom: 0.5rem;">
              <?php echo isset($donation['quantity']) ? htmlspecialchars($donation['quantity']) : 'No address provided'; ?>
            </span>
            <em style="color: gray; font-size: 0.9rem;">
              <?php echo isset($donation['pickup_time']) ? htmlspecialchars($donation['pickup_time']) : 'Quantity not specified'; ?>
            </em>

            <!-- Hidden input for delivery ID -->
            <input type="hidden" name="delivery_id" value="<?php echo htmlspecialchars($donation['id']); ?>">

            <!-- Submit Button -->
            <button type="submit" name="select_delivery" style="
            margin-top: 0.5rem;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 0.3rem;
            cursor: pointer;
          ">
              Select
            </button>
          </div>
        </form>
        <?php endforeach; ?>
        <?php else: ?>
        <p style="text-align: center; color: gray;">No pending deliveries.</p>
        <?php endif; ?>
      </section>

    </form>
  </section>

  <?php include 'includes/footer.php'; ?>
</body>


</html>