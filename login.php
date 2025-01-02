<?php

include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // call registerUser method
  $result = $users->loginUser($_POST);
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | FoodBridge</title>
  <!-- Get the stylesheet from /css -->
  <link rel="stylesheet" href="css/pages/login.css">
</head>

<body>
  <?php include 'includes/nav.php'; ?>

  <section class="container">
    <image src="./images/foodbridge_logo_row.png" alt="FoodBridge Logo" class="form-logo" />
    <form action="" method="post" style="width: 100%;">
      <section class="form-container">
        <span class="input-container">
          <label class="input-label">Email</label>
          <input type="email" name="email" placeholder="Email" class="input-item">
        </span>
        <span class="input-container">
          <label class="input-label">Password</label>
          <input type="password" name="password" placeholder="Password" class="input-item">
        </span>
        <button type="submit" class="login-btn" style="cursor:pointer">Login</button>
        <span class="input-container" style="text-align: center;">
          <a href=" #" class="outbound-url">Forgot your Password?</a>
          <a href="register" class="outbound-url">Don't have an account?</a>
        </span>
        <div id="error-alert"><?php echo $result ?? ''; ?></div>
      </section>
    </form>
  </section>

  <?php include 'includes/footer.php'; ?>
</body>


</html>