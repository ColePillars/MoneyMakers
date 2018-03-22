<!-- Slick Carousel Resources -->
<link rel="stylesheet" type="text/css" href="../vendor/slick-master/slick/slick.css">
<link rel="stylesheet" type="text/css" href="../vendor/slick-master/slick/slick-theme.css">


<style type="text/css">
    html, body {
      margin: 0;
      padding: 0;
    }
    * {
        box-sizing: border-box;
    }
    .slider {
        width: 80%;
        margin: 10px auto;
    }
    .slick-slide {
        margin: 0px 1px;
    }
    .slick-slide img {
        width: 100%;
    }
    .slick-prev:before,
    .slick-next:before {
        color: black;
    }
    .slick-slide {
        transition: all ease-in-out .3s;
        opacity: .2;
    }
    .slick-active { 
        opacity: 1;
    }
</style>
<section class="slider responsive">
	<?php 
	include ('../resources/connection.php');
	//include ('../resources/functions.php');
	if ($_SESSION['is_logged_in']) {
	    $sql = "
        SELECT  c.atr_stock_id, c.Close, c.Timestamp, n.Name, ROUND((c.Close  - y.Close), 2) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange'
        FROM StockInfo.Time_Series_Daily as c
        INNER JOIN
        (
        	SELECT atr_stock_id, timestamp, Close
        	FROM StockInfo.Time_Series_Daily
        	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
            ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
        ) as y on c.atr_stock_id = y.atr_stock_id
    	INNER JOIN
    	(
    		SELECT DISTINCT atr_stock_id
    		FROM UserCredentials.tbl_stock_subs
    		WHERE atr_username = '" . $_SESSION['username'] . "'
    	) as s on c.atr_stock_id= s.atr_stock_id
        INNER JOIN StockInfo.Stock_Symbol_Index as n ON c.atr_stock_id = n.Symbol
        WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
        ORDER BY atr_stock_id ASC";
	}
	else {
	    $sql = "
        SELECT  c.atr_stock_id, c.Close, c.Timestamp, n.Name, ROUND((c.Close  - y.Close), 2) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange'
        FROM StockInfo.Time_Series_Daily as c
        INNER JOIN
        (
        	SELECT atr_stock_id, timestamp, Close
        	FROM StockInfo.Time_Series_Daily
        	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
            ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
        ) as y on c.atr_stock_id = y.atr_stock_id
    	INNER JOIN
    	(
    		SELECT DISTINCT atr_stock_id
    		FROM UserCredentials.tbl_stock_subs
    		WHERE atr_username = 'testing'
    	) as s on c.atr_stock_id= s.atr_stock_id
        INNER JOIN StockInfo.Stock_Symbol_Index as n ON c.atr_stock_id = n.Symbol
        WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
        ORDER BY atr_stock_id ASC";
	}
    $result = mysqli_query($conn, $sql);
    if ($result -> num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $str = $row['Name'];
            if (strlen($str) > 30) {
                $str = substr($str, 0, 27) . '...';
            }
            echo "
            <a href='../pages/stockpage.php?Symbol=" . $row['atr_stock_id'] . "' style='text-decoration: none; color: black;'>
                <div class='row'>
                <div class='col-sm-6 text-center'>
                    <h4> " . $str . " </h4>
                </div>
                <div class='col-sm-6 text-center'>
                    <h5> " . $row['Close'] . " </h5>
            ";
            if ($row['ClosePercentChange'] > 0) {
                echo "
                    <h5 style='color:#28a745'><i class='fa fa-lg fa-caret-up'></i> " . $row['ClosePercentChange'] . "%</h5>
                ";
            }
            if ($row['ClosePercentChange'] < 0) {
                echo "
                    <h5 style='color:#dc3545'><i class='fa fa-lg fa-caret-down'></i> " . $row['ClosePercentChange'] . "%</h5>
                ";
            }
            if ($row['ClosePercentChange'] == 0) {
                echo "
                    <h5 style='color:#337ab7'><i class='fa fa-lg fa-minus'></i> " . $row['ClosePercentChange'] . "%</h5>
                ";
            }
            echo "
                </div>
                </div>
                <div class='row'>
                    <div class='col-sm-12 text-center'>
            ";
            StockSparkline($row['atr_stock_id']);
            echo "
                    </div>
                </div>
            </a>
            ";
        }
    }
	?>
</section>

