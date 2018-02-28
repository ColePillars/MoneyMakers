<?php 

// this page holds all user written functions to be accesed
// database connections must be included within the function

//This function will check for empty input on registration test  informnation
function CheckEmptyRegistrationInput($Input, $Field){
    if(empty($Input)){
        $_SESSION['InvaliRegistrationMessage'] = "Please Fill Out The " . $Field . " Field";
        header('Location: register.php');
        exit();
    }
}

//This function will generate a random key for user registration and password reset
function GenerateRandomKey($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

Function SearchStockIndex($SearchString){
    
    //include database connection
    include ('connection.php');
    
    //Search all fields for the substring and dump results to table,
 
    $SearchSQL = "
    SELECT *
    FROM StockInfo.Stock_Symbol_Index
    WHERE Symbol LIKE '%" . $SearchString . "%'
    OR NAME LIKE '%" . $SearchString . "%'
    OR Sector LIKE '%" . $SearchString . "%'
    OR Industry LIKE '%" . $SearchString . "%'";
    
    //Execute SQL Query
    $SearchResult = mysqli_query($conn, $SearchSQL);
    if ($SearchResult->num_rows > 0){
          
        echo"<div class='panel-body'>
            <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>
            <thead>
            <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Sector</th>
            <th>Industry</th>
            </tr>
            </thead>
            <tbody>";
        
        
        while($row = $SearchResult->fetch_assoc()) {
            echo "
            <tr>
            <td><a href='../pages/stockpage.php?Symbol=" . $row['Symbol'] . "'>"  . $row['Symbol'] . "</a></td>
            <td>"  . $row['Name'] . "</td>
            <td>"  . $row['Sector'] . "</td>
            <td>"  . $row['Industry'] . "</td>
            </tr>";           
        } 
        
        echo "
        </tbody>
        </table>
        <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->";
        
    }  
}


//This function will show the last 10 day stock pricces and changes
Function FetchLastTenDaysChart($StockSymbol){
 
    // include connections page
    include('connection.php');
    //Counter to skip the 11th day
    $SkipCounter = 0;
    //Query to show the last 11days of close prices
    $ShowLastTenSQL = "SELECT atr_Stock_id, timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp > (SELECT DISTINCT Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 11) AND atr_Stock_id = '" . $StockSymbol . "' order by atr_stock_id ASC, Timestamp DESC";
    $SearchResult = mysqli_query($conn, $ShowLastTenSQL);
    if ($SearchResult->num_rows > 0){
        echo" <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Change</th>
                        <th>Change (%)</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $SearchResult->fetch_assoc()) {
            //Skipping the 11th day
            if ($SkipCounter <> 0) {
            //Computing difference between previous day and current day
            $Difference = round($row['Close'] - $PreviousClose,2);
            //Computing percent difference between previous day and current day
            $PDifference = round((($Difference / $PreviousClose) * 100),2) . "%";
               echo "
                <tr>
                <td>"  . substr($row['timestamp'], 0, 10) . "</td>
                <td>"  . $row['Close'] . "</td>
                <td>"  . $Difference .  "</td>
                <td>"  . $PDifference .  "</td>
                </tr>";
                //Storing close value for previous day.
                $PreviousClose = $row['Close'];
            }else{
               $PreviousClose = $row['Close'];
            }
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        echo "
       </tbody>
       </table>";    
    }  
}


//This function will output top five gains of stocks
//As of not it does not show subscribed stocks
Function ShowMostGains(){
    
    include('connection.php');
    
    //Query to show most gain
    $ShowMostGainsSQL = "
    SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', (((c.Close / y.Close)  -1 ) * 100) as 'ClosePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Close
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    ORDER BY ClosePercentChange DESC limit 5";
    
    
    $SearchResult = mysqli_query($conn, $ShowMostGainsSQL);
    if ($SearchResult->num_rows > 0){
        echo"<table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Change</th>
                        <th>Change (%)</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $SearchResult->fetch_assoc()) {
            echo "
            <tr>
            <td>"  . $row['atr_stock_id'] . "</td>
            <td>"  . $row['Close'] . "</td>
            <td>"  . $row['Change'] . "</td>
            <td>"  . $row['ClosePercentChange'] . "</td>
            </tr>";
                
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        echo "
           </tbody>
       </table>";
    }    
    
    
}


//This function will output top five gains of stocks
//As of not it does not show subscribed stocks
Function ShowMostLosses(){

    include('connection.php');
    
    //Query to show most gain
    $ShowMostLossesSQL = "
    SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', (((c.Close / y.Close)  -1 ) * 100) as 'ClosePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Close
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    ORDER BY ClosePercentChange ASC limit 5";

    
    $SearchResultLosses = mysqli_query($conn, $ShowMostLossesSQL);
    if ($SearchResultLosses->num_rows > 0){
        echo"<table class='table table-hover'>
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Price</th>
                                                    <th>Change</th>
                                                    <th>Change (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
        while($row = $SearchResultLosses->fetch_assoc()) {
            echo "
            <tr>
            <td>"  . $row['atr_stock_id'] . "</td>
            <td>"  . $row['Close'] . "</td>
            <td>"  . $row['Change'] . "</td>
            <td>"  . $row['ClosePercentChange'] . "</td>
            </tr>";
            
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        echo "
           </tbody>
       </table>";
    }
    else{
        echo "fail";
        echo $ShowMostLossesSQL;
    }
    

}


//This function will output graph of chosen stock
//Assumes graphing resources are included in page above
Function StockGraph($StockSymbol){
    
    include('connection.php');
    
    $sql = "SELECT * FROM StockInfo.Time_Series_Daily WHERE StockInfo.Time_Series_Daily.atr_stock_id ='".$StockSymbol."' ORDER BY Time_Series_Daily.Timestamp ASC";
    $result = mysqli_query($conn, $sql);
    
    if ($result -> num_rows > 0) {
        
        //Chartdiv style
        echo '
<style>
#chartdiv {
	width	: 100%;
	height	: 800px;
}										
</style>
        ';    
        
        //Original colors of amchart example
        //"fillColors": "#7f8da9",
        //"negativeFillColors": "#db4c3c"
        
        
        //1st half of chart script
        echo '
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
        "fillColors": "#28a745",
	    "highField": "high",
	    "lineColor": "#28a745",
	    "lineAlpha": 1,
	    "lowField": "low",
	    "fillAlphas": 0.9,
	    "negativeFillColors": "#dc3545",
	    "negativeLineColor": "#dc3545",
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
        ';
        
        //Stock data
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
        
        //2nd-half of chart script
        echo '
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
	  chart.zoomToIndexes( chart.dataProvider.length - 40, chart.dataProvider.length - 1 );
	}
</script>
        ';
        
        //Chart Div
        echo '
<div id="chartdiv"></div>
        ';
    
    }
}



?>