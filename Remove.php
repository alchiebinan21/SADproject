<?php
include_once('commands.php');
session_start();

$errAmount = '';
$errShares = '';
$date = date('M-d-Y');
		$userId = $_GET['user_id'];
		$pageHeader = "Share Info";
		$command = new Command();
		$getmember = $command->getMember($userId);
		
		
		$dataCapital = $command->viewcapital("Select SUM(Amount * numOfShares) as 'Total Capital' from transaction where mrNo = $userId");
		
		
		$dataShares = $command->viewshares("Select * from transaction where mrNo = $userId");
				
		
		
		
		$_SESSION['successCheck'] = false;
		
		
		if (isset($_REQUEST['submit'])) 
			{
				if ($_REQUEST['submit']=='Withdraw') 
				{
					$_SESSION['successCheck'] = true;
					$pageHeader = "Member Withdrawn";
					$userId = $_GET['user_id'];
					$member = $command->getMember($userId);
					$fname = $member->getFname();
					$lname = $member->getLname();
					$bday = $member->getBirthDate();
					$add = $member->getMemberAdd();
					$status = $member->getMemberCivilStatus();
					$occ = $member->getMemberOccupation();
					$bplace = $member->getMemberBplace();
					$income = $member->getMemberIncome();
					$oincome = $member->getMemberOIncome();
					$contact = $member->getMemberContact();
					$edback = $member->getMemberEducationalBack();
					$sss = $member->getMemberSSS();
					$phealth = $member->getMemberPhealth();
					$pe	= $member->getPresentEmployer();
					$relative = $member->getMemberRelative();
					$dateadd = $member->getDateAdded();	
					$firstname = $_SESSION['fname'];
					$lastname = $_SESSION['lname'];
					$space = " ";
					$name = $firstname.$space.$lastname;
					
					$command->AddWithReceipt($userId,$dataCapital[0],$name);
					$command->DeleteAdd($fname,$lname,$bplace,$add,$status,$occ,$bday,$income,$oincome,$pe,$contact,$edback,$relative,$sss,$phealth,$name,$dateadd,$userId);
					$command->deleteData($userId);

					$withdraw = $command->getWithdraw($userId);
					$getmember = $command->getMember($userId);
				}
			}
			
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<style>
	.fade {
  opacity: 0;
  -webkit-transition: opacity 0.15s linear;
  -moz-transition: opacity 0.15s linear;
  -o-transition: opacity 0.15s linear;
  transition: opacity 0.15s linear;
	}
	.fade.in {
	  opacity: 1;
	}
	
	@media print 
	{
		.btn{
			display:none;
			}
		#print
		{
			display:none;
		}
		#Home
		{
			display:none;
		}
	}

		
	 </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Withdrawal Receipt</title>
	


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
	<script type="text/javascript">
	
	
    window.setTimeout(function() {
  $("#myAlert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove();
  });
}, 1500);

</script>
<script>
  $(document).ready(function() {
    $('#datepicker').datepicker({
		minDate: 0,						
      });
  });
  
  
  </script>
</head>

<body onload="myFunction()">
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
					<div>
							<?php if($_SESSION['successCheck'] == false){?>
							<h2>Member ID: <?php echo $userId;?></h2>
							
							<h2> <?php echo $getmember->getFname(); echo " "; echo $getmember->getLname();?>'s current capital:  ₱ <?php if($dataCapital){
																	$x = 0; 
																	foreach($dataCapital as $datacapital){
																		if($x == 0){echo $datacapital; $x+=1;}
																		else {
																			break;
																		}
																		}}?></h2>
							
					</div>
								<br>
								<br>
								
												
												
								<div class="row">
								<div class ="col-md-12">
									
									
									<?php if($dataShares) { ?>
											<table class = "table table striped table-bordered table-hover">
													<tr>
														<th>Transaction ID</th>
														<th>Date</th>
														<th>Amount</th>
														<th>Shares</th>
														<th>Equivalent Capital</th>
													<tr>
											<?php foreach($dataShares as $datashares) { ?>
													<tr>
														<td><?php echo $datashares->getTransactionId();?></td>
														<td><?php echo$datashares->getTransactionDate();?></td>
														<td><?php echo$datashares->getAmountDeposit();?></td>
														<td><?php echo$datashares->getShares();?></td>
														<td><?php echo$datashares->getCapital();?> </td>
													<tr>
												
												<?php
											}
											?>
											</table>
											<?php 
											
											}
											?>
			
									
								<div class ="col-md-0">
								
								<div class="form-group">
									<div class="input-group">
										
									</div>
								</div>
								</div>
								</div>
								</div>
								<div class="form-group">
									<div class="col-l-10 col-sm-offset-0">
										<input name="user_id" type="hidden" value="<?php echo $userId;?>" >
									</div>
								</div>
					
									<div class ="col-md-2">
										<div class="form-group">
									
											<div class="input-group">
												<a class="btn btn-danger btn-m" onclick="confirmDeleteLoan(<?php echo $userId;?>)">Withdraw</a>
											</div>
										</div>
									</div>
									
							<?php }?>
							
					
				
				<?php if (isset($_REQUEST['submit'])) {
					if($_REQUEST['submit']=='Withdraw'){?>
					<div class ="col-md-12">
						<div class="form-group">
									Withdraw Receipt No. <?php echo $withdraw->getWithdrawNo(); ?><br>
									Paid to: <?php echo $fname; echo " "; echo $lname;?><br> 
									Date Issued: <?php echo $dateNow = date('M-d-Y');?><br><br>
									
									RECEIVED from the Ascension of the Lord Parish Credit Cooperative the amount of <b><?php echo $dataCapital[0]?></b> Representing <br>
									the total Amount of the Capital Shares. <br> <br> <br>
									
									PAID BY: <?php echo $name;?><br>
									
									<?php if($dataShares) { ?>
									<br>
											<table class = "table table striped table-bordered table-hover">
													<tr>
														<th>Transaction ID</th>
														<th>Date</th>
														<th>Amount</th>
														<th>Shares</th>
														<th>Equivalent Capital</th>
													<tr>
											<?php foreach($dataShares as $datashares) { ?>
													<tr>
														<td><?php echo $datashares->getTransactionId();?></td>
														<td><?php echo$datashares->getTransactionDate();?></td>
														<td><?php echo$datashares->getAmountDeposit();?></td>
														<td><?php echo$datashares->getShares();?></td>
														<td><?php echo$datashares->getCapital();?> </td>
													<tr>
												
												<?php
											}
											?>
											</table>
											<?php 
											
											}
											?>
											
									
						</div>
				<input id="print" class="print btn btn-primary" type="button" value="Print" onclick="window.print()" target="_blank" style="cursor:pointer">	
				
					<?php }
					}?>			
				<?php if($_SESSION['Position'] == "Manager")
				{?>
				<a id="Home" align="left" href="success.php?cont=search" type="submit" class="btn btn-primary col-sm-offset-0">Back</a>
				<?php }?>
				<?php if($_SESSION['Position'] == "Treasurer")
				{?>
				<a id="Home" align="left" href="successT.php?cont=search"type="submit" class="btn btn-primary col-sm-offset-0">Back</a>
				<?php }?>
				
					
				</div>
				
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
	
	<script type="text/javascript">
    var button = document.getElementById('submit')
    button.addEventListener('click',hideshow,false);
	
    function hideshow() {
        document.getElementById('submit').style.display = 'block'; 
        this.style.display = 'none'
    }   
	
	function confirmDeleteLoan(userid) {
		answer = confirm('Are you sure to Delete loan # ' + userid);
		if (answer) {
			location.href = "Remove.php?user_id="+userid+"&submit=Withdraw";
		} else {
			return;
		}
	}
	
</script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	
	

</body>

</html>