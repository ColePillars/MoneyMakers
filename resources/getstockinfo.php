<?php 

// include connections page
include('connection.php');
$Interval = "daily";
$StockSymbol= "F";
$TimePeriod = "100";


//Getting the json request into a PHP object
$Data = file_get_contents("https://www.alphavantage.co/query?function=RSI&symbol=" . $StockSymbol . "&interval=" . $Interval . "&time_period="
    . $TimePeriod . "&series_type=close&apikey=S7R0WLCOH163H1DE&datatype=json");


//Decoding the json into a php array.
$JSONData = json_decode($Data);

//Defining base query, will append each row to the query statement
$StartSQL = "INSERT IGNORE INTO StockInfo.Technical_Analysis_RSI(atr_stock_id,Timestamp,RSI,Composite_Key)
            VALUES('" . $StockSymbol . "',";

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
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            if($limit < 30){
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 6){
                $MidQuery =  substr($MidQuery, 0, -2) . "','" . $StockSymbol . "_" . $Timestamp . "');";
                echo $MidQuery . "<br>";
            // $conn->query($MidQuery) ? null : $all_query_ok = false;
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
 
?>