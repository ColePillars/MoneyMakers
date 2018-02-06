<?php

    session_start();

    include ('connection.php');
    
    $user = mysqli_escape_string($conn,$_POST['user']);
    $pass = mysqli_escape_string($conn,$_POST['pass']);
    
    $sql = "SELECT * FROM UserCredentials.tbl_user_cred WHERE atr_username ='" . $user . "'";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    
    //If user exists in database, do...
    if($count == 1) {
        while($row = mysqli_fetch_assoc($result)) {
            
            //Verifies password to the hash in Database
            $hash = $row['atr_password'];
            if (password_verify($pass, $hash)) {
                
                //If usertype is normal, login user
                if ($row['atr_type'] == "normal") {
                    $_SESSION['username'] = $user;
                    $_SESSION['is_logged_in'] = true;
                    header('Location: ../pages/index.php');
                    exit();
                }
                
                //If usertype is not normal, ask to confirm email
                else {
                    $_SESSION['InvalidLoginMessage'] = "Please confirm your email and try again";
                    header('Location: ../pages/login.php');
                    exit();
                }
            }
            else {
                $_SESSION['InvalidLoginMessage'] = "Password is incorrect, please try again";
                header('Location: ../pages/login.php');
                exit();
            }
        }
    }
    //If user does not exist in database, login is invalid
    else {
        $_SESSION['InvalidLoginMessage'] = "Login is invalid, please try again";
        header('Location: ../pages/login.php');
        exit();
    }

?>