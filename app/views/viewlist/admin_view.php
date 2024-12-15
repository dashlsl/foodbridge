<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="$root/public/assets/css/styles.css">
    <style>
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto; 
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        td {
            background-color: #fafafa;
        }

        .table-container {
            margin-top: 20px;
        }

        
        .table-container h2 {
            margin-bottom: 15px;
        }

       
        .default-view, .user-management-view, .donation-history-view {
            display: none;
        }

        .logout-container {
            margin-top: 30px;
        }

       
        .sidebar-link.active {
            color: red;
            font-weight: bold;
        }

        
        @media (max-width: 768px) {
            table {
                font-size: 14px;
                overflow-x: auto;
            }
            th, td {
                padding: 8px;
            }
        }

    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="/foodbridge/public/assets/images/foodbridge-logo-ver1.png" alt="FoodBridge Logo" class="logo">
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="sidebar-link" id="dashboardLink">Admin Dashboard</a></li>
                <li><a href="#" class="sidebar-link" id="userManagementLink">User Management</a></li>
                <li><a href="#" class="sidebar-link" id="donationHistoryLink">Donation History</a></li>
                <li><a href="#" class="sidebar-link" id="reportLink">Report</a></li>
                <li><a href="#" class="sidebar-link" id="settingsLink">Settings</a></li>
            </ul>
            <div class="logout-container">
                <button class="logout-button">Logout</button>
            </div>
        </div>

        <!-- Main content -->
        <div class="main-content">
            
            <div class="default-view" id="dashboardView">
                <h2>Welcome to the Admin Dashboard</h2>
                <p>Here you can display statistics or a graph.</p>
                
                <div style="width: 100%; height: 300px; background-color: #f0f0f0;">
                    <p>Graph/Statistics Placeholder</p>
                </div>
            </div>

            <!-- User Management Table -->
            <div class="user-management-view" id="userManagementView">
                <div class="table-container">
                    <h2>User Management</h2>
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="display">john_doe</span><input type="text" class="edit" value="john_doe" style="display: none;"></td>
                                <td><span class="display">john@example.com</span><input type="email" class="edit" value="john@example.com" style="display: none;"></td>
                                <td>
                                    <span class="display">Donor</span>
                                    <select class="edit" style="display: none;">
                                        <option value="Donor" selected>Donor</option>
                                        <option value="Volunteer">Volunteer</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="edit-button" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class="display">jane_doe</span><input type="text" class="edit" value="jane_doe" style="display: none;"></td>
                                <td><span class="display">jane@example.com</span><input type="email" class="edit" value="jane@example.com" style="display: none;"></td>
                                <td>
                                    <span class="display">Volunteer</span>
                                    <select class="edit" style="display: none;">
                                        <option value="Donor">Donor</option>
                                        <option value="Volunteer" selected>Volunteer</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="edit-button" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="donation-history-view" id="donationHistoryView">
                <div class="table-container">
                    <h2>Donation History</h2>
                    <table class="donation-table">
                        <thead>
                            <tr>
                                <th>Donation ID</th>
                                <th>Donor ID</th>
                                <th>Donation Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>$100</td>
                                <td>2024-12-01</td>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2</td>
                                <td>$50</td>
                                <td>2024-12-02</td>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>1</td>
                                <td>$200</td>
                                <td>2024-12-05</td>
                                <td>Pending</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initially show the Admin Dashboard view
        document.getElementById('dashboardView').style.display = 'block';
        
        
        function hideAllViews() {
            document.getElementById('dashboardView').style.display = 'none';
            document.getElementById('userManagementView').style.display = 'none';
            document.getElementById('donationHistoryView').style.display = 'none';
        }

        // Show the Admin Dashboard view
        document.getElementById('dashboardLink').addEventListener('click', function() {
            hideAllViews();
            document.getElementById('dashboardView').style.display = 'block';
            setActiveLink(this);
        });

        // Show the User Management table view
        document.getElementById('userManagementLink').addEventListener('click', function() {
            hideAllViews();
            document.getElementById('userManagementView').style.display = 'block';
            setActiveLink(this);
        });

        // Show the Donation History table view
        document.getElementById('donationHistoryLink').addEventListener('click', function() {
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

        // Function to toggle between display and edit mode
        function editRow(button) {
            var row = button.closest('tr');  
            var inputs = row.querySelectorAll('.edit'); 
            var displays = row.querySelectorAll('.display');
            var isEditing = button.textContent === "Save";

            if (isEditing) {
                
                inputs.forEach((input, index) => {
                    var value = input.value;
                    if (input.tagName === "SELECT") {
                        value = input.options[input.selectedIndex].value;
                    }
                    displays[index].textContent = value;  
                    input.style.display = "none"; 
                });

                displays.forEach(display => display.style.display = "inline");  
                button.textContent = "Edit";
            } else {
                
                inputs.forEach(input => input.style.display = "inline");  
                displays.forEach(display => display.style.display = "none");  
                button.textContent = "Save";
            }
        }
    </script>
</body>
</html>
