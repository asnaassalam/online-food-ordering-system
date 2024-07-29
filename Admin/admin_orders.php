<?php
session_start();
if (!isset($_SESSION['adminloggedin'])) {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <!--poppins-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="admin_orders.css">
</head>

<body>
    <div class="sidebar">
        <button class="close-sidebar" id="closeSidebar">&times;</button>
        <h2>Dashboard</h2>
        <ul>
            <li><a href="index.php"><i class="fas fa-chart-line"></i> Overview</a></li>
            <li><a href="admin_menu.php"><i class="fas fa-utensils"></i> Menu Management</a></li>
            <li><a href="admin_orders.php" class="active"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="reservations.html"><i class="fas fa-calendar-alt"></i> Reservations</a></li>
            <li><a href="reviews.html"><i class="fas fa-star"></i> Reviews</a></li>
            <li><a href="users.html"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="settings.html"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <button id="toggleSidebar" class="toggle-button">
                <i class="fas fa-bars"></i>
            </button>
            <h2><i class="fas fa-shopping-cart"></i> Orders</h2>
        </div>

        <div class="search-bar">
            <form method="GET" action="admin_orders.php">
                <select name="status">
                    <option value="">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="On the way">On the way</option>
                </select>
                <button type="submit">Search</button>
            </form>
        </div>

        <?php

        include 'db_connection.php';

        // Retrieve orders based on the selected status
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $query = "SELECT order_id, order_date, name, phone, grand_total, order_status, pmode, cancel_reason
                  FROM orders";

        if ($status) {
            $query .= " WHERE order_status = '$status'";
        }

        $query .= " ORDER BY order_id DESC";
        $result = $conn->query($query);

        // Display orders in a table
        echo "<table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Payment Mode</th>
                    <th>Cancel Reason</th>
                    <th>Action</th>
                </tr>";
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = '';
                switch ($row['order_status']) {
                    case 'Pending':
                        $statusClass = 'status-pending';
                        break;
                    case 'Processing':
                        $statusClass = 'status-processing';
                        break;
                    case 'Completed':
                        $statusClass = 'status-completed';
                        break;
                    case 'Cancelled':
                        $statusClass = 'status-cancelled';
                        break;
                    case 'On the way':
                        $statusClass = 'status-ontheway';
                        break;
                }
                echo "<tr>
                    <td>" . $row['order_id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['phone'] . "</td>
                    <td>" . 'Rs ' . $row['grand_total'] . "</td>
                    <td><span class='status $statusClass'>" . $row['order_status'] . "</span></td>
                    <td>" . $row['pmode'] . "</td>
                    <td>" . ($row['order_status'] == 'Cancelled' ? $row['cancel_reason'] : '-') . "</td>
                    <td><button id='viewbtn' onclick=\"viewDetails(" . $row['order_id'] . ")\">View Details</button></td>
                </tr>";
            }
        } else {
            // If no rows, display the "No Menu Items" message
            echo "<tr><td colspan='8' style='text-align: center;'>No Menu Items</td></tr>";
        }

        echo "</table>";

        $conn->close();
        ?>
    </div>
    <script src="sidebar.js"></script>
    <script>
        const modal = document.querySelector('.modal');
        const buttons = document.querySelectorAll('.toggleButton');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.toggle('open');
            });
        });
    </script>

</body>

</html>