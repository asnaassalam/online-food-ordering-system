<?php
session_start();
require 'db_connection.php';

// Check if the email session variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Add products into the cart table
    if (isset($_POST['pid']) && isset($_POST['pname']) && isset($_POST['pprice'])) {
        $pid = $_POST['pid'];
        $pname = $_POST['pname'];
        $pprice = $_POST['pprice'];
        $pimage = $_POST['pimage'];
        $pcode = $_POST['pcode'];
        $pqty = 1;

        $total_price = $pprice * $pqty;

        $stmt = $conn->prepare('SELECT itemName FROM cart WHERE itemName=? AND email=?');
        $stmt->bind_param('ss', $pname, $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = $res->fetch_assoc();
        $code = $r['itemName'] ?? '';

        if (!$code) {
            $query = $conn->prepare('INSERT INTO cart (itemName, price, image, quantity, total_price, catName, email) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $query->bind_param('sdsisss', $pname, $pprice, $pimage, $pqty, $total_price, $pcode, $email);
            $query->execute();

            echo '<div class="alert alert-success alert-dismissible mt-2">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Item added to your cart!</strong>
                    </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible mt-2">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Item already added to your cart!</strong>
                    </div>';
        }
    }

    // Get no. of items available in the cart table
    if (isset($_GET['cartItem']) && $_GET['cartItem'] == 'cart_item') {
        $stmt = $conn->prepare('SELECT SUM(quantity) AS qty FROM cart WHERE email=?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo $row['qty'];
    }

    // Remove single items from cart
    if (isset($_GET['remove'])) {
        $id = $_GET['remove'];

        $stmt = $conn->prepare('DELETE FROM cart WHERE id=? AND email=?');
        $stmt->bind_param('is', $id, $email);
        $stmt->execute();

        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Item removed from the cart!';
        header('location:cart.php');
    }

    // Remove all items at once from cart
    if (isset($_GET['clear'])) {
        $stmt = $conn->prepare('DELETE FROM cart WHERE email=?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'All items removed from the cart!';
        header('location:cart.php');
    }

    // Update quantity and total price of the product in the cart table
    if (isset($_POST['qty'])) {
        $qty = $_POST['qty'];
        $pid = $_POST['pid'];
        $pprice = $_POST['pprice'];

        $tprice = $qty * $pprice;

        $stmt = $conn->prepare('UPDATE cart SET quantity=?, total_price=? WHERE id=? AND email=?');
        $stmt->bind_param('idis', $qty, $tprice, $pid, $email);
        $stmt->execute();

        // Return the updated total price to the client-side for display (optional)
        echo $tprice;
    }
    
    
} 
?>
