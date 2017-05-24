<?php
include_once('commands.php');
session_start();

$temp;

date_default_timezone_set('Asia/Manila');

$current_date = date('Y-m-d');

$pageHeader = "Welcome !";
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$space = " ";
$name = $firstname.$space.$lastname;

$_SESSION['check'] = false;



if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='add') {
		$pageHeader = "Add Member";
	}
}


if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='search') {
		$pageHeader = "Search Member";
		$command = new Command();
		$dataSet = $command->viewdata("Select * from member");
	}
}

if(isset($_REQUEST['conti'])) {
	if($_REQUEST['conti']=='removeLoan') {
		$AppNo = $_GET['AppNo'];
		$Reason = $_GET['Reason'];
		$command = new Command();
		$command->denyLoan($Reason,$name,$AppNo);
		$command->updateDenyLoan($AppNo);
		$pageHeader = "Loan Denied";
	}
}

if(isset($_REQUEST['conti'])) {
	if($_REQUEST['conti']=='release') {
		$AppNo = $_GET['AppNo'];
		$command = new Command();
		$command->ApproveLoanChair($AppNo);
		$pageHeader = "Loan Approved";
	}
}

	
if(isset($_REQUEST['contu'])){
	if($_REQUEST['contu']=='view')
	{
		$userId = $_GET['user_id'];
		$pageHeader = "View Member ID # $userId";

		
	}
}

if(isset($_REQUEST['contl'])){
	if($_REQUEST['contl']=='viewloan'){
	
		$AppNo = $_GET['ApplicationNo'];
		
		$command = new Command();
		$Loan = $command->getLoan($AppNo);
		$memberid = $Loan->getMemberId();
		
		$member = $command->getMember($memberid);
		
		$fname = $member->getFname();
		$lname = $member->getLname();
		$space = " ";
		$name = $fname.$space.$lname;
	
	
	
	
		$pageHeader = "View Loan Information";
	}

}
/*-----------------------------------------------------------------------------------KANI CHI--------------------------------------------------------*/
if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='loan') {
		$pageHeader = "Manage Loan";
		$command = new Command();
		$dataLoan = $command->getdata("Select * from loan where approval = 2");
		$dataSet = $command->viewdata("Select * from member");
	}
}
/*-----------------------------------------------------------------------------------HANTUD DRI--------------------------------------------------------*/

if(isset($_REQUEST['contu']))
{
		if($_REQUEST['contu']=='update')
		{
			$command = new Command();
			$userId = $_GET['user_id'];
			echo $userId;
		
			if(isset($_REQUEST['fName']))
			{
			$fName = $_REQUEST['fName'];
			echo $fName;
			}
		}
}

if(isset($_REQUEST['cont'])) {
	if($_REQUEST['cont']=='loanList') {
		$pageHeader = "Manage Loan";
		$command = new Command();
		$dataLoan = $command->getdata("Select * from loan where approval > -1");
		$dataSet = $command->viewdata("Select * from member");
	}
}




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



// For Adding User php
if (isset($_REQUEST['submit'])) {
	if ($_REQUEST['submit']=='Add') {
		
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
		{
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
  
 <style>
	td{
		text-align:center; 
	}
	
	th{
		text-align:center; 
	}
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
                <a class="navbar-brand" href="successB.php">Board Chairman</a>
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

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
					
							<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// KANI CHI ////////////////////////////////////////////////////////////////////////////////// -->
						<li>
                            <a href="successB.php?cont=loan"><i class="fa fa-rub fa-fw"></i> Loan for Approval</a>
                        </li>
						
						 <li>
                            <a href="successB.php?cont=loanList"><i class="fa fa-rub fa-fw"></i> List of Loans</a>
                        </li>
						<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
						
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
						
						<?php if($_SESSION['check'] == true) 
						{ ?>
							<div class="form-group">
							<br>
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
							<br><br>

						<?php 
						}
						?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				
<!-- Add User ////////////////////////////////////////////////////////////////////////////////////////////////-->  
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='add') 
						{?>
							<form class="form-horizontal" role="form" method="get" action="success.php">
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
							</form><?php	
						}
					}
					?>
					
<!-- Update ////////////////////////////////////////////////////////////////////////////////////////////////-->  
					<?php
				if(isset($_REQUEST['contu']))
				{
						$id = intval($_REQUEST['user_id']);
						$command = new Command();
						$data = $command->getMember($id);
						
						if($_REQUEST['contu']=='view')
						{


								?>
								<form>
								<div class="form-inline">
								
								  <div class="form-group">
									<label for="exampleInputName2">First Name</label>
									<input type="text" class="form-control" id="fName" name="fName" placeholder="<?php echo $data->getFname();?>"></td>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Last Name</label>
									<input type="text" class="form-control" id="lname" placeholder="<?php echo $data->getLname();?>"></td>
								  </div>
								  <br>
								  <br>
								  
								  
								  <div class="form-group">
									<label for="exampleInputName2">Birth Date</label>
									<input type="text" class="form-control" id="bdate" placeholder="<?php print_r($data->getBirthDate());?>"></td>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Address</label>
									<input type="text" class="form-control" id="add" placeholder="<?php print_r($data->getMemberAdd());?>"></td>
								  </div>
								   <br>
								  <br>
								  
								  
								  <div class="form-group">
									<label for="exampleInputName2">Occupation</label>
									<input type="text" class="form-control" id="occ" placeholder="<?php print_r($data->getMemberOccupation());?>"></td>
								  </div>
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Civil Status</label>
									<input type="text" class="form-control" id="civil" placeholder="<?php print_r($data->getMemberCivilStatus());?>">
								  </div>
		
								<br>
								<br>
								
								  <div class="form-group">
									<label for="exampleInputName2">Birth Place</label>
									<input type="text" class="form-control" id="bplace" placeholder="<?php print_r($data->getMemberBplace());?>">
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Income</label>
									<input type="email" class="form-control" id="income" placeholder="<?php print_r($data->getMemberIncome());?>">
								  </div>
								<br>
								<br>

								  <div class="form-group">
									<label for="exampleInputName2">Other Income</label>
									<input type="text" class="form-control" id="oincome" placeholder="<?php print_r($data->getMemberOIncome());?>">
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Contact #</label>
									<input type="text" class="form-control" id="contact" placeholder="<?php print_r($data->getMemberContact());?>">
								  </div>
								<br>
								<br>

								  <form class="form-inline">
								  <div class="form-group">
									<label for="exampleInputEmail2">SSS #</label>
									<input type="text" class="form-control" id="sss" placeholder="<?php print_r($data->getMemberSSS());?>">
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Relative</label>
									<input type="text" class="form-control" id="relative" placeholder="<?php print_r($data->getMemberRelative());?>">
								  </div>
								  </form>
								<br>
								<br>								
								  
								  <div class="form-group">
									<label for="exampleInputEmail2">Phil Health #</label>
									<input type="text" class="form-control" id="phealth" placeholder="<?php print_r($data->getMemberPhealth());?>">
								  </div>
								<br> 
								<br>
								
								  <div class="form-group">
									<label for="exampleInputName2">Educational Background</label>
									<input type="text" class="form-control" id="edback" placeholder="<?php print_r($data->getMemberEducationalBack());?>">
								  </div>
								<br>
								<br>
								
								<td style="width: 10%;">
									<a class="btn btn-primary btn" href="" onclick="confirmUpdate(<?php echo $data->getMemberId(); $_SESSION['userid']?>);">Update</a>
									<br><br>
								</td>								  
								  </div>
								  
								
								</form>
								<br>
								
								  
								
								
								
								
								


								
								

							<?php	
						}
				}
				
					?>
	<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// KANI CHI ////////////////////////////////////////////////////////////////////////////////// -->				
	<!-- View Loan ////////////////////////////////////////////////////////////////////////////////////////////////--> 				
						<?php
				if(isset($_REQUEST['contl']))
				{
						$appNo = intval($_REQUEST['ApplicationNo']);
						$command = new Command();
						$dataloan = $command->getLoan($appNo);
						if($_REQUEST['contl']=='viewloan')
						{
						

								?>
						<div class="container-fluid">
						
						<div class ="row">
						<form role="form">
						<div class ="col-md-4">
								  <div class="form-group">
									<label for="exampleInputName2">Application No.</label>
										<div class="input-group">
											<input type="text" class="form-control" id="fName" name="fName" placeholder="<?php echo $dataloan->getApplicationNo();?>"> </td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Member Name</label>
										<div class = "input-group">
											<input type="text" class="form-control" id="lname" placeholder="<?php echo $name?>"></td>
											<span class="input-group-addon"></span>
										</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputName2">Loan Amount</label>
									<div class="input-group">
									<input type="text" class="form-control" id="bdate" placeholder="<?php print_r($dataloan->getloanAmount());?>"></td>
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Loan Date</label>
									<div class="input-group">
									<input type="text" class="form-control" id="add" placeholder="<?php print_r($dataloan->getloanDate());?>"></td>
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputName2">Loan Type</label>
									<div class="input-group">
									<input type="text" class="form-control" id="occ" placeholder="<?php print_r($dataloan->getloanType());?>"></td>
									<span class="input-group-addon"></span>
									</div>
								  </div>
						
								  <div class="form-group">
									<label for="exampleInputEmail2">Mode Type</label>
									<div class="input-group">
									<input type="text" class="form-control" id="civil" placeholder="<?php print_r($dataloan->getmodeType());?>">
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  <?php $reason = $dataloan->getReason();
								  if($reason != null){ ?>
								  <div class="form-group">			
									<label for="exampleInputEmail2">Reason for Denial</label>
									<textarea type="text" class="form-control" id="reason" placeholder="<?php print_r($dataloan->getReason());?>"></textarea>
								  </div>
								  <?php
								   }
								   ?>
						</div>
								  <div class ="col-md-4">
								  <div class="form-group">
									<label for="exampleInputName2">Loan Term</label>
									<div class="input-group">
									<input type="text" class="form-control" id="bplace" placeholder="<?php print_r($dataloan->getloanTerm());?>">
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputEmail2">Loan Installment No.</label>
									<div class="input-group">
									<input type="email" class="form-control" id="income" placeholder="<?php print_r($dataloan->getloanInstallNo());?>">
									<span class="input-group-addon"></span>
									</div>
								  </div>
								  <div class="form-group">
									<label for="exampleInputName2">Loan Repayment</label>
									<div class="input-group">
									<input type="text" class="form-control" id="oincome" placeholder="<?php print_r($dataloan->getloanRepayment());?>">
									<span class="input-group-addon"></span>
									</div>
								  </div>

								  
								   
							</div>
						</form>
						</div>
						</div>

								
							<?php	
						}
				}
				
					?>
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->		
					
				
<!-- Search User ////////////////////////////////////////////////////////////////////////////////////////////////-->  
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='search') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
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
																	<th>Transaction</th>
																	<th>First Name</th>
																	<th>Last Name</th>
																	<th>Manage Member</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataSet) {
																	foreach($dataSet as $data) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $data->getMemberId();?>"></td>-->
																			<td style="width: 10%;">
																				<a class="btn btn-info btn-xs" "href="" onclick="confirmAddloan(<?php echo $data->getMemberId();?>);">Add Loan</a>
																				<a class="btn btn-info btn-xs" "href="" onclick="goToShare(<?php echo $data->getMemberId();?>);">Shares</a>
				
																			</td>
																			<td style="width: 10%;"><?php echo $data->getFname(); ?></td>
																			<td style="width: 10%;"><?php echo $data->getLname(); ?></td>
																			<td style="width: 10%;">
																			<a class="btn btn-primary btn-xs" "href="" onclick="confirmEdit(<?php echo $data->getMemberId();?>);">View</a>

																			</td>
																		</tr><?php 
																	}
																}?>
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>
					
				
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='loan') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
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
																	<th>ID</th>
																	<th>Application No.</th>
																	<th>Member Name</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataLoan) {
																	foreach($dataLoan as $dataloan) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $dataloan->getMemberId();?>"></td>-->
																			<td style="width: 10%;">
																				<a class="btn btn-primary btn-xs" "href="" onclick="confirmEditLoan(<?php echo $dataloan->getApplicationNo();?>);">View</a>
							
																				<a class="btn btn-warning btn-xs" "href="" onclick="confirmDeleteLoan(<?php echo $dataloan->getApplicationNo();?>);">Deny</a>
																				
																		
																				<a class="btn btn-success btn-xs" "href="" onclick="ReleaseLoan(<?php echo $dataloan->getApplicationNo();?>);">Approve</a>
																				
																			</td>
																			<td style="width: 10%;"><?php echo $dataloan->getApplicationNo(); ?></td>
																			<td style="width: 10%;"><?php   $app = $dataloan->getApplicationNo();
																											$command = new Command();
																											$datajoin = $command->joindata($app);
																											echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																		</tr><?php 
																	}
																}?>
																<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
										</div>
									<!-- /.col-lg-12 -->
									</form>
								</div>
					<?php	}
					}
					?>
					
							
					<?php
					if(isset($_REQUEST['cont'])) {
						if($_REQUEST['cont']=='loanList') {
						
						//	$query="select * from user where username != '".$_COOKIE['user']."'";
						//	$result=mysqli_query($dbconn, $query); ?>
						
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
																	<th>View</th>
																	<th>Manager</th>
																	<th>Credit Commitee</th>
																	<th>Chairman</th>
																	<th>Treasurer</th>
																	<th>Application No.</th>
																	<th>Member ID</th>
																</tr>
															</thead>
															<tbody>
																<?php if($dataLoan) {
																	foreach($dataLoan as $dataloan) {?>
																		<tr class="odd gradeX">
																			
																			<!--<td style="width: 1%; right="100"><input type="checkbox" id="blankCheckbox" name="user_id" value="<?php echo $dataloan->getMemberId();?>"></td>-->
																			<td style="width: 1%;">
																				<a class="btn btn-primary btn-xs" "href="" onclick="confirmEditLoan(<?php echo $dataloan->getApplicationNo();?>);">View</a>
																			</td>
																			<td style="width: 5%;">
																				<?php if($dataloan->getApproval() > 0)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td>
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width: 6%;">
																				<?php if($dataloan->getApproval() > 1)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td>
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width: 5%;">
																				<?php if($dataloan->getApproval() > 2)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td>
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width: 5%;">
																				<?php if($dataloan->getApproval() == 4)
																				{
																				?>
																				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
																			</td>
																				<?php }
																				else
																				{
																				?>
																				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
																				<?php }?>
																			<td style="width: 10%;"><?php echo $dataloan->getApplicationNo(); ?></td>
																			<td style="width: 10%;"><?php   $app = $dataloan->getApplicationNo();
																											$command = new Command();
																											$datajoin = $command->joindata($app);
																											echo $datajoin->getFname();echo " "; echo $datajoin->getLname();?></td>
																			
																		</tr><?php 
																	}
																}?>
															</tbody>
														</table>
													</div>
												</div>
												<!-- /.panel-body -->
											</div>
											<!-- /.panel -->			
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
    $(document).ready(function($) {
        $('#dataTables-example').dataTable();
    });
	
	
	function confirmDelete(userId) {
		answer = confirm('Are you sure to Remove this member ' + userId);
		if (answer) {
			location.href = "success.php?conti=remove&user_id="+userId;
		} else {
			return;
		}
	}
	
	function confirmDeleteLoan(AppNo) {
		answer = confirm('Are you sure to Deny loan # ' + AppNo);
		if (answer) {
			var x = prompt("Please Indicate The Reason for Denial");
			if(x)
				{
				location.href = "successB.php?conti=removeLoan&AppNo="+AppNo+"&Reason="+x;
				}
				
		} else {
			return;
		}
	}
	
	function ReleaseLoan(AppNo) {
		answer = confirm('Are you sure to Approve loan # ' + AppNo);
		if (answer) {
			location.href = "successB.php?conti=release&AppNo="+AppNo;
		} else {
			return;
		}
	}
	
	function confirmEdit(userId) {
			location.href = "update.php?user_id="+userId;
		}
	
	<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// KANI CHI ////////////////////////////////////////////////////////////////////////////////// -->
	function confirmEditLoan(AppNo) {
			location.href = "successB.php?contl=viewloan&ApplicationNo="+AppNo;
		}
	<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HANTUD DRI ////////////////////////////////////////////////////////////////////////////////// -->
	
	function confirmUpdate(userId) {
		answer = confirm('Are you sure to Update Information on member ' + userId);
		if (answer) {
			location.href = "update.php?user_id="+userId;
		} else {
			return;
		}
	}
	
	function goToShare(userId) {
			location.href = "deposit.php?user_id="+userId;
	}
	
	
	function confirmAddloan(userId) {
		answer = confirm('Are you sure to Add Loan on member ' + userId);
		if (answer) {
		
			location.href = "addloan.php?user_id="+userId;
		} else {
			return;
		}
	}
    </script>

</body>

</html>