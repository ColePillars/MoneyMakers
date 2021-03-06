<?php
session_start();
include ('../resources/logininclude.php');
include ('../resources/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Search Page</title>
   	<link rel="icon" href="../resources/mm_favicon.png.ico">
   	<meta charset="utf-8">
   	<meta http-equiv="X-UA-Compatible" content="IE=edge">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
   	<meta name="description" content="">
  	<meta name="author" content="">
        
	<!-- Styling Resources -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
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
			<h3>
              	<?php
                echo  $_SESSION['InvalidStockMessage'];
                unset($_SESSION['InvalidStockMessage']);
                ?>
           	</h3>
          	<?php
            SearchStockIndex($_GET['SearchString']);
            ?>
        </div>
        <?php
        include ('../pageelements/footer.php');
        ?>
    </div>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            searching: false,
            responsive: true
        });
    });
	</script>
</body>

</html>
