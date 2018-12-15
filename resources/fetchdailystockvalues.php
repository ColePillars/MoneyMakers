<?php 
session_start();
include('connection.php');
include('stockfunctions.php');
include('buysellmethods.php');

//getting all subscribed stocks and their user
$GetSubbedStocksSQL  = "
SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs ORDER BY atr_stock_id ASC";
//Looping through each distinct stock, storing last 100 point, ignore values that are stored
$GetSubbedStocksResult = mysqli_query($conn, $GetSubbedStocksSQL);
if ($GetSubbedStocksResult->num_rows > 0){    
    while($row = $GetSubbedStocksResult->fetch_assoc()) {
        
	echo (string) $row['atr_stock_id'] . "<br>";
        FetchDailyJSON($row['atr_stock_id']);
        sleep(15);
        FetchRSIJSON($row['atr_stock_id'], "daily", "100");
        Sim($row['atr_stock_id']);
	sleep(15);
        
        
    }
    
    //Determine buy/sell for Two_Period_RsE
    Two_Period_RSI();
    //Determine buy/sell for Heikin_Ashi
    Heikin_Ashi();
    //Make final buy/sell choice
    Final_Decision();
    
}


?>
