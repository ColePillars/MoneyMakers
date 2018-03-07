<?php
// This page makes insert queries to UserCredentials.tbl_stock_subs

// starting session
session_start();
// access to custom functions
include ('../resources/functions.php');
// including database connection file
include ('../resources/connection.php');

// SQL query to see if user is already subbed to current stock
$CheckUserSubbed = "SELECT * FROM UserCredentials.tbl_stock_subs
 WHERE atr_username ='" . $_SESSION['username'] . "' AND atr_stock_id = '" . $_GET['Symbol'] . "';";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

// If $count != 0, then the user is already subbed to this stock.
if ($count != 0) {
    // Remove stock sub from database. UNSUBSCRIBE
    $DeleteStockSubsSQL = "
    DELETE FROM UserCredentials.tbl_stock_subs WHERE atr_username = '" . $_SESSION['username'] . "'
    AND atr_stock_id = '" . $_GET['Symbol'] . "';";
} else {
    // Insert stock sub into database. SUBSCRIBE
    $InsertStockSubsSQL = "
INSERT INTO UserCredentials.tbl_stock_subs (atr_username, atr_stock_id)
VALUES ('" . $_SESSION['username'] . "', '" . $_GET['Symbol'] . "');";
}

// checking echo error if so, DEV PURPOSE ONLY!
if ($conn->query($InsertStockSubsSQL) === TRUE) {} else {
    echo "Error: " . $InsertStockSubsSQL . "<br>" . $conn->error;
}

// close database connection
$conn->close();

// Go back to subscribebutton.php
$_SESSION['InvalidUpdateMessage'] = "You are now subscribed!";
header('Location: ../pages/subscribebutton.php');
exit();
?>