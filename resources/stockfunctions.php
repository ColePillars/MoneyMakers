<?php 
// this function will fetch and store intradaily values given the parameters
//RETURNS 100 DATA POINTS, SO IF HOURLY, LAST 100 HOURS!!
function FetchIntraDaily($StockSymbol, $Interval){
    //including db connectoin
    include('connection.php');
  
    //URL to get api data, from user input
    $data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" . $StockSymbol . "&interval=" . $Interval . "&apikey=S7R0WLCOH163H1DE&datatype=csv");
    //Split the response into rows via each array element is an array
    $rows = explode("\n",$data);
    
    //enable variable to skip headers
    $HeaderSkip = 0;
    
    //Loop through each row
    foreach($rows as $row) {
        
        //Skip the header row
        if ($HeaderSkip == 0){
            $HeaderSkip = 1;
            goto HeaderSkip;
        }
        
        //Split each row up into columns by comma
        $DataFields[] = str_getcsv($row);
        //loop through ech column
        foreach ($DataFields as $DataColumn){
            //Query for inserting each row 
            $InsertStockRowSQL = "
            INSERT INTO StockInfo.Time_Series_Intradaily(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume)
            VALUES ('" . $StockSymbol . "','" . $DataColumn[0] ."','" . $DataColumn[1] ."','" . $DataColumn[2] ."','" . $DataColumn[3] ."','" . $DataColumn[4] ."','" . $DataColumn[5] . "');";
            //Execute SQL query to update user type
            if ($conn->query($InsertStockRowSQL) == TRUE){}
        }
        //To skip the headers
        HeaderSkip:
    }
}
?>