<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Subscribe button test</title>

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
		<h1 class="page-header">Please test subscribe button</h1>
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
        echo " ";
    }
    
    // SQL query to see if user is already subbed to current stock
    $CheckUserSubbed = "SELECT * FROM UserCredentials.tbl_stock_subs
 WHERE atr_username ='" . $_SESSION['username'] . "' AND atr_stock_id = '" . $_GET['Symbol'] . "';";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    
//     // If $count is greater than 0, then the user is already subbed to the stock
//     if ($count != 0) {
//         // User is subscribed, need to show UNSUBSCRIBE
//     } else {
//         // User is not subscribed, need to show SUBSCRIBE
//     }
}
?>
		</div>
	</div>
	<div class="panel-body">
		<form role="form" action="../resources/subscribefunction.php"
			method="POST" name="subscription">
			<fieldset>
				<!-- takes user to subscribefunction.php-->
				<div class="form-group">
					<input type="submit" class="btn btn-lg btn-success btn-block"
						value=<?php
    if ($count != 0) {
        echo Unsubscribe;
    } else {
        echo Subscribe;
    }
    ?>>

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

