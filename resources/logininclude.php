<?php 

session_start();

$page = end(explode( "/" , $_SERVER['SCRIPT_NAME']));

//Redirects to login page, if you aren't logged in and accessing a page other than index, login, or register
if (!(($_SESSION['is_logged_in']) || ($page == 'index.php') || ($page == 'login.php') || ($page == 'register.php') || ($page == 'forgotpassword.php'))) {
    header('Location: ../pages/login.php');
    exit();
}

?>