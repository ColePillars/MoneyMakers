<?php
include ('logininclude.php');
$_GET['Symbol'] = F;
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
<style>
.center {
	margin: auto;
	width: 10%;
}
</style>
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">
<link href="../vendor/morrisjs/morris.css" rel="stylesheet">
<link href="../vendor/font-awesome/css/font-awesome.min.css"
	rel="stylesheet" type="text/css">

<!-- Graphing Resources, scripts must stay above StockGraph function -->
<script src="../graphing/amcharts/amcharts.js"></script>
<script src="../graphing/amcharts/serial.js"></script>
<script src="../graphing/amcharts/plugins/export/export.min.js"></script>
<link rel="stylesheet"
	href="../graphing/amcharts/plugins/export/export.css" type="text/css"
	media="all" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation"
			style="margin-bottom: 0">
			<div>
				<a href="index.php"><img class="navbar-left"
					style="max-width: 225px; padding: 6px"
					src="../resources/mm_logo.png"</img> </a>
			</div>
			<div class="col-md-3">
				<form action="search.php" role="form" method="POST">
					<div class="form-group-lg input-group"
						style="margin-top: 16px; max-width: 400px">
						<input type="text" class="form-control" name="SearchString"
							id="SearchString" placeholder="Search stocks"> <span
							class="input-group-btn">
							<button class="btn btn-info btn-lg" type="submit">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</div>
				</form>
			</div>
			<div class="col-lg-6"></div>
            <?php
            session_start();
            if ($_SESSION['is_logged_in']) {
                include ('../resources/loggedinnav.php');
                // echo "test";
            } else {
                echo "
						<div class='nav navbar-top-links navbar-right btn-lg' style='margin-top:12px'>
							<a href='login.php'><i class='fa fa-sign-in fa-fw'></i> Login</a>
						</div>
				";
            }
            
            ?>
        </nav>
		<div id="page-wrapper">
		   <?php 
// Test $_GET['Symbol']
                  // $_GET['Symbol'] = AB;
                  // Get variable values
    $UserName = mysqli_escape_string($conn, $_SESSION['username']);
    $Symbol = mysqli_escape_string($conn, $_GET['Symbol']);
    
    // SQL query to see if user is already subbed to current stock
    $CheckUserSubbed = "SELECT * FROM UserCredentials.tbl_stock_subs
 WHERE atr_username ='" . $UserName . "' AND atr_stock_id = '" . $Symbol . "';";
    $result = mysqli_query($conn, $CheckUserSubbed);
    $count = mysqli_num_rows($result);
    ?>
			<div class="row-eq-height">
				<div class="panel-body center">
					<form role="form" action="../resources/bothsubfunction.php"
						method="GET" name="subscription"
						
						<fieldset>
							<!-- takes user to bothsubfunction.php-->
							<div class="form-group">
								<input type="submit"
									class="<?php
        if ($count == 0) {
            echo "btn btn-lg btn-succes";
        } else {
            echo "btn btn-lg btn-danger";
        }
        ?>"
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
				<div class="col-lg-12">
					<h1 class="page-header"></h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<div class="row-eq-height">

				<div class="col-lg-3">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-bar-chart fa-5x"
										style="margin-top: 32px; display: block; text-align: center"></i>
								</div>
								<div class="col-xs-8">
									<div class="h2">
                                    <?php
                                    include ('../resources/connection.php');
                                    $GetStockName = "SELECT Name FROM StockInfo.Stock_Symbol_Index WHERE Symbol = '" . $_GET['Symbol'] . "';";
                                    $SearchResult = mysqli_query($conn, $GetStockName);
                                    if ($SearchResult->num_rows > 0) {
                                        while ($row = $SearchResult->fetch_assoc()) {
                                            echo $row['Name'];
                                        }
                                    } else {
                                        // if no results, push user to another page
                                    }
                                    ?>
                                    </div>
									<div style="margin-bottom: 6px">Stock percent change</div>
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<ul class="nav nav-pills">
								<li class="active"><a href="#status-pills" data-toggle="tab">Status</a>
								</li>
								<li><a href="#history-pills" data-toggle="tab">History</a></li>
								<li><a href="#details-pills" data-toggle="tab">Details</a></li>
								<button type="button"
									class="btn btn-warning btn-circle btn-l pull-right"
									data-toggle="modal" data-target="#submodal"
									style="margin-top: 6px">
									<i class="fa fa-star fa-lg"></i>
								</button>
								<div class="modal fade" id="submodal" tabindex="-1"
									role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
									style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h3 class="modal-title" id="myModalLabel">Subscribe to stock</h3>
											</div>
											<div class="modal-body">This stock will appear in "My Subs"
												on your homepage</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default"
													data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-success"
													data-dismiss="modal">Okay</button>
											</div>
										</div>
									</div>
								</div>
							</ul>
						</div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="status-pills">
									<!--<h4>Status</h4>-->
									<p>
										<font size=9><center>
												<strong><?php
            include ('../resources/connection.php');
            $status = "SELECT Final_Decision FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $_GET['Symbol'] . "';";
            $statusResult = mysqli_query($conn, $status);
            if ($statusResult->num_rows > 0) {
                while ($row = $statusResult->fetch_assoc()) {
                    echo $row['Final_Decision'];
                }
            } else {
                // echo "Advise on whether you should buy or sell right now";
            }
            ?></strong>
											</center></font>
									</p>
								</div>
								<div class="tab-pane fade" id="history-pills">
									<h4>History</h4>
									<p>History of the stock, noting any significant events</p>
								</div>
								<div class="tab-pane fade" id="details-pills">
									<h4>Details</h4>
									<p>Tips on whether to invest or not</p>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="table-responsive">
                                        <?php
                                        include ('../resources/functions.php');
                                        // output changes from the last ten days
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
					<div class="panel panel-yellow">
						<div class="panel-heading" style="font-size: 18px">
							Stock News
							<div class="fa fa-rss pull-left"
								style="margin-right: 12px; margin-top: 3px"></div>
						</div>
						<div class="chat-panel panel panel-default">
							<div class="panel-body" style="height: 710px">
								<ul class="chat">
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 1</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 2</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 3</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 4</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 5</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 6</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 7</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 8</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 9</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 10</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
									<li class="left clearfix"><span class="chat-img pull-left"> <img
											src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
											class="img-circle">
									</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font">Story 11</strong> <small
													class="pull-right text-muted"> <i
													class="fa fa-clock-o fa-fw"></i> Date/Time
												</small>
											</div>
											<p>Story headline</p>
										</div></li>
								</ul>
							</div>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-4"></div>
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