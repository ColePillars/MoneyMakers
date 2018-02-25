<?php 

// this page holds all user written functions to be accesed
// database connections must be included within the function

//This function will check for empty input on registration test  informnation
function CheckEmptyRegistrationInput($Input, $Field){
    if(empty($Input)){
        $_SESSION['InvaliRegistrationMessage'] = "Please Fill Out The " . $Field . " Field";
        header('Location: register.php');
        exit();
    }
}

//This function will generate a random key for user registration and password reset
function GenerateRandomKey($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

Function SearchStockIndex($SearchString){
    
    //include database connection
    include ('connection.php');
    
    //Search all fields for the substring and dump results to table,
 
    $SearchSQL = "
    SELECT *
    FROM StockInfo.Stock_Symbol_Index
    WHERE Symbol LIKE '%" . $SearchString . "%'
    OR NAME LIKE '%" . $SearchString . "%'
    OR Sector LIKE '%" . $SearchString . "%'
    OR Industry LIKE '%" . $SearchString . "%'";
    
    //Execute SQL Query
    $SearchResult = mysqli_query($conn, $SearchSQL);
    if ($SearchResult->num_rows > 0){
          
        echo"<div class='panel-body'>
            <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>
            <thead>
            <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Sector</th>
            <th>Industry</th>
            </tr>
            </thead>
            <tbody>";
        
        
        while($row = $SearchResult->fetch_assoc()) {
            echo "
            <tr>
            <td><a href='../pages/stockpage.php?Symbol=" . $row['Symbol'] . "'>"  . $row['Symbol'] . "</a></td>
            <td>"  . $row['Name'] . "</td>
            <td>"  . $row['Sector'] . "</td>
            <td>"  . $row['Industry'] . "</td>
            </tr>";           
        } 
        
        echo "
        </tbody>
        </table>
        <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->";
        
    }  
}


//This function will show the last 10 day stock pricces and changes
Function FetchLastTenDaysChart($StockSymbol){
 
    // include connections page
    include('connection.php');
    //Counter to skip the 11th day
    $SkipCounter = 0;
    //Query to show the last 11days of close prices
    $ShowLastTenSQL = "SELECT atr_Stock_id, timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp > (SELECT DISTINCT Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 11) AND atr_Stock_id = '" . $StockSymbol . "' order by atr_stock_id ASC, Timestamp DESC";
    $SearchResult = mysqli_query($conn, $ShowLastTenSQL);
    if ($SearchResult->num_rows > 0){
        echo" <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Change</th>
                        <th>Change (%)</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $SearchResult->fetch_assoc()) {
            //Skipping the 11th day
            if ($SkipCounter <> 0) {
            //Computing difference between previous day and current day
            $Difference = round($row['Close'] - $PreviousClose,2);
            //Computing percent difference between previous day and current day
            $PDifference = round((($Difference / $PreviousClose) * 100),2) . "%";
               echo "
                <tr>
                <td>"  . substr($row['timestamp'], 0, 10) . "</td>
                <td>"  . $row['Close'] . "</td>
                <td>"  . $Difference .  "</td>
                <td>"  . $PDifference .  "</td>
                </tr>";
                //Storing close value for previous day.
                $PreviousClose = $row['Close'];
            }else{
               $PreviousClose = $row['Close'];
            }
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        echo "
       </tbody>
       </table>";    
    }  
}


//This function will output top five gains of stocks
//As of not it does not show subscribed stocks
Function ShowMostGains(){
    
    include('connection.php');
    
    //Query to show most gain
    $ShowMostGainsSQL = "
    SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', (((c.Close / y.Close)  -1 ) * 100) as 'ClosePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Close
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    ORDER BY ClosePercentChange DESC limit 5";
    
    
    $SearchResult = mysqli_query($conn, $ShowMostGainsSQL);
    if ($SearchResult->num_rows > 0){
        echo"<table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Change</th>
                        <th>Change (%)</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $SearchResult->fetch_assoc()) {
            echo "
            <tr>
            <td>"  . $row['atr_stock_id'] . "</td>
            <td>"  . $row['Close'] . "</td>
            <td>"  . $row['Change'] . "</td>
            <td>"  . $row['ClosePercentChange'] . "</td>
            </tr>";
                
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        echo "
           </tbody>
       </table>";
    }    
    
    
}


//This function will output top five gains of stocks
//As of not it does not show subscribed stocks
Function ShowMostLosses(){

    include('connection.php');
    
    //Query to show most gain
    $ShowMostLossesSQL = "
    SELECT  c.atr_stock_id, c.Close, c.Timestamp, (c.Close  - y.Close) as 'Change', (((c.Close / y.Close)  -1 ) * 100) as 'ClosePercentChange'
    FROM StockInfo.Time_Series_Daily as c
    INNER JOIN
    (
    	SELECT atr_stock_id, timestamp, Close
    	FROM StockInfo.Time_Series_Daily
    	WHERE Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily
        ORDER BY Timestamp DESC LIMIT 1 OFFSET 1)
    ) as y on c.atr_stock_id = y.atr_stock_id
    WHERE c.Timestamp = (SELECT DISTINCT Timestamp from StockInfo.Time_Series_Daily order by Timestamp DESC LIMIT 1 )
    ORDER BY ClosePercentChange ASC limit 5";

    
    $SearchResultLosses = mysqli_query($conn, $ShowMostLossesSQL);
    if ($SearchResultLosses->num_rows > 0){
        echo"<table class='table table-hover'>
                                            <thead>
                                                <tr>
                                                    <th>Stock</th>
                                                    <th>Price</th>
                                                    <th>Change</th>
                                                    <th>Change (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
        while($row = $SearchResultLosses->fetch_assoc()) {
            echo "
            <tr>
            <td>"  . $row['atr_stock_id'] . "</td>
            <td>"  . $row['Close'] . "</td>
            <td>"  . $row['Change'] . "</td>
            <td>"  . $row['ClosePercentChange'] . "</td>
            </tr>";
            
            //Counter to skip the 11th day
            $SkipCounter = $SkipCounter  +1;
        }
        echo "
           </tbody>
       </table>";
    }
    else{
        echo "fail";
        echo $ShowMostLossesSQL;
    }
    

}



?>