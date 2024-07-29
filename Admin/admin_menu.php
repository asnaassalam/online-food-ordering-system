<?php
session_start();
if (!isset($_SESSION['adminloggedin'])) {
    header("Location: ../login.php");
    exit();
}

include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <!--poppins-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="admin_menu.css">
</head>

<body>
    <div class="sidebar">
        <button class="close-sidebar" id="closeSidebar">&times;</button>
        <h2>Dashboard</h2>
        <ul>
            <li><a href="index.php"><i class="fas fa-chart-line"></i> Overview</a></li>
            <li><a href="admin_menu.php" class="active"><i class="fas fa-utensils"></i> Menu Management</a></li>
            <li><a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
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
            <h2><i class="fas fa-utensils"></i> Menu Management</h2>
        </div>
        <div class="modal-row">
            <div>
                <button onclick="openModal()">Add New Category</button>
                <button onclick="openItemModal()">Add New Item</button>
            </div>
            <div class="search-bar ">
                <select id="categoryFilter" onchange="filterCategories()">
                    <option value="">All Categories</option>
                    <?php
                    $sql = "SELECT catName FROM menucategory";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['catName']}'>{$row['catName']}</option>";
                    }
                    ?>
                </select>

            </div>

        </div>

        <table id="menuTable">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM menuitem";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // If there are rows, display them 
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr data-category='{$row['catName']}'>
                                <td>{$row['itemName']}</td>
                                <td><img src='../uploads/{$row['image']}' alt='{$row['itemName']}' width='50'></td>
                                 <td>{$row['description']}</td> 
                                <td>Rs {$row['price']}</td>
                                <td>{$row['catName']}</td>
                                 <td>{$row['status']}</td>
                                <td>
                                   <button id='editbtn'  onclick=\"editItem('" . $row["itemId"] . "')\"><i class='fas fa-edit'></i></button>
                        <button id='deletebtn'  onclick=\"deleteItem('" . $row["itemId"] . "')\"><i class='fas fa-trash'></i></button>
                                </td>
                              </tr>";
                    }
                } else {
                    // If no rows, display the "No Menu Items" message
                    echo "<tr><td colspan='7' style='text-align: center;'>No Menu Items</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <div class="modal" id="categoryModal">
        <div class="modal-overlay"></div>
        <div class="modal-container">
            <form class="form" method="POST" action="add_category.php">
                <div class="modal-header">
                    <h2>Add New Category</h2>
                    <span class="close-icon" onclick="closeModal()">&times;</span>
                </div>
                <div class="modal-content">
                    <div class="input-group">
                        <input type="text" name="catName" id="catName" class="input" required>
                        <label for="catName" class="label">Category Name</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="button">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="itemModal">
        <div class="modal-overlay"></div>
        <div class="modal-container">
            <form class="form" method="POST" action="add_item.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h2>Add New Item</h2>
                    <span class="close-icon" onclick="closeItemModal()">&times;</span>
                </div>
                <div class="modal-content">
                    <div class="input-group">
                        <input type="text" name="itemName" id="itemName" class="input" required>
                        <label for="itemName" class="label">Item Name</label>
                    </div>
                    <div class="input-group">
                        <input type="text" name="description" id="description" class="input" required>
                        <label for="description" class="label">Description</label>
                    </div>
                    <div class="input-group">
                        <select name="status" id="status" class="input" required>
                            <option value="">Status</option>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                        <label for="status" class="label">Status</label>
                    </div>

                    <div class="input-group">
                        <input type="number" name="price" id="price" class="input" required>
                        <label for="price" class="label">Price</label>
                    </div>
                    <div class="input-group">
                        <select name="catName" id="catName" class="input" required>
                            <option value="">Select Category</option>
                            <?php
                            $sql = "SELECT catName FROM menucategory";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['catName']}'>{$row['catName']}</option>";
                            }
                            ?>
                        </select>
                        <label for="catName" class="label">Category</label>
                    </div>
                    <div class="input-group">
                        <input type="file" name="image" id="image" class="input" accept="image/*" required>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button" onclick="closeItemModal()">Cancel</button>
                    <button type="submit" class="button">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('categoryModal').classList.add('open');
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.remove('open');
        }

        function openItemModal() {
            document.getElementById('itemModal').classList.add('open');
        }

        function closeItemModal() {
            document.getElementById('itemModal').classList.remove('open');
        }

        function filterCategories() {
            const category = document.getElementById('categoryFilter').value;
            const rows = document.querySelectorAll('#menuTable tbody tr');
            rows.forEach(row => {
                if (category === "" || row.dataset.category === category) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function editItem(itemId) {
            window.location.href = `edit_item.php?id=${itemId}`;
        }

        function deleteItem(itemId) {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = `delete_item.php?id=${itemId}`;
            }
        }
    </script>
</body>

</html>