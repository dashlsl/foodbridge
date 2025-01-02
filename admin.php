<?php
include 'includes/header.php';
require_once 'classes/Session.php';
require_once 'classes/Admin.php';

Session::init();

if (!Session::get('isAdmin')) {
    header('Location: index.php');
    exit();
}
$userDonations = $donations->getAllDonations();
$users = $admin->getAllUsers();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $result = $admin->deleteUser($_POST['user_id']);
    if ($result) {
        header('Location: admin.php'); // Redirect to refresh the page
        exit();
    } else {
        echo "Failed to delete user.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $userId = $_POST['user_id'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone'];
    $newAddress = $_POST['address'];
    $newStatus = $_POST['status'];
    $newPoints = $_POST['points'];

    $result = $admin->updateUserInfo($userId, $newEmail, $newPhone, $newAddress, $newStatus, $newPoints);
    if ($result) {
        header('Location: admin.php'); // Redirect to refresh the page
        exit();
    } else {
        echo "Failed to update user information.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | FoodBridge</title>
    <link rel="stylesheet" href="css/pages/admin.css">
    <script>
        function enableEdit(button, userId) {
            // Get the row of the clicked button
            var row = button.closest('tr');

            // Replace the fields with input elements
            var email = row.querySelector('.email');
            var phone = row.querySelector('.phone');
            var address = row.querySelector('.address');
            var points = row.querySelector('.points');

            email.innerHTML = `<input type="email" name="email" value="${email.innerText}" required>`;
            phone.innerHTML = `<input type="tel" name="phone" value="${phone.innerText}" required>`;
            address.innerHTML = `<input type="text" name="address" value="${address.innerText}" required>`;
            points.innerHTML = `<input type="number" name="points" value="${points.innerText}" required>`;

            // Change the Edit button to a Save button
            button.innerText = "Save";
            button.setAttribute("onclick", `saveUser(${userId}, this)`);
        }

        function saveUser(userId, button) {
            // Get the row of the clicked button
            var row = button.closest('tr');

            // Prepare the form data
            var email = row.querySelector('[name="email"]').value;
            var phone = row.querySelector('[name="phone"]').value;
            var address = row.querySelector('[name="address"]').value;
            var points = row.querySelector('[name="points"]').value;
            var status = row.querySelector('.status').innerText; // Assuming status remains static

            // Create a form element dynamically to submit the data
            var form = document.createElement('form');
            form.method = 'POST';
            form.style.display = 'none';

            form.innerHTML = `
                <input type="hidden" name="user_id" value="${userId}">
                <input type="hidden" name="email" value="${email}">
                <input type="hidden" name="phone" value="${phone}">
                <input type="hidden" name="address" value="${address}">
                <input type="hidden" name="points" value="${points}">
                <input type="hidden" name="status" value="${status}">
                <input type="hidden" name="edit_user" value="1">
            `;

            document.body.appendChild(form);
            form.submit();
        }

        function confirmDelete(userId) {
            // Show confirmation popup
            var confirmation = confirm('Are you sure you want to delete this user?');
            if (confirmation) {
                // Populate the hidden input with the user ID
                document.getElementById('delete-user-id').value = userId;
                // Submit the delete form
                document.getElementById('delete-form').submit();
            }
        }
    </script>
</head>
<body>
<div class="admin-container">
    <div class="sidebar">
        <div class="logo-container">
            <img src="\foodbridge\images\foodbridge_logo_col.png" alt="FoodBridge Logo" class="logo">
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="sidebar-link" id="userManagementLink">User Management</a></li>
            <li><a href="#" class="sidebar-link" id="donationHistoryLink">Donation History</a></li>
            <li><a href="#" class="sidebar-link" id="reportLink">Report</a></li>
            <li><a href="#" class="sidebar-link" id="settingsLink">Settings</a></li>
        </ul>
        <div class="sidebar-button-container">
            <a href="index.php" class="sidebar-button">Back to Main Site</a>
        </div>
    </div>
    <div class="main-content">
        <div class="user-management-view" id="userManagementView">
            <div class="table-container">
                <h2>User Management</h2>
                <table class="user-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="user-id"><?php echo $user['id']; ?></td>
                            <td class="email"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="role"><?php echo htmlspecialchars($user['role']); ?></td>
                            <td class="phone"><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td class="address"><?php echo htmlspecialchars($user['address']); ?></td>
                            <td class="status"><?php echo htmlspecialchars($user['status']); ?></td>
                            <td class="points"><?php echo htmlspecialchars($user['points']); ?></td>
                            <td>
                                <button class="action-button" onclick="enableEdit(this, <?php echo $user['id']; ?>)">Edit</button>
                                <button class="action-button" onclick="confirmDelete(<?php echo $user['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Delete Confirmation Form (Hidden) -->
                <form id="delete-form" method="POST">
                    <input type="hidden" name="user_id" id="delete-user-id">
                    <input type="hidden" name="delete_user" value="1">
                </form>
            </div>
        </div>

        <div class="donation-history-view" id="donationHistoryView">
            <h2>Donation History</h2>
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
    </div>
</div>
<script>
  // Initially show the user management view
  document.getElementById('userManagementView').style.display = 'block';

  function hideAllViews() {
    document.getElementById('userManagementView').style.display = 'none';
    document.getElementById('donationHistoryView').style.display = 'none';
  }

    // Show the User Management table view
  document.getElementById('userManagementLink').addEventListener('click', function() {
    event.preventDefault();
    hideAllViews();
    document.getElementById('userManagementView').style.display = 'block';
    setActiveLink(this);
  });

  // Show the Donation History table view
  document.getElementById('donationHistoryLink').addEventListener('click', function() {
    event.preventDefault();
    hideAllViews();
    document.getElementById('donationHistoryView').style.display = 'block';
    setActiveLink(this);
  });

  // Function to set active link
  function setActiveLink(link) {
    var links = document.querySelectorAll('.sidebar-link');
    links.forEach(function (item) {
        item.classList.remove('active');
    });
    link.classList.add('active');
  }

</script>

</body>
</html>