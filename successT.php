<?php
include_once('commands.php');
session_start();

$temp;

$_SESSION['check'] = false;

date_default_timezone_set('Asia/Manila');

$current_date = date('Y-m-d');

$pageHeader = "Welcome !";

if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='add') {
		$pageHeader = "Add Member";
	}
}


if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='search') {
		$_SESSION['back'] = 'cont=search';
		$pageHeader = "Search Member";
		$command = new Command();
		$dataSet = $command->viewdata("Select * from member");
	}
}

if(isset($_REQUEST['conti'])) {
	if($_REQUEST['conti']=='remove') {
		$_SESSION['check'] = false;
		$userId = $_GET['user_id'];
		$command = new Command();
		$command->deleteData($userId);
		$pageHeader = "Member Removed";
		$_SESSION['check'] = true;
	}
}

if(isset($_REQUEST['conti'])) {
	if($_REQUEST['conti']=='removeLoan') {
		$_SESSION['check'] = false;
		$AppNo = $_GET['AppNo'];
		$Reason = $_GET['Reason'];
		$command = new Command();
		$command->denyLoan($AppNo,$Reason);
		
		$pageHeader = "Loan Denied";
		$_SESSION['check'] = true;
	}
}

if(isset($_REQUEST['conti'])) {
	if($_REQUEST['conti']=='release') {
		$_SESSION['check'] = false;
		
		$AppNo = $_GET['AppNo'];
		$command = new Command();
		$Loan = $command->getLoan($AppNo);   
		$oAmount = $Loan->getloanAmount();
		$memberid = $Loan->getMemberId();
		$_SESSION['back'] = 'cont=loan';
		
		
		$fname = $_SESSION['fname'];
		$lname = $_SESSION['lname'];
		$space = " ";
		$user = $fname.$space.$lname;
		
		
		$command->ReleasedBy($AppNo,$user);
		$term = $Loan->getloanTerm();
		
		$amountM = $oAmount/$term;
		$interest = ($oAmount *.02)/$term;     
		
		$amountToBePaid = $amountM + $interest;
		$date = date("Y-m-d");
		
		$plus = 1;
		$command->ReleaseLoan($AppNo);
		$command->changeStatus($AppNo);
		$command->dateReleased($AppNo,$date);
		for($x=0;$x<$term;$x++)
			{
				$tempdate = date("Y-m-d",strtotime("+$plus month"));

				$command->createPayment($AppNo,$tempdate);
				$plus = $plus+1;

			}

		$pageHeader = "Loan Approved";
		$_SESSION['check'] = true;
	}

}

	
if(isset($_REQUEST['contu'])){
	if($_REQUEST['contu']=='view')
	{
		$userId = $_GET['user_id'];
		$pageHeader = "View Member ID # $userId";

		
	}
}

if(isset($_REQUEST['contl'])){
	if($_REQUEST['contl']=='viewloan'){
	

		$AppNo = $_GET['ApplicationNo'];
		
		$command = new Command();
		$Loan = $command->getLoan($AppNo);
		$memberid = $Loan->getMemberId();
		
		$member = $command->getMember($memberid);
		
		$fname = $member->getFname();
		$lname = $member->getLname();
		$space = " ";
		$name = $fname.$space.$lname;
	
	
	
	
	
		$pageHeader = "View Loan Information";
	}
}
if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='DeniedLoan') {
		$_SESSION['back'] = 'cont=DeniedLoan';
		$pageHeader = "Denied Loans";
		$command = new Command();
		$dataLoan = $command->getdata("Select * from loan where approval = -1");
		$dataSet = $command->viewdata("Select * from member");
	}
}
/*-----------------------------------------------------------------------------------KANI CHI--------------------------------------------------------*/
if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='loan') {
		$_SESSION['back'] = 'cont=loan';
		$pageHeader = "Manage Loan";
		
		$command = new Command();
		$dataLoan = $command->getdata("Select * from loan where approval = 3");
		$dataSet = $command->viewdata("Select * from member");
	}
}
/*-----------------------------------------------------------------------------------HANTUD DRI--------------------------------------------------------*/

if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='ReleasedLoan') {
		$_SESSION['back'] = 'cont=ReleasedLoan';
		$pageHeader = "On Going Loans";
		$command = new Command();
		$dataLoan = $command->getdata("Select * from loan where approval = 4 and status = 'On Going'");
		$dataSet = $command->viewdata("Select * from member");
	}
}

if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='CompletedLoan') {
		$_SESSION['back'] = 'cont=CompletedLoan';
		$pageHeader = "Completed Loans";
		$command = new Command();
		$dataLoan = $command->getdata("Select * from loan where approval = 4 and status = 'Paid'");
		$dataSet = $command->viewdata("Select * from member");
	}
}


if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='loanList') {
		$_SESSION['back'] = 'cont=loanList';
		$pageHeader = "Manage Loan";
		$command = new Command();
		$dataLoan = $command->getdata("Select * from loan where approval > -1");
		//$dataLoan = $command->getdata("Select * from loan where approval < 3 and status = 'For Approval'");
		$dataSet = $command->viewdata("Select * from member");
	}
}

if(isset($_REQUEST['cont'])) {
		if($_REQUEST['cont']=='Billing' || $_REQUEST['cont']=='BillingW' || $_REQUEST['cont']=='BillingM' || $_REQUEST['cont']=='BillingO') {
		$pageHeader = "Billing";
		$command = new Command();
		$dataPayment = $command->getLoanP("Select * from loanp where (status = 'Pending' or status = 'Overdue' or status = 'Can be Paid Advance') order by paymentDate asc");
		$countdata = count($dataPayment);
		
		for($x=0;$x<$countdata;$x++)
			{
				$loanpID = $dataPayment[$x]->getpaymentNo();
				$dateToPay = $dataPayment[$x]->getpaymentDate();
				
				$datetime3 = strtotime(date('Y-m-d'));
				$datetime2 = strtotime(date('Y-m-d',strtotime($dateToPay)));
				$status = $dataPayment[$x]->getStatus();
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
				
				
				else if($days > 30)
				{
					if($status == 'Pending' || $status == 'Overdue' || $status == 'Can be Paid Advance')
					{
					$command->updateStatusPending($loanpID);
                    $status = 'Pending';
					}
				}
				
				else if($days >= 0 && $days <= 30 )
				{
					if($status == 'Can be Paid Advance' || $status == 'Overdue')
					{
					
					$command->updateStatusPending($loanpID);
                    $status = 'Pending';
					}
				}
				
			
			}
		$dataPayment = $command->getLoanP("Select * from loanp where (status = 'Pending' or status = 'Overdue' or status = 'Can be Paid Advance') order by paymentDate asc");
		
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
	#reason::-webkit-input-placeholder { color: red; }
	#reason::-moz-placeholder { color: red; }
	#reason::-moz-placeholder { color: red; }
	#reason::-ms-input-placeholder { color: red; }
	
	td{
		text-align:center; 
	}
	
	th{
		text-align:center; 
	}
	</style>
<script>
  $(document).ready(function() {
    $('#datepicker').datepicker({
		minDate: 0,						
      });
  });
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
                <a class="navbar-brand" href="successT.php">Treasurer</a>
            </div>
            <!-- /end, navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
							<li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
						
						
						
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
					
							<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// KANI CHI ////////////////////////////////////////////////////////////////////////////////// -->
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
                            <a href="successT.php?cont=CompletedLoan"><i class="fa fa-list fa-fw"></i> Paid Loans</a>
                        </li>
						<li>
                            <a href="paymentForm.php"><i class=" fa fa-money"></i> Payments</a>
                        </li>
						<li>
                            <a href="successT.php?cont=Billing"><i class="fa fa-list fa-fw"></i> Billing</a>
                        </li>
						
						<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
						
                    </ul>
                </div>
            </div>
        </nav>
		<!-- end, Navigation -->

        <!-- Page Content -->
        <div id="page-wrapper">  <!-- ito ang CENTER -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
					
                        <h1 class="page-header"><?php echo $pageHeader; ?></h1>
						
						<?php if($_SESSION['check'] == true) 
						{ ?>
							<div class="form-group">
							<br>
								<div class="col-sm-10 col-sm-offset-0">
								<a id="Home" href="successT.php" type="submit" class="btn btn-primary"> Home</a>
								</div>
								
							</div>
							<br>
							<br>
							<div class="form-group">
								<div class="col-sm-10 col-sm-offset-0">
									<a id="Home" href="successT.php?<?php echo $_SESSION['back'];?>" type="submit" class="btn btn-primary"> Back</a>
								</div>
							</div>
							<br><br>

						<?php 
						}
						?>
						
						<?php if(isset($_REQUEST['conti'])) 
						{
							if($_REQUEST['conti']=='release') 
							{ ?>
							
							<div class="col-sm-10 col-sm-offset-0">
								<a class="btn btn-primary btn" href="Release.php?AppNo=<?php echo $AppNo;?>">Proceed to Loan Voucher</a>
							</div>						  
							<?php 
							}
						}?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				
					
					
					
<!-- Update ////////////////////////////////////////////////////////////////////////////////////////////////-->  
					<?php
				if(isset($_REQUEST['contu']))
				{
						$id = intval($_REQUEST['user_id']);
						$command = new Command();
						$data = $command->getMember($id);
						
						if($_REQUEST['contu']=='view')
						{


								?>
								<form>
								<div class="form-inline">
								
								  <div class="form-group">
									<label for="exampleInputName2">First Name</label>
									<input type="text" class="form-control" id="fName" name="fName" placeholder="<?php echo $data->getFname();?>"></td>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Last Name</label>
									<input type="text" class="form-control" id="lname" placeholder="<?php echo $data->getLname();?>"></td>
								  </div>
								  <br>
								  <br>
								  
								  
								  <div class="form-group">
									<label for="exampleInputName2">Birth Date</label>
									<input type="text" class="form-control" id="bdate" placeholder="<?php print_r($data->getBirthDate());?>"></td>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Address</label>
									<input type="text" class="form-control" id="add" placeholder="<?php print_r($data->getMemberAdd());?>"></td>
								  </div>
								   <br>
								  <br>
								  
								  
								  <div class="form-group">
									<label for="exampleInputName2">Occupation</label>
									<input type="text" class="form-control" id="occ" placeholder="<?php print_r($data->getMemberOccupation());?>"></td>
								  </div>
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Civil Status</label>
									<input type="text" class="form-control" id="civil" placeholder="<?php print_r($data->getMemberCivilStatus());?>">
								  </div>
		
								<br>
								<br>
								
								  <div class="form-group">
									<label for="exampleInputName2">Birth Place</label>
									<input type="text" class="form-control" id="bplace" placeholder="<?php print_r($data->getMemberBplace());?>">
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Income</label>
									<input type="email" class="form-control" id="income" placeholder="<?php print_r($data->getMemberIncome());?>">
								  </div>
								<br>
								<br>

								  <div class="form-group">
									<label for="exampleInputName2">Other Income</label>
									<input type="text" class="form-control" id="oincome" placeholder="<?php print_r($data->getMemberOIncome());?>">
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Contact #</label>
									<input type="text" class="form-control" id="contact" placeholder="<?php print_r($data->getMemberContact());?>">
								  </div>
								<br>
								<br>

								  <form class="form-inline">
								  <div class="form-group">
									<label for="exampleInputEmail2">SSS #</label>
									<input type="text" class="form-control" id="sss" placeholder="<?php print_r($data->getMemberSSS());?>">
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Relative</label>
									<input type="text" class="form-control" id="relative" placeholder="<?php print_r($data->getMemberRelative());?>">
								  </div>
								  </form>
								<br>
								<br>								
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Phil Health #</label>
									<input type="text" class="form-control" id="phealth" placeholder="<?php print_r($data->getMemberPhealth());?>">
								  </div>
								<br> 
								<br>
								
								  <div class="form-group">
									<label for="exampleInputName2">Educational Background</label>
									<input type="text" class="form-control" id="edback" placeholder="<?php print_r($data->getMemberEducationalBack());?>">
								  </div>
								<br>
								<br>
								
								<td style="width: 10%;">
									<a class="btn btn-primary btn" href="" onclick="confirmUpdate(<?php echo $data->getMemberId(); $_SESSION['userid']?>);">Update</a>
									<br><br>
								</td>								  
								  </div>
								</form>
								<br>
								
								  
								
								
								
								
								


								
								

							<?php	
						}
				}
				
					?>
	<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// KANI CHI ////////////////////////////////////////////////////////////////////////////////// -->				
	<!-- View Loan ////////////////////////////////////////////////////////////////////////////////////////////////--> 				
						<?php
				if(isset($_REQUEST['contl']))
				{
						$appNo = intval($_REQUEST['ApplicationNo']);
						$command = new Command();
						$dataloan = $command->getLoan($appNo);
						if($_REQUEST['contl']=='viewloan')
						{
						

								?>
						<div class="container-fluid">
						
						<div class ="row">
						<form role="form">
						<div class ="col-md-4">
						
								<?php $certify = $dataloan->getCertifiedBy();
								  if($certify != null){ ?>
								  <div class="form-group">			
									<label for="exampleInputEmail2">Certified By</label>
									<textarea type="text" class="form-control" id="reason" placeholder="<?php print_r($dataloan->getCertifiedBy());?>"></textarea>
								  </div>
								  <?php
								   }
								   ?>

						
								  <div class="form-group">
									<label for="exampleInputName2">Application No.</label>
										<div class="input-group">
											<input type="text" class="form-control" id="fName" name="fName" placeholder="<?php echo $dataloan->getApplicationNo();?>"> </td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Member ID</label>
										<div class = "input-group">
											<input type="text" class="form-control" id="lname" placeholder="<?php echo $name?>"></td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputName2">Loan Amount</label>
									<div class="input-group">
									<input type="text" class="form-control" id="bdate" placeholder="<?php print_r($dataloan->getloanAmount());?>"></td>
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Loan Date Applied</label>
									<div class="input-group">
									<input type="text" class="form-control" id="add" placeholder="<?php print_r($dataloan->getloanDate());?>"></td>
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputName2">Loan Type</label>
									<div class="input-group">
									<input type="text" class="form-control" id="occ" placeholder="<?php print_r($dataloan->getloanType());?>"></td>
									<span class="input-group-addon"></span>
									</div>
								  </div>
						
								  <div class="form-group">
									<label for="exampleInputEmail2">Mode Type</label>
									<div class="input-group">
									<input type="text" class="form-control" id="civil" placeholder="<?php print_r($dataloan->getmodeType());?>">
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  
								  <?php $reason = $dataloan->getReason();
								  if($reason != null){ ?>
								  <div class="form-group">			
									<label for="exampleInputEmail2">Reason for Denial</label>
									<textarea type="text" class="form-control" id="reason" placeholder="<?php print_r($dataloan->getReason());?>"></textarea>
								  </div>
								  <?php
								   }
								   ?>
								   
								   
								   
								   <?php $releasedBy = $dataloan->getReleasedby();
								   if($releasedBy != null) {?>
								   <a class="btn btn-primary btn" href="Release.php?AppNo=<?php echo $appNo;?>">View Loan Voucher</a>
								   <br>
								   <br>
								   <a class="btn btn-primary btn" href="statement.php?AppNo=<?php echo $appNo;?>">View Statement of Account</a>
								   <?php }?>

								   
								   
								   
						</div>
								  <div class ="col-md-4">
								  <?php $certifyDate = $dataloan->getpaidDate();
								  if($certifyDate != null){ ?>
								  <div class="form-group">			
									<label for="exampleInputEmail2">Date Paid</label>
									<textarea type="text" class="form-control" id="reason" placeholder="<?php print_r($dataloan->getpaidDate());?>"></textarea>
								  </div>
								  <?php
								   }
								   ?>
								  <div class="form-group">
									<label for="exampleInputName2">Loan Term</label>
									<div class="input-group">
									<input type="text" class="form-control" id="bplace" placeholder="<?php print_r($dataloan->getloanTerm());?>">
									<span class="input-group-addon"></span>
									</div>
								  </div>
								
								  <div class="form-group">
									<label for="exampleInputName2">Loan Repayment</label>
									<div class="input-group">
									<input type="text" class="form-control" id="oincome" placeholder="<?php print_r($dataloan->getloanRepayment());?>">
									<span class="input-group-addon"></span>
									</div>
								  </div>

								  <?php $paymentstart = $dataloan->getloanPaymentStart();
								  if($paymentstart != null){ ?>
								  <div class="form-group">			
									<label for="exampleInputEmail2">Loan Released</label>
									<textarea type="text" class="form-control" id="reason" placeholder="<?php print_r($dataloan->getloanPaymentStart());?>"></textarea>
								  </div>
								  <?php
								   }
								   ?>
								   
							</div>
							
						</form>
						
						</div>
						<br>
						<a id="Home" href="successT.php?<?php echo $_SESSION['back'];?>" type="submit" class="btn btn-primary col-sm-offset-0">Back</a>
								<br>
								<br>
								<br>
								<br>
					</div>

								
							<?php	
						}
				}
				
					?>
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->		
					
				
<!-- Search User ////////////////////////////////////////////////////////////////////////////////////////////////-->  
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='search') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
								<div class="row">
									<form action="success.php" method="get">
										<div class="col-lg-11">
											<div class="panel panel-default">
												<div class="panel-heading">
													
												</div>
												<!-- /.panel-heading -->
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover" id="dataTables-example">
															<thead>
																<tr>
																	<th>Transaction</th>
																	<th>First Name</th>
																	<th>Last Name</th>
																	<th>Manage Member</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataSet) {
																	foreach($dataSet as $data) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $data->getMemberId();?>"></td>-->
																			<td style="width: 15%;">
																				<?php $count = $command->getCountOnGoingLoans($data->getMemberId());?>
																				<a class="btn btn-info btn-xs" "href="" onclick="confirmAddloan(<?php echo $data->getMemberId()?>,<?php echo $count;?>);">Add Loan</a>
																				<a class="btn btn-success btn-xs" "href="" onclick="goToShare(<?php echo $data->getMemberId();?>);">Shares</a>
				
																			</td>
																			<td style="width: 15%"><?php echo $data->getFname(); ?></td>
																			<td style="width: 15%"><?php echo $data->getLname(); ?></td>
																			<td style="width: 15%">
																			<a class="btn btn-primary btn-xs" "href="" onclick="confirmEdit(<?php echo $data->getMemberId();?>);">View</a>

																			</td>
																		</tr><?php 
																	}
																}?>
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>
					
				
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='loan') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
								<div class="row">
									<form action="success.php" method="get">
										<div class="col-lg-11">
											<div class="panel panel-default">
												<div class="panel-heading">
													
												</div>
												<!-- /.panel-heading -->
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover" id="dataTables-example">
															<thead>
																<tr>
																	<th>ID</th>
																	<th>Application No.</th>
																	<th>Member ID</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataLoan) {
																	foreach($dataLoan as $dataloan) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $dataloan->getApplicationNo();?>"></td>-->
																			<td style="width: 15%">
																				<a class="btn btn-primary btn-xs" "href="" onclick="confirmEditLoan(<?php echo $dataloan->getApplicationNo();?>);">View</a>
																			
																				<a class="btn btn-warning btn-xs" "href="" onclick="confirmDeleteLoan(<?php echo $dataloan->getApplicationNo();?>);">Deny</a>
																				
																				<a class="btn btn-success btn-xs" "href="" onclick="ReleaseLoan(<?php echo $dataloan->getApplicationNo();?>);">Release</a>
																				
																			</td>
																			<td style="width: 15%;"><?php echo $dataloan->getApplicationNo(); ?></td>
																			<td style="width: 15%;"><?php    $app = $dataloan->getApplicationNo();
																											$membid = $dataloan->getMemberId();
																											$command = new Command();
																											$datajoin = $command->joindata($app);
																											echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																		</tr><?php 
																	}
																}?>
																<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>
					
							
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='loanList') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
								<div class="row">
									<form action="success.php" method="get">
										<div>
											<div class="panel panel-default">
												<div class="panel-heading">
													
												</div>
												<!-- /.panel-heading -->
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover" id="dataTables-example">
															<thead>
																<tr>
																	<th>View</th>
																	<th>Manager</th>
																	<th>Credit Commitee</th>
																	<th>Chairman</th>
																	<th>Treasurer</th>
																	<th>Application No.</th>
																	<th>Member ID</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataLoan) {
																	foreach($dataLoan as $dataloan) {?>
																		<tr style="width:10%">
																			
																			
																			<td style="width:10%">
																				<a class="btn btn-primary btn-xs" "href="" onclick="confirmEditLoan(<?php echo $dataloan->getApplicationNo();?>);">View</a>
																			</td>
																			<td style="width:10%">
																				<?php if($dataloan->getApproval() > 0)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td style="width:15%" >
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width:15%">
																				<?php if($dataloan->getApproval() > 1)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td style="width:10%">
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width:10%">
																				<?php if($dataloan->getApproval() > 2)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td style="width:10%">
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width:10%">
																				<?php if($dataloan->getApproval() == 4)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td style="width:10%">
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width:15%"><?php echo $dataloan->getApplicationNo(); ?></td>
																			<td style="width:15%"><?php   $app = $dataloan->getApplicationNo();
																											$command = new Command();
																											$datajoin = $command->joindata($app);
																											echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																			
																		</tr><?php 
																	}
																}?>
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>			

					<!-- Released Loan ////////////////////////////////////////////////////////////////////////////////////////////////--> 					
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='ReleasedLoan') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
								<div class="row">
									<form action="success.php" method="get">
										<div class="col-lg-8">
											<div class="panel panel-default">
												<div class="panel-heading">
													
												</div>
												<!-- /.panel-heading -->
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover" id="dataTables-example">
															<thead>
																<tr>
																	<th>ID</th>
																	<th>Application No.</th>
																	<th>Member ID</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataLoan) {
																	foreach($dataLoan as $dataloan) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $dataloan->getMemberId();?>"></td>-->
																			<td style="width: 5%;">
																				<a class="btn btn-primary btn-xs" "href="" onclick="confirmEditLoan(<?php echo $dataloan->getApplicationNo();?>);">View</a>
																			
																				
																				
																				<a class="btn btn-success btn-xs" "href="" onclick="viewPayment(<?php echo $dataloan->getApplicationNo();?>);">Payment</a>
																			</td>
																			<td style="width: 10%;"><?php echo $dataloan->getApplicationNo(); ?></td>
																			<td style="width: 10%;"><?php   $app = $dataloan->getApplicationNo();
																											$command = new Command();
																											$datajoin = $command->joindata($app);
																											echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																		</tr><?php 
																	}
																}?>
																<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>
					
					<!-- Completed Loan ////////////////////////////////////////////////////////////////////////////////////////////////--> 					
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='CompletedLoan') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
								<div class="row">
									<form action="success.php" method="get">
										<div class="col-lg-8">
											<div class="panel panel-default">
												<div class="panel-heading">
													
												</div>
												<!-- /.panel-heading -->
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover" id="dataTables-example">
															<thead>
																<tr>
																	<th>ID</th>
																	<th>Application No.</th>
																	<th>Member ID</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataLoan) {
																	foreach($dataLoan as $dataloan) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $dataloan->getMemberId();?>"></td>-->
																			<td style="width: 5%;">
																				<a class="btn btn-primary btn-xs" "href="" onclick="confirmEditLoan(<?php echo $dataloan->getApplicationNo();?>);">View</a>
																			
																				
																			</td>
																			<td style="width: 10%;"><?php echo $dataloan->getApplicationNo(); ?></td>
																			<td style="width: 10%;"><?php   $app = $dataloan->getApplicationNo();
																											$command = new Command();
																											$datajoin = $command->joindata($app);
																											echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																		</tr><?php 
																	}
																}?>
																<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>
					
					<!-- Billing ////////////////////////////////////////////////////////////////////////////////////////////////--> 					
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']== 'Billing' || $_REQUEST['cont']=='BillingW' || $_REQUEST['cont']=='BillingM' || $_REQUEST['cont']=='BillingO') {
					?>
						
								<div class="row">
									<form action="success.php" method="get">
										<div class="col-lg-12">
										<div class= "form-group">
										<a class="btn btn-primary btn-xs" href="successT.php?cont=BillingW">View Weekly</a>
										
										<a class="btn btn-primary btn-xs" href="successT.php?cont=BillingM">View Monthly</a>
										
										<a class="btn btn-primary btn-xs" href="successT.php?cont=BillingO">View Overdue</a>
										
										<a class="btn btn-primary btn-xs" href="successT.php?cont=Billing">View All</a>
										</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													
												</div>
												<!-- /.panel-heading -->
												
												
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover" id="dataTables-example">
															<thead>
																<tr>
																	<th>Due Date</th>
																	<th>Member ID</th>
																	<th>Payment ID</th>
																	<th>Application No.</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
															
															
																<?php if($dataPayment) {
																	foreach($dataPayment as $datapayment) 
																	{
																		$loanpID = $datapayment->getpaymentNo();
																		$dateToPay = $datapayment->getpaymentDate();
																		
																		$datetime3 = strtotime(date('Y-m-d'));
																		$datetime2 = strtotime(date('Y-m-d',strtotime($dateToPay)));
																		$status = $datapayment->getStatus();
																		$secs = $datetime2 - $datetime3;
																		$days = floor($secs / (24 * 60 * 60 ));
																		?>
																		
																		<?php if($_REQUEST['cont']=='Billing') 
																		{
																				?>				
																			
																			<tr class="odd gradeX">
																				
																				<td style="width: 10%;"><?php echo $datapayment->getpaymentDate();
																											  $appNo = $datapayment->getApplicationNo();?></td>	
																				<td style="width: 10%;"><?php 
																												$command = new Command();
																												$datajoin = $command->joindata($appNo);
																												echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																				<td style="width: 10%;"><?php echo $datapayment->getpaymentNo(); ?></td>
																				<td style="width: 10%;"><?php echo $appNo;?></td>
																				
																												
																												
																				
																				<td style="width: 10%;"><?php echo $datapayment->getStatus();?></td>	
																				<td align = "center" style="width: 10%;"><a class="btn btn-danger btn-xs col-lg-4 col-sm-offset-4" href="billing.php?AppNo=<?php echo $datapayment->getApplicationNo();?>">Bill</a></td>	
																			</tr><?php 
																		} ?>
																		
																		<?php if($_REQUEST['cont']=='BillingW') 
																		{
																			if($days <= 7)
																			{
																				?>				
																			
																			<tr class="odd gradeX">
																				
																				<td style="width: 15%;"><?php echo $datapayment->getpaymentDate();
																											  $appNo = $datapayment->getApplicationNo();?></td>	
																				<td style="width: 10%;"><?php 
																												$command = new Command();
																												$datajoin = $command->joindata($appNo);
																												echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																				<td style="width: 10%;"><?php echo $datapayment->getpaymentNo(); ?></td>
																				<td style="width: 15%;"><?php echo $appNo;?></td>
																												
																												
																				
																				<td style="width: 15%;"><?php echo $datapayment->getStatus();?></td>	
																				<td align = "center" style="width: 10%;"><a class="btn btn-danger btn-xs col-lg-4 col-sm-offset-4" href="billing.php?AppNo=<?php echo $datapayment->getApplicationNo();?>">Bill</a></td>
																			</tr><?php 
																			}
																		}
																		?>
																		<?php if($_REQUEST['cont']=='BillingM')
																		{
																			if($days <= 31)
																			{
																				?>				
																			
																			<tr class="odd gradeX">
																				
																				<td style="width: 15%;"><?php echo $datapayment->getpaymentDate();
																											  $appNo = $datapayment->getApplicationNo();?></td>	
																				<td style="width: 10%;"><?php 
																												$command = new Command();
																												$datajoin = $command->joindata($appNo);
																												echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																				<td style="width: 10%;"><?php echo $datapayment->getpaymentNo(); ?></td>
																				<td style="width: 15%;"><?php echo $appNo;?></td>
																												
																												
																				
																				<td style="width: 15%;"><?php echo $datapayment->getStatus();?></td>
																				<td align = "center" style="width: 10%;"><a class="btn btn-danger btn-xs col-lg-4 col-sm-offset-4" href="billing.php?AppNo=<?php echo $datapayment->getApplicationNo();?>">Bill</a></td>
																			</tr><?php 
																			}
																		}
																		?>
																		
																		<?php if($_REQUEST['cont']=='BillingO')
																		{
																			if($days < 0)
																			{
																				?>				
																			
																			<tr class="odd gradeX">
																				
																				<td style="width: 15%;"><?php echo $datapayment->getpaymentDate();
																											  $appNo = $datapayment->getApplicationNo();?></td>	
																				<td style="width: 10%;"><?php 
																												$command = new Command();
																												$datajoin = $command->joindata($appNo);
																												echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																				<td style="width: 10%;"><?php echo $datapayment->getpaymentNo(); ?></td>
																				<td style="width: 15%;"><?php echo $appNo;?></td>
																												
																												
																				
																				<td style="width: 15%;"><?php echo $datapayment->getStatus();?></td>
																				<td align = "center" style="width: 10%;"><a class="btn btn-danger btn-xs col-lg-4 col-sm-offset-4" href="billing.php?AppNo=<?php echo $datapayment->getApplicationNo();?>">Bill</a></td>
																			</tr><?php 
																			}
																		}
																	}
																}
						}
					}
																?>
					

					
					<!-- Denied Loan ////////////////////////////////////////////////////////////////////////////////////////////////--> 					
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='DeniedLoan') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
								<div class="row">
									<form action="success.php" method="get">
										<div class="col-lg-8">
											<div class="panel panel-default">
												<div class="panel-heading">
													
												</div>
												<!-- /.panel-heading -->
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover" id="dataTables-example">
															<thead>
																<tr>
																	<th>ID</th>
																	<th>Application No.</th>
																	<th>Member Name</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataLoan) {
																	foreach($dataLoan as $dataloan) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $dataloan->getMemberId();?>"></td>-->
																			<td style="width: 1%;">
																				<a class="btn btn-primary btn-xs" "href="" onclick="confirmEditLoan(<?php echo $dataloan->getApplicationNo();?>);">View</a>

																			</td>
																			<td style="width: 10%;"><?php echo $dataloan->getApplicationNo(); ?></td>
																			<td style="width: 10%;"><?php   $app = $dataloan->getApplicationNo();
																											$command = new Command();
																											$datajoin = $command->joindata($app);
																											echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																		</tr><?php 
																	}
																}?>
																<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>
					
					
            </div>
            <!-- /.container-fluid -->
        </div>
		<!--adadwadawd-->
        <!-- /#page-wrapper -->

    </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function($) {
        $('#dataTables-example').dataTable();
    });
	
	
	function confirmDelete(userId) {
		answer = confirm('Are you sure to Remove this member ' + userId);
		if (answer) {
			location.href = "success.php?conti=remove&user_id="+userId;
		} else {
			return;
		}
	}
	
	function confirmDeleteLoan(AppNo) {
		answer = confirm('Are you sure to Deny loan # ' + AppNo);
		if (answer) {
			var x = prompt("Please Indicate The Reason for Denial");
			if(x)
				{
				location.href = "successT.php?conti=removeLoan&AppNo="+AppNo+"&Reason="+x;
				}
				
		} else {
			return;
		}
	}
	
	function ReleaseLoan(AppNo) {
		answer = confirm('Are you sure to Release loan # ' + AppNo);
		if (answer) {
			location.href = "successT.php?conti=release&AppNo="+AppNo;
		} else {
			return;
		}
	}
	
	function confirmEdit(userId) {
			location.href = "update.php?user_id="+userId;
		}
	
	<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// KANI CHI ////////////////////////////////////////////////////////////////////////////////// -->

	function confirmEditLoan(AppNo) {
			location.href = "successT.php?contl=viewloan&ApplicationNo="+AppNo;
		}
	<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
	
	function confirmUpdate(userId) {
		answer = confirm('Are you sure to Update Information on member ' + userId);
		if (answer) {
			location.href = "update.php?user_id="+userId;
		} else {
			return;
		}
	}
	
	function goToShare(userId) {
			location.href = "deposit.php?user_id="+userId;
	}
	
	
	function confirmAddloan(userId,count) {
		answer = confirm('Are you sure to Add Loan on member ' + userId);
		if (answer) {
			if(count == 0)
			{
				location.href = "addloan.php?user_id="+userId;
			}
			else{
				alert('The member has an existing on going loan');
			}
		} else {
			return;
		}
	}
	
	function viewVoucher(AppNo) {
		
			location.href = "Release.php?AppNo="+AppNo;
		} 
	
	function viewPayment(AppNo) {
		
			location.href = "paymentUI.php?AppNo="+AppNo;
		} 
		
	
    </script>

</body>

</html>