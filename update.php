<?php
include_once('commands.php');
session_start();

			$userId = $_GET['user_id'];
			
			$pageHeader = "View Member # $userId";
			
			
			
			if (isset($_REQUEST['update'])) 
			{
				if ($_REQUEST['update']=='Update')
				{
					$command = new Command();
					$fName = "";
					
					
					
					
					if(empty($_REQUEST['fName']) == false)
					{
					$fName = $_REQUEST['fName'];
					$command->updateFname($fName,$userId);
					}

					if(empty($_REQUEST['lName']) == false)
					{
					$lName = $_REQUEST['lName'];
					$command->updateLname($lName,$userId);
					}
					
					if(empty($_REQUEST['bDate']) == false)
					{
					$bDate = $_REQUEST['bDate'];
					$command->updateDob($bDate,$userId);
					}
					
					if(empty($_REQUEST['Address']) == false)
					{
					$address = $_REQUEST['Address'];
					$command->updateAdd($address,$userId);
					}
					
					if(empty($_REQUEST['occupation']) == false)
					{
					$occupation = $_REQUEST['occupation'];
					$command->updateOcc($occupation,$userId);
					}
					
					if(empty($_REQUEST['civil']) == false)
					{
					$civil = $_REQUEST['civil'];
					$command->updateCivilStatus($civil,$userId);
					}
					
					if(empty($_REQUEST['bPlace']) == false)
					{
					$bPlace = $_REQUEST['bPlace'];
					$command->updateBplace($bPlace,$userId);
					}
					
					if(empty($_REQUEST['income']) == false)
					{
					$income = $_REQUEST['income'];
					$command->updateIncome($income,$userId);
					}
					
					if(empty($_REQUEST['oIncome']) == false)
					{
					$oIncome = $_REQUEST['oIncome'];
					$command->updateOincome($oIncome,$userId);
					}
					
					if(empty($_REQUEST['contact']) == false)
					{
					$contact = $_REQUEST['contact'];
					$command->updateContact($contact,$userId);
					}
					
					if(empty($_REQUEST['sss']) == false)
					{
					$sss = $_REQUEST['sss'];
					$command->updateSSS($sss,$userId);
					}
					
					if(empty($_REQUEST['relative']) == false)
					{
					$relative = $_REQUEST['relative'];
					$command->updateRelative($relative,$userId);
					}
					
					if(empty($_REQUEST['pHealth']) == false)
					{
					$pHealth = $_REQUEST['pHealth'];
					$command->updatePhilHealth($pHealth,$userId);
					}
					
					if(empty($_REQUEST['edBack']) == false)
					{
					$edBack = $_REQUEST['edBack'];
					$command->updateEdBack($edBack,$userId);
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
	
<script src="jquery-1.12.1.js"></script>
<script>
  $(document).ready(function() {
    $('#datepicker').datepicker({
		minDate: 0,						
      });
  });
  
		</script>

  
  
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
	
	#upper-header { height: 25; }
	#upper-body { height: 200px; display: none;}
	#mid-header { height: 25;  }
	#mid-body { height: 200px; display: none; } 

	

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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
					
                        <h1 class="page-header"><?php echo $pageHeader; ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>






								<?php
								$command = new Command();
								$data = $command->getMember($userId);
								?>
								
					<div class="container-fluid">
						
						<div class ="row">
							<form action="update.php" method="get" role="form">
								<div class ="col-md-4">
								
								  <div class="form-group">
									<label for="exampleInputName2">First Name</label>
										<div class="input-group">
											<input type="text" class="form-control" id="fName" name="fName" placeholder="<?php echo $data->getFname();?>"></td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Last Name</label>
										<div class="input-group">
											<input type="text" class="form-control" id="lname" name="lName" placeholder="<?php echo $data->getLname();?>"></td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  
								  <div class="form-group">
									<label for="exampleInputName2">Birth Date</label>
										<div class="input-group">
											<input type="text" class="form-control" id="bdate" name="bDate" placeholder="<?php print_r($data->getBirthDate());?>"></td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Address</label>
										<div class="input-group">
											<input type="text" class="form-control" id="add" name="Address" placeholder="<?php print_r($data->getMemberAdd());?>"></td>
											<span class="input-group-addon"></span>
										</div>
									</div>
	  
								  <div class="form-group">
									<label for="exampleInputName2">Occupation</label>
										<div class="input-group">
											<input type="text" class="form-control" id="occ" name="occupation" placeholder="<?php print_r($data->getMemberOccupation());?>"></td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Civil Status</label>
										<div class="input-group">
											<input type="text" class="form-control" id="civil" name="civil" placeholder="<?php print_r($data->getMemberCivilStatus());?>">
											<span class="input-group-addon"></span>
										</div>
								  </div>

								  <div class="form-group">
									<label for="exampleInputName2">Birth Place</label>
										<div class="input-group">
											<input type="text" class="form-control" id="bplace" name="bPlace" placeholder="<?php print_r($data->getMemberBplace());?>">
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  
								  <div class="form-group">
										<label for="exampleInputName2">Date Added</label>
											<div class="input-group">
												<input type="text" class="form-control" id="edback" name="edBack" placeholder="<?php print_r($data->getDateAdded());?>">
												<span class="input-group-addon"></span>
											</div>
									  </div>
								
								
								</div>
								
								<div class ="col-md-4">
								  <div class="form-group">
									<label for="exampleInputEmail2">Income</label>
										<div class="input-group">
											<input type="text" class="form-control" id="income" name="income" placeholder="<?php print_r($data->getMemberIncome());?>">
											<span class="input-group-addon"></span>
										</div>
								   </div>

								  <div class="form-group">
									<label for="exampleInputName2">Other Income</label>
										<div class="input-group">
											<input type="text" class="form-control" id="oincome" name="oIncome" placeholder="<?php print_r($data->getMemberOIncome());?>">
											<span class="input-group-addon"></span>
										</div>
								  </div>
								
								  <div class="form-group">
									<label for="exampleInputEmail2">Contact #</label>
										<div class="input-group">
											<input type="text" class="form-control" id="contact" name="contact" placeholder="<?php print_r($data->getMemberContact());?>">
											<span class="input-group-addon"></span>
										</div>
									</div>
									
								  <div class="form-group">
									<label for="exampleInputEmail2">SSS #</label>
										<div class="input-group">
											<input type="text" class="form-control" id="sss" name="sss" placeholder="<?php print_r($data->getMemberSSS());?>">
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Relative</label>
										<div class="input-group">
											<input type="text" class="form-control" id="relative" name="relative" placeholder="<?php print_r($data->getMemberRelative());?>">
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  						
						
								  <div class="form-group">
									<label for="exampleInputEmail2">Phil Health #</label>
										<div class="input-group">
											<input type="text" class="form-control" id="phealth" name="pHealth" placeholder="<?php print_r($data->getMemberPhealth());?>">
											<span class="input-group-addon"></span>
										</div>
								  </div>
								
								  <div class="form-group">
									<label for="exampleInputName2">Educational Background</label>
										<div class="input-group">
											<input type="text" class="form-control" id="edback" name="edBack" placeholder="<?php print_r($data->getMemberEducationalBack());?>">
											<span class="input-group-addon"></span>
										</div>
								  </div>
								
								  <div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<div class="input-group">
											<input id="update" name="user_id" type="hidden" value="<?php echo $userId;?>" class="btn btn-primary">
											
										</div>

									</div>
									
								  </div>
								 </div> 
								  <div class ="col-md-4">
									  
								  </div>
								
                                
									<?php if($_SESSION['Position'] == "Manager") {?>
                                
									<div class="form-group">
										<div class="col-sm-10 col-sm-offset-6">
											<a href="success.php?cont=search" type="submit" class="btn btn-primary">Back</a>	
											<input id="update" name="update" type="submit" onclick="confirmUpdate(<?php echo $userId?>);"value="Update" class="btn btn-primary">
										</div>
									<?php 
										
										}else{?>
										<div class="form-group">
											<div class="col-sm-10 col-sm-offset-0">	
												<a href="successT.php?cont=search" type="submit" class="btn btn-primary">Back</a>	
											</div>
										</div>
										<?php }?>
									
									
								</div>									
								
								
							</form>
							
							<br>
							
						<!------------------------------------- Slide Down for Loans --->
							<?php $goLoans = $command->OnGoingLoans($userId);
								  if($goLoans) { ?>
							
						<div class="col-sm-10">	
							<br>
								<div id="upper-header" class="box"><b>View On Going Loan</b></div>
							<br>
							
								<div>
									
									<table id="upper-body" class = "table table-striped table-bordered table-hover" border="0" style="width:90%">
									  <tr class = "odd gradeX">
										<td><b><p>App. No</p></b></td>
										<td><b><p>Loan Date Released</p></b></td>
										<td><b><p>Loan Amount</p></b></td> 
										<td><b><p>Loan Term</p></b></td>
										<td><b><p>Loan Payment Type</p></b></td>
										<td><b><p>Released By</p></b></td> 
										<td><b><p>Payments left</p></b></td>
										<td></td>
										
									  </tr>	
										
									
									
								<?php foreach($goLoans as $goloans)
									{
										$appNo = $goloans->getApplicationNo();
										$count = $command->getCountLoanToBePaid($appNo);
										?>
									  <tr>
										<td><b><p align="right"><?php echo $goloans->getApplicationNo();?></p></b></td>
										<td><b><p align="right"><?php echo $goloans->getloanPaymentStart();?></p></b></td>
										<td><b><p align="right"><?php echo number_format($goloans->getloanAmount(),2);?></p></b></td> 
										<td><b><p align="right"><?php echo $goloans->getloanTerm();?></p></b></td>
										<td><b><p align="center"><?php echo $goloans->getmodeType();?></p></b></td>
										<td><b><p><?php echo $goloans->getReleasedby();?></p></b></td> 
										<td><b><p align="right"><?php echo $count?></p></b></td>
										<td align = "center" style="width: 5%;"><a  class="btn btn-primary btn-xs" href="success.php?contl=viewloan&ApplicationNo=<?php echo $goloans->getApplicationNo();?>&>&payment=View+Payments">View</a>
									  </tr>
									  
									<?php }
									
									
									
									
									}?>
									</table>
									
								</div>
			
								<?php $paidLoan = $command->PaidLoans($userId);
									  if($paidLoan)
									  {					
								?>
								
								
			
								<div id="mid-header" class="box"><br><b>View Completed Loans</b></div>
								<br>
								<table id ="mid-body" class = "table table-striped table-bordered table-hover" border="0" style="width:90%">
								  <tr class = "odd gradeX">
									<td><b><p>App. No</p></b></td>
									<td><b><p>Loan Date Released</p></b></td>
									<td><b><p>Loan Amount</p></b></td> 
									<td><b><p>Loan Term</p></b></td>
									<td><b><p>Loan Payment Type</p></b></td>
									<td><b><p>Certified By</p></b></td> 
									<td><b><p>Date Paid Off</p></b></td>
									<td></td>
								  </tr>	
									  <?php }?>
								
							    <?php	if($paidLoan) {
										foreach($paidLoan as $paidloan)
								{
									$appNoPaid = $paidloan->getApplicationNo();
									$count = $command->getCountLoanToBePaid($appNoPaid);
									?>
								  <tr>
									<td><b><p><?php echo $paidloan->getApplicationNo();?></p></b></td>
									<td><b><p><?php echo $paidloan->getloanPaymentStart();?></p></b></td>
									<td><b><p><?php echo $paidloan->getloanAmount();?></p></b></td> 
									<td><b><p><?php echo $paidloan->getloanTerm();?></p></b></td>
									<td><b><p><?php echo $paidloan->getmodeType();?></p></b></td>
									<td><b><p><?php echo $paidloan->getCertifiedBy();?></p></b></td> 
									<td><b><p><?php echo $paidloan->getpaidDate();?></p></b></td>
									<td align = "center" style="width: 5%;"><a  class="btn btn-primary btn-xs" href="success.php?contl=viewloan&ApplicationNo=<?php echo $paidloan->getApplicationNo();?>&>&payment=View+Payments">View</a>
								  </tr>	
								<?php }
								}?>
								</table>
								
								<!--<div id="ViewHistoryTransactions" class="box"><br><b>View Payment Transactions</b></div>-->
								<br><br><br><br><br>
								
								
								</div>
						
						
					</div>
						
	
				
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
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
	
	function confirmUpdate(userId) {
		answer = confirm('Are you sure to Update Information on member ' + userId);
		if (answer) {
			
			location.href = "update.php?user_id="+userId;
			alert("Successfully updated");
		} else {
			return;
		}
	}
	
	$(document).ready(
			function()
			{
				$("#upper-header").click(function()
				{
					$("#upper-body").toggle(500);
				});

				
				$("#mid-header").click(function()
				{
					$("#mid-body").toggle(500);
					
				});

			});
			
		$
    </script>
	

</body>

</html>