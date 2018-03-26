<?php
session_start();
include ('../resources/logininclude.php');
include ('../resources/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Reset Password</title>
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
                        echo  "<h3 class='alert alert-info' style='margin-top:12px;margin-bottom:24px;font-size:12px;text-align:center'> Enter new password</h3>";
                    }
					?>
                        <form action="<?php echo "../resources/resetpasswordvalidation.php?username=" . $_GET['username'] . "&key=" . $_GET['key'] .""; ?>" role="form" method="POST">
                            <fieldset>
                                <!--  input for password -->
                                <div class="form-group">
                                    <input required pattern="(?=.*\d)(?=.*[A-Z]).{8,}" class="form-control" placeholder="Password" id="pass" name="password" type="password" value=""
                                    title="Password must be at least 8 characters long, contain at least one uppercase letter, and at least one number.">
                                </div>
                                <!--  input for password validation -->
                                <div class="form-group">
                                    <input required  pattern="(?=.*\d)(?=.*[A-Z]).{8,}" class="form-control" placeholder="Confirm Password" id="vpass" name="confirmPassword" type="password" value=""
                                    title="Must match password field" oninput="matchPassword(this)">
                               </div>
                               	<input type = "submit" class="btn btn-lg btn-success btn-block" Value = " Reset Password ">
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