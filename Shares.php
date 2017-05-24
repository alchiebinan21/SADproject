	<?php

class Shares
{
	private $TransactionID;
	private $TransactionType;
	private $TransactionDate;
	private $Amount;
	private $numOfShares;
	private $mrNo;

	public function __construct($dbRow)
	{
		$this->TransactionID = $dbRow['TransactionID'];
		
		$this->TransactionDate = $dbRow['TransactionDate'];
		$this->Amount = $dbRow['Amount'];
		$this->numOfShares = $dbRow['numOfShares'];
		$this->mrNo = $dbRow['mrNo'];
	}
	
	public function getTransactionId()
	{
		return $this->TransactionID;
	}
	
	public function getShares()
	{
		return $this->numOfShares;
	}
	
	public function getUserNo()
	{
		return $this->mrNo;
	}
	
	public function getTransactionType()
	{
		return $this->TransactionType;
	}
	
	public function getTransactionDate()
	{
		return $this->TransactionDate;
	}
	
	public function getAmountDeposit()
	{
		return $this->Amount;
	}
	
	public function getCapital()
	{
		return $this->Amount * $this->numOfShares;
	}


}