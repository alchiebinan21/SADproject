<?php
require('connection.php');
require('Members.php');
require('Loan.php'); /*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// KANI CHI /////////////////////////////////////////////////////////////////////////////////*/
require('getUser.php');
require('loanp.php');
require('payment.php');
require('receipt.php');
require('Shares.php');
require('WithdrawReceipt.php');

class Command{
	
	private $db;
	
	public function __construct(){
		$this->db = new Connection();
		$this->db = $this->db->dbConnect();
	}

	public function Add($fname,$lname,$bplace,$add,$civil,$occ,$dob,$income,$oincome,$pe,$contact,$edback,$relative,$sss,$ph){
			$st = $this->db->prepare("insert into member (fName, Lname, mBirthPlace, mAdd, mCivilStatus, mOccupation, mDateBirth,mIncome,mOtherSourceIncome,mPresentEmployer,mContactNo,mEducationalBack,mRelative,mSSS,mPhealth,dateAdded) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())");
			$st->bindParam(1,$fname);
			$st->bindParam(2,$lname);
			$st->bindParam(3,$bplace);
			$st->bindParam(4,$add);
			$st->bindParam(5,$civil);
			$st->bindParam(6,$occ);
			$st->bindParam(7,$dob);
			$st->bindParam(8,$income);
			$st->bindParam(9,$oincome);
			$st->bindParam(10,$pe);
			$st->bindParam(11,$contact);
			$st->bindParam(12,$edback);
			$st->bindParam(13,$relative);
			$st->bindParam(14,$sss);
			$st->bindParam(15,$ph);
			$st->execute();
	}
	
	
	
	public function DeleteAdd($fname,$lname,$bplace,$add,$civil,$occ,$dob,$income,$oincome,$pe,$contact,$edback,$relative,$sss,$ph,$deletedby,$dateadd,$mrNo){
			$st = $this->db->prepare("insert into deletedmember (fName, Lname, mBirthPlace, mAdd, mCivilStatus, mOccupation, mDateBirth,mIncome,mOtherSourceIncome,mPresentEmployer,mContactNo,mEducationalBack,mRelative,mSSS,mPhealth,date_deleted,deleted_by,dateAdded,mrNo) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),?,?,?)");
			$st->bindParam(1,$fname);
			$st->bindParam(2,$lname);
			$st->bindParam(3,$bplace);
			$st->bindParam(4,$add);
			$st->bindParam(5,$civil);
			$st->bindParam(6,$occ);
			$st->bindParam(7,$dob);
			$st->bindParam(8,$income);
			$st->bindParam(9,$oincome);
			$st->bindParam(10,$pe);
			$st->bindParam(11,$contact);
			$st->bindParam(12,$edback);
			$st->bindParam(13,$relative);
			$st->bindParam(14,$sss);
			$st->bindParam(15,$ph);
			$st->bindParam(16,$deletedby);
			$st->bindParam(17,$dateadd);
			$st->bindParam(18,$mrNo);
			$st->execute();
			 
	}
	
	public function AddLoan($userid,$loanamount,$loanpaytype,$loantype,$loanterm,$loanrepay,$comaker,$approval)
	{
			$st = $this->db->prepare("insert into loan (mrNo,loanAmount,modeType,loanType,loanDate,loanTerm,loanRepayment,coMaker,approval) values (?,?,?,?,now(),?,?,?,?)");
			$st->bindParam(1,$userid);
			$st->bindParam(2,$loanamount);
			$st->bindParam(3,$loanpaytype);
			$st->bindParam(4,$loantype);
			$st->bindParam(5,$loanterm);
			$st->bindParam(6,$loanrepay);
			$st->bindParam(7,$comaker);
			$st->bindParam(8,$approval);
			$st->execute();
			
			print_r($st->errorInfo());
	}
	
	
	
	public function AddWithReceipt($mrNo,$Amount,$certify)
	{
			$st = $this->db->prepare("insert into withdrawreceipt (mrNo,dateWithdraw,Amount,CertifiedBy) values (?,now(),?,?)");
			$st->bindParam(1,$mrNo);
			$st->bindParam(2,$Amount);
			$st->bindParam(3,$certify);
			$st->execute();
			
	}
	public function deleteData($mrNo){
		
		$st = $this->db->prepare("DELETE FROM member WHERE mrNo = ?");
		$st->bindParam(1,$mrNo);
		$st->execute();
	}
	
	
	
	public function ApproveLoanManager($AppNo)
	{
		$st = $this->db->prepare("Update loan SET approval = 1 where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
	}
	
	public function ApproveLoanCC($AppNo)
	{
		$st = $this->db->prepare("Update loan SET approval = 2 where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
	}
		
	public function ApproveLoanChair($AppNo)
	{
		$st = $this->db->prepare("Update loan SET approval = 3 where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
	}
	
	public function DenyLoan($Reason,$deniedBy,$AppNo)
	{
		$st = $this->db->prepare("Update loan SET approval = -1, reason = ?,deniedBy = ? where ApplicationNo = ?");
		$st->bindParam(1,$Reason);
		$st->bindParam(2,$deniedBy);
		$st->bindParam(3,$AppNo);
		$st->execute();
		
		print_r($st->errorInfo());
		
	}
	
	public function ReleaseLoan($AppNo)
	{
		$st = $this->db->prepare("Update loan SET approval = 4 where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
	}
	
	public function changeStatus($AppNo)
	{
		$st = $this->db->prepare("Update loan SET status = 'On Going' where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
		
		
	}
	
	public function dateReleased($AppNo,$date)
	{
		$st = $this->db->prepare("Update loan SET loanPaymentStart = ? where ApplicationNo = ?");
		$st->bindParam(1,$date);
		$st->bindParam(2,$AppNo);
		$st->execute();
		
		
	}
	
	public function ReleasedBy($AppNo,$user)
	{
		$st = $this->db->prepare("Update loan SET ReleasedBy = ? where ApplicationNo = ?");
		$st->bindParam(1,$user);
		$st->bindParam(2,$AppNo);
		$st->execute();
		
		
	}
	public function createPayment($Appno,$paymentdate)
	{
			$st = $this->db->prepare("insert into loanp (ApplicationNo,paymentDate) values (?,?)");
			$st->bindParam(1,$Appno);
			$st->bindParam(2,$paymentdate);
			$st->execute();
			
			
	}
	
	public function deleteDataLoan($ApplicationNo){
		
		$st = $this->db->prepare("DELETE FROM loan WHERE ApplicationNo = ?");
		$st->bindParam(1,$ApplicationNo);
		$st->execute();
		
	}
	
	public function removeData($sql){
		$st = $this->db->prepare($sql);
		$st->execute();
		
		
	}
	
	public function viewdata($sql){
		
		$st = $this->db->prepare($sql);
		$st->execute();
		while ($f = $st->fetch())
		{
			$dataSet[] = new Members($f);
		}
		
		if(!empty($dataSet))
			return $dataSet;
		
		else
			return null;
	}
	
	public function AddReceipt($paymentNo,$paymentAmount,$receivedBy)
	{
			$st = $this->db->prepare("insert into receiptp (paymentNo,Amount,datePaid,receivedBy) values (?,?,now(),?)");
			$st->bindParam(1,$paymentNo);
			$st->bindParam(2,$paymentAmount);
			$st->bindParam(3,$receivedBy);
			$st->execute();
			
			
	}
	/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -GETDATA /////////////////////////////////////////////////////////////////////////////////*/
		
		
		public function getReceipt($PaymentNo)
	{
		$st = $this->db->prepare("SELECT * from receiptp where paymentNo = ?");
		$st->bindParam(1,$PaymentNo);
		$st->execute();
		$f = $st->fetch();
		$dataReceipt = new Receipt($f);
		if(!empty($dataReceipt))
			return $dataReceipt;
		else
			return null;
		
		print_r($st->errorInfo());
	}
		
		
		
		
		
		public function getPayment($PaymentNo)
	{
		$st = $this->db->prepare("SELECT * from loanp where paymentNo = ?");
		$st->bindParam(1,$PaymentNo);
		$st->execute();
		$f = $st->fetch();
		$dataLoanP = new LoanP($f);
		if(!empty($dataLoanP))
			return $dataLoanP;
		else
			return null;
	}
		
		
		public function getdata($sql){
		
		$st = $this->db->prepare($sql);
		$st->execute();
		while ($fet = $st->fetch())
		{
			$dataLoan[] = new Loan($fet);
		}
		
		if(!empty($dataLoan))
			return $dataLoan;
		
		else
			return null;
	}

	public function getWithdraw($mrNo)
	{
		$st = $this->db->prepare("SELECT * from withdrawreceipt where mrNo = ?");
		$st->bindParam(1,$mrNo);
		$st->execute();
		$f = $st->fetch();
		$data = new WithdrawReceipt($f);
		if(!empty($data))
			return $data;
		else
			return null;
	}
	
	public function getMember($mrNo)
	{
		$st = $this->db->prepare("SELECT * from MEMBER where mrNo = ?");
		$st->bindParam(1,$mrNo);
		$st->execute();
		$f = $st->fetch();
		$data = new Members($f);
		if(!empty($data))
			return $data;
		else
			return null;
		
	}
	

	public function getLoan($appno)
	{
		$st = $this->db->prepare("SELECT * from LOAN where ApplicationNo = ?");
		$st->bindParam(1,$appno);
		$st->execute();
		$fet = $st->fetch();
		$dataloan = new Loan($fet);
		if(!empty($dataloan))
			return $dataloan;
		else
			return null;
		
		
	}
	
	
	public function getLoanPayment($PaymentNo)
	{
		$st = $this->db->prepare("SELECT * from LOAN where ApplicationNo = ?");
		$st->bindParam(1,$PaymentNo);
		$st->execute();
		$fet = $st->fetch();
		$dataloanP = new LoanP($fet);
		if(!empty($dataloan))
			return $dataloan;
		else
			return null;
		
		
	}
	
	public function getLoanP($sql){
		
		$st = $this->db->prepare($sql);
		$st->execute();
		while ($fet = $st->fetch())
		{
			$dataLoanP[] = new LoanP($fet);
		}
		
		if(!empty($dataLoanP))
			return $dataLoanP;
		
		else
			return null;
	}

	
	public function getUser($id)
	{
		$st = $this->db->prepare("SELECT * from user where user = ?");
		$st->bindParam(1,$id);
		$st->execute();
		$fetch = $st->fetch();
		$dataloan = new getUser($fetch);
		if(!empty($datauser))
			return $datauser;
		else
			return null;
	}                                                                                                
	
/////////////////////////////////////////////////////////////////////////////////////////// GET NAME /////////////////////////////////////////////////////////////////////////////////////////// 
	public function joindata($AppNo) {
	$st = $this->db->prepare("SELECT * FROM member WHERE mrNo IN (SELECT mrNo FROM loan WHERE ApplicationNo = ?)");
	$st->bindParam(1, $AppNo);
	$st->execute();
	$fet = $st->fetch();
	$datajoin = new Members($fet);

	if(!empty($datajoin))
		return $datajoin;
	else
		return null;
}
	
	public function AddUser($user,$pass,$position,$fname,$lname)
	{
			$st = $this->db->prepare("insert into user (user,pass,position,fname,lname) values (?,?,?,?,?)");
			$st->bindParam(1,$user);
			$st->bindParam(2,$pass);
			$st->bindParam(3,$position);
			$st->bindParam(4,$fname);
			$st->bindParam(5,$lname);
			$st->execute();
			
	}
	
	public function getUsername($user)
	{
		$st = $this->db->prepare("SELECT count(*) FROM user WHERE user = ?");
		$st->bindParam(1,$user);
		$st->execute();
		$number_of_rows = $st->fetchColumn();
		
		if(!empty($number_of_rows))
			return $number_of_rows;
		else
			return 0;
		
	}
	
	
	
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////// -GETDATA ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	public function viewcapital($sql){
		
		$st = $this->db->prepare($sql);
		
		$st->execute();
		$f = $st->fetch();
		
		return $f;
	}
	
	
	public function AddTransaction($userid,$DepositAmount,$numShares)
	{
			$st = $this->db->prepare("insert into transaction (mrNo,Amount,TransactionDate,numOfShares) values (?,?,now(),?)");
			$st->bindParam(1,$userid);
			$st->bindParam(2,$DepositAmount);
			$st->bindParam(3,$numShares);
			$st->execute();
			
			print_r($st->errorInfo());
	}
	
	public function viewshares($sql){
		
		$st = $this->db->prepare($sql);
		$st->execute();
		while ($f = $st->fetch())
		{
			$dataShares[] = new Shares($f);
		}
		
		if(!empty($dataShares))
			return $dataShares;
		
		else
			return null;
	}

	public function getCountReceipt($payNo)
	{
		$st = $this->db->prepare("select * from receiptp where paymentNo = ?");
		$st->bindParam(1,$payNo);
		$st->execute();
		$count = $st->rowCount();
		return $count;
	}
	
	public function getCountLoanToBePaid($AppNo)
	{
		$st = $this->db->prepare("select * from loanp where ApplicationNo = ? and (status = 'Pending' or status = 'Overdue' or status = 'Can be Paid Advance')");
		$st->bindParam(1,$AppNo);
		$st->execute();
		$count = $st->rowCount();
		return $count;
	}
	
	public function getCountLoanAdvance($AppNo)
	{
		$st = $this->db->prepare("select * from loanp where ApplicationNo = ? and status = 'Paid Advance'");
		$st->bindParam(1,$AppNo);
		$st->execute();
		$count = $st->rowCount();
		return $count;
	}

	public function getCountLoanPaid($AppNo)
	{
		$st = $this->db->prepare("select * from loanp where ApplicationNo = ? and status = 'Paid'");
		$st->bindParam(1,$AppNo);
		$st->execute();
		$count = $st->rowCount();
		return $count;
	}
	
	public function getCountOnGoingLoans($mrNo)
	{
		$st = $this->db->prepare("select * from loan where status = 'On Going' and mrNo = ?");
		$st->bindParam(1,$mrNo);
		$st->execute();
		$count = $st->rowCount();
		return $count;
	}
	
	public function OnGoingLoans($mrNo)
	{
		$st = $this->db->prepare("select * from loan where status = 'On Going' and mrNo = ?");
		$st->bindParam(1,$mrNo);
		$st->execute();

		
		while ($fet = $st->fetch())
		{
			$goLoans[] = new Loan($fet);
		}

	if(!empty($goLoans))
		return $goLoans;
	else
		return null;
	}
	
	public function PaidLoans($mrNo)
	{
		$st = $this->db->prepare("select * from loan where status = 'Paid' and mrNo = ?");
		$st->bindParam(1,$mrNo);
		$st->execute();

		
		while ($fet = $st->fetch())
		{
			$paidLoan[] = new Loan($fet);
		}

	if(!empty($paidLoan))
		return $paidLoan;
	else
		return null;
	}
	
	public function AllPaidLoans()
	{
		$st = $this->db->prepare("select * from loan where status = 'Paid'");
		$st->bindParam(1,$mrNo);
		$st->execute();

		
		while ($fet = $st->fetch())
		{
			$paidLoan[] = new Loan($fet);
		}

	if(!empty($paidLoan))
		return $paidLoan;
	else
		return null;
	}
	
	public function AllShares()
	{
		$st = $this->db->prepare("select * from transaction");
		$st->execute();

		
		while ($fet = $st->fetch())
		{
			$shares[] = new Shares($fet);
		}

	if(!empty($shares))
		return $shares;
	else
		return null;
	}
	
	public function AllDeniedLoans()
	{
		$st = $this->db->prepare("select * from loan where status = 'Denied'");
		$st->bindParam(1,$mrNo);
		$st->execute();

		
		while ($fet = $st->fetch())
		{
			$paidLoan[] = new Loan($fet);
		}

	if(!empty($paidLoan))
		return $paidLoan;
	else
		return null;
	}
	
	public function AllPayments()
	{
		$st = $this->db->prepare("select * from receiptp");
		$st->execute();

		
		while ($fet = $st->fetch())
		{
			$withdraw[] = new Receipt($fet);
		}

	if(!empty($withdraw))
		return $withdraw;
	else
		return null;
	}

	public function updateStatusLoanP($status, $paymentNo)
	{
		$st = $this->db->prepare("Update loanp SET status = ? where paymentNo = ?");
		$st->bindParam(1,$status);
		$st->bindParam(2,$paymentNo);
		$st->execute();
	}
    
	
	public function updateStatusLoan($AppNo)
	{
		$st = $this->db->prepare("Update loan SET status = 'Paid' where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
        
        
	}
	
	public function updateDenyLoan($AppNo)
	{
		$st = $this->db->prepare("Update loan SET status = 'Denied' where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
        
        
	}
	
	public function updateCertifiedByLoan($CertifiedBy,$AppNo)
	{
		$st = $this->db->prepare("Update loan SET CertifiedBy = ? where ApplicationNo = ?");
		$st->bindParam(1,$CertifiedBy);
		$st->bindParam(2,$AppNo);
		$st->execute();
        
        
	}
	
	public function updatepaidDateLoan($AppNo)
	{
		$st = $this->db->prepare("Update loan SET paidDate = now() where ApplicationNo = ?");
		$st->bindParam(1,$AppNo);
		$st->execute();
        
       
	}
	
	
	
	public function updateStatusPending($paymentNo)
	{
		$st = $this->db->prepare("Update loanp SET status = 'Pending' where paymentNo = ?");
		$st->bindParam(1,$paymentNo);
		$st->execute();
        
        
	}


	public function updateFname($fname, $mrNo)
	{
		$st = $this->db->prepare("Update member SET fName = ? where mrNo = ?");
		$st->bindParam(1,$fname);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updatePenalty($paymentNo)
	{
		$st = $this->db->prepare("Update loanp SET penalty = 0.01, status = 'Overdue' where paymentNo = ?");
		$st->bindParam(1,$paymentNo);
		$st->execute();
		
		
	}
	
	public function updatePenaltyAdvance($paymentNo)
	{
		$st = $this->db->prepare("Update loanp SET status = 'Can be Paid Advance' where paymentNo = ?");
		$st->bindParam(1,$paymentNo);
		$st->execute();
		
		
	}
    
    public function updatePenaltyLoanP($paymentNo,$penalty)
	{
		$st = $this->db->prepare("Update loanp SET penalty = ? where paymentNo = ?");
		$st->bindParam(1,$penalty);
        $st->bindParam(2,$paymentNo);
		$st->execute();
		
		
	}
	
	public function updateLname($lname, $mrNo)
	{
		$st = $this->db->prepare("Update member SET Lname = ? where mrNo = ?");
		$st->bindParam(1,$lname);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateBplace($bplace, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mBirthPlace = ? where mrNo = ?");
		$st->bindParam(1,$bplace);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateAdd($add, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mAdd = ? where mrNo = ?");
		$st->bindParam(1,$add);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateOcc($occ, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mOccupation = ? where mrNo = ?");
		$st->bindParam(1,$occ);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateDob($dob, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mDateBirth = ? where mrNo = ?");
		$st->bindParam(1,$dob);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateIncome($income, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mIncome = ? where mrNo = ?");
		$st->bindParam(1,$income);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateOincome($oincome, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mOtherSourceIncome = ? where mrNo = ?");
		$st->bindParam(1,$oincome);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updatePresentEmployer($pe, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mPresentEmployer = ? where mrNo = ?");
		$st->bindParam(1,$pe);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateContact($contact, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mContactNo = ? where mrNo = ?");
		$st->bindParam(1,$contact);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateEdBack($edback, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mEducationalBack = ? where mrNo = ?");
		$st->bindParam(1,$edback);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateRelative($relative, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mRelative = ? where mrNo = ?");
		$st->bindParam(1,$relative);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateSSS($sss, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mSSS = ? where mrNo = ?");
		$st->bindParam(1,$sss);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updatePhilHealth($ph, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mPhealth = ? where mrNo = ?");
		$st->bindParam(1,$ph);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateDependent($dep, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mDependID = ? where mrNo = ?");
		$st->bindParam(1,$dep);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
	
	public function updateCivilStatus($civil, $mrNo)
	{
		$st = $this->db->prepare("Update member SET mCivilStatus = ? where mrNo = ?");
		$st->bindParam(1,$civil);
		$st->bindParam(2,$mrNo);
		$st->execute();
	}
}





?>