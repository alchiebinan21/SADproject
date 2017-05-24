<?php
include_once('commands.php');
session_start();

			
			$userId = $_GET['user_id'];
			$command = new Command();
			$member = $command->getMember($userId);
			$dataSet = $command->viewdata("Select * from member");
			
			$fname = $member->getFname();
			$lname = $member->getLname();
			$space = " ";
			$name = $fname.$space.$lname;
			$pageHeader = "Add Loan to Member $name";
			$countPaid = $command->PaidLoans($userId);
			$countpaid = count($countPaid);
			$dataCapital = $command->viewcapital("Select SUM(Amount * numOfShares) as 'Total Capital' from transaction where mrNo = $userId");
			$errAmount = "";
			
			$_SESSION['successCheck'] = false;
			
			if (isset($_REQUEST['addloan'])) 
			{
				if ($_REQUEST['addloan']=='Add') 
				{
					
					//DECLARE VARIABLES FROM FIELDS
					
					//LOAN AMOUNT
					$loanAmount = $_REQUEST['LoanAmount'];
					
					//loan pay type checker
					

					
					if(isset($_REQUEST['paymentype']))
					{
						$loanPayType = $_REQUEST['paymentype'];
					}
					
					
					if(isset($_REQUEST['comaker']))
					{
						$comaker = $_REQUEST['comaker'];
					}
					
					
					
					
					//LOAN TYPE
					
					
					if(isset($_REQUEST['typeofloan']))
					{
						$loantype = $_REQUEST['typeofloan'];
					}

					
					//LOAN TERM
					$LoanTerm = $_REQUEST['LoanTerm'];
					

					

					//LOAN REPAYMENT
					
					if(isset($_REQUEST['loanrepayment']))
					{
						$loanrepayment = $_REQUEST['loanrepayment'];
					}

					$dataCapital = $command->viewcapital("Select SUM(Amount * numOfShares) as 'Total Capital' from transaction where mrNo = $userId");
					$data2 = $dataCapital[0]*2;
					$_SESSION['leveloan'] = false;
					
					if($loantype == 'Level Loan')
					{
						if($dataCapital[0] == null)
						{
							$errAmount = "Please Add Capital/Share before applying for loan";
							$_SESSION['leveloan'] = true;
						}
						else if($data2 < $loanAmount)
						{
							$errAmount = "Amount cannot be greater than $data2";
							$_SESSION['leveloan'] = true;
						}
						if($_SESSION['leveloan'] == false)
						{
							$_SESSION['successCheck'] = true;
					
							$command = new Command();
							
							$command->AddLoan($userId,$loanAmount,$loanPayType,$loantype,$LoanTerm,$loanrepayment,$comaker,0);
							

							$pageHeader = 'Loan Added';
						}
					}
					else if($loantype == 'Provincial')
					{
							$_SESSION['successCheck'] = true;
							$command = new Command();
							
							$command->AddLoan($userId,$loanAmount,$loanPayType,$loantype,$LoanTerm,$loanrepayment,$comaker,0);
							

							$pageHeader = 'Loan Added';
						}
					}
					else if($loantype == 'Productive Loan')
					{
							$_SESSION['successCheck'] = true;
							$command = new Command();
							
							$command->AddLoan($userId,$loanAmount,$loanPayType,$loantype,$LoanTerm,$loanrepayment,$comaker,0);
							

							$pageHeader = 'Loan Added';
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
				
				<?php if($_SESSION['successCheck'] == false){ 

				?>
				
				<form class="form-horizontal" role="form" method="get" name="addloan" action="addloan.php">
				
								<div class="form-group">
									<label for="first" class="col-sm-2 control-label">Loan Amount</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" required="required" id="LoanAmount" name="LoanAmount" placeholder="Enter Loan Amount" value="">
										<p class='text-danger'><?php echo $errAmount;?></p>
									</div>
								</div>
								
								<div class="form-group">
									<label for="civilstat" class="col-sm-2 control-label">Loan Term</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="LoanTerm" name="LoanTerm" placeholder="Enter Loan Term" value="">
										<p class='text-danger'></p>
									</div>
								</div>
								
								<div class="form-group">
											<p><label for="paymentype" class="col-sm-2 control-label">Payment Type</label></p>
											<div class="col-sm-4">
												<input name = "paymentype" class="col-sm-5 form-control" id="exampleList" value="Monthly" readonly>
											</div>
										</div>
								

										

							<?php if($countpaid == 0)
							{ ?>
								<div class="form-group">
											<p><label for="typeofloan" class="col-sm-2 control-label">Type of Loan</label></p>
											<div class="col-sm-4">
												<input name = "typeofloan" class="col-sm-5 form-control" id="exampleList" value="Level Loan" readonly>
											</div>
										</div>
								<br>
							<?php } else {?>
								<div class="form-group">
										<p><label for="typeofloan" class="col-sm-2 control-label">Type of Loan</label></p>
										<div class="col-sm-4">
											<select class = "form-control" name = "typeofloan" class="col-sm-5" id="exampleList">
												<option value="Provincial">Provincial</option>
												<option value="Productive Loan">Productive Loan</option>
										</select>
										</div>
								</div>
							<?php }?>			
								<div class="form-group">
										<p><label for="loanrepayment" class="col-sm-2 control-label">Loan Repayment</label></p>
										<div class="col-sm-4">
											<select name = "loanrepayment" class="col-sm-5 form-control" id="exampleList">
												<option value="Check">Check</option>
												<option value="Pay Roll Deduction">Pay Roll</option>
												<option value="Cash">Cash</option>
										</select>
										</div>
								</div>
								
								<div class="form-group">
						<label for="comaker" class="col-sm-2 control-label">CoMaker</label>
						<div class="col-sm-4">
							<select class="form-control" id="comaker" name="comaker" placeholder="">
											
								<?php foreach($dataSet as $dataset
											){
												$memID = $dataset->getMemberId();
												
												$cofname = $dataset->getFname();
												$colname = $dataset->getLname();
												$cospace = " ";
												$cname = $cofname.$cospace.$colname;
												
												
												$fname = $member->getFname();
												$lname = $member->getLname();
												$space = " ";
												$name = $fname.$space.$lname;
												?>
											
											<option value="<?php if($fname != $cofname || $lname != $colname){
															 print_r($memID);?>"> <?php print_r($cname);?></option>
											<?php  }
											}?>
								
							</select>
							
						</div>
					</div>
							
								
								
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<input id="addloan" name="user_id" type="hidden" value="<?php echo $userId;?>" class="btn btn-primary">
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-1">
										<input id="addloan" name="addloan" type="submit" value="Add" class="btn btn-primary col-sm-1">
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-1">
										
										<a href="success.php?cont=search" type="submit" class="btn btn-primary">Back</a>
									</div>
								</div>
							</form>
				<?php } ?>
			<?php if($_SESSION['successCheck'] == true){
				if($_SESSION['Position'] == "Treasurer") {?>
			<div class="form-group">
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
						
			<?php } ?>
			
			<?php if($_SESSION['Position'] == "Manager") {?>
			<div class="form-group">
					<div class="col-sm-10 col-sm-offset-0">
						<a id="Home" href="success.php" type="submit" class="btn btn-primary"> Home</a>
					</div>
			</div> 
			<br>
			<br>
			<div class="form-group">
							<div class="col-sm-10 col-sm-offset-0">
								<a id="Home" href="success.php?<?php echo $_SESSION['back'];?>" type="submit" class="btn btn-primary"> Back</a>
							</div>
			</div>
        </div>
			<?php } 
			}?>
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