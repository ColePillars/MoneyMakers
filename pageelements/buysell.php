<div class="w3-container">
    <table class="w3-table-all w3-card-4 w3-hoverable w3-centered">
    	<h3>Buy/Sell</h3>
    	<thead>
            <tr class="w3-light-grey">
                <th>Stock</th>
                <th>Price</th>
                <th>Change</th>
                <th>Status</th>
            </tr>
        </thead>
        <?php 
        
        include('../resources/connection.php');
        
        $sql = "
        SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange', StockInfo.Buy_Sell_Hold.Final_Decision
        FROM StockInfo.Time_Series_Daily as c
        INNER JOIN
        (
          SELECT atr_stock_id, timestamp, Close
          FROM StockInfo.Time_Series_Daily
          WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
          ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
        ) as y on c.atr_stock_id = y.atr_stock_id
        INNER JOIN StockInfo.Buy_Sell_Hold on c.atr_stock_id = StockInfo.Buy_Sell_Hold.Symbol        
        WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
        AND Final_Decision = 'Buy'
        ORDER BY ClosePercentChange DESC LIMIT 3
        ";
        
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                echo "
        <tr class='clickable-row' data-href='#'>
            <td>" . $row['atr_stock_id'] . "</td>
            <td>" . $row['Close'] . "</td>
                ";
                if ($row['Change'] > 0) {
                    echo "
            <td style='color:#28a745'>" . $row['Change'] . "</td>
                    ";
                }
                elseif ($row['Change'] < 0) {
                    echo "
            <td style='color:#dc3545'>" . $row['Change'] . "</td>
                    ";
                }
                elseif ($row['Change'] == 0) {
                    echo "
            <td style='color:#337ab7'>" . $row['Change'] . "</td>
                ";
                }
                echo "
            <td><b>BUY</b></td>
        </tr>
                ";
            }
        }
            
        $sql2 = "
        SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', ROUND((((c.Close / y.Close)  -1 ) * 100),2) as 'ClosePercentChange', StockInfo.Buy_Sell_Hold.Final_Decision
        FROM StockInfo.Time_Series_Daily as c
        INNER JOIN
        (
          SELECT atr_stock_id, timestamp, Close
          FROM StockInfo.Time_Series_Daily
          WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
          ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
        ) as y on c.atr_stock_id = y.atr_stock_id
        INNER JOIN StockInfo.Buy_Sell_Hold on c.atr_stock_id = StockInfo.Buy_Sell_Hold.Symbol        
        WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
        AND Final_Decision = 'Sell'
        ORDER BY ClosePercentChange ASC LIMIT 3
        ";
            
        $result2 = mysqli_query($conn, $sql2);
        if ($result2->num_rows > 0){
            while($row = $result2->fetch_assoc()) {
                echo "
            <tr class='clickable-row' data-href='#'>
                <td>" . $row['atr_stock_id'] . "</td>
                <td>" . $row['Close'] . "</td>
                ";
                if ($row['Change'] > 0) {
                    echo "
                <td style='color:#28a745'>" . $row['Change'] . "</td>
                    ";
                }
                elseif ($row['Change'] < 0) {
                    echo "
                <td style='color:#dc3545'>" . $row['Change'] . "</td>
                    ";
                }
                elseif ($row['Change'] == 0) {
                    echo "
                <td style='color:#337ab7'>" . $row['Change'] . "</td>
                    ";
                }
                echo "
                <td><b>SELL</b></td>
            </tr>
                ";
            }
        }
        ?>
    </table>
</div>