<?php

class Members
{
	private $mrNo;
	private $fName;
	private $Lname;
	private $mBirthPlace;
	private $mAdd;
	private $mCivilStatus;
	private $mOccupation;
	private $mDateBirth;
	private $mIncome;
	private $mOtherSourceIncome;
	private $mPresentEmployer;
	private $mContactNo;
	private $mEducationalBack;
	private $mRelative;
	private $mSSS;
	private $mPhealth;
	private $dateAdded;
	public function __construct($dbRow)
	{
		$this->mrNo = $dbRow['mrNo'];
		$this->fName = $dbRow['fName'];
		$this->Lname = $dbRow['Lname'];
		$this->mDateBirth = $dbRow['mDateBirth'];
		$this->mAdd = $dbRow['mAdd'];
		$this->mCivilStatus = $dbRow['mCivilStatus'];
		$this->mOccupation = $dbRow['mOccupation'];
		$this->mBirthPlace = $dbRow['mBirthPlace'];
		$this->mIncome = $dbRow['mIncome'];
		$this->mOtherSourceIncome = $dbRow['mOtherSourceIncome'];
		$this->mPresentEmployer = $dbRow['mPresentEmployer'];
		$this->mContactNo = $dbRow['mContactNo'];
		$this->mEducationalBack = $dbRow['mEducationalBack'];
		$this->mRelative = $dbRow['mRelative'];
		$this->mSSS = $dbRow['mSSS'];
		$this->mPhealth = $dbRow['mPhealth'];
	}
	
	public function getDateAdded()
	{
		return $this->dateAdded;
	}

	public function getPresentEmployer()
	{
		return $this->mPresentEmployer;
	}

	public function getMemberId()
	{
		return $this->mrNo;
	}
	
	public function getFname()
	{
		return $this->fName;
	}
	
	public function getLname()
	{
		return $this->Lname;
	}
	
	public function getBirthDate()
	{
		return $this->mDateBirth;
	}
	
	public function getMemberAdd()
	{
		return $this->mAdd;
	}
	
	public function getMemberCivilStatus()
	{
		return $this->mCivilStatus;
	}
	
	public function getMemberOccupation()
	{
		return $this->mOccupation;
	}
	
	public function getMemberBplace()
	{
		return $this->mBirthPlace;
	}
	
	public function getMemberIncome()
	{
		return $this->mIncome;
	}
	
	public function getMemberOIncome()
	{
		return $this->mOtherSourceIncome;
	}
	
	public function getMemberContact()
	{
		return $this->mContactNo;
	}
	
	public function getMemberEducationalBack()
	{
		return $this->mEducationalBack;
	}
	
	public function getMemberRelative()
	{
		return $this->mRelative;
	}
	
	public function getMemberSSS()
	{
		return $this->mSSS;
	}
	
	public function getMemberPhealth()
	{
		return $this->mPhealth;
	}
}