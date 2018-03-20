<?php 
session_start();
include('connection.php');
include('stockfunctions.php');

//getting all subscribed stocks and their user
$GetSubbedStocksSQL  = "
SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs ORDER BY atr_stock_id ASC";
//Looping through each distinct stock, storing last 100 point, ignore values that are stored
$GetSubbedStocksResult = mysqli_query($conn, $GetSubbedStocksSQL);
if ($GetSubbedStocksResult->num_rows > 0){    
    while($row = $GetSubbedStocksResult->fetch_assoc()) {
        
        sleep(1);
        FetchDailyJSON($row['atr_stock_id']);
        sleep(1);
        FetchRSIJSON($row['atr_stock_id'], "daily", "100");
    }
}

?>