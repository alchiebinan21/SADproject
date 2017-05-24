<?php
include_once('commands.php');

if(isset($_POST['delete'])){
	{
		$mrNo = $_POST['mrno'];
		$command = new Command();
		$command->deleteData($mrNo);
	}

}
?>

<html>
<head></head>
<body>
	<form method="post" action="delete.php">
		mrNo: <input type="text" name="mrno"/><br>
		First Name: <input type="text" name="fname"/><br>
		Last Name: <input type="password" name="lname"/><br>
		<input type="submit" name="delete" value="Delete">
</body>
</html>