<?php 
//Start session
session_start();


//Includes
include('../resources/connection.php');
include('stockfunctions.php');
include('buysellmethods.php');
echo $_POST['Symbol'];

//Insert record for stock subscription
$SubToStockSQL = "INSERT INTO UserCredentials.tbl_stock_subs (atr_stocksubid,atr_username,atr_stock_id) VALUES ('" . $_SESSION['username'] . "_" . $_POST['Symbol'] . "','" . $_SESSION['username']  . "','" . $_POST['Symbol'] . "');";
if ($conn->query($SubToStockSQL) == TRUE){}

//checking if there are stocks that need to be update
$CheckOutdatedStockSQL = "

SELECT DISTINCT s.atr_stock_id, d.timestamp
FROM UserCredentials.tbl_stock_subs  as s

LEFT JOIN (

SELECT atr_stock_id, MAX(timestamp) as'timestamp'
    FROM StockInfo.Time_Series_Daily 

    GROUP BY atr_stock_id
) as d ON d.atr_stock_id = s.atr_stock_id
WHERE d.timestamp <> DATE(NOW())
ORDER BY atr_stock_id ASC

";
    
$CheckOutdatedStockResult = mysqli_query($conn, $CheckOutdatedStockSQL);
if ($CheckOutdatedStockResult->num_rows > 0){
    while($row = $CheckOutdatedStockResult->fetch_assoc()) {
        FetchDailyJSON($row['atr_stock_id']);
        FetchRSIJSON($row['atr_stock_id'], "daily", "100");
    }
}


    //Fetch daily information
    FetchDailyJSON($_POST['Symbol']);
    FetchRSIJSON($_POST['Symbol'], "daily", "100");
    
    //Determine buy/sell for Two_Period_RsE
    Two_Period_RSI();
    //Determine buy/sell for Heikin_Ashi
    Heikin_Ashi();
    //Make final buy/sell choice
    Final_Decision();

    //push user back to their stock page
    header('Location: ../pages/stockpage.php?Symbol=' . $_POST['Symbol']);
    exit();
    

?>