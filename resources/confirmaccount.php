<?php 

/*
 * This file will:
 * 1) extract information from url given for user registration
 * 2) clean input from $_GET
 * 3) check if user came from a valid url (the email confirmation)
 * 4) check if the key given by user matches key stored in database
 * 5) make new key to update stored key
 * 6) change usertype to normal
 * 7) push user to login.php 
 */



// starting session
session_start();
// access to custom functions
include ('functions.php');
//including database connection file
include ('connection.php');

//Getting information from verification link
$RegistrationKey = mysqli_escape_string($conn,$_GET['key']);
$UserName = mysqli_escape_string($conn,$_GET['username']);

// checking if user came from a valid url with key and username value
// if not re-route to registr mage with error message
if ($Key = NULL or $Username = NULL){
    $_SESSION['InvaliRegistrationMessage'] = "Oops! Something Went wrong! <br> Please try again";
    header('Location: ../pages/register.php');
    exit();
}

//check if the key and username match up to user_info
$CheckUserInfoSQL = "
        SELECT * FROM UserCredentials.tbl_user_info 
        WHERE atr_username = '" . $UserName . "' 
        AND atr_user_key = '" . $RegistrationKey . "';";

// exectue SQL query
$CheckUserInfoResult = mysqli_query($conn,$CheckUserInfoSQL);
// if there is one match for username and key
if($CheckUserInfoResult->num_rows == 1){
    // fetch new key to assign to user key
    $RandomKey = GenerateRandomKey();
    // query for changing user key
    $ResetKeySQL = "
        UPDATE UserCredentials.tbl_user_info 
        SET atr_user_key = '" . $RandomKey . "'
        WHERE atr_username = '" . $UserName . "';";
    // query for set user_type to normal
    $UpdateUserTypeSQL ="
        UPDATE UserCredentials.tbl_user_cred
        SET atr_type = 'normal'
        WHERE atr_username = '" . $UserName . "';";
    
    // execute SQL query to reset key
    if ($conn->query($ResetKeySQL) === TRUE){}
    else{
        //output mysql error if fail, DEV PURPOSE ONLY
        //MUST HANDEL ERROR
        echo "Error: " . $ResetKeySQL . "<br>" . $conn->error;
    }
    // execute SQL query to update user type
    if ($conn->query($UpdateUserTypeSQL) === TRUE){}
    else{
        //output mysql error if fail, DEV PURPOSE ONLY
        //MUST HANDEL ERROR
        echo "Error: " . $UpdateUserTypeSQL . "<br>" . $conn->error;
    }

   //push user to login page to log in     
    header("location: ../pages/login.php");
    exit(); 
}
else{
    //if user re-clicked this ling or made their own key
    $_SESSION['InvaliRegistrationMessage'] = "Oops! Something Went Wrong";
    header('Location: ../pages/register.php');
    exit();
  }

// close db connection
$conn->close();


?>