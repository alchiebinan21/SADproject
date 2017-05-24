<html>
<head>
</head>
<body>
<?php
include_once('commands.php');

$command = new Command();
$dataSet = $command->viewdata("Select * from member");

echo "<table border=1>
<tr>
<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Update</th>
<th>Delete</th>
</tr>";

if($dataSet)
{
	foreach($dataSet as $data)
	{
		echo "<tr>";
		
		echo "<td>".$data->getMemberId();
		
		//echo "<td>".'<input type="submit" name="ok" value="Next">'.<"/td>";
		
		
		echo "<td> ".$data->getFname()."</td>";
		
		echo "<td> ".$data->getLname();
		
		echo "<br />";
	}
}
?>
</body>
</html>