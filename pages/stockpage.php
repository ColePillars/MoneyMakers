<?php
include ('../resources/logininclude.php');
include ('../resources/functions.php');
session_start();
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
                    <div class="panel panel-primary" style="font-size:12px"> 
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-bar-chart fa-5x" style="margin-top:22px;display:block;text-align:center"></i>
                                </div>
                                <div class="col-xs-8">
                                    <div class="h4">
                                        <?php 
                                        include ('../resources/connection.php');
                                        $GetStockName = "SELECT Name FROM StockInfo.Stock_Symbol_Index WHERE Symbol = '" .  $_GET['Symbol'] . "';";
                                        $SearchResult = mysqli_query($conn, $GetStockName);
                                        if ($SearchResult->num_rows > 0){
                                            while($row = $SearchResult->fetch_assoc()) {
                                                $GLOBALS['StockFullName'] = $row['Name'];
                                                echo $row['Name'];
                                            }
                                        }
                                        else{
                                            //if no results, push user to another page
                                            $_SESSION['InvalidStockMessage'] = $_GET['Symbol'] . " is an invalid stock";
                                            header('Location: search.php');
                                            exit();
                                        }
                                        ?>
                                    </div>
                                    <div style="margin-bottom:6px">
                                        <?php 
                                        echo $_GET['Symbol'];
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#status-pills" data-toggle="tab">Status</a>
                                </li>
                                <li><a href="#details-pills" data-toggle="tab">Details</a>
                                </li>
                                <li><a href="#simulation-pills" data-toggle="tab">Sim</a>
                                </li>
                                <?php
                                ShowSubUnsubIcon();
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="status-pills">
                                    <h3 class='alert alert-warning' style='margin-top:3px;margin-bottom:3px;font-size:28px;text-align:center'>
                                    	<?php
                                        include ('../resources/connection.php');
                                        $status = "SELECT Final_Decision FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" .  $_GET['Symbol'] . "';";
                                        $statusResult = mysqli_query($conn, $status);
                                        if ($statusResult->num_rows > 0){
                                            while($row = $statusResult->fetch_assoc()) {
                                                echo $row['Final_Decision'];
                                            }
                                        }
                                        ?>
                                  	</h3>
                                </div>
                                <div class="tab-pane fade" id="details-pills">
                                    <?php 
                                    ShowCompanyInformation($_GET['Symbol']);
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="simulation-pills">
                                	<h3 class='alert alert-info' style='margin-top:3px;margin-bottom:3px;font-size:28px;text-align:center'>
                                	<?php 
                                    echo PotentialGains(1000, 100, 0, $_GET['Symbol']);
                                    ?> %
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php
                                        FetchLastTenDaysChart($_GET['Symbol']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <?php
                	StockGraph($_GET['Symbol']);
                    ?>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-yellow" style="height:615px">
                        <div class="panel-heading" style="font-size:12px">Stock News
                            <div class="fa fa-rss pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="chat-panel panel panel-default">
                            <div class="panel-body" style="height:562px;font-size:12px">
                                <ul class="chat">
                                    <?php
                                    ShowRssFeedNews($StockFullName);         
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                </div>
                            </div>
                        </div>
                    </div>
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