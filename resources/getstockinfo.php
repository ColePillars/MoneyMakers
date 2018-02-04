<?php 


include('stockfunctions.php');

//FetchIntraDaily("F", "60min");





 

 $data = file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=F&interval=60min&apikey=S7R0WLCOH163H1DE&datatype=json");
 
 
 //$data2 = substr($data,304);
 //echo $data2;
$StockSymbol = "F";
$jsondata = json_decode($data);
$SkipMeta = 0;
//var_dump($jsondata);

$StartSQL = "INSERT INTO StockInfo.Time_Series_Intradaily(atr_stock_ID,Timestamp,Open,High,Low,Close,Volume)
            VALUES('F',";

$count = 0;

foreach ($jsondata  as $trend){
    foreach ($trend as $test => $test2){
        
        //execute query
        if($count > 5){
            $MidQuery = $StartSQL;
            $MidQuery = $MidQuery . "'" . $test . "',";
         //start to define query
        }
        
         foreach ($test2 as $testcolumns => $testcolumns2){
             
                $MidQuery = $MidQuery . "'" . $testcolumns2 . "',";
         }
         
         if($count > 5){
            $MidQuery =  substr($MidQuery, 0, -2) . "');<br>";
            //this echo is where the query should be executed
            echo $MidQuery;
         }
        $count = $count + 1;
     }
 }
 
 
//secho $jsondata[4]['4. close'];
/*
 echo json_last_error(); // 4 (JSON_ERROR_SYNTAX)
 echo json_last_error_msg(); // unexpected character
 */
?>