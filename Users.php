<?php 

class Users{

	private $id;
	private $name;
	private $username;
	private $email;
	
	public function __construct($dbRow)
	{
		$this->id = $dbRow['id'];
		$this->name = $dbRow['name'];
		$this->username = $dbRow['username'];
		$this->email = $dbRow['email'];
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername($id)
	{
		$this->username = $username;
	}
	
	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}
}
?>