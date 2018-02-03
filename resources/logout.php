<?php
   session_start();
   
   if(session_destroy()) {
      $_SESSION['username'] = NULL;
      $_SESSION['is_logged_in'] = false;
      header("Location: ../pages/index.php");
   }
?>