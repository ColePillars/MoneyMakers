<?php
include ('../resources/logininclude.php');
include ('../resources/functions.php');
session_start();
?>    
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Home Page</title>
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
        <div id="page-wrapper" style="padding-top:70px;min-height:900px">
            <div class="row-eq-height">
                <div class="col-lg-3">
                    <div class="chat-panel panel panel-green chat" style="height:615px">
                        <div class="panel-heading" style="font-size:12px">My Subs
                            <div class="fa fa-star pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="chat-panel panel panel-default">
                            <div class="panel-body" style="font-size:12px;height:562px">
                                <ul class="chat">
                                    <?php
                                    ShowSubbedStocks();
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-yellow" style="height:615px">
                        <div class="panel-heading" style="font-size:12px">News
                            <div class="fa fa-rss pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="chat-panel panel panel-default">
                            <div class="panel-body" style="font-size:12px;height:562px">
                                <ul class="chat">
                                    <?php
                                    ShowRssFeedNews("Stock Market");
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
                <div class="col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Active
                            <div class="fa fa-globe pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                        ShowMostMoving();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Cryptocurrencies
                            <div class="fa fa-key pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Price</th>
                                                    <th>Change</th>
                                                    <th>Percent</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Gains
                            <div class="fa fa-arrow-up pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                        ShowMostGains();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Losses
                            <div class="fa fa-arrow-down pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                        ShowMostLosses();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>