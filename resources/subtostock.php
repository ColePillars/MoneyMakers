<?php 
//Start session
session_start();
//Includes
include('../resources/connection.php');
include('stockfunctions.php');
include('buysellmethods.php');

echo "HELLO<br>";
//Insert record for stock subscription
$SubToStockSQL = "INSERT INTO UserCredentials.tbl_stock_subs (atr_stocksubid,atr_username,atr_stock_id) VALUES ('" . $_SESSION['username'] . "_" . $_POST['Symbol'] . "','" . $_SESSION['username']  . "','" . $_POST['Symbol'] . "');";
if ($conn->query($SubToStockSQL) == TRUE){}

echo "FAM<br>";
//Fetch daily stock market values
FetchDailyJSON($_POST['Symbol']);
echo "WHAT<br>";
//Fetch RSI values
FetchRSIJSON($_POST['Symbol'], "daily", "100");
echo "WHY<br>";

//Determine buy/sell for Two_Period_RsE
//Two_Period_RSI();
//Determine buy/sell for Heikin_Ashi
//Heikin_Ashi();
//Make final buy/sell choice
//Final_Decision();

//Simulation();

//push user back to their stock page
header('Location: ../pages/stockpage.php?Symbol=' . $_POST['Symbol']);
exit();



?>