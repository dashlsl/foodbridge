<?php

include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // call registerUser method
  $result = $users->registerUser($_POST);

  // if the result is successful, redirect to login page
  if ($result === 'Registered successfully. Redirecting to login page...') {
    header("refresh:2;url=login");
  }
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | FoodBridge</title>
  <!-- Get the stylesheet from /css -->
  <link rel="stylesheet" href="css/pages/register.css">
</head>

<body>
  <?php include 'includes/nav.php'; ?>

  <section class="container">
    <image src="./images/foodbridge_logo_row.png" alt="FoodBridge Logo" class="form-logo" />
    <form action="" method="post">
      <section class="form-container">
        <span class="input-container">
          <label class=" input-label">Email</label>
          <input class="input-item" type="email" name="email" placeholder="Email"
            value="<?php echo htmlspecialchars($email ?? ''); ?>">
        </span>
        <span class="input-container">
          <label class=" input-label">Password</label>
          <input class="input-item" type="password" name="password" placeholder="Password">
        </span>
        <span class="input-container">
          <label class=" input-label">Role</label>
          <select name="role">
            <option value="" disabled selected>Select Role</option>
            <option value="donor" <?php echo ($role ?? '') === 'donor' ? 'selected' : ''; ?>>Donor</option>
            <option value="volunteer" <?php echo ($role ?? '') === 'volunteer' ? 'selected' : ''; ?>>Volunteer</option>
            <option value="receiver" <?php echo ($role ?? '') === 'receiver' ? 'selected' : ''; ?>>Receiver</option>
          </select>
        </span>
        <span class="input-container">
          <label class=" input-label">Phone</label>
          <input class="input-item" type="tel" name="phone" placeholder="Phone"
            value="<?php echo htmlspecialchars($phone ?? ''); ?>">
        </span>
        <span class="input-container">
          <label class=" input-label">Address</label>
          <input class="input-item" type="textarea" name="address" placeholder="Address"
            value="<?php echo htmlspecialchars($address ?? ''); ?>">
        </span>
        <div id="error-alert"><?php echo $result ?? ''; ?></div>
        <button type submit class="register-btn">Register</button>
      </section>
    </form>
  </section>

  <?php include 'includes/footer.php'; ?>

</body>

</html>