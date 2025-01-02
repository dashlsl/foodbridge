<!-- Not to be confused with header -->
<?php
require_once 'classes/Session.php';
Session::init();

// on clicking logout, destroy session and redirect to login page
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  Session::destroy();
  header("Location: login");
}

?>

<link rel="stylesheet" href="css/nav.css">

<nav class="navbar" id="navbar" name="navbar">
  <a href="./">
    <image src="./images/foodbridge_logo_row.png" alt="FoodBridge Logo" class="logo" />
  </a>
  <a href="#" class="nav-link">Learn</a>
  <a href="#" class="nav-link">Get Involved</a>
  <a href="#" class="nav-link">Support</a>
  <a href="#" class="nav-link">Locations</a>
  <a href="#" class="nav-link">About</a>
  <!-- <a href="login" class="nav-link" style="margin-left:auto">Login</a>\ -->
  <?php
  if (Session::get('id')) {
    echo '<a href="login?action=logout" class="nav-link" style="margin-left:auto">Logout</a>';
  } else {
    echo '<a href="login" class="nav-link" style="margin-left:auto">Login</a>';
  }
  ?>

  <?php
  if (Session::get('id')) {
    echo "Points: " . Session::get('points');
  } else {
    echo '';
  }
  ?>

  <?php
  // if the user isAdmin the donate button will say "Admin"
  if (Session::get('isAdmin')) {
    echo '<a href="admin" class="nav-link donate-button">Admin</a>';
  // if the user role is volunteer the donate button will say "Deliver"
  } else if (Session::get('role') === 'volunteer') {
    echo '<a href="deliver" class="nav-link donate-button">Deliver</a>';
  // if the user role is receiver the donate button will say "Request"
  } else if (Session::get('role') === 'receiver') {
    echo '<a href="request" class="nav-link donate-button">Request</a>';
  // if the user role is donor the donate button will say "Donate"
  } else {
    echo '<a href="donate" class="nav-link donate-button">Donate</a>';
  }
  ?>
</nav>