<?php 
include ('logininclude.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../resources/mm_favicon.png.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Money Makers - Password Reset</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
 
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="max-width:400px;min-width:400px">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
					<a href="index.php"><img class="center-block" src="../resources/mm_logo.png" style="min-width:125px;max-width:250px;display:block;"</img></a>          
                    </div>
                    <div class="panel-body">
                    <?php
					session_start();
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
                               	<!-- Change this to a button or input when using this as a form -->
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

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>