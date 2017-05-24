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
		
		
		if(isset($_REQUEST['view'])){
		if($_REQUEST['view']=='View Transactions') {
		$dataShares = $command->viewshares("Select * from transaction where mrNo = $userId");
		}
		}
		
							
				if(isset($_REQUEST['share'])) {
						if ($_REQUEST['share']=='Add Share') 
				{
					
					 $DepositAmount = $_REQUEST['DepositAmount'];
					 
					 $transactionDate = $_REQUEST['transactionDate'];
					 $numShares = $_REQUEST['Shares'];
					
					 $total = $DepositAmount * $numShares;
					
					
					if(!empty($DepositAmount)&& !empty($numShares) && $total >= 1200) {
					$command = new Command();
					$command->AddTransaction($userId,$DepositAmount,$numShares);
					
					
			echo $result = '<div id="myAlert" class="alert alert-success fade in" data-alert="alert">Share Added!</div>';
					}
					else
					{
						echo $result = '<div id="myAlert" class="alert alert-danger fade in" data-alert="alert">Minumum Capital Not Met!</div>';
					}
		
	
		
				}
				
				
			}
$dataCapital = $command->viewcapital("Select SUM(Amount * numOfShares) as 'Total Capital' from transaction where mrNo = $userId");

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
	 </style>

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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
					
                        <h1 class="page-header"><?php echo $pageHeader; ?></h1>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
					<div>
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
				<form class="form-horizontal" role="form" method="get" name="deposit" action="deposit.php">
								
								
								<div class="row">
								<div class ="col-md-12">
								<div class ="col-md-2">
								<div class="form-group">
									<div class="input-group">
										<input id="transaction" name="submit" type="submit" value="Add Transaction" class="btn btn-primary">
									</div>
								</div>
								</div>
								<div class ="col-md-2">
								
								<div class="form-group">
									<div class="input-group">
										<input id="view" name="view" type="submit" value="View Transactions" class="btn btn-primary">
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
								
				</form>
					
				
									<?php if (isset($_REQUEST['submit'])) 
									{
										if ($_REQUEST['submit']=='Add Transaction') 
										{ 
									?>
										
								<form class="form-horizontal" role="form" method="get" name="deposit" action="deposit.php" onSubmit="validateForm()">
				
								<div class="form-group">
									<label for="transactionDate" class="col-sm-2 control-label">Transaction Date</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="date" name="transactionDate" placeholder="<?php echo $date; ?>" value="<?php echo $date; ?>" readonly>
										<p class='text-danger'></p>
									</div>
								</div>
				
								<div class="form-group">
									<label for="amount" class="col-sm-2 control-label">Amount</label>
									<div class="col-sm-10">
										<input type="number" class="form-control" id="DepositAmount" name="DepositAmount" placeholder="Enter Amount" value="" required="required">
										<p class='text-danger'><?php echo $errAmount;?></p>
									</div>
								</div>
								
								<div class="form-group">
									<label for="nshares" class="col-sm-2 control-label">No. of Shares</label>
									<div class="col-sm-10">
										<input type="number" class="form-control" id ="Shares" name="Shares" placeholder="Enter Shares" value="" required="required">
										<p class='text-danger'><?php echo $errShares;?></p>
									</div>
								</div>
								
								
															
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<input id="share" name="share" type="submit" value="Add Share" class="btn btn-primary">
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<input id="addloan" name="user_id" type="hidden" value="<?php echo $userId;?>" class="btn btn-primary">
									</div>
								</div>

	
							</form>
									
								  <?php }
		}?>
		
		<?php if (isset($_REQUEST['view'])) 
									{
										if ($_REQUEST['view']=='View Transactions') 
										{ 
										if($dataShares) { ?>
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
			
										}

									}
									?>
									
									<?php if($_SESSION['Position'] == "Manager")
				{?>
				<a id="Home" align="left" href="success.php?cont=search" type="submit" class="btn btn-primary col-sm-offset-0">Back</a>
				<?php }?>
				<?php if($_SESSION['Position'] == "Treasurer")
				{?>
				<a id="Home" align="left" href="successT.php?cont=search"type="submit" class="btn btn-primary col-sm-offset-0">Back</a>
				<?php }?>
									
			
		
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
</script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	
	

</body>

</html>