	<?php

class Loan
{
	private $ApplicationNo;
	private $mrNo;
	private $loanAmount;
	private $loanDate;
	private $loanType;
	private $modeType;
	private $loanTerm;
	private $loanRepayment;
	private $loanPaymentSched;
	private $loanPaymentStart;
	private $coMakerID;
	private $approval;
	private $reason;
	private $status;
	private $ReleasedBy;
	private $CertifiedBy;
	private $paidDate;
	private $deniedBy;
	private $coMaker;
	
	public function __construct($dbRow)
	{
		$this->ApplicationNo = $dbRow['ApplicationNo'];
		$this->mrNo = $dbRow['mrNo'];
		$this->loanAmount = $dbRow['loanAmount'];
		$this->loanDate = $dbRow['loanDate'];
		$this->loanType = $dbRow['loanType'];
		$this->modeType = $dbRow['modeType'];
		$this->loanTerm = $dbRow['loanTerm'];
		$this->loanRepayment = $dbRow['loanRepayment'];
		$this->loanPaymentStart = $dbRow['loanPaymentStart'];
		$this->approval = $dbRow['approval'];
		$this->reason = $dbRow['reason'];
		$this->status = $dbRow['status'];
		$this->ReleasedBy = $dbRow['ReleasedBy'];
		$this->CertifiedBy = $dbRow['CertifiedBy'];
		$this->paidDate = $dbRow['paidDate'];
		$this->deniedBy = $dbRow['deniedBy'];
		$this->coMaker = $dbRow['coMaker'];
	}
	
	public function getdeniedBy()
	{
		return $this->deniedBy;
	}
	
	public function getReason()
	{
		return $this->reason;
	}
	
	public function getpaidDate()
	{
		return $this->paidDate;
	}
	
	
	public function getCertifiedBy()
	{
		return $this->CertifiedBy;
	}
	
	public function getReleasedby()
	{
		return $this->ReleasedBy;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function getApplicationNo()
	{
		return $this->ApplicationNo;
	}
	
	public function getMemberId()
	{
		return $this->mrNo;
	}
	
	public function getloanAmount()
	{
		return $this->loanAmount;
	}
	
	public function getloanDate()
	{
		return $this->loanDate;
	}
	
	public function getloanType()
	{
		return $this->loanType;
	}
	
	public function getmodeType()
	{
		return $this->modeType;
	}
	
	public function getloanTerm()
	{
		return $this->loanTerm;
	}
	
	public function getloanInstallNo()
	{
		return $this->loanInstallNo;
	}
	
	public function getloanRepayment()
	{
		return $this->loanRepayment;
	}
	
	
	public function getloanPaymentStart()
	{
		return $this->loanPaymentStart;
	}
	
	public function getcoMaker()
	{
		return $this->coMaker;
	}
	
	public function getApproval()
	{
		return $this->approval;
	}
}