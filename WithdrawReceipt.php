<?php

class WithdrawReceipt
{
	public $withdrawNo;
	public $mrNo;
	public $dateWithdraw;
	public $Amount;
	public $CertifiedBy;
	
	public function __construct($dbRow)
	{
		$this->withdrawNo = $dbRow['withdrawNo'];
		$this->mrNo = $dbRow['mrNo'];
		$this->dateWithdraw = $dbRow['dateWithdraw'];
		$this->Amount = $dbRow['Amount'];
		$this->CertifiedBy = $dbRow['CertifiedBy'];
	}
	
	public function getWithdrawNo()
	{
		return $this->withdrawNo;
	}
	
	public function getMrNo()
	{
		return $this->mrNo;
	}
	
	public function getDateWithdraw()
	{
		return $this->dateWithdraw;
	}
	
	public function getAmount()
	{
		return $this->Amount;
	}
	public function getCertifiedBy()
	{
		return $this->CertifiedBy;
	}
	public function getPaymentNo()
	{
		return $this->paymentNo;
	}
}