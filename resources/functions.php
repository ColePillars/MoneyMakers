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
    
    //cleaning search input
    $SearchString = mysqli_escape_string($conn, $SearchString);
    
    
    //Search all fields for the substring and dump results to table,
    $SearchSQL = "
    SELECT *
    FROM StockInfo.Stock_Symbol_Index
    WHERE Symbol LIKE '%" . $SearchString . "%'
    OR NAME LIKE '%" . $SearchString . "%'
    OR Sector LIKE '%" . $SearchString . "%'
    OR Industry LIKE '%" . $SearchString . "%'
    LIMIT 500";
    
    //Execute SQL Query
    $SearchResult = mysqli_query($conn, $SearchSQL);
    if ($SearchResult->num_rows > 0) {
        echo '
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Symbol</th>
                                <th>Name</th>
                                <th>Sector</th>
                                <th>Industry</th>
                            </tr>
                        </thead>
                        <tbody>';
        while($row = $SearchResult->fetch_assoc()) {
            echo "
                            <tr>
                                <td>" . $row['Symbol'] . "</td>
                                <td><a href='stockpage.php?Symbol=" . $row['Symbol'] . "'>" . $row['Name'] . "</a></td>
                                <td><a href='search.php?SearchString=" . $row['Sector'] . "'>" . $row['Sector'] . "</a></td>
                                <td><a href='search.php?SearchString=" . $row['Industry'] . "'>" . $row['Industry'] . "</a></td>
                            </tr>";         
        } 
        echo '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';
        
    }  
    else {
        $SearchSQLNothing = "
        SELECT *
        FROM StockInfo.Stock_Symbol_Index
        LIMIT 500";
        
        //Execute SQL Query
        $SearchResultNothing = mysqli_query($conn, $SearchSQLNothing);
        if ($SearchResultNothing->num_rows > 0){
            echo '
            <h3>No matching search results</h3>';
            echo '
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Symbol</th>
                                    <th>Name</th>
                                    <th>Sector</th>
                                    <th>Industry</th>
                                </tr>
                            </thead>
                            <tbody>';
            while($row = $SearchResultNothing->fetch_assoc()) {
                echo '
                                <tr>
                                    <td><a href="../pages/stockpage.php?Symbol='.$row["Symbol"].'">'.$row["Symbol"].'</a></td>
                                    <td>'.$row["Name"].'</td>
                                    <td>'.$row["Sector"].'</td>
                                    <td>'.$row["Industry"].'</td>
                                </tr>';
            }
            echo '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';   
        }   
    }
}


//This function will show the last 10 day stock pricces and changes
Function FetchLastTenDaysChart($StockSymbol){
    
    // include connections page
    include('connection.php');
    //Counter to skip the 11th day
    $SkipCounter = 0;
    $Output = array();
    //Query to show the last 11days of close prices
    $ShowLastTenSQL = "SELECT atr_Stock_id, DATE_FORMAT(timestamp, '%m-%d-%y') as 'timestamp', Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp >
(SELECT DISTINCT Timestamp FROM StockInfo.Time_Series_Daily WHERE atr_stock_id ='" . $StockSymbol . "' ORDER BY Timestamp DESC LIMIT 1 offset 11) AND atr_Stock_id = '" . $StockSymbol . "'
 order by atr_stock_id ASC, Timestamp ASC";
    $SearchResult = mysqli_query($conn, $ShowLastTenSQL);
    if ($SearchResult->num_rows > 0){
        echo" <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Price ($)</th>
                        <th>Change</th>
                        <th>Percent</th>
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
                array_push($Output,(string)substr($row['timestamp'], 0, 10));
                array_push($Output,(string)$row['Close']);
                array_push($Output,(string)$Difference);
                array_push($Output,(string)$PDifference);
                //Storing close value for previous day.
                $PreviousClose = $row['Close'];
            }else{
                $PreviousClose = $row['Close'];
            }
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        for($i=39; $i >= 3; $i-=4){
            // Date, Price, Change, Percent
            echo "
                <tr>
                <td>"  . $Output[$i-3] . "</td>
                <td>"  . $Output[$i-2] . "</td>
                ";
            if ($Output[$i-1] > 0) {
                echo"
                    <td style='color:#28a745'>"  . $Output[$i-1] .  "</td>
                    <td style='color:#28a745'> <i class='fa fa-lg fa-caret-up'> </i> "  . abs($Output[$i]) .  "%</td>
                    </tr>";
            }
            elseif ($Output[$i-1] < 0) {
                echo"
                    <td style='color:#dc3545'>"  . $Output[$i-1] .  "</td>
                    <td style='color:#dc3545'> <i class='fa fa-lg fa-caret-down'> </i> "  . abs($Output[$i]) .  "%</td>
                    </tr>";
            }
            elseif ($Output[$i-1] == 0) {
                echo"
                    <td style='color:#337ab7'>"  . $Output[$i-1] .  "</td>
                    <td style='color:#337ab7'> <i class='fa fa-lg fa-minus'> </i> "  . abs($Output[$i]) .  "%</td>
                    </tr>";
            }
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
    SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Close
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    AND (c.Close  - y.Close) > 0     
    ORDER BY ClosePercentChange DESC limit 5";
    
    
    $SearchResult = mysqli_query($conn, $ShowMostGainsSQL);
    if ($SearchResult->num_rows > 0){
        echo"<table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th>Price ($)</th>
                        <th>Change</th>
                        <th>Percent</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $SearchResult->fetch_assoc()) {
            echo "
            <tr>
            <td>"  . $row['atr_stock_id'] . "</td>
            <td>"  . $row['Close'] . "</td>";
            if ($row['Change']> 0) {
                echo"
                    <td style='color:#28a745'>"  . $row['Change'].  "</td>
                    <td style='color:#28a745'> <i class='fa fa-lg fa-caret-up'> </i> "  . $row['ClosePercentChange'].  "% </td>
                    </tr>";
            }
            elseif ($row['Change']< 0) {
                echo"
                    <td style='color:#dc3545'>"  . $row['Change'].  "</td>
                    <td style='color:#dc3545'> <i class='fa fa-lg fa-caret-down'> </i> "  . $row['ClosePercentChange'].  "% </td>
                    </tr>";
            }
            elseif ($row['Change']== 0) {
                echo"
                    <td style='color:#337ab7'>"  . $row['Change'].  "</td>
                    <td style='color:#337ab7'> <i class='fa fa-lg fa-minus'> </i> "  . $row['ClosePercentChange'].  "% </td>
                    </tr>";
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
Function ShowMostLosses(){

    include('connection.php');
    
    //Query to show most gain
    $ShowMostLossesSQL = "
    SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Close
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    AND (c.Close  - y.Close) < 0    
    ORDER BY ClosePercentChange ASC limit 5";

    
    $SearchResultLosses = mysqli_query($conn, $ShowMostLossesSQL);
    if ($SearchResultLosses->num_rows > 0){
        echo"<table class='table table-hover'>
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Price ($)</th>
                                                    <th>Change</th>
                                                    <th>Percent</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
        while($row = $SearchResultLosses->fetch_assoc()) {
            echo "
            <tr>
            <td>"  . $row['atr_stock_id'] . "</td>
            <td>"  . $row['Close'] . "</td>";
            if ($row['Change']> 0) {
                echo"
                    <td style='color:#28a745'>"  . $row['Change'].  "</td>
                    <td style='color:#28a745'> <i class='fa fa-lg fa-caret-up'> </i> "  . $row['ClosePercentChange'].  "% </td>
                    </tr>";
            }
            elseif ($row['Change']< 0) {
                echo"
                    <td style='color:#dc3545'>"  . $row['Change'].  "</td>
                    <td style='color:#dc3545'> <i class='fa fa-lg fa-caret-down'> </i> "  . $row['ClosePercentChange'].  "% </td>
                    </tr>";
            }
            elseif ($row['Change']== 0) {
                echo"
                    <td style='color:#337ab7'>"  . $row['Change'].  "</td>
                    <td style='color:#337ab7'> <i class='fa fa-lg fa-minus'> </i> "  . $row['ClosePercentChange'].  "</td>
                    </tr>";
            }
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



//This function will output top moving stocks
//As of not it does not show subscribed stocks
Function ShowMostMoving(){
    
    include('connection.php');
    
    //Query to show most gain
    $ShowMostMovingSQL = "

    SELECT  c.atr_stock_id, ROUND((c.Volume/1000000),2) as 'Volume', c.Timestamp, ROUND(((c.Volume  - y.Volume)/1000000),2) as 'Change', ROUND((((c.Volume / y.Volume)  -1 ) * 100)/1000,2) as 'VolumePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Volume
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    ORDER BY (c.Volume  - y.Volume)  DESC limit 5


        



";
    
    
    $ShowMostMovingResults = mysqli_query($conn, $ShowMostMovingSQL);
    if ($ShowMostMovingResults->num_rows > 0){
        echo"<table class='table table-hover'>
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Volume</th>
                                                    <th>Change</th>
                                                    <th>Percent</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
        while($row = $ShowMostMovingResults->fetch_assoc()) {
            echo "
            <tr>
            <td>"  . $row['atr_stock_id'] . "</td>
            <td>"  . $row['Volume'] . " M </td>";
            if ($row['Change']> 0) {
                echo"
                    <td style='color:#337ab7'>"  . $row['Change'].  " M </td>
                    <td style='color:#337ab7'> <i class='fa fa-lg fa-caret-up'> </i> "  . $row['VolumePercentChange'].  " K </td>
                    </tr>";
            }
            elseif ($row['Change']< 0) {
                echo"
                    <td style='color:#337ab7'>"  . $row['Change'].  " M </td>
                    <td style='color:#337ab7'> <i class='fa fa-lg fa-caret-down'> </i> "  . $row['VolumeePercentChange'].  " K </td>
                    </tr>";
            }
            elseif ($row['Change']== 0) {
                echo"
                    <td style='color:#337ab7'>"  . $row['Change'].  " M </td>
                    <td style='color:#337ab7'> <i class='fa fa-lg fa-minus'> </i> "  . $row['VolumePercentChange'].  " K </td>
                    </tr>";
            }
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        echo "
           </tbody>
       </table>";
    }
    else{
        echo "fail";
        echo $ShowMostMovingResults;
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
	height	: 85vh;
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

//This function will output sparkline of chosen stock
//Assumes graphing resources are included in page above
Function StockSparkline($StockSymbol){
    
    include('connection.php');
    
    $sql = "SELECT * FROM StockInfo.Time_Series_Daily WHERE StockInfo.Time_Series_Daily.atr_stock_id ='".$StockSymbol."' ORDER BY Time_Series_Daily.Timestamp ASC LIMIT 10";
    $result = mysqli_query($conn, $sql);
    
    if ($result -> num_rows > 0) {
        
        //Chartdiv style
        echo '
<style>
#chartdiv {
    width: 100%;
    height: 500px;
}
</style>
        ';
        
        //1st half of chart script
        echo '
<script>
AmCharts.makeChart( "'.$StockSymbol.'Graph", {
    "type": "serial",
    "theme": "light",

    "dataProvider": [ {
        ';
        
        //Stock data
        $var = 1;
        while($row = $result->fetch_assoc()) {
            if ($var == 1) {
                echo '"day": '.$var.',';
                echo '"value": '.$row['Close'];
            }
            else {
                echo '}, {';
                echo '"day": '.$var.',';
                echo '"value": '.$row['Close'];
            }
            $var++;
        }
        echo '} ],';
        
        //2nd-half of chart script
        echo '
    "categoryField": "day",
    "autoMargins": false,
    "marginLeft": 0,
    "marginRight": 5,
    "marginTop": 0,
    "marginBottom": 0,
    "graphs": [ {
        "valueField": "value",
        "bulletField": "bullet",
        "showBalloon": false,
        "lineColor": "#a9ec49"
    } ],
    "valueAxes": [ {
        "gridAlpha": 0,
        "axisAlpha": 0
    } ],
    "categoryAxis": {
        "gridAlpha": 0,
        "axisAlpha": 0,
        "startOnAxis": true
    }
} );
</script>
        ';
        
        //Chart Div
        echo '
<div class="chart-block" style="display: block; margin-left: auto;margin-right: auto;">
    <div id="'.$StockSymbol.'Graph" style="vertical-align: middle; display: inline-block; width: 100%; height: 50px;"></div>
</div>
        ';
        
    }
    
}

Function PotentialGains($initialMoney, $numberOfDays, $commission, $stockSymbol) {
    
    include('../resources/connection.php');
    $finalSellPrice;
    $stock = 0;
    $money = $initialMoney;
    $sql = "SELECT * FROM ( SELECT * FROM StockInfo.Simulation WHERE StockInfo.Simulation.Symbol = '".$stockSymbol."' ORDER BY StockInfo.Simulation.Timestamp DESC LIMIT ".$numberOfDays." ) AS tmp ORDER BY Timestamp ASC";
    unset($_SESSION['array1']);
    unset($_SESSION['array2']);
    unset($_SESSION['array3']);
    unset($_SESSION['array4']);
    unset($_SESSION['array5']);
    $array1 = array(); //Date
    $array2 = array(); //Close
    $array3 = array(); //Buy/Sell
    $array4 = array(); //Stock
    $array5 = array(); //Money
    
    $result = mysqli_query($conn, $sql);
    if ($result -> num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //Final Decision is to BUY
            if ($row['Final_Decision'] == "Buy") {
                //Have enough money to buy
                if ($money >= $row['Close']) {
                    $effectiveRate = (1 + $commission) * $row['Close'];
                    $tempStock = floor($money / $effectiveRate);
                    $money = $money - ($tempStock * $effectiveRate);
                    $stock = $stock + $tempStock;
                    array_push($array1, substr($row['Timestamp'],5,5));
                    array_push($array2, $row['Close']);
                    array_push($array3, $row['Final_Decision']);
                    array_push($array4, $stock);
                    array_push($array5, $money);
                }
            }
            //Final Decision is to SELL
            if ($row['Final_Decision'] == "Sell") {
                //Own stock to sell
                if ($stock > 0) {
                    $effectiveRate = (1 - $commission) * $row['Close'];
                    $money = $money + ($stock * $effectiveRate);
                    $stock = 0;
                    array_push($array1, substr($row['Timestamp'],5,5));
                    array_push($array2, $row['Close']);
                    array_push($array3, $row['Final_Decision']);
                    array_push($array4, $stock);
                    array_push($array5, $money);
                }
            }
            $finalSellPrice = $row['Close'];
        }
    }
    $effectiveRate = (1 - $commission) * $finalSellPrice;
    $total = $money + ($stock * $effectiveRate);
    $percent = 100 * (($total / $initialMoney) - 1);
    $_SESSION['array1'] = $array1;
    $_SESSION['array2'] = $array2;
    $_SESSION['array3'] = $array3;
    $_SESSION['array4'] = $array4;
    $_SESSION['array5'] = $array5;
    return $percent;
}

Function MarketGains($initialMoney, $numberOfDays, $commission, $stockSymbol) {
    
    include('../resources/connection.php');
    $finalSellPrice;
    $stock = 0;
    $money = $initialMoney;
    $sql = "SELECT * FROM ( SELECT * FROM StockInfo.Simulation WHERE StockInfo.Simulation.Symbol = '".$stockSymbol."' ORDER BY StockInfo.Simulation.Timestamp DESC LIMIT ".$numberOfDays." ) AS tmp ORDER BY Timestamp ASC";
    
    
    $result = mysqli_query($conn, $sql);
    if ($result -> num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($money >= $row['Close']) {
                $effectiveRate = (1 + $commission) * $row['Close'];
                $tempStock = floor($money / $effectiveRate);
                $money = $money - ($tempStock * $effectiveRate);
                $stock = $stock + $tempStock;
            }
            $finalSellPrice = $row['Close'];
        }
    }
    $effectiveRate = (1 - $commission) * $finalSellPrice;
    $total = $money + ($stock * $effectiveRate);
    $percent = 100 * (($total / $initialMoney) - 1);
    return $percent;
}

Function MaximumGains($initialMoney, $numberOfDays, $commission, $stockSymbol) {
    
    include('../resources/connection.php');
    $finalSellPrice;
    $stock = 0;
    $money = $initialMoney;
    $sql1 = "SET @rownr1 = 0";
    $sql2 = "SET @rownr2 = 0";
    $sql3 = "
    SELECT tmp1.Symbol, tmp1.Close1 as 'Close1' ,tmp1.Timestamp1, (@rownr1 := @rownr1 + 1) AS rowNumber, tmp2.Close2 , tmp2.Timestamp2
    FROM (
        SELECT tmp1.Symbol, tmp1.Close as 'Close1' ,tmp1.Timestamp as 'Timestamp1', (@rownr1 := @rownr1 + 1) AS rowNumber
        FROM StockInfo.Simulation as tmp1
        WHERE tmp1.Symbol = '".$stockSymbol."'
        ORDER BY tmp1.Timestamp DESC LIMIT ".$numberOfDays."
        ) as tmp1
        INNER JOIN (
            SELECT Symbol, Close as 'Close2', Timestamp as 'Timestamp2', (@rownr2 := @rownr2 + 1) AS rowNumber
            FROM StockInfo.Simulation
            WHERE StockInfo.Simulation.Symbol = '".$stockSymbol."'
            ORDER BY StockInfo.Simulation.Timestamp DESC LIMIT ".$numberOfDays." OFFSET 1
            ) AS tmp2
            ON tmp1.rowNumber = tmp2.rowNumber
            ORDER BY tmp1.Timestamp1 ASC
    ";
    
    $conn->query($sql1);
    $conn->query($sql2);
    
    $result3 = mysqli_query($conn, $sql3);
    if ($result3 -> num_rows > 0) {
        while($row = $result3->fetch_assoc()) {
            if ($row['Close2'] < $row['Close1']) {
                if ($money >= $row['Close2']) {
                    $effectiveRate = (1 + $commission) * $row['Close2'];
                    $tempStock = floor($money / $effectiveRate);
                    $money = $money - ($tempStock * $effectiveRate);
                    $stock = $stock + $tempStock;
                }
            }
            if ($row['Close2'] > $row['Close1']) {
                if ($stock > 0) {
                    $effectiveRate = (1 - $commission) * $row['Close2'];
                    $money = $money + ($stock * $effectiveRate);
                    $stock = 0;
                }
            }
            $finalSellPrice = $row['Close2'];
        }
    }
    $effectiveRate = (1 - $commission) * $finalSellPrice;
    $total = $money + ($stock * $effectiveRate);
    $percent = 100 * (($total / $initialMoney) - 1);
    return $percent;
}


//this function will determine what button to output for the sub/unsub button
Function ShowSubUnsubIcon(){

    include('../resources/connection.php');
    //check if user is already subbd to this stock
    $CheckIfSubbedSQL = "SELECT * FROM UserCredentials.tbl_stock_subs WHERE atr_username='" . $_SESSION['username'] . "' AND atr_stock_id='" . $_GET['Symbol'] . "';";
    $CheckSubResults = mysqli_query($conn, $CheckIfSubbedSQL);

    if ($CheckSubResults->num_rows > 0){
        echo "
           <button type='button' class='btn btn-success btn-outline btn-circle btn-l pull-right' data-toggle='modal' data-target='#submodal' style='margin-top:6px;;'><i class='fa fa-check fa-lg'></i>
            </button>
            <div class='modal fade' id='submodal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>

                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h3 class='modal-title' id='myModalLabel'>Unsubscribe from stock</h3>
                        </div>
                        <div class='modal-body'>
                            This stock will be removed from your subscribed stock carousel
                        </div>
                        <div class='modal-footer'>
                          <form action='../resources/unsubtostock.php' method='POST' id='form1'>
                        	<input type='hidden' name='Symbol' value = '"  . $_GET['Symbol'] . "'>
                        </form>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                            <button type='submit'class='btn btn-success'  form='form1' Value='Sumbit'>Okay</button>
                        </div>
                    </div>
                </div>
            </div>";
    }
    else{
        //at this point user is not subbed, but there still may be stock info here
        //check this stock exsits but user isnt subbed
        $CheckIfStockExists = "SELECT * FROM StockInfo.Time_Series_Daily WHERE atr_stock_id='" . $_GET['Symbol'] . "';";
        $CheckIfStockExistsResults = mysqli_query($conn, $CheckIfStockExists);
        if ($CheckIfStockExistsResults->num_rows > 0){
        
            echo "
               <button type='button' class='btn btn-success btn-outline btn-circle btn-l pull-right' data-toggle='modal' data-target='#submodal' style='margin-top:6px;;'><i class='fa fa-plus fa-lg'></i>
                </button>
                <div class='modal fade' id='submodal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>

                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h3 class='modal-title' id='myModalLabel'>Subscribe to stock</h3>
                            </div>
                            <div class='modal-body'>
                                This stock will be added to your subscribed stock carousel
                            </div>
                            <div class='modal-footer'>
                              <form action='../resources/subtostock.php' method='POST' id='form1'>
                            	<input type='hidden' name='Symbol' value = '"  . $_GET['Symbol'] . "'>
                            </form>
                                <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                                <button type='submit'class='btn btn-success'  form='form1' Value='Submit'>Okay</button>
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }

        else{
            //at this point we dont hold stock info for this item, which means the user isnt subbed
            $_SESSION['Subscribe'] = true;
            
            echo "
                  <button type='button' class='btn btn-success btn-outline btn-circle btn-l pull-right'  style='margin-top:6px'><i class='fa fa-refresh fa-spin fa-lg'></i>
                </button>
                   <div   id='submodal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='
                       height: 300px;
                       position: absolute;
                       left: 150%;
                       top: 50%;
                       margin-left: -150px;
                       margin-top: -150px;'>             
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h3 class='modal-title' id='myModalLabel'>Subscribe to stock</h3>
                            </div>
                            <div class='modal-body'>
                                  Subscribe to this stock to view detailed information?
                            </div>
                            <div class='modal-footer'>
                              <form action='../resources/subtostock.php' method='POST' id='form1'>
                            	<input type='hidden' name='Symbol' value = '"  . $_GET['Symbol'] . "'>
                            </form>
                                <a href='search.php'><button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button></a>
                                <button type='submit'class='btn btn-success'  form='form1' Value='Sumbit'>Okay</button>
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }
    }   
}


Function ShowCompanyInformation($Symbol){

 include('connection.php');
 
 $FetchStockMetaInfo = "SELECT Sector, Industry FROM StockInfo.Stock_Symbol_Index WHERE Symbol='" . $Symbol . "';";
 
 $FetchStockMetaResults = mysqli_query($conn, $FetchStockMetaInfo);
 if ($FetchStockMetaResults->num_rows > 0){
     
     while($row = $FetchStockMetaResults->fetch_assoc()) {
         echo "<p style='font-size:12px'><b style='font-weight:bold'>Industry: </b>" . $row['Industry'] . "</p>";
         echo "<p style='font-size:12px'><b style='font-weight:bold'>Sector: </b>" . $row['Sector'] . "</p>";
     }    
 } 
}


Function ShowRssFeedNews($Topic){
    
    $Topicleaned=str_replace(' ','%20', $Topic);
    echo $test2;
    $googlersssource = "https://news.google.com/news/rss/search/section/q/" . $Topicleaned . "/" . $Topicleaned . "?hl=en&gl=US&ned=us";
    $xml = simplexml_load_file($googlersssource);
    for($itemcounter = 0; $itemcounter < 10; $itemcounter++){
        $title = $xml->channel->item[$itemcounter]->title;
        $href = $xml->channel->item[$itemcounter]->link;
        $date = $xml->channel->item[$itemcounter]->pubDate;
        
        echo "
                                        <li>
                                        <div class='chat-body clearfix'>
                                            <div class='header'>
                                              <a  href='" . $href . "'><strong class='primary-font'>" . $title . "</strong></a>
                                                <small class='text-muted'><br>
                                                <i class='fa fa-clock-o fa-fw'></i>" . $date . "
                                            </small>
                                            </div>
                                        </div>
                                    </li>";
    }
}

Function ShowSubbedStocks()
{
    include ('connection.php');
    $GetSubbedStocksSQL = "    SELECT  c.atr_stock_id, c.Close, c.Timestamp, n.Name, ROUND((c.Close  - y.Close), 2) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Close
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
	INNER JOIN
	(
		SELECT DISTINCT atr_stock_id
		FROM UserCredentials.tbl_stock_subs
		WHERE atr_username = '" . $_SESSION['username'] . "'
	) as s on c.atr_stock_id= s.atr_stock_id
    INNER JOIN StockInfo.Stock_Symbol_Index as n ON c.atr_stock_id = n.Symbol
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    ORDER BY ClosePercentChange;";
    
    $GetSubbedStocksResults = mysqli_query($conn, $GetSubbedStocksSQL);
    if ($GetSubbedStocksResults->num_rows > 0) {
        
        while ($row = $GetSubbedStocksResults->fetch_assoc()) {
            echo "
            <div class='panel panel-default' style='margin-bottom:10px'>
                <a href='stockpage.php?Symbol=" . $row['atr_stock_id'] . "'>
                    <div style='width: 100%' class='panel-heading'>
                        <div class='row'>";
            
//                             <div class='col-xs-4'>
//                                 <i class='fa fa-bar-chart fa-4x' style='margin-top: 32px; display: block; text-align: center'></i>
//                             </div>
                            
            StockSparkline($row['atr_stock_id']);
                            
            echo "
    	                    <div class='col-xs-8' style='padding-left: 10%'>
                                <div class='h5'><b>" . $row['Name'] . "</b>
                                </div>
                                <div style='font-size:90%';>
                                    Price ($): " . $row['Close'] . "
                                </div>
                                <div style='font-size:90%';>
                                    Change: " . $row['Change'] . "
                                </div>
                                <div style='margin-bottom: 3px; font-size:90%'>
                                    Percent: " . $row['ClosePercentChange'] . "
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
		    </div>";
        }
    }
}



?>