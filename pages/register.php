<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

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
                    //if user had input error,outputerror, clear error message
                    if ($_SESSION['InvaliRegistrationMessage']<>NULL){
                        echo  "<h3 class='panel-title'>" . $_SESSION['InvaliRegistrationMessage'] . "</h3>";
                        unset($_SESSION['InvaliRegistrationMessage']);
                    }
                    else{
                        echo  "<h3 class='panel-title'>Please Fill Out All Fields In The Form Below</h3>";
                    }
                    ?>  
                    </div>
                    <div class="panel-body">
                        <form role="form" action="registervalidation.php" method="POST" name="registerform" >
                            <fieldset>
                            <!--  Input for username -->
                            <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text">
                                </div>
                                <!-- Input for email address -->
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail Address" name="email" type="email">
                                </div>
                                 <!-- Input for first name -->
                                <div class="form-group">
                                    <input class="form-control" placeholder="First Name" name="firstname" type="text" >
                                </div>
                                 <!-- Input for last name -->
                                <div class="form-group">
                                    <input class="form-control" placeholder="Last Name" name="lastname" type="text">
                                </div>
                                <!--  input for password -->
                                <div class="form-group">
                                    <input  class="form-control" placeholder="Password" name="password" type="password">
                                </div>
                                <!--  input for password validation -->
                                <div class="form-group">
                                    <input class="form-control" placeholder="Type Password Again" name="passwordcheck" type="password" >
                               </div>
                                <!-- takes user to 'ValidateRegistration.php, to validate and register user-->
                                 <div class="form-group">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value='Register'>
                               </div>
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
