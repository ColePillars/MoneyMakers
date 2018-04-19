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
        
        sleep(2);
        FetchDailyJSON($row['atr_stock_id']);
        sleep(3);
        FetchRSIJSON($row['atr_stock_id'], "daily", "100");
        sleep(1);
        Sim($row['atr_stock_id']);
        
        
        
    }
    
    //Determine buy/sell for Two_Period_RsE
    Two_Period_RSI();
    //Determine buy/sell for Heikin_Ashi
    Heikin_Ashi();
    //Make final buy/sell choice
    Final_Decision();
    
}


?>