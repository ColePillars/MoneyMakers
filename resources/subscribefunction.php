<?php
// This page makes insert queries to UserCredentials.tbl_stock_subs

// starting session
session_start();
// access to custom functions
include ('../resources/functions.php');
// including database connection file
include ('../resources/connection.php');

//Test $_GET['Symbol']
$_GET['Symbol']=AB;
//Get variable values
$UserName = mysqli_escape_string($conn, $_SESSION['username']);
$Symbol = mysqli_escape_string($conn, $_GET['Symbol']);
// SQL query to see if user is already subbed to current stock
$CheckUserSubbed = "SELECT * FROM UserCredentials.tbl_stock_subs
 WHERE atr_username ='" . $UserName . "' AND atr_stock_id = '" . $Symbol . "';";
$result = mysqli_query($conn, $CheckUserSubbed);
$count = mysqli_num_rows($result);

// If $count == 0, then the user is not subbed to this stock.
if ($count == 0) {
    // Insert stock sub into database. SUBSCRIBE
    $InsertStockSubsSQL = "
INSERT INTO UserCredentials.tbl_stock_subs (atr_username, atr_stock_id)
VALUES ('" . $UserName . "', '" . $Symbol . "');";
} else {
    // Remove stock sub from database. UNSUBSCRIBE
    $DeleteStockSubsSQL = "
    DELETE FROM UserCredentials.tbl_stock_subs WHERE atr_username = '" . $UserName . "'
    AND atr_stock_id = '" . $Symbol . "';";
}

// checking echo error if so, DEV PURPOSE ONLY!
if ($conn->query($CheckUserSubbed) === TRUE) {} else {
    echo "Error: " . $CheckUserSubbed . "<br>" . $conn->error;
}
if ($conn->query($InsertStockSubsSQL) === TRUE) {} else {
    echo "Error: " . $InsertStockSubsSQL . "<br>" . $conn->error;
}
if ($conn->query($DeleteStockSubsSQL) === TRUE) {} else {
    echo "Error: " . $DeleteStockSubsSQL . "<br>" . $conn->error;
}
// close database connection
$conn->close();

// Go back to subscribebutton.php
$_SESSION['InvalidUpdateMessage'] = "Your subscription has changed!";
header('Location: ../pages/subscribebutton.php');
exit();
?>