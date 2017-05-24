<html>
	<head><title>Lab Exercise 06a : PHP Forms</title></head>
	
		
		    
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<!-- Optional theme -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
			<!-- Latest compiled and minified JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
		
		<script>
				$( document ).ready(function() 
				{
					$("#fname_error_message").hide();
					$("#mname_error_message").hide();
					$("#lname_error_message").hide();
					
					var error_fname = false;

					
					$("#fname").focusout(function()
					{
						checkFname();
					});
					
					$("#mname").focusout(function()
					{
						checkMname();
					});
					
					$("#lname").focusout(function()
					{
						checkLname();
					});
					
					$("#lname").focusout(function()
					{
						checkAdd();
					});
				});
				
				function checkFname()
				{
					var name = document.forms["myForm"]["fname"].value;
					
					
					if(name.length == 0)
					{
						$("#fname_error_message").html("Please enter your Firstname");
						$("#fname_error_message").fadeIn(1000);
						error_fname = true;
					}
					else
					{
						$("#fname_error_message").fadeOut(1000);
					}
				}
				
				function checkMname()
				{
					var name = document.forms["myForm"]["mname"].value;
					
					
					if(name.length == 0)
					{
						$("#mname_error_message").html("Please enter your Middle Name");
						$("#mname_error_message").fadeIn(1000);
						error_mname = true;
					}
					else
					{
						$("#mname_error_message").fadeOut(1000);
					}
				}
				
				function checkLname()
				{
					var name = document.forms["myForm"]["lname"].value;
					
					
					if(name.length == 0)
					{
						$("#lname_error_message").fadeIn(1000);
						$("#lname_error_message").html("Please enter your Last Name");
						$("#lname_error_message").fadeIn(1000);
						error_mname = true;
					}
					else
					{
						$("#lname_error_message").fadeOut(1000);
					}
				}
				
				function checkAdd()
				{
					var name = document.forms["myForm"]["city"].value;
					
					
					if(name.length == 0)
					{
						$("#add_error_message").fadeIn(1000);
						$("#add_error_message").html("Please enter your Last Name");
						$("#add_error_message").fadeIn(1000);
						error_mname = true;
					}
					else
					{
						$("#add_error_message").fadeOut(1000);
					}
				}
				
		</script>
	
		<style>
			.error_form{
				font-size:15px;
				font-family: Arial;
				color: #FF0052;
				
			}
			
			::-webkit-input-placeholder { 
				color:    #909;
			}
			:-moz-placeholder { 
			   color:    #909;
			   opacity:  1;
			}
			::-moz-placeholder {
			   color:    #909;
			   opacity:  1;
			}
			:-ms-input-placeholder {
			   color:    #909;
			}
			
		</style>
	<body>
		<div class="page-wrapper">
			<div class="container-fluid" >
				<div class="page-header">
				<h2 class = "col-md-offset-4">Application for Registration</h2>
				</div>
					<div class="row col-md-offset-0">
					
						
						<form class="form-horizontal" id="myForm" name="prelimForm" method="post" action="Binan_midLE06b.php">
						
							<div class="form-group">
								<div class="col-sm-3">
								<label class="control-label col-md-offset-5" for="fname"><h3><b>Name</b></h3></label>
								</div>
							</div>
								
						<div class="page-header">	
							<div class="form-group">
									<label class="control-label col-sm-2" for="fname">First Name:</label>
									<span class="error_form">*</span>
									<span class="error_form" id="fname_error_message">*</span>
									<div class="col-sm-5">
									<input type="text" class ="form-control" id="fname" name="fname" required>
								
									</div>
							</div>
							
							<div class="form-group">
									<label for="mname" class="control-label col-sm-2">Middle Name:</label>
									<span class="error_form">*</span>
									<span class="error_form" id="mname_error_message">*</span>
									<div class="col-sm-5">
									<input type="text" class = "form-control" id="mname" name="mname" required></td>
									</div>
							</div>
							
							<div class="form-group">
								<label for="lname" class="control-label col-sm-2" >Last Name:</label>
								<span class="error_form">*</span>
								<span class="error_form" id="lname_error_message">*</span>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="lname" name="lname" required>
								</div>
							</div>
							
							
						</div>
						
						
							<div class="form-group">
								<div class="col-sm-4">
								<label class="control-label col-md-offset-3" for="fname"><h3><b>Residence Address</b></h3></label>
								</div>
							</div>
						<div class="page-header">	
							<div class="form-group">
								<label for="add" class="control-label col-sm-2">Province:</label></td>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="province" name="province" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="add" class="control-label col-sm-2">City/Municipality:</label></td>
								<span class="error_form">*</span>
								<span class="error_form" id="add_error_message"></span>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="city" name="city" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="add" class="control-label col-sm-2">Barangay</label></td>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="Barangay" name="Barangay" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="add" class="control-label col-sm-2">House No/ Street</label></td>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="Barangay" name="Barangay" required>
								</div>
							</div>
						</div>
						
							<div class="form-group">
								<div class="col-sm-4">
								<label class="control-label col-md-offset-3"><h3><b>Citizenship</b></h3></label>
								</div>
							</div>
							
						<div class="page-header">	
							<div class="form-group">
								<label for="Occupation" class="control-label col-sm-2">Citizenship:</label>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="citizen" name="citizen" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="civil" class="control-label col-sm-2"></label>
								<input type="radio" id="civil" name="civil" value = "By Birth" required> By Birth
								<input type="radio" id="civil" name="civil" value = "Neutralized"> Neutralized
								<input type="radio" id="civil" name="civil" value = "Reacquired"> Reacquired
							</div>
							
							<div class="form-group">
								<label for="Email" class="control-label col-sm-2">Date of Naturalization<br>/Reaquisition</label>
								<div class="col-sm-2">
								<input type="date" class = "form-control" id="datenat" name="datenat" required>
								</div>
							</div>
						</div>
						
						
							<div class="form-group">
								<div class="col-sm-4">
								<label class="control-label col-md-offset-3" for="fname"><h3><b>Period of Residence</b></h3></label>
								</div>
							</div>
							
						<div class="page-header">		
							<div class="form-group">
								<label for="Occupation" class="control-label col-sm-2">In the City/ Mun:</label>	
								<label for="Occupation" class="control-label col-sm-2">No. of Years:</label>
								<div class="col-sm-1">
								<input type="number" class = "form-control" id="citizen" name="noyearscity" required>
								</div>
							
								<label for="Occupation" class="control-label col-sm-2">No. of Months: </label>
								<div class="col-sm-1">
								<input type="number" class = "form-control" id="citizen" name="nomonths" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="Occupation" class="control-label col-sm-2">In the Philippines:</label>
								<label for="Occupation" class="control-label col-sm-2">No. of Years:</label>
								<div class="col-sm-1">
								<input type="number" class = "form-control" id="citizen" name="noyears" required>
								</div>
							</div>
						</div>
						
						<div class="page-header">	
							<div class="form-group">
								<label for="Occupation" class="control-label col-sm-2">Profession/Occupation:</label>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="occ" name="occ" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="Occupation" class="control-label col-sm-2">Tin No:</label>
								<div class="col-sm-5">
								<input type="text" class = "form-control" id="tin" name="tin" required>
								</div>
							</div>
						</div>
						
							<div class="form-group">
								<div class="col-sm-4">
								<label class="control-label col-md-offset-3" for="fname"><h4><b>Name of Father</b></h4></label>
								</div>
								<div class="col-sm-4">
								<label class="control-label col-md-offset-7" for="fname"><h4><b>Name of Mother</b></h4></label>
								</div>
								
							</div>
							
						<div class="page-header">	
							<div class="form-group">
								<label for="lnamef" class="control-label col-sm-2">Last Name:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="lnamef" name="lnamef" required>
								</div>
								
								<label for="lnamem" class="control-label col-sm-2">Last Name:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="lnamem" name="lnamem" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="fnamef" class="control-label col-sm-2">First Name:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="fnamef" name="fnamef" required>
								</div>

								<label for="fnamem" class="control-label col-sm-2">First Name:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="fnamem" name="fnamem" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="lnamef" class="control-label col-sm-2">Middle Name:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="lnamef" name="lnamef" required>
								</div>

								<label for="lnamem" class="control-label col-sm-2">Middle Name:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="lnamem" name="lnamem" required>
								</div>
							</div>
						
						
						
						
						</div>
						
						<div class="page-header">	
							<div class="form-group">
								<label for="gender" class="control-label col-sm-2">Gender: </label>
								<label for="gender" class="control-label col-sm-1">
								<input type="radio" id="gender" name="gender" value = "Male" required>Male
								</label>
								<label for="gender" class="control-label col-sm-1">
								<input type="radio" id="gender" name="gender" value = "Female">Female
								</label>
						
							</div>
							
							<div class="form-group">
								<label for="Height" class="control-label col-sm-2">Height:</label>
								<div class="col-sm-1">
								<input type="number" class = "form-control" id="Height" name="Height" required>
								</div>
								
								<label for="Weight" class="control-label col-sm-1">Weight:</label>
								<div class="col-sm-1">
								<input type="number" class = "form-control" id="Weight" name="Weight" required>
								</div>
								
								
							</div>
						</div>
						
						
							<div class="form-group">
									<div class="col-sm-4">
									<label class="control-label col-md-offset-3" for="pob"><h4><b>Place of Birth</b></h4></label>
									</div>
							</div>
							
						<div class="page-header">
							
							<div class="form-group">
								<label for="pobc" class="control-label col-sm-2">City/Mun:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="pobc" name="pobc" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="pobp" class="control-label col-sm-2">Province:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="pobp" name="pobp" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="dob" class="control-label col-sm-2">Date of Birth:</label>
								<div class="col-sm-2">
								<input type="date" class = "form-control" id="dob" name="dob" required>
								</div>
							</div>
						</div>

						
						<div class="page-header">	
							<div class="form-group">
								<label for="civil" class="control-label col-sm-2">Civil Status: </label>
								<label for="civil" class="control-label col-sm-1">
								<input type="radio" id="civil" name="civil" value = "Single" required>Single
								</label>
								<label for="civil" class="control-label col-sm-1">
								<input type="radio" id="civil" name="civil" value = "Married">Married
								</label>
								<label for="civil" class="control-label col-sm-1">
								<input type="radio" id="civil" name="civil" value = "Widow">Widow/er
								</label>
								<label for="civil" class="control-label col-sm-1">
								<input type="radio" id="civil" name="civil" value = "Legally Separated">Separated
								</label>
							</div>
							
							<div class="form-group">
								<label for="nos" class="control-label col-sm-2">Name of Spouse:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="nos" name="nos" placeholder="*If married" required>
								</div>
							</div>
							
						</div>
						
						<div class="page-header">	
							<div class="form-group">
								<label for="nAssist" class="control-label col-sm-3">
								<input type="radio" id="nAssist" name="nAssist" value = "Illiterate"> None
								</label>
								<label for="nAssist" class="control-label col-sm-1">
								<input type="radio" id="nAssist" name="nAssist" value = "Illiterate"> Illiterate
								</label>
								<label for="nAssist" class="control-label col-sm-1">
								<input type="radio" id="nAssist" name="nAssist" value = "Disabled"> Disabled
								</label>
								
							</div>
							
							<div class="form-group">
								<label for="assist" class="control-label col-sm-2">Assisted By:</label>
								<div class="col-sm-3">
								<input type="text" class = "form-control" id="assist" name="assist" placeholder="Please fill-up Assistor's Oath">
								</div>
							</div>
						</div>

						
						<div class="page-header">	
							<div class="form-group">
								<label for="Oath" class="control-label col-sm-2">Oath:</label>
								<div style ="border: 1px solid #e5e5e5; height: 150px; overflow: auto; padding: 10px" class="col-sm-5 col-md-offset-0">
								<p>
									I do solemnly swear that the above statements regarding my person are
									true and correct; that i possess all the qualifications and none of the disqualification
									of a voter; that I have no pending application for registration in any city/municipality;
									and that I am not registered in any precinct in the Philippines.
								</p>
								</div>
							</div>
							
							<div class="form-group">
								
								<div class="col-sm-3 col-md-offset-2">
								<input type="checkbox" class="checkbox-inline" id="agree" name="agree" required>  Agree with Oath
								</div>
							
							</div>
							
							<div class="form-group">
							<p>
								<input type="submit" class="btn btn-primary col-md-offset-2" id="submit" name="submit">
							</p>
							</div>
						</form>
						</div>
				
			</div>
		</div>

		<?php
		
			if (isset($_POST['fname']))
			{
				$fname = $_POST['fname'];
				$mname = $_POST['mname'];
				$lname = $_POST['lname'];
				$add = $_POST['add'];
				$occ = $_POST['occ'];
				$civ =  $_POST['civil'];
				$email =  $_POST['email'];
				
				getThem($fname,$mname,$lname);
				echo tempPass($lname);
				echo "<br>Address: ".$add;
				echo "<br>Occupation: ".$occ;
				echo "<br>Civil Status: ".$civ;
				echo "<br>Email: ".$email;
			}
		
		
		function getThem($fname,$mname,$lname)
		{
			echo "Name: ".$fname." ".$mname." ".$lname."<br>";
			echo "Username: ".strtolower($fname[0]).strtolower($mname[0]).strtolower($lname)."<br>";
			echo "Password: ";
		}
		
		function tempPass($lname)
		{
			$count = strlen($lname);
			$string = "";
			$pos = 0;
			
			for($x=0;$x<$count;$x++)
					{
					if($lname[$x] == 'a' || $lname[$x] == 'e' || $lname[$x] == 'i' || $lname[$x] == 'o' || $lname[$x] == 'u')
					{
							$string .= strpos($lname,$lname[$x],$x);
					}
					else
					{
						$string .= $lname[$x];
					}
				}
				
			return $string;
		}

		?>
	</body>
</html>
