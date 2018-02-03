<?php
// This page makes update queries to database
// to edit user info

// starting session
session_start();
// access to custom functions
include ('../resources/functions.php');
// including database connection file
include ('../resources/connection.php');

// Gets values from profilepage.php
$UserName = mysqli_escape_string($conn, $_POST['username']);
$FirstName = mysqli_escape_string($conn, $_POST['firstname']);
$LastName = mysqli_escape_string($conn, $_POST['lastname']);
$EmailAddress = mysqli_escape_string($conn, $_POST['email']);
$Phone = mysqli_escape_string($conn, $_POST['phone']);
$StreetAddress = mysqli_escape_string($conn, $_POST['address']);
$City = mysqli_escape_string($conn, $_POST['city']);
$State = mysqli_escape_string($conn, $_POST['state']);
$Zip = mysqli_escape_string($conn, $_POST['zip']);

// checking that user did not forget/bypass population of any fields
CheckEmptyRegistrationInput($UserName, "UserName");
CheckEmptyRegistrationInput($EmailAddress, "Email Address");
CheckEmptyRegistrationInput($FirstName, "First Name");
CheckEmptyRegistrationInput($LastName, "Last Name");

// check if email address if valid
if (filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {} else {
    // push user back to register if email is not valid
    $_SESSION['InvalidUpdateMessage'] = "Email address is invalid";
    header('Location: ../pages/profilepage.php');
    exit();
}

// check if username / email is already being used
// construct SQL query
$CheckUserNameTakenSQL = "SELECT * FROM UserCredentials.tbl_user_info
 WHERE atr_username ='" . $UserName . "' OR atr_email ='" . $EmailAddress . "';";

// // execute SQL Query
$CheckUserNameTakenResult = mysqli_query($conn, $CheckUserNameTakenSQL);
if ($CheckUserNameTakenResult->num_rows > 1) {
    while ($row = $CheckUserNameTakenResult->fetch_assoc()) {
        // Checks if both email and username are both in use
        if ($row['atr_email'] == $EmailAddress && $row['atr_username'] == $UserName && $_SESSION['username']!= $UserName) {
            $_SESSION['InvalidUpdateMessage'] = "Email Address and Username Are Being Used Already<br/><a href='../pages/profilepage.php'></a>";
            header('Location: ../pages/profilepage.php');
            exit();
        }
        // checking if email is already being used
        if ($row['atr_email'] == $EmailAddress && $_SESSION['username']!=$UserName) {
            // push user back to register if email is already being used
            $_SESSION['InvalidUpdateMessage'] = "Email Address Is Being Used Already<br /><a href ='../pages/profilepage.php'> </a>";
            header('Location: ../pages/profilepage.php');
            exit();
        }
        // checking if username is already being used
        if ($row['atr_username'] == $UserName && $_SESSION['username']!=$UserName) {
            // push user back to register if username is already being used
            // potentiallyr revoke forgot password link
            $_SESSION['InvalidUpdateMessage'] = "Username Is Being Used Already <br /><a href ='profilepage.php'></a>";
            header('Location: ../pages/profilepage.php');
            exit();
        }
    }
}

// store user information and key into database
$UpdateUserInfoSQL = "
        UPDATE UserCredentials.tbl_user_info
        SET atr_username = '" . $UserName . "',
        atr_first_name = '" . $FirstName . "',
        atr_last_name = '" . $LastName . "',
        atr_email = '" . $EmailAddress . "',
        atr_phone = '" . $Phone . "',
        atr_street_address = '" . $StreetAddress . "',
        atr_city = '" . $City . "',
        atr_state = '" . $State . "',
        atr_zip= '" . $Zip . "' 
        WHERE  '" . $_SESSION['username'] . "'=atr_username;";

// store user credentials into database
$UpdateUserCredentialsSQL = "
        
        UPDATE UserCredentials.tbl_user_cred
        SET atr_username = '" . $UserName . "'
        WHERE  '" . $_SESSION['username'] . "'=atr_username;";

// Change session variable
$_SESSION['username'] = $UserName;

// Update user info in the database
// checking echo error if so, DEV PURPOSE ONLY!

if ($conn->query($UpdateUserInfoSQL) === TRUE) {} else {
    echo "Error: " . $UpdateUserInfoSQL . "<br>" . $conn->error;
}
// add user credentials to database
// Checking echo error if so, DEV PURPOSE ONLY!
if ($conn->query($UpdateUserCredentialsSQL) === TRUE) {} else {
    echo "Error:
" . $UpdateUserCredentialsSQL . "<br>" . $conn->error;
}
// close database connection
$conn->close();

// Go back to profilepage.php
$_SESSION['InvalidUpdateMessage'] = "Your profile information has been updated!";
header('Location: ../pages/profilepage.php');
exit();
?>