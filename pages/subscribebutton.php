<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="../resources/mm_favicon.png.ico">
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
    
    // Test $_GET['Symbol']
    $_GET['Symbol'] = AB;
    // Get variable values
    $UserName = mysqli_escape_string($conn, $_SESSION['username']);
    $Symbol = mysqli_escape_string($conn, $_GET['Symbol']);
    
    // SQL query to see if user is already subbed to current stock
    $CheckUserSubbed = "SELECT * FROM UserCredentials.tbl_stock_subs
 WHERE atr_username ='" . $UserName . "' AND atr_stock_id = '" . $Symbol . "';";
    $result = mysqli_query($conn, $CheckUserSubbed);
    $count = mysqli_num_rows($result);
}
?>
		</div>
	</div>
	<div class="panel-body">
		<form role="form" action="../resources/bothsubfunction.php"
			method="GET" name="subscription"
			
			<fieldset>
				<!-- takes user to subscribefunction.php-->
				<div class="form-group">
					<input type="submit" class="btn btn-lg btn-success btn-block"
						value=<?php
    if ($count == 0) {
        echo Subscribe;
    } else {
        echo Unsubscribe;
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

	<!-- Subscribe function. Fetch Stock data, then sub/unsub -->

	<script language='javascript' type='text/javascript'> 
	function doBoth(){
		fetchData();
		subUnsub();
	}
	function fetchData(){
		$.ajax({
			type: "GET",
			url:"../resources/fetchdailystockvalues.php",
// 			data:,
// 			success:,
// 			dataType:
		});
	}
	function subUnsub(){
		$.ajax({
			type: "GET",
			url:"../resources/subscribefunction.php",
// 			data:,
// 			success:,
// 			dataType:
	}
	</script>
	<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://PATHTOYOURJSFILE"></script>
</body>

</html>

