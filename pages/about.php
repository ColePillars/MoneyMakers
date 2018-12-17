<?php
session_start();
include ('../resources/logininclude.php');
include ('../resources/functions.php');
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
		<?php include ('../pageelements/navbar.php'); ?>
		<div id="page-wrapper" style="padding-top:60px">
			<?php include ('../pageelements/stockcarousel.php'); ?>
			<div class="container">
				<div id="section1">
					<h1>What is Money Makers?</h2>
					<h4 class="mb-4">Money Makers is a stock viewing and suggestion website. Individual stock pages (such as <a href="/pages/stockpage.php?Symbol=F">Ford</a>) exist which show: recent data points in table and graph form, an RSS feed of recent news related to the stock, the advice on whether to buy, sell, or to hold the stock, company information, and <a href="#section4">Potential and Market Gains.</a> Stock data is updated daily as too reflect current trends. </h4>
					</br>
				</div>
				<div id="section2">
					<h1>Why should I create an account?</h1>
					<h4>Creating an account allows you to follow the stocks that you want to consistently view. The carousel at the top of the page will be customized with the stocks that you have followed, allowing for quicker access.</h4>
					</br>
				</div>
				<div id ="section3">
					<h1>How do we determine we should buy, sell, or hold a stock?</h1>
					<h4>Money Makers uses a variety of self implemented trading strategies in combination to determine the future of a stock. These include the <a href="https://stockcharts.com/school/doku.php?id=chart_school:trading_strategies:rsi2">2-period RSI,</a> the <a href="https://stockcharts.com/school/doku.php?id=chart_school:chart_analysis:heikin_ashi">Heikin-Ashi methods,</a> and the <a href="https://stockcharts.com/school/doku.php?id=chart_school:trading_strategies:narrow_range_day_nr7">Narrow Range method.</a><h4>
					</br>
				</div>
				<div id ="section4">
                                        <h1>What is the Simulation tab? What are Potential and Market Gains?</h1>
                                        <h4>The basic idea of the simulation tab is this: How much money would you lose/gain if you had consistently invested following our advice (potential gains) compared with just holding the stock(market gains)? The values are generated by running a simulation on the last 100 stock data points with a theoretical $1000. Potential gains is then calculated by going through each data point and buying/selling when our algorithm says too. Market gains are simply calculated by buying the stock at the beginning and then selling it at the end. This allows you to compare how our algorithms perform compared to the market. The values are expressed in percentages (ex. Market Gains: -31.56% means the market loses 31 percent of the theoretical $1000 over the last 100 day).<h4>
                                        </br>
                                </div>
				<div id="section5">
					<h1>Who are we?</h1>
					<h4>This website was created by: Gjergji Heqimi, Pete Iacona, Eric Le, Cole Pillars, and Carl Welland. This project was our Senior Design Project at Oakland University during the Winter 2018 semester.</h4>
					</br>
				</div>
			<div>
		</div>
		<?php include ('../pageelements/footer.php'); ?>
	</div>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/metisMenu/metisMenu.min.js"></script>
	<script src="../vendor/raphael/raphael.min.js"></script>
	<script src="../vendor/morrisjs/morris.min.js"></script>
	<script src="../data/morris-data.js"></script>
	<script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>
