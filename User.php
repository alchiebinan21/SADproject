<?php

include_once('connection.php');
include_once('getUser.php');



class User{

	private $db;
	
	public function __construct(){
		$this->db = new Connection();
		$this->db = $this->db->dbConnect();
	}


	public function getPosition($user, $pass)
	{
		if(!empty($user) && !empty($pass))
		{
			$st = $this->db->prepare("select position from user where user=? and pass=?");
			$st->bindParam(1,$user);
			$st->bindParam(2,$pass);
			$st->execute();
			
		}
	}

	public function Login($user, $pass){
		if(!empty($user) && !empty($pass))
		{
			$st = $this->db->prepare("select * from user where user=? and pass=?");
			$st->bindParam(1,$user);
			$st->bindParam(2,$pass);
			$st->execute();
			
			
			while ($f = $st->fetch())
			{
			$dataSet[] = new getUser($f);
			}
			
			foreach($dataSet as $data)
			{
			$fname = $data->getfname();
			$lname = $data->getlname();
			
			$_SESSION['fname'] = $fname;
			$_SESSION['lname'] = $lname;
			$position = $data->getMemberPosition();
			}

			if($st->rowCount() == 1 && $position == "Manager")
			{
				header("Location: success.php");
				$_SESSION['Position'] = "Manager";
			}
			else if($st->rowCount() == 1 && $position == "Treasurer")
			{
				header("Location: successT.php");
				$_SESSION['Position'] = "Treasurer";
			}
			else if($st->rowCount() == 1 && $position == "Board Chairman")
			{
				header("Location: successB.php");
				$_SESSION['Position'] = "Board Chairman";
			}
			else if($st->rowCount() == 1 && $position == "Credit Committee")
			{
				header("Location: successC.php");
				$_SESSION['Position'] = "Credit Committee";
			}

			
		}
	}
}