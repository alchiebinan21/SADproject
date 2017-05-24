<?php
include_once('commands.php');
session_start();

date_default_timezone_set('Asia/Manila');
			
$pageHeader = "Payment Form";	
$command = new Command();
$dataSet = $command->viewdata("Select * from member");
$dateNow = date('M-d-Y');


$orString = "";

$x = 0;

if (isset($_REQUEST['payment'])) 
{

	if ($_REQUEST['payment']=='Submit') 
	{
		$x = 1;
		$memberid = $_GET['memberID'];
		$dataLoan = $command->getdata("Select * from loan where mrNo = $memberid and status = 'On Going'");
		$count = count($dataLoan);
		$data = $command->getMember($memberid);
	}
	
	if ($_REQUEST['payment']=='View Payments') 
	{
		$x = 2;
		$AppNo = $_GET['applicationNo'];
		$memberid = $_GET['memberID'];
		$dataLoan = $command->getdata("Select * from loan where mrNo = $memberid and status = 'On Going'");
		$data = $command->getMember($memberid);
		$Loan = $command->getLoan($AppNo);
		
		$dataLoan2 = $command->getLoan($AppNo);
		$dataPayment = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo and (status = 'Pending' or status = 'Overdue' or status = 'Can be Paid Advance')");
		$countdataPayment = count($dataPayment);
		
        
		$MemberId = $dataLoan2->getMemberId();
		$Amount = $dataLoan2->getloanAmount();
		$term = $dataLoan2->getloanTerm();
        
		$count = $command->getCountLoanAdvance($AppNo);
		$paid = $command->getCountLoanPaid($AppNo);
				
		$InterestArray = array();
		$AmountArray = array();
		$TermArray = array();
		$TempAmounts = $Amount;
		$TempTotalAmount = 0;
		$TempTotalAdvance = 0;
		$TempTotalInterest = 0;
		$TempTerm = $term;
		
		
		$dataLoanP = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo");
		$countLoanP = count($dataLoanP);
		
		for($y=0;$y<$countLoanP;$y++)
	{
		$status = $dataLoanP[$y]->getStatus();
		$penalty = $dataLoanP[$y]->getpenalty();
		
				$loanpID = $dataLoanP[$y]->getpaymentNo();
				$dateToPay = $dataLoanP[$y]->getpaymentDate();
				
				$datetime3 = strtotime(date('Y-m-d'));
				$datetime2 = strtotime(date('Y-m-d',strtotime($dateToPay)));
	
				$secs = $datetime2 - $datetime3;
				$days = floor($secs / (24 * 60 * 60 ));
				
				if($days < 0)
				{
					if($status == 'Pending' || $status == 'Can be Paid Advance')
					{
					$command->updatePenalty($loanpID);
                        $status = 'Overdue';
					}
				}
				
				if($days > 31)
				{
					if($status == 'Pending' || $status == 'Overdue')
					{
					$command->updatePenaltyAdvance($loanpID);
                         $status = 'Can be Paid Advance';
					}
				}
				
				else if($days >= 0 && $days <= 31 )
				{
					if($status == 'Can be Paid Advance' || $status == 'Overdue')
					{
					
					$command->updateStatusPending($loanpID);
                    $status = 'Pending';
					}
				}
				
				

		if($status == "Paid" || $status == "Pending")
		{
			$AmountArray[$y] = $TempAmounts;
			$TermArray[$y] = $TempTerm;
			$InterestArray[$y] = $TempAmounts * 0.02 * $TempTerm / $TempTerm;

			
			if($status == "Paid")
			{
				$TempTotalAmount += ($TempAmounts/$TempTerm) + (($TempAmounts * 0.02 * $TempTerm) / $TempTerm);
				
			}
			$TempTotalInterest += ($TempAmounts * 0.02 * $TempTerm) / $TempTerm;
		}
			
		if($status == "Overdue")
		{
			$AmountArray[$y] = $TempAmounts;
			$TermArray[$y] = $TempTerm;
			
			$Interest = ($TempAmounts * (0.02) * $TempTerm) / $TempTerm;
			$perMonthPay = ($TempAmounts / $TempTerm);
			$overdueInterest = ($Interest+$perMonthPay) * $penalty;
			
			
			$TempTotalInterest += $Interest + $overdueInterest;
			$InterestArray[$y] = $Interest + $overdueInterest;
			
		}
		
		if($status == "Paid Overdue")
		{
			$AmountArray[$y] = $TempAmounts;
			$TermArray[$y] = $TempTerm;
			
			$Interest = ($TempAmounts * (0.02) * $TempTerm) / $TempTerm;
			$perMonthPay = ($TempAmounts / $TempTerm);
			$overdueInterest = ($Interest+$perMonthPay) * $penalty;
			
			
			$TempTotalInterest += $Interest + $overdueInterest;
			$InterestArray[$y] = $Interest + $overdueInterest;
			
		}
		
			if($status == "Paid Advance")
			{
					$AmountArray[$y] = $TempAmounts;
					$TermArray[$y] = $TempTerm;
					$InterestArray[$y] = 0;
					$TempAmounts-=($TempAmounts/$TempTerm);
					if($TempTerm != 1)
					{
					$TempTerm-=1;
					}
					$TempTotalAdvance += $TempAmounts/$TempTerm;
			}
			
			if($status == "Can be Paid Advance")
		{
				$AmountArray[$y] = $TempAmounts;
				$TermArray[$y] = $TempTerm;
				$InterestArray[$y] = 0;
				$TempAmounts-=($TempAmounts/$TempTerm);
				if($TempTerm != 1)
					{
					$TempTerm-=1;
					}
				$TempTotalAdvance += $TempAmounts/$TempTerm;
		}
        
		}
        // JP
        $dataLoanP = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo");
        $dataLoanPInterest = $InterestArray;

       
	}
		if ($_REQUEST['payment']=='Submit Payment') 
		{
			$x = 3;
			$pageHeader = "Official Receipt";
			$AppNo = $_GET['applicationNo'];
			$paymentNo = $_GET['paymentNo'];
			$Loan = $command->getLoan($AppNo);
			$payAmount = $_GET['paymentAmount'];
			$memberid = $_GET['memberID'];
			$LoanP = $command->getLoanPayment($paymentNo);
			$dataMember = $command->getMember($memberid);
			
			$fname = $_SESSION['fname'];
			$lname = $_SESSION['lname'];
			$space = " ";
			
			$receivedBy = $fname.$space.$lname;
			
			$dataLoan = $command->getLoan($AppNo);
			$dataPayment = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo and (status = 'Pending' or status = 'Overdue' or status = 'Can be Paid Advance')");
			
			
			

			$MemberId = $dataLoan->getMemberId();
			$Amount = $dataLoan->getloanAmount();
			$term = $dataLoan->getloanTerm();

			$count = $command->getCountLoanAdvance($AppNo);
			$paid = $command->getCountLoanPaid($AppNo);
					
			$InterestArray = array();
			$AmountArray = array();
			$TermArray = array();
			$TempAmounts = $Amount;
			$TempTotalAmount = 0;
			$TempTotalAdvance = 0;
			$TempTotalInterest = 0;
			$TempTerm = $term;
			
			
			$dataLoanP = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo");
			$countLoanP = count($dataLoanP);
			
			for($y=0;$y<$countLoanP;$y++)
			{
				$status = $dataLoanP[$y]->getStatus();
				$penalty = $dataLoanP[$y]->getpenalty();
				
				if($status == "Paid" || $status == "Pending")
				{
					$AmountArray[$y] = $TempAmounts;
					$TermArray[$y] = $TempTerm;
					$InterestArray[$y] = $TempAmounts * 0.02 * $TempTerm / $TempTerm;

					
					if($status == "Paid")
					{
						$TempTotalAmount += ($TempAmounts/$TempTerm) + (($TempAmounts * 0.02 * $TempTerm) / $TempTerm);
						
					}
					$TempTotalInterest += ($TempAmounts * 0.02 * $TempTerm) / $TempTerm;
				}
					
				if($status == "Overdue")
				{
					$AmountArray[$y] = $TempAmounts;
					$TermArray[$y] = $TempTerm;
					
					$Interest = ($TempAmounts * (0.02) * $TempTerm) / $TempTerm;
					$perMonthPay = ($TempAmounts / $TempTerm);
					$overdueInterest = ($Interest+$perMonthPay) * $penalty;
					
					
					$TempTotalInterest += $Interest + $overdueInterest;
					$InterestArray[$y] = $Interest + $overdueInterest;
					
				}
				
				if($status == "Paid Overdue")
				{
					$AmountArray[$y] = $TempAmounts;
					$TermArray[$y] = $TempTerm;
					
					$Interest = ($TempAmounts * (0.02) * $TempTerm) / $TempTerm;
					$perMonthPay = ($TempAmounts / $TempTerm);
					$overdueInterest = ($Interest+$perMonthPay) * $penalty;
					
					
					$TempTotalInterest += $Interest + $overdueInterest;
					$InterestArray[$y] = $Interest + $overdueInterest;
					
				}
				
				if($status == "Paid Advance")
				{
						$AmountArray[$y] = $TempAmounts;
						$TermArray[$y] = $TempTerm;
						$InterestArray[$y] = 0;
						$TempAmounts-=($TempAmounts/$TempTerm);
						if($TempTerm != 1)
						{
						$TempTerm-=1;
						}
						$TempTotalAdvance += $TempAmounts/$TempTerm;
				}
				
				if($status == "Can be Paid Advance")
				{
						$AmountArray[$y] = $TempAmounts;
						$TermArray[$y] = $TempTerm;
						$InterestArray[$y] = 0;
						$TempAmounts-=($TempAmounts/$TempTerm);
						if($TempTerm != 1)
						{
						$TempTerm-=1;
						}
						$TempTotalAdvance += $TempAmounts/$TempTerm;
				}
			
            
			}
			
			for($y=0;$y<$countLoanP;$y++)
			{
				$payNo = $dataLoanP[$y]->getpaymentNo();
				
				

				if($paymentNo == $payNo)
				{
					$Receipt = $command->getReceipt($paymentNo);
					$ReceiptNo = $Receipt->getReceiptpNo();
					$ReceiptAmount = $Receipt->getAmount();
					

					
					$TotalToBePaid = $AmountArray[$y]/$TermArray[$y] + $InterestArray[$y];
					
					$LoanPayment = $command->getPayment($paymentNo);
					$datePayment = $LoanPayment->getpaymentDate();
					$dateNow = date('M-d-Y');
					 
					$ts1 = strtotime($dateNow);
					$ts2 = strtotime($datePayment);

					$seconds_diff = $ts2 - $ts1;
					
					$days_diff = $seconds_diff/86400;
					
					if($TotalToBePaid == $payAmount)
					{

					if($days_diff>= 0 && $days_diff <= 31)
					{
						$status = 'Paid';
						$command->updateStatusLoanP($status,$paymentNo);
						
						$orString = ".";
					}
					
					else if($days_diff < 0)
					{
						$status = 'Paid Overdue';
						$penalty = 0.01;
						$command->updateStatusLoanP($status,$paymentNo);
						$command->updatePenaltyLoanP($paymentNo,$penalty);

						$orString = "Due to the Overdue of Date which the interest was added by 1% to the Amount to be paid.";
					}
					
					else if($days_diff > 31)
					{
						
						$InterestArray[$y] = 0;
						$status =  'Paid Advance';
						$command->updateStatusLoanP($status,$paymentNo);
						$payAmount = $AmountArray[$y]/$TermArray[$y];
						$orString = "due to paying in advance.";
					}
					
					if($Receipt->getReceiptpNo() == null)
					{
						$command->AddReceipt($paymentNo,$payAmount,$receivedBy);
					}
					
                    
				}
				

			}
		}
			        $Receipt = $command->getReceipt($paymentNo);
					$ReceiptNo = $Receipt->getReceiptpNo();
					$ReceiptAmount = $Receipt->getAmount();
       
    $dataLoanPaid = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo and (status = 'Paid' or status = 'Paid Advance' or status = 'Paid Overdue')");
    
    $countLoanPaid = count($dataLoanPaid);   
    
        if($countLoanP == $countLoanPaid)
        {
			echo $receivedBy;
            $command->updateStatusLoan($AppNo);
			$command->updateCertifiedByLoan($receivedBy,$AppNo);
			$command->updatepaidDateLoan($AppNo);
        }
	}
	

}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Profiling User</title>
	


    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">
		
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <style>
	.box
	{
		width:700px;
		background-color:#f8f8f8;
		border-color: #e7e7e7;
		border: 1px solid transparent;
		border-radius: 0;
		border-width: 1 1 1px;
	}
</style>

 <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
	
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
<script>
//   $(document).ready(function() {
//     $('#datepicker').datepicker({
// 		minDate: 0,						
//       });
//   });

  </script>
</head>

<body>
    <div id="wrapper">

        <!-- start, Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<!-- / start, navbar-header -->
			<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<?php if($_SESSION['Position'] == "Manager") {?>
                <a class="navbar-brand" href="success.php">Manager</a>
				<?php 
				}?>
				<?php if($_SESSION['Position'] == "Treasurer") {?>
                <a class="navbar-brand" href="successT.php">Treasurer</a>
				<?php 
				}?>
            </div>
            <!-- /end, navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
							<a href="admin.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li>
							<a href="admin.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
							<li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
						
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

			<?php if($_SESSION['Position'] == "Manager") {?>
			
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
					
                        <li>
                            <a href="success.php?cont=add"><i class="fa fa-group fa-fw"></i> Add Member</a>
                        </li>
                        <li>
                            <a href="success.php?cont=search"><i class="fa fa-search fa-fw"></i> Transaction Management</a>
                        </li>
						<li>
                            <a href="success.php?cont=loan"><i class="fa fa-rub fa-fw"></i> Loan for Approval</a>
                        </li>
						<li>
                            <a href="success.php?cont=ReleasedLoan"><i class="fa fa-stack-exchange"></i> On Going Loans</a>
                        </li>
						<li>
                            <a href="success.php?cont=DeniedLoan"><i class="fa fa-stack-exchange"></i> Denied Loans</a>
                        </li>
						<li>
                            <a href="success.php?cont=CompletedLoan"><i class="fa fa-list fa-fw"></i> Paid Loans</a>
                        </li>
                        <li>
                            <a href="success.php?cont=loanList"><i class="fa fa-list fa-fw"></i> List of Loans</a>
                        </li>
						<li>
                            <a href="paymentForm.php"><i class=" fa fa-money"></i> Payments</a>
                        </li>
						<li>
                            <a href="success.php?cont=Billing"><i class="fa fa-list fa-fw"></i> Billing</a>
                        </li>
						
						
                    </ul>
                </div>
            </div>
			
			
			<?php
			}
			
			?>
			
			<?php if($_SESSION['Position'] == "Treasurer") {?>
			
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
					
                        <li>
                            <a href="successT.php?cont=search"><i class="fa fa-search fa-fw"></i> Transaction Management</a>
                        </li>
						<li>
                            <a href="successT.php?cont=loan"><i class="fa fa-rub fa-fw"></i> Loan for Release</a>
                        </li>
						<li>
                            <a href="successT.php?cont=ReleasedLoan"><i class="fa fa-stack-exchange"></i> On Going Loans</a>
                        </li>
						 <li>
                            <a href="successT.php?cont=loanList"><i class="fa fa-rub fa-fw"></i> List of Loans for Approval</a>
                        </li>
						<li>
                            <a href="successT.php?cont=DeniedLoan"><i class="fa fa-stack-exchange"></i> Denied Loans</a>
                        </li>
						<li>
                            <a href="paymentForm.php"><i class=" fa fa-money"></i> Payments</a>
                        </li>
						<li>
                            <a href="successT.php?cont=Billing"><i class="fa fa-list fa-fw"></i> Billing</a>
                        </li>
						
						
                    </ul>
                </div>
            </div>
			
			
			<?php
			}
			?>
        </nav>
		<!-- end, Navigation -->

        <!-- Page Content -->
		
		
        <div id="page-wrapper">  <!-- ito ang CENTER -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
					
                        <h1 class="page-header"><?php echo $pageHeader; ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				<form class="form-horizontal" role="form" method="get" name="payment"  action="paymentForm.php">
							<?php if($x == 0){?>
								<div class="form-group">
									<p><label for="memberID" class="col-sm-2 control-label">Member ID</label></p>
									<div class="col-sm-10">
										<select name = "memberID" class="col-sm-5" id="exampleList">
											<?php foreach($dataSet as $dataset
											){
												$memID = $dataset->getMemberId();
												$dataCount = $command->getdata("Select * from loan where mrNo = $memID and status = 'On Going'");
												$countData = count($dataCount);
												$fname = $dataset->getFname();
												$lname = $dataset->getLname();
												$space = " ";?>
											
											<?php if($countData != 0){ ?>
											<option value="<?php echo $dataset->getMemberId();?>"><?php echo $fname; echo $space; echo $lname;?></option>
											<?php  }
											}											?>
											
										</select>
									</div>
								</div>
							<?php }?>
							
							<?php if($x > 0 && $x < 3){?>
								<div class="form-group">
									<label for="memberID" class="col-sm-2 control-label">Member ID</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" name="memberName" placeholder="<?php 
										$fname = $data->getFname();
										$lname = $data->getLname();
										$space = " ";
										echo $fname.$space.$lname;?>" value=""  disabled>
										<input type="hidden" class="form-control" name="memberID" value="<?php echo $data->getMemberId();?>" >
									</div>
								</div>
							<?php }?>
<!-- Submit -->					
								<?php 
								if (isset($_REQUEST['payment'])) 
									{
                                        
									if ($_REQUEST['payment']=='Submit') 
										{
                                         	if($count != 0){ ?>
									<div class="form-group">
										<p><label for="ApplicationNo" class="col-sm-2 control-label">Application No.</label></p>
										<div class="col-sm-10">
											<select name = "applicationNo" class="col-sm-5" id="exampleList">
												<?php foreach($dataLoan as $dataloan){?>
												<option value="<?php echo $dataloan->getApplicationNo();?>"><?php echo $dataloan->getApplicationNo();?></option>
												<?php  } ?>
										</select>
										</div>
									</div>
												<?php }
											else
											{?>
											<div class="form-group">
												<div class="col-sm-8">
												<p class='text-danger col-sm-7 control-label'>No Existing On Going Loan for <?php echo $fname; echo $space; echo $lname;?></p>
												</div>
											</div>
												<?php $x = -1;}}}?>
	
<!-- View Payments -->	
	
								<?php 
								if (isset($_REQUEST['payment'])) 
									{
									if ($_REQUEST['payment']=='View Payments') 
										{
                                            
										?>
										
									<?php if($x > 1){?>
								<div class="form-group">
									<label for="ApplicationNo" class="col-sm-2 control-label">Application No</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" name="applicationNo" placeholder="<?php 
										echo $Loan->getApplicationNo();?>" value="" disabled>
										<input type="hidden" class="form-control" name="applicationNo" value="<?php echo $Loan->getApplicationNo();?>" >
									</div>
								</div>
								<?php }?>
								
								
										<table border="0" style="width:100%">
										  <tr>
											<td><b><p>Date</p></b></td>
											<td><b><p>Payment ID</p></b></td>
											<td><b><p>Principal Amount</p></b></td> 
											<td><b><p>Loan Interest</p></b></td>
											<td><b><p>Total Amount</p></b></td> 
											<td><b><p>Status</p></b></td>
										  </tr>
										<?php 
										for ($y=0;$y<$countLoanP;$y++)
										{
											if(($dataLoanP[$y]->getStatus() == "Pending") || ($dataLoanP[$y]->getStatus() == "Overdue") || ($dataLoanP[$y]->getStatus() == "Can be Paid Advance") ){
											?>
										<tr>
											<td><p><?php $date = new DateTime($dataLoanP[$y]->getpaymentDate());echo $date->format('M-d-Y');?></p></td>
											<td><p><?php echo $dataLoanP[$y]->getpaymentNo();?></p></td>
											<td><p><?php echo $AmountArray[$y]/$TermArray[$y];?></p></td> 
											<td><p><?php echo $InterestArray[$y];?></p></td>
											<td><p id="loanp-<?php echo $dataLoanP[$y]->getpaymentNo();?>"><?php if($dataLoanP[$y]->getStatus() == "Paid Advance" || $dataLoanP[$y]->getStatus() == "Can be Paid Advance")
													{
														echo $AmountArray[$y]/$TermArray[$y];
													}
													else if($dataLoanP[$y]->getStatus() == "Overdue")
													{
													  echo $AmountArray[$y]/$TermArray[$y] + $dataLoanPInterest[$y];
													}
													
													else
													{
													  echo $AmountArray[$y]/$TermArray[$y] + $AmountArray[$y] * 0.02 * $TermArray[$y]/$TermArray[$y];
													}
													?></p></td>
											
													
											<td><p><?php echo $dataLoanP[$y]->getStatus();?></p></td>

										  </tr>
										  
										  <tr>
											<td>
										  </tr>
										 <?php
										}}
										?>
										</table>
										<br>
										<div class="form-group">
											<p><label for="PaymentNo" class="col-sm-2 control-label">Payment ID</label></p>
											<div class="col-sm-10">
												<select name = "paymentNo" class="col-sm-3" id="paymentNoList">
													<?php foreach($dataPayment as $datapayment
													){?>
													<option value="<?php echo $datapayment->getpaymentNo();?>"><?php echo $datapayment->getpaymentNo(); ?></option>
													<?php  } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="paymentAmount" class="col-sm-2 control-label">Loan Amount</label>
											<div class="col-sm-3">
												<input id="paymentAmount" name = "paymentAmount" type="text" class="form-control" placeholder="Enter Amount" value="" readonly>
												<p class='text-danger'></p>
											</div>
										</div>

								
								
								
								<?php
										}
									}
								?>

								<?php if($x == 0){?>
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-1">
										<input id="payment" name="payment" type="submit" value="Submit" class="btn btn-primary">
									</div>
								</div>
								<?php } ?>
								
								<?php if($x == 1){?>
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-1">
										<input id="payment" name="payment" type="submit" value="View Payments" class="btn btn-primary">
									</div>
								</div>
								<?php } ?>
								
								<?php if($x == 2){
									if($countdataPayment != 0){?>
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-1">
										<input id="payment" name="payment" type="submit" value="Submit Payment" class="btn btn-primary">
									</div>
								</div>
									<?php }
								} ?>
								
								<?php if($x == -1 || $x == 1 || $x == 2){?>
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-1">
										<input id="payment" name="payment" type="submit" value="Back" class="btn btn-primary">
									</div>
								</div>	
								<?php } ?>	
				</form>
				
				<!-- Submit Payment -->		
							
							<?php if (isset($_REQUEST['payment']))
									{
										if ($_REQUEST['payment']=='Submit Payment') 
										{ ?>
										<h4>Receipt No. <?php echo $ReceiptNo;?></h4>
										<br>
										Date: <?php echo $dateNow;?>
										<br>
										<br>
										Received from <b><?php 
										$fname = $dataMember->getFname();
										$lname = $dataMember->getLname();
										$space = " ";
										echo $fname.$space.$lname;?></b>
										with the Address at <?php echo $dataMember->getMemberAdd();?><br>
										the sum of <b><?php echo $ReceiptAmount;?></b> In Partial Payment for Loan
										# <?php echo $AppNo;?> with the Principal Amount of 
										
										<?php for($y=0;$y<$countLoanP;$y++)
										{
											$payNo = $dataLoanP[$y]->getpaymentNo();
											$penalty = $dataLoanP[$y]->getpenalty();
											if($paymentNo == $payNo)
											{
												echo $PrincipalAmount = $AmountArray[$y]/$TermArray[$y];echo " ";
												
												?> with an <br>Interest of <?php echo $InterestArray[$y];echo " ";
												echo $orString;?><br><br><h4>Received By: <?php echo $receivedBy;?></h4>
											<?php } ?>
											
										
										
										
										 <?php 
										
								
										}?>
										 <br> <br>
										<a id="Back" href="paymentForm.php?memberID=<?php echo $_GET['memberID'];?>&applicationNo=<?php echo $AppNo;?>&payment=View+Payments" type="submit" class="btn btn-primary col-sm-offset-0">Back</a>
								   <?php  } ?>
								  
								<?php }?>
				
            <!-- /.container-fluid -->
        </div>
		
		<!--adadwadawd-->
        <!-- /#page-wrapper -->

    </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
        
        jQuery(document).ready(function($) {
            $('#paymentNoList').change(function() {
                paymentNumber = $(this).val();
                amount = $('#loanp-'+paymentNumber).html();           
                $('#paymentAmount').val(amount);     
            });
            $('#paymentNoList').change();
        });
        
        
        
	function validateForm()
    {
    var a=document.forms["addloan"]["LoanAmount"].value;

    if (a==null)
      {
      alert("Please Fill All Required Field");
      return false;
      }
    }
	
	function confirmSubmit(PayID) 
	{
		answer = confirm('Are you sure to Submit Payment?');
		if (answer) {
			var x = prompt("Please Indicate The Reason for Denial");
			if(x)
				{
				location.href = "successB.php?conti=removeLoan&AppNo="+AppNo+"&Reason="+x;
				}
				
		} else {
			return;
		}
	}
    </script>
	
	
	
    </script>
	

</body>

</html>