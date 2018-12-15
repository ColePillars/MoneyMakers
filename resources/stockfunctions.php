<?php
// this function will fetch and store intradaily values given the parameters
// this function will fetch and store daily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 days!!
function FetchDailyJSON($StockSymbol){
    
    // include connections page
    include('connection.php');
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&outputsize=compact&symbol=" . $StockSymbol . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT IGNORE INTO StockInfo.Time_Series_Daily(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume,Composite_Key)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    //$count = 0;
    $limit = 0;

    
    
    
    $all_query_ok = true;
    $conn->begin_transaction();
    
    //Looping through each json object
    
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if ($Timestamp < 6) continue;
            echo $StockSymbol . " daily " . $Timestamp . "\n";
	    if ($limit < 100) {
		$existsQuery = "SELECT * FROM StockInfo.Time_Series_Daily WHERE Timestamp = '" . $Timestamp . "' and atr_stock_id = '" . $StockSymbol . "'";
                $existsResult = mysqli_query($conn, $existsQuery);
                if (mysqli_num_rows($existsResult) == 0) {
                    $MidQuery = $StartSQL;
                    $MidQuery = $MidQuery . "'" . $Timestamp . "',";
                    //loop through each value, open, high, low, close, volume, append to insert query
                    foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                        $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
                    }
                    $MidQuery =  substr($MidQuery, 0, -2) . "','" . $StockSymbol . "_" . $Timestamp . "');";
                    echo $MidQuery . " \n";
                    $conn->query($MidQuery) ? null : $all_query_ok = false;
	            $limit = $limit + 1;
		}
            }
	    else {
		break;
	    }
        }
    }
    
    
    //Commits changes if ALL queries succeed
    if ($all_query_ok) { $conn->commit(); }
    
    //Rollback changes if ANY query fails
    else { $conn->rollback(); }
    
    
}

function FetchRSIJSON($StockSymbol, $Interval, $TimePeriod){
    //ob_start();
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=RSI&symbol=" . $StockSymbol . "&interval=" . $Interval . "&time_period="
        . $TimePeriod . "&series_type=close&apikey=S7R0WLCOH163H1DE&datatype=json");
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT IGNORE INTO StockInfo.Technical_Analysis_RSI(atr_stock_id,Timestamp,RSI,Composite_Key)
            VALUES('" . $StockSymbol . "',";

    $limit = 0;
    
    $all_query_ok = true;
    $conn->begin_transaction();
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if ($Timestamp < 8) continue;
	    echo $StockSymbol . " rsi " . $Timestamp . " \n";
	    if ($limit < 100) {
            	$existsQuery = "SELECT * FROM StockInfo.Technical_Analysis_RSI WHERE Timestamp = '" . $Timestamp . "' and atr_stock_id = '" . $StockSymbol . "'";
	    	$existsResult = mysqli_query($conn, $existsQuery);
	    	if (mysqli_num_rows($existsResult) == 0) {
                    $MidQuery = $StartSQL;
                    $MidQuery = $MidQuery . "'" . $Timestamp . "',";
                    //loop through each value, open, high, low, close, volume, append to insert query
                    foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                        $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
                    }
                    // If not meta data, append end of query statement
                    $MidQuery =  substr($MidQuery, 0, -2) . "','" . $StockSymbol . "_" . $Timestamp . "');";
		    echo $MidQuery . " \n";
                    $conn->query($MidQuery) ? null : $all_query_ok = false;
		}
                $limit = $limit + 1;
            }
	    else {
		break;
	    }

        }
    }
    
    //Commits changes if ALL queries succeed
    if ($all_query_ok) { $conn->commit(); }
    
    //Rollback changes if ANY query fails
    else { $conn->rollback(); }
}
Function FetchDailyJSONSub($StockSymbol){
    
    // include connections page
    include('connection.php');
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&outputsize=compact&symbol=" . $StockSymbol . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT IGNORE INTO StockInfo.Time_Series_Daily(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume,Composite_Key)
            VALUES('" . $StockSymbol . "',";
    
    
    //getting max date to not break everything
    $MaxDateSQL = "SELECT MAX(Timestamp) as 'MaxTime' FROM StockInfo.Time_Series_Daily";
    $MaxDateResult = mysqli_query($conn, $MaxDateSQL);
    if ($MaxDateResult->num_rows > 0) {
        while($row = $MaxDateResult->fetch_assoc()) {
            
            $MaxDate = $row['MaxTime'];
        }
    }

    //Counter to skip metadata
    $count = 0;
    
    $all_query_ok = true;
    $conn->begin_transaction();
    
    //Looping through each json object
   
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 4){
                $MidQuery = $StartSQL;
                $SkipInsert = False;
                if (date('Ymd', strtotime($MaxDate)) < date('Ymd', strtotime($Timestamp))){
                    $SkipInsert = True;
                }
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }

            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            
            // If not meta data, append end of query statement
            if($count > 4){
                $MidQuery =  substr($MidQuery, 0, -2) . "','" . $StockSymbol . "_" . $Timestamp . "');";
                // echo $MidQuery . "<br>";
                if ($SkipInsert == False){
                    
                    $conn->query($MidQuery) ? null : $all_query_ok = false;
                }

            }
            
            $count = $count + 1;
        }
        
    }
    
    //Commits changes if ALL queries succeed
    if ($all_query_ok) { $conn->commit(); }
    
    //Rollback changes if ANY query fails
    else { $conn->rollback(); }
    
    
    
}
function FetchRSIJSONSub($StockSymbol, $Interval, $TimePeriod){
    ob_start();
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=RSI&symbol=" . $StockSymbol . "&interval=" . $Interval . "&time_period="
        . $TimePeriod . "&series_type=close&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT IGNORE INTO StockInfo.Technical_Analysis_RSI(atr_stock_id,Timestamp,RSI,Composite_Key)
            VALUES('" . $StockSymbol . "',";
    
    
    
    //getting max date to not break everything
    $MaxDateSQL = "SELECT MAX(Timestamp) as 'MaxTime' FROM StockInfo.Time_Series_Daily";
    $MaxDateResult = mysqli_query($conn, $MaxDateSQL);
    if ($MaxDateResult->num_rows > 0) {
        while($row = $MaxDateResult->fetch_assoc()) { 
            $MaxDate = $row['MaxTime'];
        }
    }

    //Counter to skip metadata
    $count = 0;
    $limit = 0;
    
    $all_query_ok = true;
    $conn->begin_transaction();
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 6){
                $MidQuery = $StartSQL;
                $SkipInsert = False;
                if (date('Ymd', strtotime($MaxDate)) < date('Ymd', strtotime($Timestamp))){
                    $SkipInsert = True;
                }
                
                
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            if($limit < 107){
                foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                    $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
                }
                // If not meta data, append end of query statement
                if($count > 6){
                    $MidQuery =  substr($MidQuery, 0, -2) . "','" . $StockSymbol . "_" . $Timestamp . "');";
                    if($SkipInsert == False){
                        
                        $conn->query($MidQuery) ? null : $all_query_ok = false;
                    }
                }
                $count = $count + 1;
                $limit = $limit + 1;
            }
        }
    }
    
    //Commits changes if ALL queries succeed
    if ($all_query_ok) { $conn->commit(); }
    
    //Rollback changes if ANY query fails
    else { $conn->rollback(); }
    
}
// this function will fetch and store monthly adjusted values given the parameters
//RETURNS 100 DATA POINTS
function FetchCryptoDailyJSON($StockSymbol, $Market){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=DIGITAL_CURRENCY_DAILY&symbol=" . $StockSymbol . "&market=" . $Market . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Crypto_Daily(atr_stock_id,Timestamp,Open_Market,Open_USD,High_Market,High_USD,Low_Market,Low_USD,Close_Market,Close_USD,Volume,Market_Cap_USD)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 6){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 6){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }
}
?>
