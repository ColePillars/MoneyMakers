<?php 

include ('../resources/connection.php');

$StockName = mysqli_escape_string($conn,$_GET['stockname']);

$sql = "SELECT * FROM StockInfo.Time_Series_Daily_Adjusted WHERE StockInfo.Time_Series_Daily_Adjusted.atr_stock_id ='".$StockName."' ORDER BY Time_Series_Daily_Adjusted.Timestamp ASC";

$result = mysqli_query($conn, $sql);
?>
<!-- Styles -->
<style>
#chartdiv {
	width	: 100%;
	height	: 500px;
}										
</style>

<!-- Resources -->
<script src="../graphing/amcharts/amcharts.js"></script>
<script src="../graphing/amcharts/serial.js"></script>
<script src="../graphing/amcharts/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="../graphing/amcharts/plugins/export/export.css" type="text/css" media="all" />
<!-- <script src="../graphing/amcharts/themes/chalk.js"></script> -->

<!-- Chart code -->
<script>
var chart = AmCharts.makeChart( "chartdiv", {
	  "type": "serial",
	  "theme": "none",
	  "dataDateFormat":"YYYY-MM-DD",
	  "valueAxes": [ {
	    "position": "left"
	  } ],
	  "graphs": [ {
	    "id": "g1",
	    "balloonText": "Open:<b>[[open]]</b><br>Low:<b>[[low]]</b><br>High:<b>[[high]]</b><br>Close:<b>[[close]]</b><br>",
	    "closeField": "close",
	    "fillColors": "#7f8da9",
	    "highField": "high",
	    "lineColor": "#7f8da9",
	    "lineAlpha": 1,
	    "lowField": "low",
	    "fillAlphas": 0.9,
	    "negativeFillColors": "#db4c3c",
	    "negativeLineColor": "#db4c3c",
	    "openField": "open",
	    "title": "Price:",
	    "type": "candlestick",
	    "valueField": "close"
	  } ],
	  "chartScrollbar": {
	    "graph": "g1",
	    "graphType": "line",
	    "scrollbarHeight": 30
	  },
	  "chartCursor": {
	    "valueLineEnabled": true,
	    "valueLineBalloonEnabled": true
	  },
	  "categoryField": "date",
	  "categoryAxis": {
	    "parseDates": true
	  },
	  "dataProvider": [ {
		  <?php
		  if ($result -> num_rows > 0) {
		      $var = 0;
		      while($row = $result->fetch_assoc()) {
		          if ($var == 0) {
		              echo '"date": "'.substr($row['Timestamp'], 0, -9).'",';
		              echo '"open": "'.$row['Open'].'",';
		              echo '"high": "'.$row['High'].'",';
		              echo '"low": "'.$row['Low'].'",';
		              echo '"close": "'.$row['Close'].'"';
		          }
		          else {
		              echo '}, {';
		              echo '"date": "'.substr($row['Timestamp'], 0, -9).'",';
		              echo '"open": "'.$row['Open'].'",';
		              echo '"high": "'.$row['High'].'",';
		              echo '"low": "'.$row['Low'].'",';
		              echo '"close": "'.$row['Close'].'"';
		          }
		          $var++;
		      }
		      echo '} ],';
		  }
		  ?>
	  "export": {
	    "enabled": true,
	    "position": "bottom-right"
	  }
	} );

	chart.addListener( "rendered", zoomChart );
	zoomChart();

	// this method is called when chart is first inited as we listen for "dataUpdated" event
	function zoomChart() {
	  // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
	  chart.zoomToIndexes( chart.dataProvider.length - 10, chart.dataProvider.length - 1 );
	}
</script>

<!-- HTML -->
<div id="chartdiv"></div>	