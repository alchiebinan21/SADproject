<?php
include_once('commands.php');
session_start();

$errFname = '';
$errLname = '';
$errName = '';
$errPass = '';
$errPosition = '';
$result = "";
$command = new Command();

if (isset($_REQUEST['register'])) 
	{
		if ($_REQUEST['register']=='Register') 
		{
			
			  
			$user = $_REQUEST['user'];
			$pass = $_REQUEST['pass'];
			$position = $_REQUEST['position'];
			$fname = $_REQUEST['fname'];
			$lname = $_REQUEST['lname'];
			
			$data = $command->getUsername($user);
			
		if(!empty($user) && !empty($pass) && !empty($position) && !empty($fname) && !empty($lname) && $data == 0) {
			$command->AddUser($user,$pass,$position,$fname,$lname);
			$result = '<div id="myAlert" class="alert alert-success fade in" data-alert="alert">User successfully created</div>';
		}
		else {
			$result = '<div id="myAlert" class="alert alert-danger fade in" data-alert="alert">Missing fields or username has already been used</div>';
		}
		}
		
		
		if (!$_REQUEST['fname']) {
		$errFname = 'Please enter your first name';
	}
		
	
	
	if (!$_REQUEST['lname']) {
		$errLname = 'Please enter your last name';
	}
		
	
	
		if (!$_REQUEST['user']) {
		$errName = 'Please enter your user name';
	}


	if (!$_REQUEST['pass']) {
		$errPass = 'Please enter your password';
	}
		
		if (!$_REQUEST['position']) {
		$errPosition = 'Please enter the position';
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
    <title>Register</title>
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
  				<h1 class="page-header text-center">Register User!</h1>
				<form class="form-horizontal" role="form" method="get" action="register.php">
				<div class="form-group">
						<label for="name" class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name" value="">
							<p class='text-danger'><?php echo $errFname;?></p>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" value="">
							<p class='text-danger'><?php echo $errLname;?></p>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="user" name="user" placeholder="Enter username" value="">
							<p class='text-danger'><?php echo $errName;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="pass" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="pass" name="pass" placeholder="Enter password">
							<p class='text-danger'><?php echo $errPass;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="position" class="col-sm-2 control-label">Position</label>
						<div class="col-sm-10">
							<select class="form-control" id="position" name="position" placeholder="Enter position">
								<option value="Manager">Manager</option>
								<option value="Treasurer">Treasurer</option>
								<option value="Credit Committee">Credit Committee</option>
								<option value="Board Chairman">Board Chairman</option>
								
							</select>
							<p class='text-danger'><?php echo $errPosition;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input id="register" name="register" type="submit" value="Register" class="btn btn-primary">
							<a id="Back" href="success.php" type="submit" class="btn btn-primary col-sm-offset-1"> Back</a>
						</div>
						
					</div>
					
					<div class="form-group" id="aw">
						<div class="col-sm-10 col-sm-offset-2">
							<?php echo $result; ?>	</div>
					</div>
					
						
					
			</div>
					
				</form> 
			</div>
		</div>
	</div>   
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>