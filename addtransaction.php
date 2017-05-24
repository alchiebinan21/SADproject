<?php
include_once('commands.php');
session_start();

			$userId = $_GET['user_id'];
			
			$pageHeader = "Add Loan to Member # $userId";
			
		
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
                <a class="navbar-brand" href="success.php">Manager</a>
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
                            <a href="success.php?cont=loan"><i class="fa fa-rub fa-fw"></i> Loan List</a>
                        </li>
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
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				<form class="form-horizontal" role="form" method="get" name="addloan" onsubmit="return validateForm()" action="addloan.php">
								<div class="form-group">
									<label for="first" class="col-sm-2 control-label">Loan Amount</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="LoanAmount" name="LoanAmount" placeholder="Enter Loan Amount" value="">
										<p class='text-danger'></p>
									</div>
								</div>
								
								<div class="form-group">
									<label for="last" class="col-sm-2 control-label">Payment Type</label>
									<div class="col-sm-10">
										<div class="checkbox">
										  <label>
											<input type="checkbox" name="daily" value="Daily">
											Daily
										  </label>
										  
										  <label>
											<input type="checkbox" name="weekly" value="Weekly">
											Weekly
										  </label>
										  
										  <label>
											<input type="checkbox" name="bimonthly" value="BiMonthly">
											Bi-Monthly
										  </label>
										  
										  <label>
											<input type="checkbox" name="monthly" value="Weekly">
											Monthly
										  </label>
										  
										  <label>
											<input type="checkbox" id="quarterly" value="Quarterly">
											Quarterly
										  </label>
										  
										  <label>
											<input type="checkbox" id="semiannual" value="SemiAnnual">
											Semi Annual
										  </label>
										  
										  <label>
											<input type="checkbox" id="anually" value="Anually">
											Anually
										  </label>
										</div>
										
										<p class='text-danger'></p>
										
									</div>
									
									
								</div>

								
								<div class="form-group">
									<label for="birthplace" class="col-sm-2 control-label">Loan Payment Date</label>
									<div class="col-sm-10">
										<input type="date" class="form-control" id="loanpaydate" name="loanpaydate" placeholder="Loan Payment Schedule" value="">
										<p class='text-danger'></p>
									</div>
								</div>
								
								<div class="form-group">
									<label for="address" class="col-sm-2 control-label">Type of Loan</label>
									<div class="col-sm-10">
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="provincial" name="provincial" value="Provincial">
											Provincial
										  </label>
										
										<label>
											<input type="checkbox" name="level" value="Level">
											Level Loan
										  </label>
										  
										  <label>
											<input type="checkbox" name="productive" value="Productive">
											Productive Loan
										  </label>
										<p class='text-danger'></p>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="civilstat" class="col-sm-2 control-label">Loan Term</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="LoanTerm" name="LoanTerm" placeholder="Enter Loan Term" value="">
										<p class='text-danger'></p>
									</div>
								</div>
								
								<div class="form-group">
									<label for="occupation" class="col-sm-2 control-label">No. of Installments</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="LoanInstallment" name="LoanInstallment" placeholder="Enter Loan Installment No." value="">
										<p class='text-danger'></p>
									</div>
								</div>
								
								
								<div class="form-group">
									<label for="address" class="col-sm-2 control-label">Repayment</label>
									<div class="col-sm-10">
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="Check" name="Check" value="Check">
											Check
										  </label>
										
										<label>
											<input type="checkbox" name="Payroll" value="PayrollDeduction">
											Payroll Deduction
										  </label>
										  
										  <label>
											<input type="checkbox" name="Cash" value="Cash">
											Cash
										  </label>
										<p class='text-danger'></p>
										</div>
									</div>
								</div>
								
								
								<div class="form-group">
									<label for="birthplace" class="col-sm-2 control-label">Loan Payment Sched</label>
									<div class="col-sm-10">
										<input type="date" class="form-control" id="loanpaysched" name="loanpaysched" placeholder="Loan Payment Schedule" value="">
										<p class='text-danger'></p>
									</div>
								</div>
								
								
								<div class="form-group">
									<label for="birthplace" class="col-sm-2 control-label">Loan Payment Start</label>
									<div class="col-sm-10">
										<input type="date" class="form-control" id="loanpaystart" name="loanpaystart" placeholder="Loan Payment Start" value="">
										<p class='text-danger'></p>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<input id="addloan" name="user_id" type="hidden" value="<?php echo $userId;?>" class="btn btn-primary">
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<input id="addloan" name="addloan" type="submit" value="Add" class="btn btn-primary">
									</div>
								</div>
								
								
							</form>

				
				
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