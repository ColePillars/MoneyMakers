<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Subscribed Stocks</title>

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
		<h1 class="page-header">Subscribed Stocks</h1>
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
    // $_SESSION['InvalidLoginMessage'] = "You are not logged in!";
    header('Location: login.php');
    exit();
} else {
    
    $sql1 = "SELECT * FROM StockInfo.Time_Series_Intradaily;";
    $result1 = mysqli_query($conn, $sql1);
    $sql2 = "SELECT * FROM UserCredentials.tbl_stock_subs WHERE atr_username ='" . $_SESSION['username'] . "';";
    $result2 = mysqli_query($conn, $sql2);
    
    while ($row = mysqli_fetch_assoc($result1)) {
        $_SESSION['stockid'] = atr_stock_id;
        $_SESSION['timestamp'] = Timestamp;
        $_SESSION['open'] = Open;
        $_SESSION['high'] = High;
        $_SESSION['low'] = Low;
        $_SESSION['close'] = Close;
        $_SESSION['volume'] = Volume;
    }
    while ($row = mysqli_fetch_assoc($result2)) {
        $_SESSION['username'];
        $_SESSION['stockid'] = atr_stock_id;
    }
    // $sql="SELECT name FROM system_dept ORDER BY id";
    // $result=mysql_query($sql);
    // $count=mysql_num_rows($result);
    // if (!mysql_query($sql,$conn))
    // {
    // exit('Error: ' . mysql_error());
    // }
    // else
    // {
    // $dept = array();
    // while ($row = mysql_fetch_array($result2)) {
    // $dept[] = $row['atr_stock_id'];
    // echo $row['atr_stock_id'];
    // }
    // }
}
?>
		</div>
	</div>
	<div class="panel-body">
		<h3><?php
if ($_SESSION['stockid'] != NULL) {
    echo "You are not subscribed to any stocks.";
} else {
    while ($row = mysqli_fetch_assoc($result2)) {
        echo $row['atr_stock_id'];
    }
}
?></h3>
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

