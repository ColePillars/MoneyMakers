<?php 
// this function will fetch and store intradaily values given the parameters
// this function will fetch and store daily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 days!!

Function FetchDailyJSON($StockSymbol){
    
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
                    $MidQuery =  substr($MidQuery, 0, -2) . "','" . $StockSymbol . "_" . $Timestamp . "');";
                   // echo $MidQuery . "<br>";
                   $conn->query($MidQuery) ? null : $all_query_ok = false;
                    
                }

                $count = $count + 1;
        }

    }
    
}

// this function will fetch and store daily adjusted (cumulative) values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 days!!
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

// this function will fetch and store weekly values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 WEEKS
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
            }
            $count = $count + 1;
        }
    }
}

function FetchRSIJSON($StockSymbol, $Interval, $TimePeriod){
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
            if($limit < 120){
                foreach ($TimeSeries as $ObjectHeader => $ObjectValue){
                    $MidQuery = $MidQuery . "'" . $ObjectValue . "',";
                }
                // If not meta data, append end of query statement
                if($count > 6){
                    $MidQuery =  substr($MidQuery, 0, -2) . "','" . $StockSymbol . "_" . $Timestamp . "');";
                    $conn->query($MidQuery) ? null : $all_query_ok = false;
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
?>