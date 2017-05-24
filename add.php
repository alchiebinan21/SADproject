<?php
include_once('commands.php');

if(isset($_POST['add']))
{
	$fname = $_POST['first'];
	$lname = $_POST['last'];
	$bplace = $_POST['birthplace'];
	$add = $_POST['address'];
	$occ = $_POST['occupation'];
	$dob = $_POST['dob'];
	$income = $_POST['Income'];
	$oincome = $_POST['otherincome'];
	$pe = $_POST['employer'];
	$contact = $_POST['contact'];
	$edback = $_POST['eb'];
	$relative = $_POST['relative'];
	$sss = $_POST['sss'];
	$ph = $_POST['philhealth'];
	$dep = $_POST['dependent'];
	$civil = $_POST['civilstat'];
	
	$command = new Command();
	$command->Add($fname,$lname,$bplace,$add,$civil,$occ,$dob,$income,$oincome,$pe,$contact,$edback,$relative,$sss,$ph);
	/*$command->addfname($fname,$lname);*/
}












?>

<html>
<head>Add a new member</head>
<body>
	<form method="post" action="add.php">
		First Name: <input type="text" name="first"/>
		Last Name: <input type="text" name="last"/><br>
		Birth Place: <input type="text" name="birthplace"/>
		Address: <input type="text" name="address"/><br>
		Civil Status: <input type="text" name="civilstat"/><br>
		Occupation: <input type="text" name="occupation"/><br>
		Date of Birth: <input type="date" name="dob"/><br>
		Income: <input type="text" name="Income"/>
		Other Source of Income: <input type="text" name="otherincome"/><br>
		Present Employer: <input type="text" name="employer"/>
		Contact No: <input type="text" name="contact"/><br>
		Educational Background: <input type="text" name="eb"/>
		Relative: <input type="text" name="relative"/><br>
		SSS #: <input type="text" name="sss"/>
		Phil Health #: <input type="text" name="philhealth"/><br>
		Dependent: <input type="text" name="dependent"/><br>
		
		
		<input type="submit" name="add" value="Add">
		<input type="submit" name="delete" value="Delete">
</body>
</html>