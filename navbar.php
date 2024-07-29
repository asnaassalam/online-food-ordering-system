<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Bootstrap CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!--Lexend font for navbar-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />
  <!--Icon-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!--Logo Font-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Lexend+Zetta:wght@100..900&family=Nova+Round&display=swap" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <title>Navbar</title>
  <style>
    body {
      background: #feead4;
      font-family: "Poppins", sans-serif;
      font-weight: 300;
      font-style: normal;
    }

    a {
      color: white;
      text-decoration: none;
    }

    .navbar-brand,
    .offcanvas-header {
      color: #fb4a36;
      font-family: "Nova Round", system-ui;
      font-optical-sizing: auto;
      font-weight: 550;
      font-style: normal;
    }

    .nav-container {
      margin-right: 30px;
      margin-left: 30px;
      padding-bottom: 15px;
      padding-right: 13px;
      padding-left: 13px;
    }

    .Btn {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      width: 40px;
      height: 40px;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition-duration: 0.3s;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
      background-color: #fb4a36;
    }

    /* plus sign */
    .sign {
      width: 100%;
      transition-duration: 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sign svg {
      width: 22px;
    }

    .sign svg path {
      fill: #1d1818;
    }

    /* text */
    .text {
      position: absolute;
      right: 0%;
      width: 0%;
      opacity: 0;
      color: #1d1818;
      font-size: 1.2em;
      font-weight: 500;
      transition-duration: 0.3s;
    }

    /* hover effect on button width */
    .Btn:hover {
      width: 125px;
      border-radius: 40px;
      transition-duration: 0.3s;
    }

    .Btn:hover .sign {
      width: 33%;
      transition-duration: 0.3s;
      padding-left: 10px;
      padding-right: 8px;
    }

    /* hover effect button's text */
    .Btn:hover .text {
      opacity: 1;
      width: 70%;
      transition-duration: 0.3s;
      padding-right: 10px;
    }

    /* button click effect*/
    .Btn:active {
      transform: translate(2px, 2px);
    }

    .navbar-toggler {
      border: none;
      font-size: 1.25rem;
    }

    .navbar-toggler:focus,
    .btn-close:focus {
      box-shadow: none;
      outline: none;
    }

    

   

    .logo {
      font-size: 28px;
    }

    .nav-link {
      color: black;
      font-weight: 500;
      transition: 0.3s color ease;
      font-family: "Lexend", sans-serif;
      font-optical-sizing: auto;
      font-weight: 480;
      font-style: light;
      
    }

    .dropdown-menu {
      border: none;
      margin-left: -30px;
      text-align: center;
      background-color: #fed9c7;
     margin-top: -5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    
.dropdown-item {
  color: #212529;
}

.dropdown-item:hover {
  background-color: #fb4a36;
  color: white;
}
.nav-item.dropdown .nav-link:hover {
  color: #fb4a36;
}


   

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='gray' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
      padding-left: 22px;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #fb4a36;
    }

    .navbar-nav .nav-link.active,
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link:focus {
      color: #fb4a36;
    }

    .offcanvas-header {
      background-color: #212529;
    }

   
    .nav-item.dropdown:hover .dropdown-menu {
      display: block;
    }


    .logo:hover {
      color: white;
    }
   .navbar{
    border-bottom-left-radius: 80px;
    border-bottom-right-radius: 80px;
    padding: 5px 0px 0px 0px;
   background-color: #fed9c7;
   }
   .cart{
    color: green;
    font-size: 22px;
    cursor: pointer;
   }
   
  </style>
</head>

<body>
  <!--Navbar-->
  <div>
    <nav class="navbar  navbar-expand-lg fixed-top">
      <div class="container-fluid nav-container">
        <a class="navbar-brand me-auto logo" href="index.php">Flavour Fiesta</a>
        <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header ">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
              Flavour Fiesta
            </h5>
            <button type="button" class="btn-close btn-close-white" aria-label="Close" id="closeOffcanvas"></button>
          </div>
          <div class="offcanvas-body text-center">
            <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link mx-lg-2" aria-current="page" href="index.php">Home</a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mx-lg-2" href="menu.php" role="button" aria-haspopup="true" aria-expanded="false">
                  Menu
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" >
                  <li><a class="dropdown-item" href="menu.php#appetizer">Appetizers</a></li>
                  <li><a class="dropdown-item" href="menu.php#burger">Burger</a></li>
                  <li><a class="dropdown-item" href="menu.php#pizza">Pizza</a></li>
                  <li><a class="dropdown-item" href="menu.php#beverage">Beverages</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link mx-lg-2" href="index.php#Reservation">Reservation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mx-lg-2" href="index.php#About-Us">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mx-lg-2" href="index.php#Contact">Contact Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mx-lg-2" href="#review">Review</a>
              </li>
            </ul>
          </div>
        </div>
        <a class="nav-link cart" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>

        <a href="login.php">
          <button class="Btn">
            <div class="text">LOGIN</div>
            <div class="sign">
              <svg viewBox="0 0 512 512">
                <path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"></path>
              </svg>
            </div>
          </button>
        </a>
        <button class="navbar-toggler" type="button" aria-label="Toggle navigation" id="toggleOffcanvas">
          <span class="navbar-toggler-icon" style="color: #f9f6e8"></span>
        </button>
      </div>
    </nav>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
  <!--Bootstrap JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



  <script>
    const closeOffcanvasBtn = document.getElementById("closeOffcanvas");
    const toggleOffcanvasBtn = document.getElementById("toggleOffcanvas");
    const offcanvasNavbar = new bootstrap.Offcanvas(
      document.getElementById("offcanvasNavbar")
    );

    closeOffcanvasBtn.addEventListener("click", function() {
      offcanvasNavbar.hide();
    });

    toggleOffcanvasBtn.addEventListener("click", function() {
      offcanvasNavbar.show();
    });
  </script>
 



</body>

</html>