<?php
if(isset($_POST['ok'])){
	header('location: success.php');
}
?>

<html>
<head>Successfully Added!</head>
<body>
		<form method="post" action="success.php">
		<input type="submit" name="ok" value="Next">
</body>
</html>