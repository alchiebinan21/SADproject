<?php
include_once('commands.php');
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Manila');

$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$space = " ";
$name = $firstname.$space.$lastname;

$pageHeader = "Reports";

if(isset($_REQUEST['submit'])){
	if($_REQUEST['submit']=='LoanReport') 
	{
			$command = new Command();
			$allPaid = $command->AllPaidLoans();

			$pageHeader = "Paid Loans Report";
	}
	
	if($_REQUEST['submit']=='DeniedLoanReport') 
	{
			$command = new Command();
			$allDenied = $command->AllDeniedLoans();

			$pageHeader = "Denied Loan Report";
	}
	
	if($_REQUEST['submit']=='PaymentsReport') 
	{
			$command = new Command();
			$allPayments = $command->AllPayments();
			
			$pageHeader = "Payments Report";
	}
	
	if($_REQUEST['submit']=='CapitalSharesReport') 
	{
			$command = new Command();
			$allShares = $command->AllShares();
			$pageHeader = "Capital Shares Report";
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
		width:450px;
		background-color:#f8f8f8;
		border-color: #e7e7e7;
		border: 1px solid transparent;
		border-radius: 0;
		border-width: 1 1 1px;
	}
	@media print{
		.btn{display:none}
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
                            <a href="success.php?cont=loanList"><i class="fa fa-list fa-fw"></i> List of Loans for Approval</a>
                        </li>
			             <li>
                            <a href="paymentForm.php"><i class=" fa fa-money"></i> Payments</a>
                        </li>
						<li>
                            <a href="success.php?cont=Billing"><i class="fa fa-list fa-fw"></i> Billing</a>
                        </li>
						<li>
                            <a href="Report.php"><i class="fa fa-list-alt fa-fw"></i> Reports</a>
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
                            <a href="successT.php?cont=CompletedLoan"><i class="fa fa-list fa-fw"></i> Paid Loans</a>
                        </li>
			             <li>
                            <a href="paymentForm.php"><i class=" fa fa-money"></i> Payments</a>
                        </li>
						<li>
                            <a href="successT.php?cont=Billing"><i class="fa fa-list fa-fw"></i> Billing</a>
                        </li>
						<li>
                            <a href="Report.php"><i class="fa fa-list-alt fa-fw"></i> Reports</a>
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
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-lg-12">
					
                        <h1 class="page-header"><?php echo $pageHeader; ?></h1>
						<div class="col-lg-13">
							<div class="form-group">
								<a id="Home" align="left" href="Report.php?submit=LoanReport" type="submit" class="btn btn-primary col-sm-offset-0">Paid Loan Report</a>
								<a id="Home" align="left" href="Report.php?submit=DeniedLoanReport" type="submit" class="btn btn-primary col-sm-offset-0">Denied Loan Report</a>
								<a id="Home" align="left" href="Report.php?submit=PaymentsReport" type="submit" class="btn btn-primary col-sm-offset-0">Payments Report</a>
								<a id="Home" align="left" href="Report.php?submit=CapitalSharesReport" type="submit" class="btn btn-primary col-sm-offset-0">Capital Shares Report</a>
							</div>
						</div>
					<?php if(isset($_REQUEST['submit']))
						{	
					  if($_REQUEST['submit']=='LoanReport') 
							{ ?>
						<table class="table table-striped table-bordered table-hover"border="0" style="width:100%">
						
								<tr>
									<td>Application No.</td>
									<td>Name</td>
									<td>Certified By</td>
									<td>Loan Amount</td>
									<td>Date Completely Paid</td>
								</tr>
								
								<?php foreach($allPaid as $AllPaid){ ?>
								<tr>
									<?php $mrNo = $AllPaid->getMemberId();
										  $member = $command->getMember($mrNo);
										  $AppNo = $AllPaid->getApplicationNo();
										  $fname = $member->getFname();
										  $lname = $member->getLname();
										  $name = $fname.$space.$lname;
									
									
									?>
									
									<td><?php echo $AllPaid->getApplicationNo();?></td>
									<td><?php echo $name;?></td>
									<td><?php echo $AllPaid->getCertifiedBy();?></td>
									<td><?php echo $AllPaid->getloanAmount();?></td>
									<td><?php echo $AllPaid->getpaidDate();?></td>
								</tr>
							<?php }}
							}?>
	
						<?php if(isset($_REQUEST['submit']))
						{	
					  if($_REQUEST['submit']=='DeniedLoanReport') 
							{ ?>
						<table class="table table-striped table-bordered table-hover"border="0" style="width:100%">
						
								<tr>
									<td>Application No.</td>
									<td>Name</td>
									<td>Denied By</td>
									<td>Loan Amount</td>
									<td>Reason</td>
								</tr>
								
								<?php foreach($allDenied as $AllDenied){ ?>
								<tr>
									<?php $mrNo = $AllDenied->getMemberId();
										  $member = $command->getMember($mrNo);
										  $AppNo = $AllDenied->getApplicationNo();
										  $fname = $member->getFname();
										  $lname = $member->getLname();
										  $name = $fname.$space.$lname;
									
									
									?>
									
									<td><?php echo $AllDenied->getApplicationNo();?></td>
									<td><?php echo $name;?></td>
									<td><?php echo $AllDenied->getdeniedBy();?></td>
									<td><?php echo $AllDenied->getloanAmount();?></td>
									<td><?php echo $AllDenied->getReason();?></td>
								</tr>
							<?php }}
							}?>
						</table>
						
						<?php if(isset($_REQUEST['submit']))
						{	
					  if($_REQUEST['submit']=='PaymentsReport') 
							{ ?>
						<table class="table table-striped table-bordered table-hover"border="0" style="width:100%">
						
								<tr>
									<td>Receipt No.</td>
									<td>Application No.</td>
									<td>Name</td>
									<td>Date Paid</td>
									<td>Paid Amount</td>
									<td>Received By</td>
								</tr>
								
								<?php foreach($allPayments as $AllPayments){ ?>
								<tr>
									<?php $paymentNo = $AllPayments->getPaymentNo();
										  $paymentDate = $AllPayments->getDatePaid();
										  $paymentAmount = $AllPayments->getAmount();
										  $paymentReceived = $AllPayments->getReceivedBy();
										  $payment = $command->getPayment($paymentNo);
										  $AppNo = $payment->getApplicationNo();
										  $Loan = $command->getLoan($AppNo);
										  $member = $Loan->getMemberId();
										  
										  $memberName = $command->getMember($member);
										  
										  $fname = $memberName->getFname();
										  $lname = $memberName->getLname();
										  $name = $fname.$space.$lname;
									
									
									?>
									
									<td><?php echo $paymentNo;?></td>
									<td><?php echo $AppNo;?></td>
									<td><?php echo $name;?></td>
									<td><?php echo $paymentDate;?></td>
									<td><?php echo $paymentAmount;?></td>
									<td><?php echo $paymentReceived;?></td>
								</tr>
							<?php }}
							}?>
						</table>
						
						<?php if(isset($_REQUEST['submit']))
						{	
					  if($_REQUEST['submit']=='CapitalSharesReport') 
							{ ?>
						<table class="table table-striped table-bordered table-hover"border="0" style="width:100%">
						
								<tr>
									<td>Transaction No.</td>
									<td>Transaction Date</td>
									<td>Name</td>
									<td>Amount</td>
									<td>Number of Shares</td>
								</tr>
								
								<?php foreach($allShares as $AllShares){ ?>
								<tr>
									<?php $AllShares->getTransactionId();
										  $mrNo = $AllShares->getUserNo();
										  
										  $member = $command->getMember($mrNo);
										  $fname = $member->getFname();
										  $lname = $member->getLname();
										  $name = $fname.$space.$lname;
									
									
									?>
									
									<td><?php echo $AllShares->getTransactionId();?></td>
									<td><?php echo $AllShares->getTransactionDate();?></td>
									<td><?php echo $name;?></td>
									<td><?php echo $AllShares->getAmountDeposit();?></td>
									<td><?php echo $AllShares->getShares();?></td>
								</tr>
							<?php }}
							}?>
						</table>
						
                    </div>
					
                    <!-- /.col-lg-12 -->
                </div>

				
				
				<?php if($_SESSION['Position'] == "Manager")
				{?>
				<input class="btn btn-primary" type="button" value="Print" onclick="window.print()" target="_blank" style="cursor:pointer">
				<a id="Home" align="left" href="Report.php" type="submit" class="btn btn-primary col-sm-offset-0">Back</a>
				<?php }?>
				
				
				
				
				
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
	function validateForm()
    {
    var a=document.forms["addloan"]["LoanAmount"].value;

    if (a==null)
      {
      alert("Please Fill All Required Field");
      return false;
      }
    }
	
    </script>
	

</body>

</html>