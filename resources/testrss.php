    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <!-- Styling Resources -->
   	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  	<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
   	<link href="../vendor/morrisjs/morris.css" rel="stylesheet">
   	<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
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
        
        .clearfix {
            overflow: auto;
        }
        
        .img2 {
            float: left;
            width:30%;
            padding: 5px;
            border-radius: 25px;
        }
        .dateinfo{
        position:absolute;
            bottom:5;
            right:5;
            }
        
        
        </style>


        <div class='w3-card-4 w3-margin' style='width:50%'>
            <div class='w3-display-container w3-text-white'>
                 <div class='clearfix'>
                     <img  class='img2' src='" . $img ."' >
                     <h4 style='color:black'>" . $title . "</p>
                     <small class='text-muted dateinfo'><br>
                        <i class='fa fa-clock-o fa-fw'></i>" . $date . "
                    </small>
                </div>
            </div>
        </div>";
    
$i++;
}


?>