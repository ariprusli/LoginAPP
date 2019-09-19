<?php

session_start();
require 'class.user.php';

$user = new USER();

if($user->isLoggedIn()!=""){

	$user->redirect('home.php');
}

if(isset($_POST['btn-signup'])){

	$uname = strip_tags($_POST['txt_uname']);
	$umail = strip_tags($_POST['txt_umail']);
	$password = strip_tags($_POST['txt_password']);

	if($uname == ""){

		$error[] = "Username Tidak Boleh Kosong!";
	}elseif ($umail == "") {
		$error[]= "Email Tidak Boleh Kosong!";
	}elseif (!filter_var($umail, FILTER_VALIDATE_EMAIL)){

		$error[]= "Enter Email Yang Valid";
	}elseif ($password == "") {
		
		$error[]= "Password TIdak Boleh Kosong!";
	}elseif (strlen($password)<6) {
		$error[]= "Password Harus Lebih Dari 6 Karakter!";
	}else{

		try{

			$stmt = $user->runQuery("SELECT user_name, user_email FROM users WHERE user_name = :uname OR user_email = :umail");
			$stmt->execute(array(':uname'=>$uname ,':umail'=>$umail));
			$row = $stmt->fetch(PDO::FETCH_OBJ);

			if($row->user_name == $uname){

				$error[] = "Username Tidak Tersedia";
			}elseif ($row->user_email == $umail) {
				$error[] = "Email sudah dipakai";
			}else{

				if($user->register($uname, $umail, $password)){

					$user->redirect('sign-up.php?joined');
				}
			}
		}catch(PDOException $e){

			echo $e->getMessage();
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/style.css">
</head>
<body>
	<div class="signin-form">
		<div class="container">
			<form method="post" class="form-signin">
				<h2 class="form-sigin-heading">Sign up</h2>
				<?php
					if (isset($error)) {
						
						foreach ($error as $error){
							 ?>
							 <div class="alert alert-danger">
							 	<i class="glyphicon glyphicon-warning-sign"></i>&nbsp; <?php echo $error; ?>
							 </div>
							 <?php
						}
					}else if (isset($_GET['joined'])) {
						?>
						<div class="alert alert-info">
							<i class="glyphicon glyphicon-log-in"></i> &nbsp; Pendaftaran Berhasil <a href="index.php">Login disini</a>
						</div>
						<?php
					}
				?>
				<div class="form-group">
					<input type="text" class="form-control" name="txt_uname" placeholder="Username" value="<?php if(isset($error)){echo $uname;}?>">
				</div>
								<div class="form-group">
					<input type="text" class="form-control" name="txt_umail" placeholder="Alamat Email" value="<?php if(isset($error)){echo $umail;}?>">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="txt_password" placeholder="Password">
				</div>
				<div class="clear-fix"></div><hr/>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="btn-signup">
						<i class="glyphicon glyphicon-open-file"></i>&nbsp; SIGN UP
					</button>
				</div>
				<br/>
				<label>Have an account? <a href="index.php">Sign in</a></label>
			</form>
		</div>
	</div>

</body>
</html>