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
    <title>Money Makers - Stock</title>
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div id="wrapper" style="min-height:400px">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div>
                <a href="index.php"><img class="navbar-left" style="max-width:175px;padding:6px" src="../resources/mm_logo.png" </img>
                </a>
                </div>
            <div class="col-md-3">
            	<form action="search.php" role="form" method="POST">	
                	<div class="form-group input-group" style="margin-top:16px;max-width:400px">
                    	<input type="text" class="form-control"  name="SearchString" id="SearchString" placeholder="Search stocks">
                    	<span class="input-group-btn">
                        	<button class="btn btn-info btn" type="submit"><i class="fa fa-search"></i>
                        	</button>
                    	</span>
                	</div>
                </form>
            </div>
            <div class="col-lg-6">
            </div>
            <?php
			session_start();
			if ($_SESSION['is_logged_in']){
		    include ('../resources/loggedinnav.php');
			//echo "test";
			}
			else {
			    echo "
						<div class='nav navbar-top-links navbar-right btn-lg' style='margin-top:12px;font-size:16px'>
							<a href='login.php'><i class='fa fa-sign-in fa-fw'></i> Login</a>
						</div>
				";
			}
			
			?>
        </nav>
        <div id="page-wrapper" style="padding:10px">
            <div class="row-eq-height">
                <div class="col-lg-12">
                    <h1></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row-eq-height">
                <div class="col-lg-3">
                    <div class="panel panel-primary" style="font-size:12px"> 
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-bar-chart fa-5x" style="margin-top:32px;display:block;text-align:center"></i>
                                </div>
                                <div class="col-xs-8">
                                    <div class="h3">
                                    <?php 
                                        include('../resources/connection.php');
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
                                            $_SESSION['InvalidStockMessage'] = " - " . $_GET['Symbol'] . " is an invalid stock";
                                            header('Location: search.php');
                                            exit();
                                        }
                                    ?>
                                    </div>
                                    <div style="margin-bottom:6px">Stock percent change</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#status-pills" data-toggle="tab">Status</a>
                                </li>
                          
                                <li><a href="#details-pills" data-toggle="tab">Details</a>
                                </li>
                                <?php 
                                    include('../resources/functions.php');
                                    //Showing the sub/unsub button
                                    ShowSubUnsubIcon();
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="status-pills">
                                    <!--<h4>Status</h4>-->
                                    <p><center style="font-size:28px"><?php
                                        include('../resources/connection.php');
                                        $status = "SELECT Final_Decision FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" .  $_GET['Symbol'] . "';";
                                        $statusResult = mysqli_query($conn, $status);
                                        if ($statusResult->num_rows > 0){
                                            while($row = $statusResult->fetch_assoc()) {
                                                echo $row['Final_Decision'];
                                            }
                                        }
                                        else{
                                            //echo "Advise on whether you should buy or sell right now";
                                        }?></center></p>
                                </div>
         
                                <div class="tab-pane fade" id="details-pills">
                                    <h3>Details:</h3>
                                    <?php 
                                        ShowCompanyInformation($_GET['Symbol']);
                                    ?>

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
                                       // include('../resources/functions.php');
                                        //output changes from the last ten days
                                        FetchLastTenDaysChart($_GET['Symbol']);
                                        ?>
                                    </div>
                                    <!-- /.table-responsive -->
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
                                        //Showing all stock related news for the cpmany name
                                        ShowRssFeedNews($StockFullName);         
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
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