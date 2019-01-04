<div class="w3-container" id="recentdata">
	<h3>Recent Data</h3>
    <table class="w3-table-all w3-card-4 w3-hoverable w3-centered">
    	<thead>
            <tr class="w3-light-grey">
                <th>&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                <th>Price</th>
                <th>Change</th>
                <th>%&nbsp;Change</th>
            </tr>
        </thead>
        <?php
        
        include('connection.php');
        
        $SkipCounter = 0;
        $Output = array();
        
        $sql = "
        SELECT atr_Stock_id, DATE_FORMAT(timestamp, '%y-%m-%d') as 'timestamp', Open, High, Low, Close
        FROM StockInfo.Time_Series_Daily
        WHERE Timestamp >
        (
            SELECT DISTINCT Timestamp 
            FROM StockInfo.Time_Series_Daily 
            WHERE atr_stock_id ='" . $_GET['Symbol'] . "' 
            ORDER BY Timestamp DESC LIMIT 1 offset 11
        ) 
        AND atr_Stock_id = '" . $_GET['Symbol'] . "'
        ORDER BY atr_stock_id ASC, Timestamp ASC
        ";
        
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                if ($SkipCounter != 0) {
                    //Computing difference between previous day and current day
                    $Difference = round($row['Close'] - $PreviousClose,2);
                    //Computing percent difference between previous day and current day
                    $PDifference = round((($Difference / $PreviousClose) * 100),2) . "%";
                    array_push($Output,(string)$row['timestamp']);
                    array_push($Output,(string)$row['Close']);
                    array_push($Output,(string)$Difference);
                    array_push($Output,(string)$PDifference);
                    //Storing close value for previous day.
                    $PreviousClose = $row['Close'];
                }else{
                    $PreviousClose = $row['Close'];
                }
                $SkipCounter = $SkipCounter  +1;
            }
            for($i=39; $i >= 3; $i-=4){
                echo "
        <tr>
            <td>" . substr($Output[$i-3], 3, 5) . "</td>
            <td>" . $Output[$i-2] . "</td>
                ";
                if ($Output[$i-1] > 0) {
                    echo"
            <td style='color:#28a745'>" . $Output[$i-1] . "</td>
            <td style='color:#28a745'><i class='fa fa-lg fa-caret-up'></i>&nbsp;" . abs($Output[$i]) . "%</td>
        </tr>
                    ";
                }
                elseif ($Output[$i-1] < 0) {
                    echo"
            <td style='color:#dc3545'>" . $Output[$i-1] . "</td>
            <td style='color:#dc3545'><i class='fa fa-lg fa-caret-down'></i>&nbsp;" . abs($Output[$i]) . "%</td>
        </tr>
                    ";
                }
                elseif ($Output[$i-1] == 0) {
                    echo"
            <td style='color:#337ab7'>" . $Output[$i-1] . "</td>
            <td style='color:#337ab7'><i class='fa fa-lg fa-minus'></i>&nbsp;" . abs($Output[$i]) . "%</td>
        </tr>
                    ";
                }
            }
        }
        ?>
    </table>
</div>
