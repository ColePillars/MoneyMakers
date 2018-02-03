<?php 
/*
 * This page wil:
 * 1) extract user information from register.php
 * 2) clean input to check against SQL injectin
 * 3) ensure user populated all fields 
 * 4) validate user enterered a valid email address
 * 5) check that user enetered password twice correctly (both passwords field match)
 * 6) validate user is not registered with username/email arelady
 * 7) generate key for email confirmation
 * 8) store user information and key into database
 * 9) store user credentials into database
 * 10) send an email confirmation to the user
 * 11) ask user to confirm account creationio via email
 */

//starting session
session_start();
//access to custom functions
include ('functions.php');
//including database connection file
include ('connection.php');

//Getting values from register.php
//Check user input for sql injection
$UserName = mysqli_escape_string($conn, $_POST['username']);
$EmailAddress = mysqli_escape_string($conn, $_POST['email']);
$FirstName = mysqli_escape_string($conn, $_POST['firstname']);
$LastName = mysqli_escape_string($conn, $_POST['lastname']);
$Password = mysqli_escape_string($conn, $_POST['password']);
$PasswordCheck = mysqli_escape_string($conn, $_POST['passwordcheck']);

//Checking that user did not forget/bypass population of any fields
CheckEmptyRegistrationInput($UserName, "UserName");
CheckEmptyRegistrationInput($EmailAddress, "Email Address");
CheckEmptyRegistrationInput($FirstName, "First Name");
CheckEmptyRegistrationInput($LastName, "Last Name");
CheckEmptyRegistrationInput($Password, "Password");
CheckEmptyRegistrationInput($PasswordCheck, "Password Twice");

//Check if email address if valid
if (filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {
}
else {
    //Push user back to register if email is not valid
    $_SESSION['InvaliRegistrationMessage'] = "Email address is invalid";
    header('Location: ../pages/register.php');
    exit();
}

//Check that the passwords user entered are the same
if ($Password <> $PasswordCheck) {
    //Push user back to register if email is already being used
    $_SESSION['InvaliRegistrationMessage'] = "Passwords must match";
    header('Location: ../pages/register.php');
    exit();
}

//Checks if password is in the correct form (8 characters, 1 uppercase, 1 number)
if ( (strlen($Password) < 8) || !(preg_match('@[A-Z]@', $Password)) || !(preg_match('@[0-9]@', $Password)) ) {
    //Push user back to register if password is in incorrect form
    $_SESSION['InvaliRegistrationMessage'] = "Password must have atleast 8 character with 1 uppercase and 1 number";
    header('Location: ../pages/register.php');
    exit();
}

//Check if username / email is already being used
//Construct SQL query
$CheckUserNameTakenSQL = "SELECT * FROM UserCredentials.tbl_user_info
 WHERE atr_username ='" . $UserName . "' OR atr_email ='" . $EmailAddress . "';";

//Execute SQL Query
$CheckUserNameTakenResult = mysqli_query($conn, $CheckUserNameTakenSQL);
if ($CheckUserNameTakenResult->num_rows > 0) {
    while($row = $CheckUserNameTakenResult->fetch_assoc()) {
       //Checking is email is already being used
        if ($row['atr_email'] == $EmailAddress) {
            //Push user back to register if email is already being used
            $_SESSION['InvaliRegistrationMessage'] = "Email Address Is Being Used Already<br><a href ='../pages/ForgotPassword.php'> Click Here To Reset Your Password.</a>";
            header('Location: ../pages/register.php');
            exit();
        }
        //Checking is username is already being used
        if ($row['atr_username'] == $UserName) {
            //Push user back to register if username is already being used
            //potentially revoke forgot password link
            $_SESSION['InvaliRegistrationMessage'] = "Username Is Being Used Already <br><a href ='../pages/ForgotPassword.php'> Click Here To Reset Your Password.</a>";
            header('Location: ../pages/register.php');
            exit(); 
        }
    }
} 

//Fetch random key for user registration
$RegistrationKey = GenerateRandomKey();

//Store user information and key into database
$InsertUserInfoSQL ="
    INSERT INTO UserCredentials.tbl_user_info (atr_username,atr_first_name,atr_last_name,atr_email,atr_phone,atr_street_address,atr_city,atr_state,atr_zip,atr_user_key)
    VALUES ('" . $UserName . "','" . $FirstName . "','" . $LastName . "','" . $EmailAddress . "','','','','','','" .  $RegistrationKey . "');";

//Store user credentials into database
$InsertUserCredentialsSQL = "
    INSERT INTO UserCredentials.tbl_user_cred (atr_username,atr_password,atr_type)
    VALUES ('" . $UserName . "','" . $Password .  "','locked')";


//Begins transaction and sets boolean all_query_ok to true
$all_query_ok = true;
$conn->begin_transaction();
    
//Queries; sets all_query_ok to false if any fail
$conn->query($InsertUserCredentialsSQL) ? null : $all_query_ok = false;
$conn->query($InsertUserInfoSQL) ? null : $all_query_ok = false;
    
//Commits changes if all queries succeed
if ($all_query_ok) {
    $conn->commit();
}
//Rollback changes if any query fails
else {
    $conn->rollback();
    $_SESSION['InvaliRegistrationMessage'] = "Something went wrong, please try again";
    header('Location: ../pages/register.php');
    exit();
}

//Generate body for email
$EmailContents = "
Click on the link below to complete your account registration.

http://35.196.255.59/" . substr_replace(getcwd(),"",0,14) . "/confirmaccount.php?username=" . $UserName . "&key=" . $RegistrationKey ."";

//Send email with confirmation link
mail($EmailAddress,"Account Registration Confirmation",$EmailContents);

//Close database connection
$conn->close();

//Output instructions and push user to register.php
$_SESSION['InvaliRegistrationMessage'] = "Please Check Your Email For Confirmation";
header('Location: ../pages/register.php');
exit(); 

?>