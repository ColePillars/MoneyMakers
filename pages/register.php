<?php
session_start();
include ('../resources/logininclude.php');
include ('../resources/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Register</title>
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
                    //if user had input error,outputerror, clear error message
                    if ($_SESSION['InvaliRegistrationMessage']<>NULL){
                        echo  "<h3 class='alert alert-danger' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>" . $_SESSION['InvaliRegistrationMessage'] . "</h3>";
                        unset($_SESSION['InvaliRegistrationMessage']);
                    }
                    else{
                        echo  "<h3 class='alert alert-info' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'>Please fill out all fields in the form below</h3>";
                    }
                    ?>  
                        <form role="form" action="../resources/registervalidation.php" method="POST" name="registerform" onsubmit="matchPassword(this)">
                            <fieldset>
                                <!--  Input for username -->
                            	<div class="form-group">
                                    <input required pattern="[A-Za-z0-9]{1,}" class="form-control" placeholder="Username" name="username" type="text" title="No special characters" autofocus>
                                </div>
                                <!-- Input for email address -->
                                <div class="form-group">
                                    <input required class="form-control" placeholder="E-mail Address" name="email" type="email" autofocus>
                                </div>
                                 <!-- Input for first name -->
                                <div class="form-group">
                                    <input required pattern="[A-Za-z]{1,}" class="form-control" placeholder="First Name" name="firstname" type="text" title="Alphabetic characters only" autofocus>
                                </div>
                                 <!-- Input for last name -->
                                <div class="form-group">
                                    <input required pattern="[A-Za-z]{1,}" class="form-control" placeholder="Last Name" name="lastname" type="text" title="Alphabetic characters only" autofocus>
                                </div>
                                <!--  input for password -->
                                <div class="form-group">
                                    <input required pattern="(?=.*\d)(?=.*[A-Z]).{8,}" class="form-control" placeholder="Password" id="pass" name="password" type="password" value=""
                                    title="Password must be at least 8 characters long, contain at least one uppercase letter, and at least one number.">
                                </div>
                                <!--  input for password validation -->
                                <div class="form-group">
                                    <input required  pattern="(?=.*\d)(?=.*[A-Z]).{8,}" class="form-control" placeholder="Confirm Password" id="vpass" name="passwordcheck" type="password" value=""
                                    title="Must match password field" oninput="matchPassword(this)">
                               	</div>
                                <!-- takes user to '../pages/registervalidation.php, to validate and register user-->
                                <div class="form-group">
                                	<input type="submit" class="btn btn-lg btn-success btn-block" value='Register'>
                               	</div>
                               	<label class="pull-right">
                                   	<a class="btn btn-link" style="margin-top:-12px" href='login.php'>Cancel</a>
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
    <script language='javascript' type='text/javascript'> 
	function matchPassword(input){
		if(input.value!=document.getElementById('pass').value){
			input.setCustomValidity('Passwords do not match.');
		} else{
			input.setCustomValidity('');
		}
	}
	</script>
</body>

</html>
