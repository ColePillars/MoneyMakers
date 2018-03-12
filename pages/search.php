<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../resources/mm_favicon.png.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Money Makers - Search</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

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
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div>
                <a href="index.php"><img class="navbar-left" style="max-width:225px;padding:6px" src="../resources/mm_logo.png" </img>
                </a>
                </div>
            <div class="col-md-3">
            	<form action="search.php" role="form" method="POST">
                	<div class="form-group-lg input-group" style="margin-top:16px;max-width:400px">
                    	<input type="text" class="form-control" name="SearchString" id="SearchString" placeholder="Search stocks">
                    	<span class="input-group-btn">
                        	<button class="btn btn-info btn-lg" type="submit"><i class="fa fa-search"></i>
                        	</button>
                    </span>
                </div>
                </form>
            </div>
            <div class="col-lg-6">
            </div>
            <?php
			session_start();
			if ($_SESSION['is_logged_in']){
		    include ('../resources/loggedinnav.php');
			//echo "test";
			}
			else {
			    echo "
						<div class='nav navbar-top-links navbar-right btn-lg' style='margin-top:12px'>
							<a href='login.php'><i class='fa fa-sign-in fa-fw'></i> Login</a>
						</div>
				";
			}
			
			?>
        </nav>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">
                    Search Results
                    <?php 
                    session_start();
                    echo  $_SESSION['InvalidStockMessage'];
                    unset($_SESSION['InvalidStockMessage']);
                    ?>
                    
                    
                    </h3>
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- /.panel -->
                    <?php 
                    include('../resources/functions.php');
                    //Output search results
                    SearchStockIndex($_POST['SearchString']);
                    ?>
                    <!--  -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>   

</body>

</html>
