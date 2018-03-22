<?php 

session_start();
include ('connection.php');
include ('functions.php');

$email = mysqli_escape_string($conn,$_POST['email']);

$checkEmail = "SELECT atr_email FROM UserCredentials.tbl_user_info
 WHERE atr_email ='" . $email . "';";
$checkEmailResult = mysqli_query($conn, $checkEmail);
//checks to see if the query returns a value or not
if ($checkEmailResult->num_rows > 0 ) {
    //loops through the results which is an array (mostly likely of 1 element)
    
    while($row = $checkEmailResult->fetch_assoc()) {
        //checks to see if the username is valid, if the new password and confirmed password ar ethe same, and if....
        //the new password or the confirmed password are not NULL
        
        if ($row['atr_email'] == $email) {
            $resetPassKey = GenerateRandomKey();
            $UpdateKeySql = "UPDATE UserCredentials.tbl_user_info SET atr_user_key = '" . $resetPassKey .  "' WHERE atr_email ='" . $email .  "';";
            $result = mysqli_query($conn,$UpdateKeySql);
            
            $user = "SELECT atr_username FROM UserCredentials.tbl_user_info
                WHERE atr_email = '" . $email . "';";
            $userResult = mysqli_query($conn, $user);
            
            if($userResult->num_rows == 1){
            //Generate body for email'
            echo "in the if statement";
                while ($userRow = $userResult->fetch_assoc()){ 
                    $EmailContents = "
                    Click on the link below to reset your password.
                    
                    http://35.196.255.59/" . substr_replace(getcwd(),"",0,14) . "/confirmresetlink.php?username=" . $userRow['atr_username'] . "&key=" . $resetPassKey ."";
            
                    // send email with confirmation link
                    mail($email,"Password reset",$EmailContents);
                    $_SESSION['CheckEmailMessage'] = "Please check your email to reset your password";
                    header('Location: ../pages/login.php');
                    exit();
                }
            
            }
            
        }
        else {
            $_SESSION['Invalid'] = "Invalid Email: Email is not registered";
            header('Location: ../pages/forgotpassword.php');
            exit();
        }
        //Prompts for your credentials if the passwords do not match
    }
}
else {
    $_SESSION['Invalid'] = "Invalid Email: Email is not registered";
    header('Location: ../pages/forgotpassword.php');
    exit();
}

?>
