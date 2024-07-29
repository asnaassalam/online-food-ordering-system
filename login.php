<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="login.css"/>
  <title>Login/Register</title>

</head>
<body>
  <?php
  include_once ("navbar.php");
  ?>

<div class="container">
		<div class="forms-container">
			<div class="signin-signup">
				<form action="dblogin.php" class="sign-in-form" method="POST">
					<h2 class="title">Sign in</h2>
					<div class="input-field">
						<i class="fas fa-envelope"></i>
						<input type="email" placeholder="Email" name="email" required  onkeyup="hideAlertBox()"/>
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" placeholder="Password" name="password" required  onkeyup="hideAlertBox()"/>
					</div>
					<input type="submit" value="Login" class="submit solid" />
					
					<?php

if(isset($_GET['error'])) {
	echo('
	<div class="alert alert-danger" id="alertbox" role="alert">
	Email or Password is incorrect.
</div>');
}

?>

				</form>
				<form action="dbregister.php" class="sign-up-form" method="POST" id="registerForm">
					<h2 class="title">Sign up</h2>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" placeholder="First Name" name="firstName" onkeyup="hideAlertBox()" required/>
					</div>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" placeholder="Last Name" name="lastName" onkeyup="hideAlertBox()" required/>
					</div>
					<div class="input-field">
						<i class="fas fa-envelope"></i>
						<input type="email" placeholder="Email" name="email" onkeyup="hideAlertBox()" required/>
					</div>
          <div class="input-field">
            <i class="fas fa-phone" style="transform: rotate(90deg);"></i>
						<input type="text" placeholder="Contact No" name="contact" onkeyup="hideAlertBox()" required/>
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" placeholder="Password" name="password" onkeyup="hideAlertBox()" required/>
					</div>
					<input type="submit" class="submit" value="Sign up"  id="registerButton" />
				

					
				</form>
			</div>
		</div>

		<div class="panels-container">
			<div class="panel left-panel">
				<div class="content">
					<h3>New to Our Restaurant?</h3>
					<p>
          Join us today and enjoy the convenience of online ordering. Get exclusive offers and track your orders easily.
          </p>
					<button class="btn transparent" id="sign-up-btn">
						Sign up
					</button>
				</div>
				<img  src="images/form-pic.png" class="image" alt="" />
			</div>
			<div class="panel right-panel">
				<div class="content">
					<h3>Our Customer?</h3>
					<p>
          Sign in to continue enjoying our delicious meals and manage your orders seamlessly.
					</p>
					<button class="btn transparent" id="sign-in-btn">
						Sign in
					</button>
				</div>
				<img  src="images/form-pic2.png" class="image" alt=""  style="margin-bottom: 400px" />
			</div>
		</div>
	</div>
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script>
    const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});
  </script>
	<script>
    function hideAlertBox() {
        const alertBox = document.getElementById('alertbox');
        alertBox.style.display = 'none';
    }
  </script> 
</body>
</html>