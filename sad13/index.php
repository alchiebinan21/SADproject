<?php
session_start();
include_once('User.php');

$errName = "";
$errPass  = "";
$result = "";
error_reporting(0);

if(isset($_REQUEST['submit']))
{
	$user = $_REQUEST['user'];
	$pass = $_REQUEST['pass'];
	
	$_SESSION['user'] = $user;

	$object = new User();

	if($object->Login($user, $pass)) {
		$result = '';
		
		
	}
	else {
		$result = '<div id="myAlert" class="alert alert-danger fade in" data-alert="alert">Sorry your Username or Password is incorrect.</div>';
	}
	
	
	// Check if username has been entered
	if (!$_REQUEST['user']) {
		$result = '<div id="myAlert" class="alert alert-danger fade in" data-alert="alert">Please enter your username</div>';
	}

	//Check if password is correct
	if (!$_REQUEST['pass']) {
		$result = '<div id="myAlert" class="alert alert-danger fade in" data-alert="alert">Please enter your password</div>';
	}
}
?>


<!DOCTYPE html>
<html lang="en">


  <head>
  
	 <style>
	.fade {
  opacity: 0;
  -webkit-transition: opacity 0.15s linear;
  -moz-transition: opacity 0.15s linear;
  -o-transition: opacity 0.15s linear;
  transition: opacity 0.15s linear;
	}
	.fade.in {
	  opacity: 1;
	}
	 </style>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Log In page">
    <meta name="author" content="James Labor, Alchie Binan, Faye Leonar, Perkeen Li, Coleene Escarlan">
    <title>Log In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<script type="text/javascript">
	
	
    window.setTimeout(function() {
  $("#myAlert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove();
  });
}, 1500);

</script>
  </head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<h1 class="page-header text-center">Welcome User!</h1>
				<form class="form-horizontal" role="form" method="get" action="index.php">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="user" placeholder="Enter username" value="<?php if(isset($_REQUEST["user"])) echo htmlspecialchars ($_REQUEST["user"]); ?>">
							<p class='text-danger'><?php echo $errName;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="pass" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="pass" name="pass" placeholder="Enter password">
							<?php echo "<p class='text-danger'>$errPass</p>";?>
						</div>
					</div>
					<div class="row">
						<div class ="col-md-5">
							<div class="form-group">
								<div class="col-sm-10 col-sm-offset-10">
								<input id="submit" name="submit" type="submit" value="Login" class="btn btn-primary">
							</div>
						</div>
					</div>
					<div class ="col-md-5">
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<a class="btn btn-primary btn-m" "href="" onclick="registerUser();">Register</a>
						</div>
					</div>
					</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<?php echo $result; ?>	
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>   
	<script>
		function registerUser() {
			location.href = "register.php";
	}
	</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>