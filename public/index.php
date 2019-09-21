<?php
	require_once '../includes/config.php';
	require_once '../includes/functions.php';
	require_once '../includes/database.php';
	require_once '../includes/user.php';
	require_once '../includes/session.php';
?>

<?php
	$message = "";
	$user = new User();

  if ($session ->isLoggedIn()) {
  	redirectTo("./home.php");
	}

  if (isset($_POST['submit'])) {
  	$email = trim($_POST['email']);
  	$password = trim($_POST['password']);

  	$foundUser = User::authenticate($email, $password);

  	if ($foundUser) {
			$session->login($foundUser);
  		redirectTo("./home.php");
  	} else {
  		$message = "Email/password combination incorrect.";
  	}
  }else{
  	$username = "";
  	$password = "";
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>News-Event Management System</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/fonts/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/main.css">
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form class="login100-form validate-form flex-sb flex-w" method="post" action="index.php" role="form">
					<span class="login100-form-title p-b-32">
						Login
					</span>

					<span class="txt1 p-b-11">
						Email
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Email is required">
						<input class="input100" type="email" name="email" >
						<span class="focus-input100"></span>
					</div>

					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<input class="input100" type="password" name="password" >
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
            <input type="submit" name="submit" id="loginBt" value="LOGIN" class="login100-form-btn">
					</div>

					<span class="txt1 p-b-11">
          <br ><br ><br >
					<?php echo outputMessage($message, "danger");?>
					</span>
				</form>
				<span class="txt1 p-b-11" style="text-align: right;">
					<a class="nav-link btn-rotate" style="color: red" href="./register.php">Register Now</a>
				</span>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<script src="./assets/js/core/jquery-3.2.1.min.js"></script>
	<script src="./assets/js/core/popper.js"></script>
	<script src="./assets/js/core/bootstrap.min.js"></script>
	<script src="./assets/js/main.js"></script>
</body>
</html>
