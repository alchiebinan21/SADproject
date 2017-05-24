	<?php

class Payment
{
	private $ApplicationNo;
	private $paymentNo;
	private $paymentDate;
	private $paidOn;
	private $penalty;
	private $certifiedBy;
	private $amountToBePaid;
	private $mrNo;
	private $status;
	
	public function __construct($dbRow)
	{
		$this->ApplicationNo = $dbRow['ApplicationNo'];
		$this->mrNo = $dbRow['mrNo'];
		$this->paymentNo = $dbRow['paymentNo'];
		$this->paymentDate = $dbRow['paymentDate'];
		$this->paidOn = $dbRow['paidOn'];
		$this->penalty = $dbRow['penalty'];
		$this->certifiedBy = $dbRow['certifiedBy'];
		$this->amountToBePaid = $dbRow['amountToBePaid'];
		$this->status = $dbRow['status'];
	}
	
	public function getApplicationNo()
	{
		return $this->ApplicationNo;
	}
	
	public function getMrNo()
	{
		return $this->mrNo;
	}
	
	public function getPaymentNo()
	{
		return $this->paymentNo;
	}
	
	public function getPaymentDate()
	{
		return $this->paymentDate;
	}
	
	public function getPaidOn()
	{
		return $this->paidOn;
	}
	
	public function getPenalty()
	{
		return $this->penalty;
	}
	
	public function getCertifiedBy()
	{
		return $this->certifiedBy;
	}
	
	public function getAmountToBePaid()
	{
		return $this->amountToBePaid;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	

}