<?php
	require_once '../includes/config.php';
	require_once '../includes/functions.php';
	require_once '../includes/database.php';
  require_once '../includes/user.php';
  require_once '../includes/userRank.php';
	require_once '../includes/session.php';

  $message = "";
  global $database;
  $user = new User();
  $rank = new UserRank();

  if ($session ->isLoggedIn()) {
  	redirectTo("./home.php");
  }

  if (isset($_POST['submit'])) {
    if (isset($_POST['name'])) {
      $user->name = $name = trim($_POST['name']);
    }
  	if (isset($_POST['email'])) {
      $user->email = $email = trim($_POST['email']);
    }
    if ($_POST['password'] === $_POST['password2']) {
      $user->password = $password = $_POST['password'];
    } else {
      $message = 'Passwords don\'t match';
    }
    $user->referral_code = $referral_code = generateRandomString();
    if(!empty($_POST['referral'])) {
      $user->referral = $referral = $_POST['referral'];
    } else {
      $user->referral = $referral = null;
    }

  	if (empty($message)) {
      if ($user->save()) {
        $rank->userId = $userId = $database->insertId();
        $rank->user_rank = $user_rank = 0;
        if($rank->save()) {
          if(!empty($_POST['referral'])) {
            $referredUser = User::findByRefCode($user->referral);
            $rankId = UserRank::findByUserId($referredUser->id);
            $total = User::getTotalByReferralCode($user->referral);

            switch ($total) {
              case 4:
                $newRank = 1;
                break;
              case 8:
                $newRank = 2;
                break;
              case 12:
                $newRank = 3;
                break;
              case 16:
                $newRank = 4;
                break;
              default:
                $newRank = $rankId->user_rank;
                break;
            }
            $rank->id = $id = $referredUser->id;
            $rank->userId = $userId = $id;
            $rank->user_rank = $user_rank = $newRank;
            if($rank->save()) {
              redirectTo("index.php");
            }
            redirectTo("index.php");
          } else {
            redirectTo("index.php");
          }
        }
      } else {
        $message = 'Couldn\'t add ... please try again';
      }
    }
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
				<form class="login100-form validate-form flex-sb flex-w" method="post" action="register.php" role="form">
					<span class="login100-form-title p-b-32">
						Registration
          </span>

          <span class="txt1 p-b-11">
						Name
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Name is required">
						<input class="input100" type="text" name="name" >
						<span class="focus-input100"></span>
          </div>

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

          <span class="txt1 p-b-11">
						Confirm Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<input class="input100" type="password" name="password2" >
						<span class="focus-input100"></span>
          </div>

          <span class="txt1 p-b-11">
						Referral Code
					</span>
					<div class="wrap-input100 m-b-12">
						<input class="input100" type="text" name="referral" >
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
            <input type="submit" name="submit" id="loginBt" value="REGISTER" class="login100-form-btn">
					</div>

					<span class="txt1 p-b-11">
            <br ><br ><br >
            <?php echo outputMessage($message);?>
					</span>
        </form>
        <span class="txt1 p-b-11" style="text-align: right;">
					<a class="nav-link btn-rotate" style="color: red" href="./index.php">Login Here</a>
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
