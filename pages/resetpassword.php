<?php 
include ('../resources/logininclude.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

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
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    <?php
					session_start();
					if ($_SESSION['Invalid'] <> NULL){
						echo $_SESSION['Invalid'];
						unset($_SESSION['Invalid']);
					}
                    else{
                       echo "Enter your new password";
                    }
					?>
                    </div>
                    <div class="panel-body">
                    
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
                                    title="Must match password field" oninput="matchPassword(this)"/>
                               </div>
                               	<!-- Change this to a button or input when using this as a form -->
                               	<input type = "submit" class="btn btn-lg btn-success btn-block" Value = " Reset Password ">
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