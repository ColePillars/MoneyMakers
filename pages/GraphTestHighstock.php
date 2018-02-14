<?php 

include ('../resources/connection.php');

$sql = "SELECT * FROM StockInfo.Time_Series_Crypto_Daily ORDER BY Time_Series_Crypto_Daily.Timestamp ASC";
$result = mysqli_query($conn, $sql);

$array = Array();

if ($result -> num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $values = Array();
        
        array_push($values, $row['atr_stock_id']);
        array_push($values, $row['Timestamp']);
        array_push($values, $row['Open_USD']);
        array_push($values, $row['High_USD']);
        array_push($values, $row['Low_USD']);
        array_push($values, $row['Close_USD']);
        
        array_push($array, $values);
        
        unset($values);
    }
}

// foreach ( $array as $var ) {
//     echo '</br>';
//     echo $var[0];
//     echo '  ';
//     echo $var[1];
//     echo '  ';
//     echo $var[2];
// }

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Highstock Example</title>

		<style type="text/css">

		</style>
	</head>
	<body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="../graphing/highstock.js"></script>
<script src="../graphing/exporting.js"></script>

	<div id="container" style="height: 400px; min-width: 310px"></div>
		<script type="text/javascript">
		$(function () { 
		    var myChart = Highcharts.chart('container', {
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Fruit Consumption'
		        },
		        xAxis: {
		            categories: ['Apples', 'Bananas', 'Oranges']
		        },
		        yAxis: {
		            title: {
		                text: 'Fruit eaten'
		            }
		        },
		        series: [{
		            name: 'Jane',
		            data: [1, 0, 4]
		        }, {
		            name: 'John',
		            data: [5, 7, 3]
		        }]
		    });
		});
		</script>
	</body>
</html>

