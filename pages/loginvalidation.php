<?php

    session_start();

    include ('../resources/connection.php');
    
    $user = mysqli_escape_string($conn,$_POST['user']);
    $pass = mysqli_escape_string($conn,$_POST['pass']);
    
    $sql = "SELECT * FROM UserCredentials.tbl_user_cred WHERE atr_username ='" . $user . "' AND atr_password ='" . $pass . "'";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    //$row = $result->fetch_assoc();
    
    if($count == 1) {
        while($row = mysqli_fetch_assoc($result)) {
            if ($row['atr_type'] == "normal") {
                $_SESSION['username'] = $user;
                $_SESSION['is_logged_in'] = true;
                header('Location: index.php');
                exit();
            }
            else{
                $_SESSION['InvalidLoginMessage'] = "Please confirm your email and try again";
                header('Location: login.php');
                exit();
            }
        }
    }
    else {
        $_SESSION['InvalidLoginMessage'] = "Login is invalid, please try again";
        header('Location: login.php');
        exit();
    }
    

?>