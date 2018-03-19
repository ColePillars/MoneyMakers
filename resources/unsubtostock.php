<?php 
//Start session
session_start();
//Includes
include('../resources/connection.php');
//Query to remove description
$RemoveSubscriptionSQL = "DELETE FROM UserCredentials.tbl_stock_subs WHERE atr_stocksubid = '" . $_SESSION['username'] . "_" . $_POST['Symbol'] . "';";
if ($conn->query($RemoveSubscriptionSQL) == TRUE){
    //push user back to the stock page
    header('Location: ../pages/stockpage.php?Symbol=' . $_POST['Symbol']);
    exit();
}
?>