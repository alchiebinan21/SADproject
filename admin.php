<?php
include_once('commands.php');

date_default_timezone_set('Asia/Manila');
$current_date = date('Y-m-d');

$pageHeader = "Welcome Administrator !";

if(isset($_REQUEST['content'])) {
	if($_REQUEST['content']=='add') {
		$pageHeader = "Add User";
	}
}
if(isset($_REQUEST['content'])) {
	if($_REQUEST['content']=='search') {
		$pageHeader = "Search User";
	}
}
if(isset($_REQUEST['content'])) {
	if($_REQUEST['content']=='added') {
		$pageHeader = "Member Added";
	}
}
if(isset($_REQUEST['content'])) {
	if($_REQUEST['content']=='remove') {
		$pageHeader = "Member Remove";
	}
}
$i = 0;
$errFname = "";
$errLname = "";
$errPass  = "";
$errBplace = "";
$errAdd = "";
$errOcc = "";
$errOther = "";
$errIncome = "";
$errEmp = "";
$errContact = "";
$errEB = "";
$errRelative = "";
$errSSS = "";
$errPhil = "";
$errDep = "";
$errCivil = "";
$result = "";

//remove

if(isset($_REQUEST['content'])) {
	if($_REQUEST['user_id']=='removed') {
		$command = new Command();		
		$command->deleteData($_REQUEST['user_id']);
	}
}



if (isset($_REQUEST['content'])) {
	if ($_REQUEST['content'] = 'search') {
		$command = new Command();
		$dataSet = $command->viewdata("Select * from member");
	}
}

// For Adding User php
if (isset($_REQUEST['add'])) {
	$fname = $_REQUEST['first'];
	$lname = $_REQUEST['last'];
	$bplace = $_REQUEST['birthplace'];
	$add = $_REQUEST['address'];
	$occ = $_REQUEST['occupation'];
	$dob = $_REQUEST['dob'];
	$income = $_REQUEST['Income'];
	$oincome = $_REQUEST['otherincome'];
	$pe = $_REQUEST['employer'];
	$contact = $_REQUEST['contact'];
	$edback = $_REQUEST['eb'];
	$relative = $_REQUEST['relative'];
	$sss = $_REQUEST['sss'];
	$ph = $_REQUEST['philhealth'];
	$dep = $_REQUEST['dependent'];
	$civil = $_REQUEST['civilstat'];
	
	$command = new Command();
	if($command->Add($fname,$lname,$bplace,$add,$civil,$occ,$dob,$income,$oincome,$pe,$contact,$edback,$relative,$sss,$ph))
		
	/*$command->addfname($fname,$lname);*/

	// Check if first name has been entered
	if (!$_REQUEST['fname']) {
		$errFname = 'Please enter your first name';
	}
	
	// Check if last name has been entered
	if (!$_REQUEST['lname']) {
		$errLname = 'Please enter your last name';
	}
	
	// Check if birth place has been entered
	if (!$_REQUEST['bplace']) {
		$errBplace = 'Please enter your birth place';
	}
	
			// Check if address has been entered
	if (!$_REQUEST['address']) {
		$errAdd = 'Please enter your address';
	}
	
			// Check if occupation has been entered
	if (!$_REQUEST['occupation']) {
		$errOcc = 'Please enter your occupation';
	}
	
			// Check if income has been entered
	if (!$_REQUEST['Income']) {
		$errIncome = 'Please enter your income';
	}
	
			// Check if other income has been entered
	if (!$_REQUEST['otherincome']) {
		$errOther = 'Please enter your other income';
	}
	
			// Check if employer has been entered
	if (!$_REQUEST['employer']) {
		$errEmp = 'Please enter your employer';
	}
	
					// Check if contact has been entered
	if (!$_REQUEST['contact']) {
		$errContact = 'Please enter your contact';
	}
	
					// Check if educational background has been entered
	if (!$_REQUEST['eb']) {
		$errEB = 'Please enter your educational background';
	}
	
					// Check if relative has been entered
	if (!$_REQUEST['relative']) {
		$errRelative = 'Please enter your relative';
	}
	
					// Check if SSS has been entered
	if (!$_REQUEST['sss']) {
		$errSSS = 'Please enter your SSS no';
	}
	
					// Check if phil health has been entered
	if (!$_REQUEST['philhealth']) {
		$errPhil = 'Please enter your phil health';
	}
	
					// Check if dependents has been entered
	if (!$_REQUEST['dependent']) {
		$errDep = 'Please enter name';
	}
	
					// Check if civil status has been entered
	if (!$_REQUEST['civilstat']) {
		$errCivil = 'Please enter your civil status';
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
	


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                <a class="navbar-brand" href="admin.php">Profiling User V1.0</a>
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
							<li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="admin.php?content=add"><i class="fa fa-bar-chart-o fa-fw"></i> Add User</a>
                        </li>
                        <li>
                            <a href="admin.php?content=search"><i class="fa fa-table fa-fw"></i> Search User</a>
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
				
				
<!-- Add User ////////////////////////////////////////////////////////////////////////////////////////////////-->  
					<?php
					if(isset($_REQUEST['content'])) {
						if($_REQUEST['content']=='add') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
					<form class="form-horizontal" role="form" method="get" action="index.php">
					
					<div class="form-group">
						<label for="first" class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="first" name="first" placeholder="Enter first name" value="<?php if(isset($_REQUEST["first"])) echo htmlspecialchars ($_REQUEST["fname"]); ?>">
							<p class='text-danger'><?php echo $errFname;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="last" class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="last" name="last" placeholder="Enter last name" value="<?php if(isset($_REQUEST["last"])) echo htmlspecialchars ($_REQUEST["lname"]); ?>">
							<p class='text-danger'><?php echo $errLname;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="birthplace" class="col-sm-2 control-label">Birth Place</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="birthplace" name="birthplace" placeholder="Enter birth place" value="<?php if(isset($_REQUEST["birthplace"])) echo htmlspecialchars ($_REQUEST["birthplace"]); ?>">
							<p class='text-danger'><?php echo $errBplace;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="address" class="col-sm-2 control-label">Address</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php if(isset($_REQUEST["address"])) echo htmlspecialchars ($_REQUEST["address"]); ?>">
							<p class='text-danger'><?php echo $errAdd;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="civilstat" class="col-sm-2 control-label">Civil Status</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="civilstat" name="civilstat" placeholder="Enter civil status" value="<?php if(isset($_REQUEST["civilstat"])) echo htmlspecialchars ($_REQUEST["civilstat"]); ?>">
							<p class='text-danger'><?php echo $errCivil;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="occupation" class="col-sm-2 control-label">Occupation</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="occupation" name="occupation" placeholder="Enter occupation" value="<?php if(isset($_REQUEST["occupation"])) echo htmlspecialchars ($_REQUEST["occupation"]); ?>">
							<p class='text-danger'><?php echo $errOcc;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="dob" class="col-sm-2 control-label">Date of Birth</label>
						<div class="col-sm-10">
							<input type="date" class="form-control" id="dob" name="dob">
						</div>
					</div>
					
					<div class="form-group">
						<label for="Income" class="col-sm-2 control-label">Income</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="Income" name="Income" placeholder="Enter income" value="<?php if(isset($_REQUEST["Income"])) echo htmlspecialchars ($_REQUEST["Income"]); ?>">
							<p class='text-danger'><?php echo $errIncome;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="otherincome" class="col-sm-2 control-label">Other Source of Income</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="otherincome" name="otherincome" placeholder="Enter other source" value="<?php if(isset($_REQUEST["otherincome"])) echo htmlspecialchars ($_REQUEST["otherincome"]); ?>">
							<p class='text-danger'><?php echo $errOther;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="employer" class="col-sm-2 control-label">Present Employer</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="employer" name="employer" placeholder="Enter present employer" value="<?php if(isset($_REQUEST["employer"])) echo htmlspecialchars ($_REQUEST["employer"]); ?>">
							<p class='text-danger'><?php echo $errEmp;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="contact" class="col-sm-2 control-label">Contact No</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="contact" name="contact" placeholder="Enter contact number" value="<?php if(isset($_REQUEST["contact"])) echo htmlspecialchars ($_REQUEST["contact"]); ?>">
							<p class='text-danger'><?php echo $errContact;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="eb" class="col-sm-2 control-label">Educational Background</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="eb" name="eb" placeholder="Enter educational background" value="<?php if(isset($_REQUEST["eb"])) echo htmlspecialchars ($_REQUEST["eb"]); ?>">
							<p class='text-danger'><?php echo $errEB;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="relative" class="col-sm-2 control-label">Relative</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="relative" name="relative" placeholder="Enter relative's name" value="<?php if(isset($_REQUEST["relative"])) echo htmlspecialchars ($_REQUEST["relative"]); ?>">
							<p class='text-danger'><?php echo $errRelative;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="sss" class="col-sm-2 control-label">SSS #</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="sss" name="sss" placeholder="Enter sss number" value="<?php if(isset($_REQUEST["sss"])) echo htmlspecialchars ($_REQUEST["sss"]); ?>">
							<p class='text-danger'><?php echo $errSSS;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="philhealth" class="col-sm-2 control-label">Phil Health #</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="philhealth" name="philhealth" placeholder="Enter Phil health number" value="<?php if(isset($_REQUEST["philhealth"])) echo htmlspecialchars ($_REQUEST["philhealth"]); ?>">
							<p class='text-danger'><?php echo $errPhil;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="dependent" class="col-sm-2 control-label">Dependent</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="dependent" name="dependent" placeholder="Enter dependents" value="<?php if(isset($_REQUEST["dependent"])) echo htmlspecialchars ($_REQUEST["dependent"]); ?>">
							<p class='text-danger'><?php echo $errDep;?></p>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Add" class="btn btn-primary">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<?php echo $result; ?>	
						</div>
					</div>
				</form> 
					<?php	}
					}
					?>
				
				
<!-- Search User ////////////////////////////////////////////////////////////////////////////////////////////////-->  
					<?php
					if(isset($_REQUEST['content'])) {
						if($_REQUEST['content']=='search') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
								<div class="row">
									<form action="search.php" method="get">
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
																	<th>First Name</th>
																	<th>Last Name</th>
																</tr>
															</thead>
															<tbody>
																<tr class="odd gradeX">
																	<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value=1></td>
																	<td style="width: 10%;">aw</td>
																	<td style="width: 10%;">aw</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->

											<button class="btn btn-primary" name="restoreB" value="clicked">Update</button>
											<button class="btn btn-danger" name="removeB" value="clicked">Remove</button>
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
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
	
	
    </script>

</body>

</html>
