<?php
//Start session
session_start();
//Includes
include('../resources/connection.php');
include('stockfunctions.php');
include('buysellmethods.php');
//echo $_POST['Symbol'];
//Insert record for stock subscription
$SubToStockSQL = "INSERT INTO UserCredentials.tbl_stock_subs (atr_stocksubid,atr_username,atr_stock_id) VALUES ('" . $_SESSION['username'] . "_" . $_POST['Symbol'] . "','" . $_SESSION['username']  . "','" . $_POST['Symbol'] . "');";
if ($conn->query($SubToStockSQL) == TRUE){}
//Fetch daily information
FetchDailyJSONSub($_POST['Symbol']);
FetchRSIJSONSub($_POST['Symbol'], "daily", "100");

//Determine buy/sell for Two_Period_RsE
Two_Period_RSI();
//Determine buy/sell for Heikin_Ashi
Heikin_Ashi();
//Calculates potential gains
Sim($_POST['Symbol']);
//Make final buy/sell choice
Final_Decision();
//push user back to their stock page
header('Location: ../pages/stockpage.php?Symbol=' . $_POST['Symbol']);
exit();
?>