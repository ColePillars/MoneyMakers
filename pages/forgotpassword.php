<?php
session_start();
include ('../resources/logininclude.php');
include ('../resources/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Forgot Password</title>
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
					if ($_SESSION['Invalid'] <> NULL){
					    echo  "<h3 class='alert alert-danger' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>" . $_SESSION['Invalid'] . "</h3>";
						unset($_SESSION['Invalid']);
					}
                    else{
                        echo  "<h3 class='alert alert-info' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>Enter your registered email address below</h3>";
                    } 
					?>
                        <form action="../resources/forgotpasswordvalidation.php" role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" name="email" type="text" autofocus>
                                </div>
                               	<input type = "submit" class="btn btn-lg btn-success btn-block" Value = "Send reset link">
                              	<label class="pull-right">
                                 	<a class="btn btn-link" style="margin-top:6px" href='login.php'>Cancel</a>
                              	</label>
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