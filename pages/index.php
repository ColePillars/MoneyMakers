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
    <title>Money Makers - Home</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div id="wrapper" style="min-width:400px">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div>
                <a href="index.php"><img class="navbar-left" style="max-width:175px;padding:6px" src="../resources/mm_logo.png" </img>
                </a>
                </div>
            <div class="col-md-3">
            	<form action="search.php" role="form" method="POST">
               		<div class="form-group input-group" style="margin-top:16px;max-width:400px;min-width:200px">
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
						<div class='nav navbar-top-links navbar-right btn' style='margin-top:12px;font-size:16px'>
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
            <!-- /.row -->
            <div class="row-eq-height">
                <div class="col-lg-3">
                    <div class="chat-panel panel panel-green chat" style="height:615px">
                        <div class="panel-heading" style="font-size:12px">My Subs
                            <div class="fa fa-star pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="height:570px">
                            <div class="list-group-sm">
                                <div class="panel panel-default">
                                    <a href="stockpage.php">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-bar-chart fa-4x" style="margin-top:18px;display:block;text-align:center"></i>
                                                </div>
                                                <div class="col-xs-8" style="padding-left:10%;font-size:12px">
                                                    <div class="h4" style="margin-bottom:4px">Stock Name</div>
                                                    <div>Stock points</div>
                                                    <div>Stock change</div>
                                                    <div style="margin-bottom:6px">Stock % change</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="panel panel-default">
                                    <a href="stockpage.php">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-bar-chart fa-4x" style="margin-top:18px;display:block;text-align:center"></i>
                                                </div>
                                                <div class="col-xs-8" style="padding-left:10%;font-size:12px">
                                                    <div class="h4" style="margin-bottom:4px">Stock Name</div>
                                                    <div>Stock points</div>
                                                    <div>Stock change</div>
                                                    <div style="margin-bottom:6px">Stock % change</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="panel panel-default">
                                    <a href="stockpage.php">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-bar-chart fa-4x" style="margin-top:18px;display:block;text-align:center"></i>
                                                </div>
                                                <div class="col-xs-8" style="padding-left:10%;font-size:12px">
                                                    <div class="h4" style="margin-bottom:4px">Stock Name</div>
                                                    <div>Stock points</div>
                                                    <div>Stock change</div>
                                                    <div style="margin-bottom:6px">Stock % change</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="panel panel-default">
                                    <a href="stockpage.php">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <i class="fa fa-bar-chart fa-4x" style="margin-top:18px;display:block;text-align:center"></i>
                                                </div>
                                                <div class="col-xs-8" style="padding-left:10%;font-size:12px">
                                                    <div class="h4" style="margin-bottom:4px">Stock Name</div>
                                                    <div>Stock points</div>
                                                    <div>Stock change</div>
                                                    <div style="margin-bottom:6px">Stock % change</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-3">
                    <!-- /.panel -->
                    <div class="panel panel-yellow" style="height:615px">
                        <div class="panel-heading" style="font-size:12px">News
                            <div class="fa fa-rss pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="chat-panel panel panel-default">
                            <div class="panel-body" style="font-size:12px;height:562px">
                                <ul class="chat">
                                <?php 
                                    include('../resources/functions.php');
                                    //Showing all stock related news for the stock market
                                    ShowRssFeedNews("Stock Market");
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
                    <!-- /.panel -->
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
                                    <!-- /.table-responsive -->
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
                                                    <th>Change (%)</th>
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
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- /.panel -->
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Gains
                            <div class="fa fa-arrow-up pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                            ShowMostGains();
                                        ?>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Losses
                            <div class="fa fa-arrow-down pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                            //Cannot include function.php, breaks for some reason?
                                            ShowMostLosses();
                                        ?>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
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