<?php
include_once('commands.php');
session_start();

date_default_timezone_set('Asia/Manila');
			
$AppNo = $_GET['AppNo'];	
$pageHeader = "Loan Voucher";	
$command = new Command();
$dataLoan = $command->getLoan($AppNo);
$dataPayment = $command->getLoanP("Select * from loanp where ApplicationNo = $AppNo");

$getPayment = $command->getLoanP("Select * from loanp where ApplicatioNo = $AppNo and ");

$MemberId = $dataLoan->getMemberId();
$Amount = $dataLoan->getloanAmount();
$term = $dataLoan->getloanTerm();
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

$CBU = $Amount * 0.03;
$interest = $Amount * 0.02 * $term;
$interestPerMonth = $interest / $term;



$data = $command->getMember($MemberId);
$firstname = $data->getFname();
$lastname = $data->getLname();




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
				
				Paid to: <?php echo $firstname; echo " "; echo $lastname;?> <br>
				Date issued: <?php $date = new DateTime($dataLoan->getloanPaymentStart());echo $date->format('M-d-Y');?><br>
			
				<br>
				LOAN APPROVED - <?php echo number_format($Amount,2);?>
				<br>
				<br>
				Less Deductions:<br>
				Loan Interest - <?php echo number_format($interest,2);?> 
				<br>
				Service Fee - 200.00<br>
				CBU - <?php echo number_format($CBU,2);?><br>
				Saving Dep - <?php echo number_format($CBU,2);?><br>
				Total - <?php echo number_format($total = $CBU+$CBU+$interest+200,2);?><br>
				<br>
				NETLOAN PROCEEDS - <?php echo number_format($Amount-$total,2);?> <br>
				<br>
				RECEIVED from the Ascension of the Lord Parish Credit Cooperative the amount of <?php echo number_format($Amount-$total,2);?> pesos Representing the net proceeds of my loan.
				<br><br>
				PAID BY: <?php echo $dataLoan->getReleasedBy();?> <br>
				<br>
				<table border="1" style="width:100%">
				  <tr>
					<td align = "center">Date</td>
					<td align = "center">Principal Amount</td> 
					<td align = "center">Loan Interest</td>
					<td align = "center">Total Amount</td> 
				  </tr>

				<?php if($dataPayment) {
				foreach($dataPayment as $datapayment){?>
				<tr>
					<td align = "center"><?php $date = new DateTime($datapayment->getpaymentDate());echo $date->format('M-d-Y');?></td>
					<td align = "center"><?php echo number_format($Amount/$term,2);?></td> 
					<td align = "center"><?php echo number_format($interestPerMonth,2);?></td>
					<td align = "center"> <?php echo number_format($interestPerMonth+($Amount/$term),2);?></td>
				  </tr>
				  
				  
				 <?php
				}
				}?>
				</table>
				  <br><br><br>
				<?php if($_SESSION['Position'] == "Manager") {?>
				<input class="btn btn-primary" type="button" value="Print" onclick="window.print()" target="_blank" style="cursor:pointer">
				<a id="Home" href="success.php?contl=viewloan&ApplicationNo=<?php echo $AppNo;?>" type="submit" class="btn btn-primary col-sm-offset-1">Back</a>
				<?php }?>
				<?php if($_SESSION['Position'] == "Treasurer") {?>
				<input class="btn btn-primary" type="button" value="Print" onclick="window.print()" target="_blank" style="cursor:pointer">
				<a id="Home" href="successT.php?contl=viewloan&ApplicationNo=<?php echo $AppNo;?>" type="submit" class="btn btn-primary col-sm-offset-1">Back</a>
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