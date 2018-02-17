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

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      
  function drawChart() {
    var data = google.visualization.arrayToDataTable([

        <?php 
   			 for ($i=0; $i < 100; $i++) {
   			     $open = $array[$i][2];
   			     $high = $array[$i][3];
   			     $low = $array[$i][4];
   			     $close = $array[$i][5];
   			     if ($i == 99) {
   			         echo '[ \''.$i.'\', '.$low.', '.$open.', '.$close.', '.$high.']';
   			     } else {
   			         echo '[ \''.$i.'\', '.$low.', '.$open.', '.$close.', '.$high.'],';
   			     }
   			 }
   	  ?>

    	  
//       ['Mon', 20, 28, 38, 45],
//       ['Tue', 31, 38, 55, 66],
//       ['Wed', 50, 55, 77, 80],
//       ['Thu', 77, 77, 66, 50],
//       ['Fri', 68, 66, 22, 15]
      // Treat first row as data as well.
    ], true);

    var options = {
      legend:'none'
    };

    var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>