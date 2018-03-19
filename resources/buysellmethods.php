<?php
//This page will hold the functions to the statistical methods that will determine
//whether to buy, sell,  or hold
session_start();
include('connection.php');

//FIX THIS QUERY!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
function Two_Period_RSI(){
    session_start();
    include('connection.php');
    $selectRSI = "SELECT atr_stock_id, Timestamp, RSI FROM StockInfo.Technical_Analysis_RSI WHERE Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Technical_Analysis_RSI ORDER BY Timestamp DESC LIMIT 1 offset 1) order by atr_stock_id ASC, Timestamp ASC";
    $selectRSIResult = mysqli_query($conn, $selectRSI);
    
    if($selectRSIResult->num_rows > 0){
        while($row = $selectRSIResult->fetch_assoc()){
            //sell if...
            echo $row['atr_stock_id'];
            if($row['RSI'] >= 90){
                $check = "SELECT Two_Period_RSI FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                $checkResult = mysqli_query($conn, $check);
                if ($checkResult->num_rows > 0){
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Two_Period_RSI = 'Sell' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Two_Period_RSI) VALUES('" . $row['atr_stock_id'] . "','Sell')";
                    if ($conn->query($insert) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $insert . "<br>" . $conn->error;
                    }
                }
                //buy if...
            } elseif ($row['RSI'] <= 10) {
                $check = "SELECT Two_Period_RSI FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                $checkResult = mysqli_query($conn, $check);
                if ($checkResult->num_rows > 0){
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Two_Period_RSI = 'Buy' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Two_Period_RSI) VALUES('" . $row['atr_stock_id'] . "','Buy')";
                    if ($conn->query($insert) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $insert . "<br>" . $conn->error;
                    }
                }
                //else hold...
            } else {
                $check = "SELECT Two_Period_RSI FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                $checkResult = mysqli_query($conn, $check);
                if ($checkResult->num_rows > 0){
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Two_Period_RSI = 'Hold' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Two_Period_RSI) VALUES('" . $row['atr_stock_id'] . "','Hold')";
                    if ($conn->query($insert) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $insert . "<br>" . $conn->error;
                    }
                }
            }
        }
    }
}





function Heikin_Ashi(){
    session_start();
    include('connection.php');
    
    function Heikin($O, $H, $L, $C, $oldO, $oldC){
        $HA_Close = ($O + $H + $L + $C)/4;
        $HA_Open = ($oldC + $oldO)/2;
        $HA_Low = min($L, $HA_Open, $HA_Close);
        $HA_High = max($H, $HA_Open, $HA_Close);
        return array($HA_Open, $HA_High, $HA_Low, $HA_Close);
    }
//Select open, high, low, close, from time_Series_daily where (last 11 time_stamps) for each distinct symbol
    $select = "SELECT atr_stock_id, Timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 11) order by atr_stock_id ASC, Timestamp ASC";
    $selectResult = mysqli_query($conn, $select);
    
    $initial = 11;
    $oldO = 0;
    $oldC = 0;
    
    if ($selectResult->num_rows > 0){
        while($row = $selectResult->fetch_assoc()){
            if (($initial%11) == 0){
                $oldO = $row['Open'];
                $oldC = $row['Close'];
                //testing echo
                //echo "INITIAL SYMBOL SKIP#" . $initial . "<br>";
                $initial = $initial +1;
                
            } else {
                if (($initial%11) == 10){
                    $list = Heikin($row['Open'], $row['High'], $row['Low'], $row['Close'], $oldO, $oldC);
                    
                    if(($list[0] > $list[3]) && ($oldO > $oldC) && (abs($list[0] - $list[3]) > abs($oldO - $oldC)) && ($list[0] == $list[1])){
                        $check = "SELECT Heikin_Ashi FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                        $checkResult = mysqli_query($conn, $check);
                        if ($checkResult->num_rows > 0){
                            $update = "UPDATE StockInfo.Buy_Sell_Hold SET Heikin_Ashi = 'Buy' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                            if ($conn->query($update) === TRUE){}
                            else{
                                //output mysql error if fail, DEV PURPOSE ONLY
                                //MUST HANDEL ERROR
                                echo "Error: " . $update . "<br>" . $conn->error;
                            }
                        } else {
                            $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Heikin_Ashi) VALUES('" . $row['atr_stock_id'] . "','Buy')";
                            if ($conn->query($insert) === TRUE){}
                            else{
                                //output mysql error if fail, DEV PURPOSE ONLY
                                //MUST HANDEL ERROR
                                echo "Error: " . $insert . "<br>" . $conn->error;
                            }
                        }
                    } elseif (($list[0] < $list[3]) && ($oldO < $oldC) && (abs($list[0] - $list[3]) > abs($oldO - $oldC)) && ($list[0] == $list[2])) {
                        $check = "SELECT Heikin_Ashi FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                        $checkResult = mysqli_query($conn, $check);
                        if ($checkResult->num_rows > 0){
                            $update = "UPDATE StockInfo.Buy_Sell_Hold SET Heikin_Ashi = 'Sell' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                            if ($conn->query($update) === TRUE){}
                            else{
                                //output mysql error if fail, DEV PURPOSE ONLY
                                //MUST HANDEL ERROR
                                echo "Error: " . $update . "<br>" . $conn->error;
                            }
                        } else {
                            $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Heikin_Ashi) VALUES('" . $row['atr_stock_id'] . "','Sell')";
                            if ($conn->query($insert) === TRUE){}
                            else{
                                //output mysql error if fail, DEV PURPOSE ONLY
                                //MUST HANDEL ERROR
                                echo "Error: " . $insert . "<br>" . $conn->error;
                            }
                        }
                    } else {
                        $check = "SELECT Heikin_Ashi FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                        $checkResult = mysqli_query($conn, $check);
                        if ($checkResult->num_rows > 0){
                            $update = "UPDATE StockInfo.Buy_Sell_Hold SET Heikin_Ashi = 'Hold' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                            if ($conn->query($update) === TRUE){}
                            else{
                                //output mysql error if fail, DEV PURPOSE ONLY
                                //MUST HANDEL ERROR
                                echo "Error: " . $update . "<br>" . $conn->error;
                            }
                        } else {
                            $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Heikin_Ashi) VALUES('" . $row['atr_stock_id'] . "','Hold')";
                            if ($conn->query($insert) === TRUE){}
                            else{
                                //output mysql error if fail, DEV PURPOSE ONLY
                                //MUST HANDEL ERROR
                                echo "Error: " . $insert . "<br>" . $conn->error;
                            }
                        }
                    }
                    $oldO = $list[0];
                    $oldC = $list[3];
                    //testing echo
                    //echo "INSERT/UPDATE #" . $initial . "<br>";
                    $initial = $initial +1;
                    //the last value for heikin ashi...Buy/sell/hold here
                } else {
                    
                    $list = Heikin($row['Open'], $row['High'], $row['Low'], $row['Close'], $oldO, $oldC);
                    $oldO = $list[0];
                    $oldC = $list[3];
                    //testing echo
                    //echo "Skip #" . $initial . "<br>";
                    $initial = $initial +1;
                }
            }
            
        }
    }
}

function Final_Decision(){
    session_start();
    include('connection.php');
    
    $selectFinal = "SELECT DISTINCT Symbol,Two_Period_RSI,Heikin_Ashi,other_method FROM StockInfo.Buy_Sell_Hold";
    $selectFinalResult = mysqli_query($conn, $selectFinal);
    
    if($selectFinalResult->num_rows > 0){
        while($row = $selectFinalResult->fetch_assoc()){
            if($row['Two_Period_RSI'] == 'Buy'){
                $update = "UPDATE StockInfo.Buy_Sell_Hold SET Final_Decision = 'Buy' WHERE Symbol='" . $row['Symbol'] . "'";
                if ($conn->query($update) === TRUE){}
                else{
                    //output mysql error if fail, DEV PURPOSE ONLY
                    //MUST HANDEL ERROR
                    echo "Error: " . $update . "<br>" . $conn->error;
                }
            } elseif ($row['Two_Period_RSI'] == 'Sell') {
                $update = "UPDATE StockInfo.Buy_Sell_Hold SET Final_Decision = 'Sell' WHERE Symbol='" . $row['Symbol'] . "'";
                if ($conn->query($update) === TRUE){}
                else{
                    //output mysql error if fail, DEV PURPOSE ONLY
                    //MUST HANDEL ERROR
                    echo "Error: " . $update . "<br>" . $conn->error;
                }
            } else {
                if ($row['Heikin_Ashi'] == 'Buy'){
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Final_Decision = 'Buy' WHERE Symbol='" . $row['Symbol'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } elseif ($row['Heikin_Ashi'] == 'Sell') {
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Final_Decision = 'Sell' WHERE Symbol='" . $row['Symbol'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Final_Decision = 'Hold' WHERE Symbol='" . $row['Symbol'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                }
            }
        }
    }
}

function Simulation(){
 session_start();
 include('connection.php');
 
 $select = "SELECT atr_stock_id, Timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp > (SELECT DISTINCT
 Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 100) order by atr_stock_id ASC, Timestamp ASC";
 $selectResult = mysqli_query($conn, $select);
 echo "hello";
 
 if ($selectResult->num_rows > 0){
 while($row = $selectResult->fetch_assoc()){
 echo "Hello Fam";
 }
 }
 }
?>
