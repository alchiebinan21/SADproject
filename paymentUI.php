<?php
include_once('commands.php');
session_start();

			
			$AppNo = $_GET['AppNo'];
			
			date_default_timezone_set('Asia/Manila');
            
			
			$command = new Command();
			$Loan = $command->getLoan($AppNo);
			$status = $Loan->getStatus();
			$dataloanp = $command->getLoanP("select * from loanp where ApplicationNo = $AppNo");
			$userId = $Loan->getMemberId();
			$member = $command->getMember($userId);
			
			$fname = $member->getfName();
			$lname = $member->getLname();
			$space = " ";
			
			$name = $fname.$space.$lname;
			$pageHeader = "$name - Loan # $AppNo - $status";
			$amount= $Loan->getloanAmount();
			$term = $Loan->getloanTerm();
		
			$principalAmount = $amount / $term;
			$interest = $amount * 0.02 * $term;
			$interestPerMonth = $interest/$term;
			$totalAmount = $principalAmount + $interestPerMonth;
			
			$InterestArray = array();
			
			$AmountArray = array();
			$TermArray = array();
			$TempAmounts = $amount;
			$TempTotalAmount = 0;
			$TempTotalAdvance = 0;
			$TempTotalInterest = 0;
			$x = 0;
			$TempTerm = $term;
			
			$dataPayment = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo");
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
				
				
				else if($days > 31)
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
			
			
			$TempTotalInterest += $Interest + $overdueInterest;
			$InterestArray[$x] = $Interest + $overdueInterest;
		}
		if($status == "Paid Advance")
		{
				$AmountArray[$x] = $TempAmounts;
				$TermArray[$x] = $TempTerm;
				$InterestArray[$x] = 0;
				$TempAmounts-=($TempAmounts/$TempTerm);
				$TempTerm-=1;
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
        $countPayment = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo and (status = 'Overdue' or status = 'Pending' or status = 'Can be Paid Advance')");
        
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
	
<script>
  $(document).ready(function() {
    $('#datepicker').datepicker({
		minDate: 0,						
      });
  });
  </script>
  
<style>
	<style>

</style>
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
																	<th>Payment ID</th>
																	<th>Payment Date</th>
																	<th>Amount to be Paid</th>
																	<th>Status</th>
                                                                    <?php $countToPay = count($countPayment);
                                                                    if($countToPay > 0){?>
																	<th style="width: 5%;"></th>
																	<?php }?>
																</tr>
															</thead>
															<tbody>
																<?php for ($x=0;$x<$countdata;$x++)
																	{

																	?>
																		
																		<tr class="odd gradeX">
																			
																			
						
																			<td style="width: 10%;"><?php echo $dataPayment[$x]->getpaymentNo();?></td>
																			
																			<td style="width: 20%;"><?php echo $dataPayment[$x]->getpaymentDate();?></td>
																			<td style="width: 10%;"><?php echo $dataLoanAmount[$x]/$dataLoanTerm[$x]+$dataLoanPInterest[$x]?></td>
																			
																			<?php $status = $dataPayment[$x]->getStatus();
																			if($status == 'Overdue'){ ?>
																			<td style="width: 10%;"><font color="red"><?php echo $dataPayment[$x]->getStatus();?></font></td>
																			<?php }elseif($status == 'Paid' || $status == 'Paid Advance'){?>
																			<td style="width: 10%;"><font color="green"><?php echo $dataPayment[$x]->getStatus();?></font></td>
																			<?php }else{?>
																			<td style="width: 10%;"><?php echo $dataPayment[$x]->getStatus();?></td>
																			<?php }
                                                                            ?>
                                                                            
                                                                           
                                                                            <?php $status = $dataPayment[$x]->getStatus();
                                                                            $AppliNo = $dataPayment[$x]->getApplicationNo();
                                                                            $LoanPay = $command->getLoan($AppliNo);
                                                                            $memID = $LoanPay->getMemberId();?>

																			
                                                                            <?php if($status != 'Paid' && $status != 'Paid Advance' && $status != 'Paid Overdue')
                                                                            {?>
																			<td align = "center" style="width: 5%;"><a  class="btn btn-primary btn-xs" href="paymentForm.php?memberID=<?php echo $memID;?>&applicationNo=<?php echo $AppliNo;?>&payment=View+Payments">Pay</a>
																			</td>
																	  <?php }
                                                                    }
																
																
																?>
															</tbody>
														</table>
													</div>
													<?php if($_SESSION['Position'] == "Manager"){ ?>
													<a id="Home" align="left" href="success.php?cont=ReleasedLoan" type="submit" class="btn btn-primary col-sm-offset-1">Back</a>
													<?php } ?>
													<?php if($_SESSION['Position'] == "Treasurer"){ ?>
													<a id="Home" align="left" href="successT.php?cont=ReleasedLoan" type="submit" class="btn btn-primary col-sm-offset-1">Back</a>
													<?php } ?>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					
						
						
						
						
						
						
						
						
                    </div>
                    <!-- /.col-lg-12 -->
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