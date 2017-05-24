<?php
include_once('commands.php');
session_start();

date_default_timezone_set('Asia/Manila');
			
$AppNo = $_GET['AppNo'];	
$pageHeader = "Statement of Account";	
$command = new Command();
$dataLoan = $command->getLoan($AppNo);
$dataPayment = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo");



$MemberId = $dataLoan->getMemberId();
$Amount = $dataLoan->getloanAmount();
$term = $dataLoan->getloanTerm();


$monthlyAmount = $Amount/$term;

//$Aterm = $term-$count;
$Aterm = $term;
$CBU = $Amount * 0.03;




/*$tempAmount = 0;
for($x=0;$x<$count;$x++)
{
	$tempAmount+=$monthlyAmount;
}
*/
$interest = ($Amount) * 0.02 * $Aterm;
$interestPerMonth = $interest / $Aterm;
$tempPaid = 0;
$tempInterest = 0;
/*
for($x=0;$x<$paid;$x++)
{
	$tempPaid+=$monthlyAmount;
	$tempInterest+=$interestPerMonth;
}
*/
$totalPaid = $tempPaid + $tempInterest;

$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];



$data = $command->getMember($MemberId);
$firstname = $data->getFname();
$lastname = $data->getLname();


$InterestArray = array();
$countdata = count($dataPayment);
$AmountArray = array();
$TermArray = array();
$TempAmounts = $Amount;
$TempTotalAmount = 0;
$TempTotalAdvance = 0;
$TempTotalInterest = 0;
$x = 0;
$TempTerm = $term;



	for($x=0;$x<$countdata;$x++)
	{
		$status = $dataPayment[$x]->getStatus();
		$penalty = $dataPayment[$x]->getpenalty();
        
        $loanpID = $dataPayment[$x]->getpaymentNo();
				$dateToPay = $dataPayment[$x]->getpaymentDate();
				
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
				
				
				else if($days > 31)
				{
					if($status == 'Pending' || $status == 'Overdue' || $status == 'Can be Paid Advance')
					{
					$command->updateStatusPending($loanpID);
                    $status = 'Pending';
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
				
				$penalty = $dataPayment[$x]->getpenalty();
		
        
        
		if($status == "Paid" || $status == "Pending")
		{
			$AmountArray[$x] = $TempAmounts;
			$TermArray[$x] = $TempTerm;
			$InterestArray[$x] = $TempAmounts * 0.02 * $TempTerm / $TempTerm;

			
			if($status == "Paid")
			{
				$TempTotalAmount += ($TempAmounts/$TempTerm) + (($TempAmounts * 0.02 * $TempTerm) / $TempTerm);
			}
			$TempTotalInterest += ($TempAmounts * 0.02 * $TempTerm) / $TempTerm;
		}
			
		if($status == "Overdue")
		{
			$AmountArray[$x] = $TempAmounts;
			$TermArray[$x] = $TempTerm;
			
			$Interest = ($TempAmounts * (0.02) * $TempTerm) / $TempTerm;
			$perMonthPay = ($TempAmounts / $TempTerm);
			$overdueInterest = ($Interest+$perMonthPay) * $penalty;
			
			
			$TempTotalInterest += $Interest + $overdueInterest;
			$InterestArray[$x] = $Interest + $overdueInterest;
			
		}
		
		if($status == "Paid Overdue")
		{
			$AmountArray[$x] = $TempAmounts;
			$TermArray[$x] = $TempTerm;
			
			$Interest = ($TempAmounts * (0.02) * $TempTerm) / $TempTerm;
			$perMonthPay = ($TempAmounts / $TempTerm);
			$overdueInterest = ($Interest+$perMonthPay) * $penalty;
			
			$TempTotalAmount += ($TempAmounts/$TempTerm) + (($TempAmounts * 0.02 * $TempTerm) / $TempTerm) + $overdueInterest;
			
			$TempTotalInterest += $Interest + $overdueInterest;
			$InterestArray[$x] = $Interest + $overdueInterest;
			
		}
		if($status == "Paid Advance")
		{
				$AmountArray[$x] = $TempAmounts;
				$TermArray[$x] = $TempTerm;
				$InterestArray[$x] = 0;
				$TempAmounts-=($TempAmounts/$TempTerm);
				if($TempTerm != 1)
					{
					$TempTerm-=1;
					}
				
				$TempTotalAdvance += $TempAmounts/$TempTerm;
				
		}
		
		if($status == "Can be Paid Advance")
		{
			$AmountArray[$x] = $TempAmounts;
			$TermArray[$x] = $TempTerm;
			$InterestArray[$x] = $TempAmounts * 0.02 * $TempTerm / $TempTerm;

			
			if($status == "Paid")
			{
				$TempTotalAmount += ($TempAmounts/$TempTerm) + (($TempAmounts * 0.02 * $TempTerm) / $TempTerm);
			}
			$TempTotalInterest += ($TempAmounts * 0.02 * $TempTerm) / $TempTerm;
		}
	}
	
    $dataPayment = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo");
    $dataLoanPInterest = $InterestArray;
    $dataLoanAmount = $AmountArray;
    $dataLoanTerm = $TermArray;
    

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
	
	@media print {
		
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
                            <a href="successT.php?cont=CompletedLoan"><i class="fa fa-list fa-fw"></i> Paid Loans</a>
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
				
				Statement of Account for <?php echo $firstname; echo " "; echo $lastname;?> <br>
				Loan Application # <?php echo $AppNo;?>
				<table border="0" style="width:90%">
				<th class="box"><b>Account Summary as of <?php echo $date = date('M-d-Y');?></b><br></th>
				<tr>
					<td></td>
					<td style="width: 0%" align="left"><b><p>Amount</p><b></td>
					<td align="right"><b><p>Paid</p><b></td>
				<tr>
					<td><p>Loan Amount</p></td>
					<td align="left" style="width: 20%;"><p><?php echo number_format($Amount,2);?></p></td>
					<td></td>
				</tr>
				<tr>
					<td><p>Loan Interest</p></td><br>
					<td align="left" style="width: 20%;"><p><?php echo number_format($TempTotalInterest,2);?></p></td>
					<td></td>
				</tr>
				<tr>
					<td><p>Payments</p></td><br>
					<td></td>
					<td align="right"><p><?php echo number_format($TempTotalAmount,2);?></p></td>
				</tr>
				
				<tr>
					<td><p>Advanced Payments</p></td><br>
					<td></td>
					<td align="right"><p><?php echo number_format($TempTotalAdvance,2);?></p></td>
				</tr>
				<tr>
					<td><p>Total Balance</p></td><br>
					<td align="left"><p><?php echo number_format($Amount+$TempTotalInterest-$TempTotalAmount-$TempTotalAdvance,2);?></p></td>
					<td align="center"><p></p></td>
				</tr>
				</table>
				<br>
				<h3 class = "box">Detailed Summary</h3>
				<br>
				<table border="0" style="width:100%">
				  <tr>
					<td><b><p align="center">Date</p></b></td>
					<td><b><p align="right">Principal Amount</p></b></td> 
					<td><b><p align="right">Loan Interest</p></b></td>
					<td><b><p align="right">Total Amount</p></b></td> 
					<td><b><p align="center">Status</p></b></td>
				  </tr>
				<?php 
				for ($x=0;$x<$countdata;$x++)
				{
					
					?>
				<tr>
					<td><p align="center"><?php $date = new DateTime($dataPayment[$x]->getpaymentDate());echo $date->format('M-d-Y');?></p></td>
					<td><p align="right"><?php echo number_format($dataLoanAmount[$x]/$dataLoanTerm[$x],2);?></p></td> 
					<td><p align="right"><?php echo number_format($dataLoanPInterest[$x],2);?></p></td>
					<td><p align="right"><?php if($dataPayment[$x]->getStatus() == "Paid Advance")
							{
								echo number_format($dataLoanAmount[$x]/$dataLoanTerm[$x],2);
							}
							else if($dataPayment[$x]->getStatus() == "Overdue")
							{
							  echo number_format($dataLoanAmount[$x]/$dataLoanTerm[$x] + $dataLoanPInterest[$x],2);
							}
							
							else
							{
							  echo number_format($dataLoanAmount[$x]/$dataLoanTerm[$x] + $dataLoanAmount[$x] * 0.02 * $dataLoanTerm[$x]/$dataLoanTerm[$x],2);
							}
							?></p></td>
					
							
					<td><p align="center"><?php echo $dataPayment[$x]->getStatus();?></p></td>

				  </tr>
				  
				  <tr>
					<td>
				  </tr>
				 <?php
				}
				?>
				</table>
				  <br><br><br>
				<?php if($_SESSION['Position'] == "Manager")
				{?>
				<input class="btn btn-primary" type="button" value="Print" onclick="window.print()" target="_blank" style="cursor:pointer">
				<a id="Home" align="left" href="success.php?contl=viewloan&ApplicationNo=<?php echo $AppNo;?>" type="submit" class="btn btn-primary col-sm-offset-1">Back</a>
				<?php }?>
				<?php if($_SESSION['Position'] == "Treasurer")
				{?>
				<input class="btn btn-primary" type="button" value="Print" onclick="window.print()" target="_blank" style="cursor:pointer">
				<a id="Home" align="left" href="successT.php?contl=viewloan&ApplicationNo=<?php echo $AppNo;?>" type="submit" class="btn btn-primary col-sm-offset-1">Back</a>
				<?php }?>
				<br>
				<br>
				<br>
				<br>
				
				
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