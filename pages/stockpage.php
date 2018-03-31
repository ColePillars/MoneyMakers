<?php
session_start();
include ('../resources/logininclude.php');
include ('../resources/functions.php');

include ('../resources/connection.php');
$GetStockName = "SELECT Name FROM StockInfo.Stock_Symbol_Index WHERE Symbol = '" .  $_GET['Symbol'] . "';";

$SearchResult = mysqli_query($conn, $GetStockName);
if ($SearchResult->num_rows > 0){
    while($row = $SearchResult->fetch_assoc()) {
        $GLOBALS['StockFullName'] = $row['Name'];
    }
}
else{
    //if no results, push user to another page
    $_SESSION['InvalidStockMessage'] = "'" . $_GET['Symbol'] . "' is an invalid stock";
    header("Location: ../pages/search.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Stock Page</title>
   	<link rel="icon" href="../resources/mm_favicon.png.ico">
   	<meta charset="utf-8">
   	<meta http-equiv="X-UA-Compatible" content="IE=edge">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
   	<meta name="description" content="">
  	<meta name="author" content="">
        
	<!-- Styling Resources -->
   	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  	<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
   	<link href="../vendor/morrisjs/morris.css" rel="stylesheet">
   	<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Graphing Resources, scripts must stay above StockGraph function -->
   	<script src="../graphing/amcharts/amcharts.js"></script>
    <script src="../graphing/amcharts/serial.js"></script>
    <script src="../graphing/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="../graphing/amcharts/plugins/export/export.css" type="text/css" media="all" />
</head>

<body>
    <div id="wrapper" style="min-width:350px">
        <?php
        include ('../pageelements/navbar.php');
		?>
        <div id="page-wrapper" style="padding-top:60px;">
        	<?php
            include ('../pageelements/stockcarousel.php');
            ?>
            <div class="row">
                <div class="col-lg-3">
                    <?php 
                    include ('../pageelements/stockinfo.php');
                    include ('../pageelements/recentdata.php');
                    ?>
                </div>
                <div class="col-lg-6">
                    <?php
                    if ($_SESSION['Subscribe']) {
                        unset($_SESSION['Subscribe']);
                    }
                    else {
                	StockGraph($_GET['Symbol']);
                    }
                    ?>
                </div>
                <div class="col-lg-3">
                    <?php
                    include ('../pageelements/rssfeed.php');
                    ?>
                </div>
            </div>
        </div>
        <?php
        include ('../pageelements/footer.php');
        ?>
    </div>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>