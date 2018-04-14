<?php
session_start();
include ('../resources/logininclude.php');
include ('../resources/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Login</title>
	<link rel="icon" href="../resources/mm_favicon.png.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Styling Resources -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
 
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="min-width:350px">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<a href="index.php"><img class="center-block" src="../resources/mm_logo.png" style="min-width:125px;max-width:250px;display:block;"</img></a>
                    </div> 
                    <div class="panel-body">
                    <?php
					if($_SESSION['CheckEmailMessage'] <> NULL){
					    echo  "<h3 class='alert alert-info' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>" . $_SESSION['CheckEmailMessage'] . "</h3>";
					    unset($_SESSION['CheckEmailMessage']);
					}
					if ($_SESSION['InvalidLoginMessage'] <> NULL){
						echo  "<h3 class='alert alert-danger' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>" . $_SESSION['InvalidLoginMessage'] . "</h3>";
						unset($_SESSION['InvalidLoginMessage']);
					}
					if ($_SESSION['EmailConfirmMessage'] <> NULL){
					    echo  "<h3 class='alert alert-success' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>" . $_SESSION['EmailConfirmMessage'] . "</h3>";
					    unset($_SESSION['EmailConfirmMessage']);
					}
					if ($_SESSION['ResetConfirmMessage'] <> NULL){
					    echo  "<h3 class='alert alert-success' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>" . $_SESSION['ResetConfirmMessage'] . "</h3>";
					    unset($_SESSION['ResetConfirmMessage']);
					}
					?>
                        <form action="../resources/loginvalidation.php" role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="user" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="pass" type="password" value="">
                                </div>
                               	<div>
                                   	<label class="pull-left">
                                       	<a class="btn btn-link btn-xs" href='register.php'>Create Acccount</a>
                                   	</label>
                                   	<label class='pull-right' >
                                       	<a class="btn btn-link btn-xs" href='forgotpassword.php'>Forgot Password?</a>
                                   	</label>
                               	</div>
                               	<input type = "submit" class="btn btn-lg btn-success btn-block" Value = "Login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>