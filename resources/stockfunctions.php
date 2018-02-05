<?php 
// this function will fetch and store intradaily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 HOURS!!
//CSV is depreciated, use the JSON functions
function FetchIntraDailyCSV($StockSymbol, $Interval){
    //including db connectoin
    include('connection.php');
  
    //URL to get api data, from user input
    $data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" . $StockSymbol . "&interval=" . $Interval . "&apikey=S7R0WLCOH163H1DE&datatype=csv");
    //Split the response into rows via each array element is an array
    $rows = explode("\n",$data);
    
    //enable variable to skip headers
    $HeaderSkip = 0;
    
    //Loop through each row
    foreach($rows as $row) {
        
        //Skip the header row
        if ($HeaderSkip == 0){
            $HeaderSkip = 1;
            goto HeaderSkip;
        }
        
        //Split each row up into columns by comma
        $DataFields[] = str_getcsv($row);
        //loop through ech column
        foreach ($DataFields as $DataColumn){
            //Query for inserting each row 
            $InsertStockRowSQL = "
            INSERT INTO StockInfo.Time_Series_Intradaily(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume)
            VALUES ('" . $StockSymbol . "','" . $DataColumn[0] ."','" . $DataColumn[1] ."','" . $DataColumn[2] ."','" . $DataColumn[3] ."','" . $DataColumn[4] ."','" . $DataColumn[5] . "');";
            //Execute SQL query to update user type
            if ($conn->query($InsertStockRowSQL) == TRUE){}
        }
        //To skip the headers
        HeaderSkip:
    }
}


// this function will fetch and store intradaily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 HOURS!!
Function FetchIntraDailyJSON($StockSymbol, $Interval){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" . $StockSymbol . "&interval=". $Interval . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Intradaily(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 5){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 5){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }   
}


// this function will fetch and store intradaily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 HOURS!!
Function FetchDailyJSON($StockSymbol){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $StockSymbol . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Daily(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 4){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 4){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }
}

// this function will fetch and store intradaily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 HOURS!!
Function FetchDailyAdjustedJSON($StockSymbol){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $StockSymbol . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Daily_Adjusted(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 4){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 4){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }
}

// this function will fetch and store intradaily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 HOURS!!
Function FetchWeeklyJSON($StockSymbol){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_Weekly&symbol=" . $StockSymbol . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Weekly(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 4){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 4){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }
}


?>