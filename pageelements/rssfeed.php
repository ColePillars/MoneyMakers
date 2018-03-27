<link href="../vendor/w3.css" rel="stylesheet">
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">
<link href="../vendor/morrisjs/morris.css" rel="stylesheet">
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<?php 

if ($StockFullName) {
}
else {
    $StockFullName = "Stockmarket";
}
$Topic = str_replace(' ','%20', $StockFullName);


$news = simplexml_load_file("https://news.google.com/news/rss/search/section/q/" . $Topic . "/" . $Topic . "?hl=en&gl=US&ned=us");

$feeds = array();

$i = 0;

foreach ($news->channel->item as $item)
{
    $parts = explode('<li>', $item->description);
    $link = (string) $item->link;
    $sitetitle = strip_tags($parts[1]);
    $story = strip_tags($parts[2]);
    $date =  (string) $item->pubDate;
    
    $title = (string) $item->title;
    if (strlen($title) > 60) {
        $title = substr($title, 0, 57) . '...';
    }
    
    preg_match('@src="([^"]+)"@', $item->description, $match);
    $img = $match[1];
    
    if($img) {
        echo "
                <div class='w3-card-4 w3-margin' style='min-height: 100px;'>
                    <a href='" . $link . "' style='text-decoration: none; color: black;'>
                        <div class='w3-display-container w3-text-white'>
                            <div style='overflow: auto;'>
                                <img src='" . $img ."' style='max-height: 95px; float: left; padding: 2px; border-radius: 15px;'>
                                <h5 style='color:black'>" . $title . "</p>
                            </div>
                            <div style='text-align: right; max-height:18px; padding: 1px'>
                                <small class='text-muted'>
                                    <i class='fa fa-clock-o fa-fw'></i>" . $date . "
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
        ";
        $i++;
    }
    
    if ($i == 6 ) break;
}

?>