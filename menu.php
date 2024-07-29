<?php
session_start();
include 'db_connection.php';

// Fetch all unique categories from the database
$categoryQuery = 'SELECT DISTINCT catName FROM menuitem';
$categoryResult = $conn->query($categoryQuery);

$categories = [];
while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row['catName'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
    <!--poppins-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="menu.css" />
    <title>Menu</title>
     <style>
        .disabled-button {
    cursor: not-allowed;
    pointer-events: none;
  
}
     </style>
</head>

<body>

    <?php

    if (isset($_SESSION['userloggedin']) && $_SESSION['userloggedin']) {
        include 'nav-logged.php';
    } else {
        include 'navbar.php';
    }
    ?>

    <div class="row justify-content-center align-items-center" style="font-size: 2.5em; font-weight: 600;">Our Menu</div>
    <div class="row justify-content-center align-items-center" style="font-size: 1.8em; font-weight: 400; color: #1d1818;">Discover a feast of flavors with our exciting menu!
    </div>

    <?php foreach ($categories as $category): ?>
        <section id="<?= strtolower($category) ?>">
        <div id="message"></div>
            <div class="container-fluid">
                <h1 class="mt-3"><?= strtoupper($category) ?></h1>
                <div class="row">
                    <?php
                    $stmt = $conn->prepare('SELECT * FROM menuitem WHERE catName = ?');
                    $stmt->bind_param('s', $category);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) :
                        $buttonClass = $row['status'] == 'Unavailable' ? 'disabled-button' : '';
                    ?>
                        <div class="col-md-3 col-sm-6 menu-item">
                            <div class=" mt-5" style="background-color: #fdd9c9; border-radius: 5px;">
                                <img src="uploads/<?= $row['image'] ?>" alt="image" class="card-img-top" height="250">
                                <div class="card-body">
                                    <h4 class="card-title text-center "><?= $row['itemName'] ?></h4>
                                    <p class="card-title text-center "><?= $row['description'] ?></p>
                                    <?php if ($row['status'] == 'Unavailable') : ?>
                                        <p class="card-status" style="color: red; text-align: center; font-size: 1.3em;"><?php echo $row['status']; ?></p>
                                    <?php endif; ?>
                                    <div style="text-align: center;">
                                        <form action="" class="form-submit">
                                            <input type="hidden" class="pid" value='<?= $row['id'] ?>'>
                                            <input type="hidden" class="pname" value="<?= $row['itemName'] ?>">
                                            <input type="hidden" class="pprice" value="<?= $row['price'] ?>">
                                            <input type="hidden" class="pimage" value="<?= $row['image'] ?>">
                                            <input type="hidden" class="pcode" value="<?= $row['catName'] ?>">
                                            <div class="button-container">
                                                <div>
                                                    <p class="card-text text-center ">Rs&nbsp;<?= number_format($row['price']) ?>/-</p>
                                                </div>
                                                <div>
                                                    <button class="addItemBtn <?= $buttonClass ?>">
                                                        <i class="fas fa-cart-plus"></i> &nbsp;&nbsp;Add to cart
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endforeach; ?>

    <?php include_once 'footer.html'; ?>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

    <script type="text/javascript">
        $(document).ready(function() {
            function userIsLoggedIn() {
                return <?php echo isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] === true ? 'true' : 'false'; ?>;
            }

            function getUserEmail() {
                return "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>";
            }

            $(".addItemBtn").click(function(e) {
                e.preventDefault();

                if (!userIsLoggedIn()) {
                    alert("Please log in to add items to the cart.");
                    window.location.href = "login.php";
                    return;
                }

                var email = getUserEmail();

                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();
                var pname = $form.find(".pname").val();
                var pprice = $form.find(".pprice").val();
                var pimage = $form.find(".pimage").val();
                var pcode = $form.find(".pcode").val();
                var pqty = 1; // Default quantity

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {
                        pid: pid,
                        pname: pname,
                        pprice: pprice,
                        pqty: pqty,
                        pimage: pimage,
                        pcode: pcode,
                        email: email
                    },
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                        load_cart_item_number();
                    }
                });
            });

            load_cart_item_number();

            function load_cart_item_number() {
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {
                        cartItem: "cart_item"
                    },
                    success: function(response) {
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>
</body>

</html>