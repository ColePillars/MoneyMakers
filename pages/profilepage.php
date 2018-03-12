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

    <title>Money Makers - Edit profile</title>

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
            <!--  <div class="col-md-4 col-md-offset-4">
				  <div class="login-panel panel panel-default">
					<div class="panel-heading">
					-->
            <?php
session_start();

// including database connection file
include ('../resources/connection.php');

// checks login status
if ($_SESSION['is_logged_in'] != true) {
    header('Location: login.php');
    exit();
} else {
    // if user had input error,outputerror, clear error message
    if ($_SESSION['InvalidUpdateMessage'] != NULL) {
        echo "<h5 class='panel-title'>" . $_SESSION['InvalidUpdateMessage'] . "</h5>";
        unset($_SESSION['InvalidUpdateMessage']);
    } else {
    }
    
    $sql = "SELECT * FROM UserCredentials.tbl_user_info WHERE atr_username ='" . $_SESSION['username'] . "';";
    $result = mysqli_query($conn, $sql);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['username'];
        $_SESSION['firstname'] = $row[atr_first_name];
        $_SESSION['lastname'] = $row[atr_last_name];
        $_SESSION['phone'] = $row[atr_phone];
        $_SESSION['address'] = $row[atr_street_address];
        $_SESSION['city'] = $row[atr_city];
        $_SESSION['state'] = $row[atr_state];
        $_SESSION['zip'] = $row[atr_zip];
    }
}
?>
        </div>
    </div>
    <div class="row center-block">
        <div class="col-md-4 col-md-offset-4" style="max-width:800px;min-width:400px">
            <div class="login-panel panel panel-default">
                <div class="panel-header">
                    <a href="index.php"><img class="center-block" src="../resources/mm_logo.png" style="min-width:125px;max-width:250px;display:block;"</img></a></div>
                <div class="panel-body" style="font-size:12px">
                    <form role="form" action="../resources/profileedit.php" method="POST" name="profileform">
                        <fieldset>
                            <!--  Input for username -->
                            <div class="form-group">
                                <h5>Username:</h5>
                                <input required pattern="[A-Za-z0-9]{1,}" class="form-control" name="username" type="text" title="No special characters" value="<?php echo $_SESSION['username'];?>" </div>
                                <!-- Input for first name -->
                                <h5>First Name:</h5>

                                <div class="form-group">
                                    <input required pattern="[A-Za-z]{1,}" class="form-control" name="firstname" type="text" title="Alphabetic characters only" value="<?php echo $_SESSION['firstname']; unset($_SESSION['firstname']);?>" </div>
                                    <!-- Input for last name -->
                                    <h5>Last Name:</h5>

                                    <div class="form-group">
                                        <input required pattern="[A-Za-z]{1,}" class="form-control" name="lastname" type="text" title="Alphabetic characters only" value="<?php echo $_SESSION['lastname'];unset($_SESSION['lastname']);?>" </div>
                                        <!-- Input for phone number -->
                                        <h5>Phone Number:</h5>

                                        <div class="form-group">
                                            <input pattern="[0-9]{10}" class="form-control" name="phone" title="Please include area code." type="text" value="<?php echo $_SESSION['phone'];unset($_SESSION['phone']);?>" </div>
                                            <!-- Input for Street address -->
                                            <h5>Street Address:</h5>

                                            <div class="form-group">
                                                <input pattern="[A-Za-z0-9]{0,}" class="form-control" name="address" type="text" title="Alphanumberic characters only" value="<?php echo $_SESSION['address'];unset($_SESSION['address']);?>" </div>
                                                <!-- Input for City -->
                                                <h5>City:</h5>

                                                <div class="form-group">
                                                    <input pattern="[A-Za-z0-9]{0,}" class="form-control" name="city" type="text" title="Alphanumberic characters only" value="<?php echo $_SESSION['city'];unset($_SESSION['city']);?>" </div>
                                                    <!-- Input for State -->
                                                    <h5>State:</h5>

                                                    <div class="form-group">
                                                        <input pattern="[A-Za-z]{0,}" class="form-control" name="state" type="text" value="<?php echo $_SESSION['state'];unset($_SESSION['state']);?>" </div>
                                                        <!-- Input for Zip Code -->
                                                        <h5>Zip Code:</h5>

                                                        <div class="form-group">
                                                            <input pattern="[0-9]{5}" class="form-control" name="zip" type="text" value="<?php echo $_SESSION['zip'];unset($_SESSION['zip']);?>" </div>
                                                            <!--
                                                            <h5>Blood Type:</h5>
                                                            <div class="form-group">
                                                                <input pattern="[A-Za-z]{1}" class="form-control" name="blood" type="text" title="Alphabetic characters only">
                                                            </div>
                                                            <h5>Social Security Number:</h5>
                                                            <div class="form-group">
                                                                <input pattern="[0-9]{9}" class="form-control" name="ssn" type="text">
                                                            </div>
                                                            <h5>Name of First Pet:</h5>
                                                            <div class="form-group">
                                                                <input class="form-control" name="petname" type="text">
                                                            </div>
                                                            <h5>Date of Birth:</h5>
                                                            <div class="form-group">
                                                                <input class="form-control" name="dob" type="text">
                                                            </div>
                                                            <h5>Father's Name:</h5>
                                                            <div class="form-group">
                                                                <input pattern="[A-Za-z]" class="form-control" name="dadname" type="text">
                                                            </div>
                                                            <h5>Mother's Maiden Name:</h5>
                                                            <div class="form-group">
                                                                <input class="form-control" name="momname" type="text">
                                                            </div>
                                                             -->
                                                            <!-- takes user to profile_edit.php-->
                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-lg btn-success btn-block" style="margin-top:24px" value='Update'>
                                                            </div>

                        </fieldset>
                    </form>
                    </div>
                    </div>
                    </div>
                    <script src="../vendor/jquery/jquery.min.js"></script>

                    <!-- Bootstrap Core JavaScript -->
                    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

                    <!-- Metis Menu Plugin JavaScript -->
                    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

                    <!-- Custom Theme JavaScript -->
                    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>