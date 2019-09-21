<?php
	require_once '../includes/config.php';
	require_once '../includes/functions.php';
	require_once '../includes/database.php';
  require_once '../includes/user.php';
  require_once '../includes/userRank.php';
	require_once '../includes/session.php';

	if (!$session->isLoggedIn()) {
  	redirectTo("./index.php");
  }

  $usersDetails = User::findById($_SESSION['userId']);
  $usersRank = UserRank::findByUserId($_SESSION['userId']);
	$numberOfReferrals = User::getTotalByReferralCode($usersDetails->referral_code);
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
				<span class="login100-form-title p-b-32">
					Details
				</span>

				<span class="txt1 p-b-11">
					Name:  &nbsp; &nbsp; <span style="color: red"><?php echo $usersDetails->name; ?></span>
				</span>
				<br />
				<br />
				<span class="txt1 p-b-11">
					Referral Code: &nbsp; &nbsp; <span style="color: red"><?php echo $usersDetails->referral_code; ?></span>
				</span>
				<br />
				<br />
				<span class="txt1 p-b-11">
					Number Of Referrals: &nbsp; &nbsp; <span style="color: red"><?php echo $numberOfReferrals; ?></span>
				</span>
				<br />
				<br />
				<span class="txt1 p-b-11">
					Rank: &nbsp; &nbsp; <span style="color: red"><?php echo $usersRank->user_rank; ?></span>
				</span>

				<br>
				<span class="txt1 p-b-11" style="text-align: right;">
					<a class="nav-link btn-rotate" style="color: red" href="./logout.php">logout</a>
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
