<?php 
// this function will fetch and store intradaily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 HOURS!!
function FetchIntraDaily($StockSymbol, $Interval){
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


//MONTHLY, Monthly Adjusted, and Crypto Currencies


// this function will fetch and store monthly values given the parameters
//RETURNS 100 DATA POINTS
function FetchMonthlyJSON($StockSymbol){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_MONTHLY&symbol=" . $StockSymbol . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Monthly(atr_stock_id,Timestamp,Open,High,Low,Close,Volume)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 3){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 3){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }
}



// this function will fetch and store monthly adjusted values given the parameters
//RETURNS 100 DATA POINTS
function FetchMonthlyAdjustedJSON($StockSymbol){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_MONTHLY_ADJUSTED&symbol=" . $StockSymbol . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Monthly_Adjusted(atr_stock_id,Timestamp,Open,High,Low,Close,Adjusted_Close,Volume,Dividend_Amount)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 3){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 3){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }
}


// this function will fetch and store monthly adjusted values given the parameters
//RETURNS 100 DATA POINTS
function FetchCryptoIntradayJSON($StockSymbol, $Market){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=DIGITAL_CURRENCY_INTRADAY&symbol=" . $StockSymbol . "&market=" . $Market . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Crypto_Intraday(atr_stock_id,Timestamp,Price_Market,Price_USD,Volume,Market_Cap_USD)
            VALUES('" . $StockSymbol . "',";
    
    //Counter to skip metadata
    $count = 0;
    
    //Looping through each json object
    foreach ($JSONData  as $JSONObject){
        //Loop through each day
        foreach ($JSONObject as $Timestamp => $TimeSeries){
            //if not meta data, append the time stamp to insert
            if($count > 7){
                $MidQuery = $StartSQL;
                $MidQuery = $MidQuery . "'" . $Timestamp . "',";
            }
            //loop through each value, open, high, low, close, volume, append to insert query
            foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
            }
            // If not meta data, append end of query statement
            if($count > 7){
                $MidQuery =  substr($MidQuery, 0, -2) . "');";
                if ($conn->query($MidQuery) == TRUE){}
            }
            $count = $count + 1;
        }
    }
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


// this function will fetch and store monthly adjusted values given the parameters
//RETURNS 100 DATA POINTS
function FetchCryptoWeeklyJSON($StockSymbol, $Market){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=DIGITAL_CURRENCY_WEEKLY&symbol=" . $StockSymbol . "&market=" . $Market . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Crypto_Weekly(atr_stock_id,Timestamp,Open_Market,Open_USD,High_Market,High_USD,Low_Market,Low_USD,Close_Market,Close_USD,Volume,Market_Cap_USD)
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


// this function will fetch and store monthly adjusted values given the parameters
//RETURNS 100 DATA POINTS
function FetchCryptoMonthlyJSON($StockSymbol, $Market){
    
    // include connections page
    include('connection.php');
    
    //Getting the json request into a PHP object
    $Data = file_get_contents("https://www.alphavantage.co/query?function=DIGITAL_CURRENCY_MONTHLY&symbol=" . $StockSymbol . "&market=" . $Market . "&apikey=S7R0WLCOH163H1DE&datatype=json");
    
    //Decoding the json into a php array.
    $JSONData = json_decode($Data);
    
    //Defining base query, will append each row to the query statement
    $StartSQL = "INSERT INTO StockInfo.Time_Series_Crypto_Monthly(atr_stock_id,Timestamp,Open_Market,Open_USD,High_Market,High_USD,Low_Market,Low_USD,Close_Market,Close_USD,Volume,Market_Cap_USD)
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
                echo $MidQuery;
            }
            $count = $count + 1;
        }
    }
}
?>