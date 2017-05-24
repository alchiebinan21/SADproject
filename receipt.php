<?php

class Receipt
{
	public $receiptpNo;
	public $datePaid;
	public $receivedBy;
	public $Amount;
	public $paymentNo;
	
	public function __construct($dbRow)
	{
		$this->receiptpNo = $dbRow['receiptpNo'];
		$this->datePaid = $dbRow['datePaid'];
		$this->receivedBy = $dbRow['receivedBy'];
		$this->Amount = $dbRow['Amount'];
		$this->paymentNo = $dbRow['paymentNo'];
	}
	
	public function getReceiptpNo()
	{
		return $this->receiptpNo;
	}
	
	public function getDatePaid()
	{
		return $this->datePaid;
	}
	
	public function getmrNo()
	{
		return $this->mrNo;
	}
	
	public function getReceivedBy()
	{
		return $this->receivedBy;
	}
	public function getAmount()
	{
		return $this->Amount;
	}
	public function getPaymentNo()
	{
		return $this->paymentNo;
	}
	public function getApplicationNo()
	{
		return $this->ApplicationNo;
	}
	
}