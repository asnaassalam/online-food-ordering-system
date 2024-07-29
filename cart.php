<?php
session_start();
require 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin'] !== true) {
    header('location:login.php');
    exit;
}

// Get the email from the session
$email = $_SESSION['email'];

// Fetch cart items for the logged-in user
$stmt = $conn->prepare('SELECT * FROM cart WHERE email=?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cart</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
    <style>
        body {
            padding-top: 120px;
            padding-bottom: 60px;
        }

        .item {
            min-height: 190px;
            border: none;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
            background-color: pink;
            box-shadow: #db4051 0px 0px 10px 0px;
        }

        .item img {
            width: 100%;
            height: 100%;
        }

        .item .buttons {
            display: flex;
            justify-content: space-between;
        }

        .item .details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .item .quantity {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .item .quantity input {
            width: 50px;
            text-align: center;
            padding: 5px 10px;
            border: none;
            background: #db4051;
            border-left: 2px solid;
            border-right: 2px solid;
            color: white;

        }



        .item .total-price {
            font-weight: bold;

        }

        .price-quantity {
            display: flex;
            justify-content: flex-end;
            align-items: center;

        }

        .quantity button {
            background: #db4051;
            color: white;
            border: none;
            padding: 5px 10px;
        }

        #minus-button {
            border-top-left-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        #plus-button {
            border-top-right-radius: 50%;
            border-bottom-right-radius: 50%;
        }

        .fixed-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            border-top: 1px solid #ddd;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        .fixed-bottom-bar .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            flex-wrap: nowrap;
            /* Prevent wrapping to rows */
        }

        .info-container {
            display: flex;
            align-items: center;
            gap: 30px;
            /* Adjust the gap between items here */
            flex: 1;
        }

        .info-item {
            margin: 0;
        }

        .buttons-container {
            display: flex;
            flex: 1;
            align-items: center;
            /* Align buttons vertically */
            gap: 0;
            /* Remove gap between buttons */
            background-color: #db4051;
            height: 100%;
            /* Full height of the bottom bar */
            margin: -10px;

        }

        .buttons-container a:hover {
            text-decoration: none;
            color: white;
        }

        .buttons-container .button {
            flex: 1;
            margin: 0;
            text-align: center;
            line-height: 60px;
            color: #fff;
            border: 1px solid transparent;

            position: relative;
        }

        .buttons-container .button:last-child {
            border-right: none;
            background: green;
        }


        .buttons-container .button:hover {
            background-color: #ea4d25;
        }

        #grand-total {
            margin-left: -25px;
        }

        @media (max-width: 767px) {
            .fixed-bottom-bar .container-fluid {
                padding: 5px;
                /* Adjust padding for smaller screens */
            }

            .buttons-container {
                margin: -5px;
            }

            .info-container {
                gap: 5px;
                /* Adjust gap for smaller screens */
            }

            .buttons-container .button {
                padding: 8px;
                /* Adjust padding for smaller screens */

            }

            #grand-total {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <?php
    if ($_SESSION['userloggedin']) {
        include_once('nav-logged.php');
    } else {
        include_once('navbar.php');
    }
    ?>

    <div class="container-fluid">
        <div class="row ">
            <div class="col">
                <div style="display:<?php if (isset($_SESSION['showAlert'])) {
                                        echo $_SESSION['showAlert'];
                                    } else {
                                        echo 'none';
                                    }
                                    unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><?php if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                            }
                            unset($_SESSION['message']); ?></strong>
                </div>
                <div class="row mt-2">
                    <?php
                    $grand_total = 0;
                    while ($row = $result->fetch_assoc()) :
                    ?>
                        <div class="col-md-4  col-sm-6">
                            <div class="item" data-id="<?= $row['id'] ?>">
                                <div class="buttons">
                                    <div>
                                        <input type="checkbox" class="selection" data-price="<?= $row['total_price'] ?>" checked>
                                    </div>
                                    <div>
                                        <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');" style="cursor:pointer;">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="row">
                                        <div class="image col-4">
                                            <img src="uploads/<?= $row['image'] ?>" alt="<?= $row['itemName'] ?>">
                                        </div>
                                        <div class="item-name-price col-5">
                                            <div class="item-name">
                                                <h3><?= $row['itemName'] ?></h3>
                                            </div>
                                            <div class="quantity">
                                                <button class="minus-btn minus-quantity-btn" id="minus-button" type="button">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="text" class="itemQty" value="<?= $row['quantity'] ?>" min="1" data-price="<?= $row['price'] ?>" data-id="<?= $row['id'] ?>">
                                                <button class="plus-btn plus-quantity-btn" id="plus-button" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-3  ">
                                            <div class="item-price  d-flex justify-content-end ">
                                                <h5>Rs <?= number_format($row['price']) ?></h5>
                                            </div>
                                            <div class=" d-flex justify-content-end ">

                                                <h5 class="item-total-quantity"> x <?= $row['quantity'] ?></h5>
                                            </div>
                                        </div>
                                        <div class="price-quantity">
                                            <div class="total-price">Subtotal: Rs <span class="item-total"><?= number_format($row['total_price']) ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $grand_total += $row['total_price']; ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-bottom-bar">
        <div class="container-fluid">
            <!-- Info Container -->
            <div class="info-container">
                <!-- Select All Column -->
                <div class="info-item text-center">
                    <input type="checkbox" id="select-all" checked> <b>Select All</b>
                </div>
                <!-- Grand Total Column -->
                <div class="info-item text-center">
                    <h4>Grand Total:</h4>
                </div>
                <div class="info-item" id="grand-total">
                    <h4 id="grand_total">Rs <?= number_format($grand_total, 2); ?></h4>
                </div>
            </div>
            <!-- Buttons Container -->
            <div class="buttons-container">
                <!-- Checkout Button Column -->
                <a href="checkout.php" id="checkout-button" class="button <?= ($grand_total > 1) ? '' : 'disabled'; ?>">
                    <i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout
                </a>
                <!-- Continue Shopping Column -->
                <a href="menu.php" class="button">
                    <i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Continue Shopping
                </a>
            </div>
        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Update item quantity
            $(".minus-quantity-btn").on('click', function() {
                var $el = $(this).closest('.item');
                var $qtyInput = $el.find('.itemQty');
                var qty = parseInt($qtyInput.val()) - 1;
                if (qty >= 1) {
                    $qtyInput.val(qty);
                    updateCart($el, qty);
                }
            });

            $(".plus-quantity-btn").on('click', function() {
                var $el = $(this).closest('.item');
                var $qtyInput = $el.find('.itemQty');
                var qty = parseInt($qtyInput.val()) + 1;
                $qtyInput.val(qty);
                updateCart($el, qty);
            });

            $(".itemQty").on('change', function() {
                var $el = $(this).closest('.item');
                var qty = parseInt($(this).val());
                if (qty >= 1) {
                    updateCart($el, qty);
                } else {
                    $(this).val(1);
                    updateCart($el, 1);
                }
            });

            function updateCart($el, qty) {
                var pid = $el.data('id');
                var pprice = $el.find(".itemQty").data('price');
                var subtotal = qty * pprice;

                $el.find('.item-total-quantity').text('x ' + qty);
                $el.find('.item-total').text(subtotal.toFixed(2));

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    cache: false,
                    data: {
                        qty: qty,
                        pid: pid,
                        pprice: pprice
                    },
                    success: function(response) {
                        console.log(response);
                        updateGrandTotal();
                        load_cart_item_number(); // Update cart item number instantly
                    }
                });
            }

            function updateGrandTotal() {
                var grandTotal = 0;
                $(".item .selection:checked").each(function() {
                    var $item = $(this).closest('.item');
                    var qty = parseInt($item.find('.itemQty').val());
                    var price = parseFloat($item.find('.itemQty').data('price'));
                    var subtotal = qty * price;
                    grandTotal += subtotal;
                });
                $("#grand_total").text('Rs ' + grandTotal.toFixed(2));
                localStorage.setItem('grandTotal', grandTotal.toFixed(2)); // Store grand total in local storage
            }

            // Load grand total from local storage
            function loadGrandTotal() {
                var grandTotal = localStorage.getItem('grandTotal');
                if (grandTotal) {
                    $("#grand_total").text('Rs ' + grandTotal);
                }
            }

            // Delete item
            $(".text-danger.lead").on('click', function(e) {
                e.preventDefault();
                var $el = $(this).closest('.item');
                var pid = $el.data('id');

                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {
                        remove: pid
                    },
                    success: function(response) {
                        console.log(response);
                        $el.remove();
                        updateGrandTotal();
                        checkSelectAll();
                        load_cart_item_number(); // Update cart item number instantly
                        setTimeout(function() {
                            location.reload(); // Auto refresh the page
                        }, 1000); // Refresh the page after 1 second
                    }
                });
            });

            // Handle checkout button click
            $('#checkout-button').on('click', function(e) {
                e.preventDefault();

                // Collect selected item IDs
                var selectedItems = [];
                $('.selection:checked').each(function() {
                    var itemId = $(this).closest('.item').data('id');
                    selectedItems.push(itemId);
                });

                if (selectedItems.length > 0) {
                    // Construct the URL with selected items
                    var checkoutUrl = 'checkout.php?items=' + encodeURIComponent(selectedItems.join(','));
                    window.location.href = checkoutUrl;
                } else {
                    alert('Please select at least one item to proceed with checkout.');
                }
            });

            // Function to load the total number of items in the cart
            function load_cart_item_number() {
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {
                        cartItem: 'cart_item'
                    },
                    success: function(response) {
                        $("#cart-item").html(response);
                    }
                });
            }

            // Select All functionality
            $('#select-all').on('change', function() {
                $('.selection').prop('checked', $(this).prop('checked'));
                updateGrandTotal();
            });

            $('.selection').on('change', function() {
                checkSelectAll();
                updateGrandTotal();
            });

            // Check if all items are selected
            function checkSelectAll() {
                if ($('.selection').length === $('.selection:checked').length) {
                    $('#select-all').prop('checked', true);
                } else {
                    $('#select-all').prop('checked', false);
                }
            }




            // Set all items as checked by default and update grand total
            $('.selection').prop('checked', true);
            updateGrandTotal();

            // Load grand total and cart item number initially
            loadGrandTotal();
            load_cart_item_number();
        });
    </script>

</body>

</html>