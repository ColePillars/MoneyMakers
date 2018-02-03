<?php 

session_start();
include ('connection.php');

$pass = mysqli_escape_string($conn,$_POST['password']);
$confPass = mysqli_escape_string($conn,$_POST['confirmpassword']);

$UserName = mysqli_escape_string($conn,$_GET['username']);
$ResetPassKey = mysqli_escape_string($conn,$_GET['key']);

CheckEmptyRegistrationInput($pass, "Password");
CheckEmptyRegistrationInput($confPass,  "Confirm Password");

if ($pass <> $confPass){
    //push user back to register if email is already being used
    $_SESSION['InvaliRegistrationMessage'] = "Passwords Must Match!";
    header('Location: ../pages/for.php');
    exit();
}


//checks to see if the query returns a value or not
if ($checkUserNameResult->num_rows > 0 ) {
    //loops through the results which is an array (mostly likely of 1 element)
    while($row = $checkUserNameResult->fetch_assoc()) {
        //checks to see if the username is valid, if the new password and confirmed password ar ethe same, and if....
        //the new password or the confirmed password are not NULL
        if (($row['atr_username'] == $user) && ($pass == $confpass) && (($pass != NULL) OR ($confpass != NULL))) {
            //Runs the query that changes the password for the user
            $sql = "UPDATE UserCredentials.tbl_user_cred SET atr_password = '" . $pass .  "' WHERE atr_username ='" . $user .  "';";
            $result = mysqli_query($conn,$sql);
            //redirects the user to the login page after changing their password
            header('Location: ../pages/login.php');
            exit();
        }
        //Prompts for your credentials if the passwords do not match
        else {
            $_SESSION['InvalidUserOrPass'] = "Passwords do not match";
            header("location: ../pages/resetpassword.php?username=" . $UserName . "&key=" . $ResetPassKey .);
            exit();
        }
    }
}
//Prompts for your credentials if the username is not in the system
else {
    $_SESSION['InvalidUserOrPass'] = "Username is not in the system";
    header('Location: ../pages/forgotpassword.php');
    exit();
}

?>
