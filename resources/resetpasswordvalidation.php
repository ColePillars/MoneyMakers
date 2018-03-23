<?php 

session_start();
include ('connection.php');
include ('functions.php');

$pass = mysqli_escape_string($conn,$_POST['password']);
$confPass = mysqli_escape_string($conn,$_POST['confirmPassword']);

$resetPassKey = mysqli_escape_string($conn,$_GET['key']);
$userName = mysqli_escape_string($conn,$_GET['username']);

if(empty($pass)){
    $_SESSION['Invalid'] = "Please Fill Out The Password Field";
    header("location: ../pages/resetpassword.php?username=" . $userName . "&key=" . $resetPassKey ."");
    exit();
}

if(empty($confPass)){
    $_SESSION['Invalid'] = "Please Fill Out The Confirm Password Field";
    header("location: ../pages/resetpassword.php?username=" . $userName . "&key=" . $resetPassKey ."");
    exit();
}

if (($resetPassKey == NULL) or ($userName == NULL)){
    $_SESSION['Invalid'] = "Oops! Something went wrong! <br> Please try again";
    header('Location: ../pages/forgotpassword.php');
    exit();
}
if ($pass <> $confPass){
    //push user back to register if email is already being used
    $_SESSION['Invalid'] = "Passwords Must Match!";
    header("location: ../pages/resetpassword.php?username=" . $userName . "&key=" . $resetPassKey ."");
    exit();
}

$checkUserName = "SELECT atr_username FROM UserCredentials.tbl_user_cred
 WHERE atr_username ='" . $userName . "';";
$checkUserNameResult = mysqli_query($conn, $checkUserName);

//checks to see if the query returns a value or not
if ($checkUserNameResult->num_rows == 1 ) {
    //loops through the results which is an array (mostly likely of 1 element)
    while($row = $checkUserNameResult->fetch_assoc()) {
        
            $hash = password_hash($pass, PASSWORD_DEFAULT);
        
            //Runs the query that changes the password for the user
            $sql = "UPDATE UserCredentials.tbl_user_cred SET atr_password = '" . $hash .  "' WHERE atr_username ='" . $userName .  "';";
            $result = mysqli_query($conn,$sql);
            
            $RandomKey = GenerateRandomKey();
            // query for changing user key
            $ResetKeySQL = "UPDATE UserCredentials.tbl_user_info SET atr_user_key = '" . $RandomKey . "' WHERE atr_username = '" . $userName . "';";
            // execute SQL query to reset key
            if ($conn->query($ResetKeySQL) === TRUE){}
            else{
                //output mysql error if fail, DEV PURPOSE ONLY
                //MUST HANDEL ERROR
                echo "Error: " . $ResetKeySQL . "<br>" . $conn->error;
            }
            
            //redirects the user to the login page after changing their password
            $_SESSION['ResetConfirmMessage'] = "Password has been reset";
            header('Location: ../pages/login.php');
            exit();
    }
}

?>
