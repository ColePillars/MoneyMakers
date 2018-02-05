<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Profile Page</title>

<!-- Bootstrap Core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div class="col-lg-12">
		<h1 class="page-header">My Profile Test</h1>
	</div>
	<div class="row">

		<!-- /.col-lg-12 -->
	</div>
	<div class="container">
		<div class="row">
			<!--  <div class="col-md-4 col-md-offset-4">
				  <div class="login-panel panel panel-default">
					<div class="panel-heading">
					-->
			<?php
session_start();

// including database connection file
include ('../resources/connection.php');

// checks login status
if ($_SESSION['is_logged_in'] != true) {
    header('Location: login.php');
    exit();
} else {
    // if user had input error,outputerror, clear error message
    if ($_SESSION['InvalidUpdateMessage'] != NULL) {
        echo "<h3 class='panel-title'>" . $_SESSION['InvalidUpdateMessage'] . "</h3>";
        unset($_SESSION['InvalidUpdateMessage']);
    } else {
        echo "<h2>Edit Information</h2>";
    }
    
    $sql = "SELECT * FROM UserCredentials.tbl_user_info WHERE atr_username ='" . $_SESSION['username'] . "';";
    $result = mysqli_query($conn, $sql);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['username'];
        $_SESSION['firstname'] = $row[atr_first_name];
        $_SESSION['lastname'] = $row[atr_last_name];
        $_SESSION['phone'] = $row[atr_phone];
        $_SESSION['address'] = $row[atr_street_address];
        $_SESSION['city'] = $row[atr_city];
        $_SESSION['state'] = $row[atr_state];
        $_SESSION['zip'] = $row[atr_zip];
    }
}
?>
		</div>
	</div>
	<div class="panel-body">
		<form role="form" action="../resources/profileedit.php" method="POST"
			name="profileform">
			<fieldset>
				<!--  Input for username -->
				<div class="form-group">
					<h3>Username:</h3>
					<br /> <input required pattern="[A-Za-z0-9]{1,}"
						class="form-control" name="username" type="text"
						title="No special characters"
						value="<?php echo $_SESSION['username'];?>"
				
				</div>
				<!-- Input for first name -->
				<h3>First Name:</h3>
				<br />
				<div class="form-group">
					<input required pattern="[A-Za-z]{1,}" class="form-control"
						name="firstname" type="text" title="Alphabetic characters only"
						value="<?php echo $_SESSION['firstname']; unset($_SESSION['firstname']);?>"
				
				</div>
				<!-- Input for last name -->
				<h3>Last Name:</h3>
				<br />
				<div class="form-group">
					<input required pattern="[A-Za-z]{1,}" class="form-control"
						name="lastname" type="text" title="Alphabetic characters only"
						value="<?php echo $_SESSION['lastname'];unset($_SESSION['lastname']);?>"
				
				</div>
				<!-- Input for phone number -->
				<h3>Phone Number:</h3>
				<br />
				<div class="form-group">
					<input pattern="[0-9]{10}" class="form-control" name="phone"
						title="Please include area code." type="text"
						value="<?php echo $_SESSION['phone'];unset($_SESSION['phone']);?>"
				
				</div>
				<!-- Input for Street address -->
				<h3>Street Address:</h3>
				<br />
				<div class="form-group">
					<input pattern="[A-Za-z0-9]{0,}" class="form-control"
						name="address" type="text" title="Alphanumberic characters only"
						value="<?php echo $_SESSION['address'];unset($_SESSION['address']);?>"
				
				</div>
				<!-- Input for City -->
				<h3>City:</h3>
				<br />
				<div class="form-group">
					<input pattern="[A-Za-z0-9]{0,}" class="form-control" name="city"
						type="text" title="Alphanumberic characters only"
						value="<?php echo $_SESSION['city'];unset($_SESSION['city']);?>"
				
				</div>
				<!-- Input for State -->
				<h3>State:</h3>
				<br />
				<div class="form-group">
					<input pattern="[A-Za-z]{0,}" class="form-control" name="state"
						type="text"
						value="<?php echo $_SESSION['state'];unset($_SESSION['state']);?>"
				
				</div>
				<!-- Input for Zip Code -->
				<h3>Zip Code:</h3>
				<br />
				<div class="form-group">
					<input pattern="[0-9]{5}" class="form-control" name="zip"
						type="text"
						value="<?php echo $_SESSION['zip'];unset($_SESSION['zip']);?>"
				
				</div>
				<!-- Input for Bloody type -->
				<h3>Blood Type:</h3>
				<br />
				<div class="form-group">
					<input pattern="[A-Za-z]{1}" class="form-control" name="blood"
						type="text" title="Alphabetic characters only">
				</div>
				<!-- Input for SSN -->
				<h3>Social Security Number:</h3>
				<br />
				<div class="form-group">
					<input pattern="[0-9]{9}" class="form-control" name="ssn"
						type="text">
				</div>
				<!-- Input for pet name -->
				<h3>Name of First Pet:</h3>
				<br />
				<div class="form-group">
					<input class="form-control" name="petname" type="text">
				</div>
				<!-- Input for dob -->
				<h3>Date of Birth:</h3>
				<br />
				<div class="form-group">
					<input class="form-control" name="dob" type="text">
				</div>
				<!-- Input for dad name -->
				<h3>Father's Name:</h3>
				<br />
				<div class="form-group">
					<input pattern="[A-Za-z]" class="form-control" name="dadname"
						type="text">
				</div>
				<!-- Input for mom name -->
				<h3>Mother's Maiden Name:</h3>
				<br />
				<div class="form-group">
					<input class="form-control" name="momname" type="text">
				</div>
				<!-- takes user to profile_edit.php-->
				<div class="form-group">
					<input type="submit" class="btn btn-lg btn-success btn-block"
						value='Update Info'>
				</div>
			</fieldset>
		</form>
	</div>
	</div>
	<!--  </div>
	  </div>
	</div>-->

	<!-- jQuery -->
	<script src="../vendor/jquery/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="../vendor/metisMenu/metisMenu.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>

