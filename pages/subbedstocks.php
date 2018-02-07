<?php 
include ('logininclude.php');
?>

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
		<h1 class="page-header">My Subscribed Stocks</h1>
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
    //$_SESSION['InvalidLoginMessage]="You are not logged in!";
    header('Location: login.php');
    exit();
} else {
    // if user had input error,outputerror, clear error message
    if ($_SESSION['InvalidUpdateMessage'] != NULL) {
        echo "<h3 class='panel-title'>" . $_SESSION['InvalidUpdateMessage'] . "</h3>";
        unset($_SESSION['InvalidUpdateMessage']);
    }
    
    $sql1 = "SELECT * FROM StockInfo.Time_Series_Daily_Adjusted;";
    $result1 = mysqli_query($conn, $sql1);
    $sql2 = "SELECT * FROM UserCredentials.tbl_stock_subs WHERE atr_username ='" . $_SESSION['username'] . "';";
    $result2 = mysqli_query($conn, $sql2);
    
    // while ($row = mysqli_fetch_assoc($result)) {
    // $_SESSION['username'];
    // $_SESSION['firstname'] = $row[atr_first_name];
    // $_SESSION['lastname'] = $row[atr_last_name];
    // $_SESSION['phone'] = $row[atr_phone];
    // $_SESSION['address'] = $row[atr_street_address];
    // $_SESSION['city'] = $row[atr_city];
    // $_SESSION['state'] = $row[atr_state];
    // $_SESSION['zip'] = $row[atr_zip];
    // }
}
?>
		</div>
	</div>
	<div class="panel-body">
		<h3><?php
if ($result2<>NULL) {
    echo "User is not subscribed to any stocks.";
} else {
    while ($row = mysql_fetch_assoc($result2)) {
        echo $row['atr_stock_id'];
    }
}

// $sql="SELECT atr_stock_id FROM system_dept ORDER BY id";
// $result=mysql_query($sql);
// $count=mysql_num_rows($result);
// if (!mysql_query($sql,$conn))
// {
// exit('Error: ' . mysql_error());
// }
// else
// {
// $dept = array();
// while($row=mysql_fetch_array($result))
// {
// $dept[]=$row['name'];
// echo $row['name'];
// }
// }
?></h3>

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

