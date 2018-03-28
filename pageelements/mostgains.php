<div class="w3-container">
    <table class="w3-table-all w3-card-4 w3-hoverable w3-centered">
    	<h3>Most Gains</h3>
    	<thead>
            <tr class="w3-light-grey">
                <th>Stock</th>
                <th>Price</th>
                <th>Change</th>
                <th>%&nbsp;Change</th>
            </tr>
        </thead>
        <?php 
        
        include('../resources/connection.php');
        
        $sql = "
        SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange'
        FROM StockInfo.Time_Series_Daily as c
        INNER JOIN
        (
        	SELECT atr_stock_id, timestamp, Close
        	FROM StockInfo.Time_Series_Daily
        	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
            ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
        ) as y on c.atr_stock_id = y.atr_stock_id
        WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
        AND (c.Close  - y.Close) > 0
        ORDER BY ClosePercentChange DESC limit 3
        ";
        
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                echo "
        <tr onclick=\"window.location='stockpage.php?Symbol=" . $row['atr_stock_id'] . "';\">
            <td>" . $row['atr_stock_id'] . "</td>
            <td>" . $row['Close'] . "</td>
                ";
                if ($row['Change'] > 0) {
                    echo "
            <td style='color:#28a745'>" . $row['Change'] . "</td>
            <td style='color:#28a745'><i class='fa fa-lg fa-caret-up'></i>&nbsp;" . abs($row['ClosePercentChange']) . "%</td>
        </tr>
                    ";
                }
                elseif ($row['Change'] < 0) {
                    echo "
            <td style='color:#dc3545'>" . $row['Change'] . "</td>
            <td style='color:#dc3545'><i class='fa fa-lg fa-caret-down'></i>&nbsp;" . abs($row['ClosePercentChange']) . "%</td>
        </tr>
                    ";
                }
                elseif ($row['Change'] == 0) {
                    echo "
            <td style='color:#337ab7'>" . $row['Change'] . "</td>
            <td style='color:#337ab7'><i class='fa fa-lg fa-minus'></i>&nbsp;" . abs($row['ClosePercentChange']) . "%</td>
        </tr>
                ";
                }
            }
        }
        ?>
    </table>
</div>






