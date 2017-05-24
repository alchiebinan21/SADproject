	<?php

class LoanP
{
	private $paymentNo;
	private $ApplicationNo;
	private $paymentDate;
	private $paidOn;
	private $penalty;
	private $certifiedBy;
	private $status;
	
	public function __construct($dbRow)
	{
		$this->paymentNo = $dbRow['paymentNo'];
		$this->ApplicationNo = $dbRow['ApplicationNo'];
		$this->paymentDate = $dbRow['paymentDate'];
		$this->paidOn = $dbRow['paidOn'];
		$this->penalty = $dbRow['penalty'];
		$this->certifiedBy = $dbRow['certifiedBy'];
		$this->status = $dbRow['status'];
		
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function getApplicationNo()
	{
		return $this->ApplicationNo;
	}
	
	
	public function getpaymentNo()
	{
		return $this->paymentNo;
	}
	
	public function getpaymentDate()
	{
		return $this->paymentDate;
	}
	
	public function getpaidOn()
	{
		return $this->paidOn;
	}
	
	public function getpenalty()
	{
		return $this->penalty;
	}
	
	public function getcertifiedBy()
	{
		return $this->certifiedBy;
	}
	

	
	
}