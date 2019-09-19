<?php

session_start();

require 'class.user.php';
$login = new USER();

if($login->isLoggedIn()!=""){

	$login->redirect('home.php');
}

if(isset($_POST['btn-login'])){

	$uname = strip_tags($_POST['txt_uname_umail']);
	$umail = strip_tags($_POST['txt_uname_umail']);
	$upass = strip_tags($_POST['txt_password']);

	if($login->doLogin($uname, $umail, $upass)){

		$login->redirect('home.php');
	}else{

		$error = "Wrong details";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/style.css">
</head>
<body>

	<div class="signin-form">
		<div class="container">
			<form class="form-signin" method="post" id="login-form">
				<h2 class="form-signin-heading">Login to WebApp</h2><hr>

				<div id="error">
					<?php
						if(isset($error)){
					?>

					<div class="alert alert-danger">
						<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error;?>!
					</div>

					<?php
					}

					?>
					<div class="form-group">
						<input type="text" class="form-control" name="txt_uname_umail" placeholder="Username or Email" required>
						<span id="check-e"></span>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="txt_password" placeholder="Password" required>
						<span id="check-e"></span>
					</div>
					<hr/>

					<div class="form-group">
						<button type="submit" class="btn btn-default" name="btn-login"><i class="glyphicon glyphicon-log-in"></i>
						&nbsp; Sign In
						<span id="check-e"></span>
					</button>
					</div>
					<br/>
					<label>Don't have an account ? <a href="sign-up.php">Sign Up</a></label>
				</div>
			</form>
		</div>
	</div>

</body>
</html>