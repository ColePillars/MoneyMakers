<?php
include ('../resources/logininclude.php');
include ('../resources/functions.php');
session_start();
?>    
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Money Makers - Home Page</title>
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
   	<link href="../vendor/morrisjs/morris.css" rel="stylesheet">
   	<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Graphing Resources, scripts must stay above StockGraph function -->
   	<script src="../graphing/amcharts/amcharts.js"></script>
    <script src="../graphing/amcharts/serial.js"></script>
    <script src="../graphing/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="../graphing/amcharts/plugins/export/export.css" type="text/css" media="all" /> 

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    

    



</head>

<body>
    <div id="wrapper" style="min-width:350px">
		<?php
        include ('../pageelements/navbar.php');
        ?>
        <div id="page-wrapper" style="padding-top:60px;">
        	<?php
            include ('../pageelements/stockcarousel.php');
            ?>
            <div class="row">
            
            
            <!-- old my subs -->
                <div class="col-lg-6">

               <div class="row">
              	<div class="col-lh-6"  id="newsfeed" style="overflow-y:scroll; height:600px; ">

     <?php 
     
     $news = simplexml_load_file('https://news.google.com/news/rss/search/section/q/ford/ford?hl=en&gl=US&ned=us');
     $feeds = array();
     
     $i = 0;
     
     foreach ($news->channel->item as $item)
     {
         preg_match('@src="([^"]+)"@', $item->description, $match);
         $parts = explode('<li>', $item->description);
         $title = (string) $item->title;
         $link = (string) $item->link;
         $img= $match[1];
         $sitetitle = strip_tags($parts[1]);
         $story = strip_tags($parts[2]);
         $date =  (string) $item->pubDate;
         
         echo"
  	    
<style>
    .img2 {
        float: left;
        width:240x;
        height 180px;
        padding: 5px;
        border-radius: 25px;
    }
    .dateinfo{
        position:absolute;
        bottom:5;
        right:5;
        }
  	    
    .TitleHeading{
        text-align: centerl
        font-familty: Arial, Helvetica, sans-serif;
        color: black;
    }
    .clearfix {
        width:80%;
    }
    .pullbottomright{
        position:absolute;
        bottom:0;
        right:0;
        padding-right:5px;
    }
  	    
    .dateholder{
        padding: 5px;
        position:relative;
    }
    @media only screen and (max-width: 768px) {
    .TitleHeading{
        border: 1px solid red;
        padding-bottom: 10px;
        font-size: 18px;
    }
       .img2 {
              display:none;
            }
     small {
        font-size: 10px;
      }
    }
  	    
    #newsfeed::-webkit-scrollbar
    {
       width: 0px;  /* remove scrollbar space */
       background: transparent;  /* optional: just make scrollbar invisible */
    }
  	    
</style>
<div class='w3-card-4 w3-margin' style='width:90%'>
    <div class='clearfix'>
    <div>
        <img class='img2' src='" . $img ."' >
            <div style='overflow:hidden'>
                <h3 class='TitleHeading'>" . $title . "</h3>
            </div>
        </div>
    </div>
    <div class='dateholder'>
        <small class='text-muted pullbottomright'>
        <i class='fa fa-clock-o fa-fw'></i>" . $date . "
    </small>
    </div>
</div>";
         
         $i++;
     }
     
     
       
     ?>

                     	          	</div>
                     	<div class="col-lg-12">
                   
                     	</div>
                     	<div class="col-lg-6">
                     
                     	</div>
                     	<div class="col-lg-6">
               
                     	</div>
                     	
                     
                     </div>              
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Active
                            <div class="fa fa-globe pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                        ShowMostMoving();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Cryptocurrencies
                            <div class="fa fa-key pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Price</th>
                                                    <th>Change</th>
                                                    <th>Percent</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                                <tr>
                                                    <td>stock</td>
                                                    <td>price</td>
                                                    <td>change</td>
                                                    <td>change %</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Gains
                            <div class="fa fa-arrow-up pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                        ShowMostGains();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="font-size:12px">Most Losses
                            <div class="fa fa-arrow-down pull-left" style="margin-right:12px;margin-top:3px"></div>
                        </div>
                        <div class="panel-body" style="font-size:12px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <?php 
                                        ShowMostLosses();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <?php
        include ('../pageelements/footer.php');
        ?>
    </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Slick Carousel Scripts -->
    <script src="../vendor/slick-master/slick/slick.min.js"></script>
	<script>
	$('.responsive').slick({
		  infinite: true,
		  slidesToShow: 5,
		  slidesToScroll: 5,
		  responsive: [
		    {
		      breakpoint: 1200,
		      settings: {
		        slidesToShow: 4,
		        slidesToScroll: 4
		      }
		    },
		    {
		      breakpoint: 992,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3
		      }
		    },
		    {
		      breakpoint: 768,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    }
		  ]
		});
	</script>
</body>

</html>