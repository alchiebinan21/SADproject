<?php

class getUser
{
	private $id;
	private $user;
	private $password;
	private $position;
	private $fname;
	private $lname;
	
	public function __construct($dbRow)
	{
		$this->id = $dbRow['id'];
		$this->user = $dbRow['user'];
		$this->pass = $dbRow['pass'];
		$this->position = $dbRow['position'];
		$this->fname = $dbRow['fname'];
		$this->lname = $dbRow['lname'];
	}
	
	public function getMemberId()
	{
		return $this->id;
	}
	
	public function getfname()
	{
		return $this->fname;
	}
	
	public function getlname()
	{
		return $this->lname;
	}
	
	public function getMemberUser()
	{
		return $this->user;
	}
	public function getMemberPass()
	{
		return $this->pass;
	}
	public function getMemberPosition()
	{
		return $this->position;
	}
}