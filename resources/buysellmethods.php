<?php
//This page will hold the functions to the statistical methods that will determine
//whether to buy, sell,  or hold
session_start();
include('connection.php');

function Two_Period_RSI(){
    session_start();
    include('connection.php');
    $selectRSI = "SELECT atr_stock_id, Timestamp, RSI FROM StockInfo.Technical_Analysis_RSI WHERE Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Technical_Analysis_RSI ORDER BY Timestamp DESC LIMIT 1 offset 1) 
        AND atr_stock_id IN (SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs) order by atr_stock_id ASC, Timestamp ASC";
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
         Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 11)
    AND atr_stock_id IN (SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs) order by atr_stock_id ASC, Timestamp ASC";
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

//MAKE SURE THAT NEW SUBBED STOCKS GET UPDATED TOO
function Simulation(){
    session_start();
    include('connection.php');
    
    function Heikin($O, $H, $L, $C, $oldO, $oldC){
        $HA_Close = ($O + $H + $L + $C)/4;
        $HA_Open = ($oldC + $oldO)/2;
        $HA_Low = min($L, $HA_Open, $HA_Close);
        $HA_High = max($H, $HA_Open, $HA_Close);
        return array($HA_Open, $HA_High, $HA_Low, $HA_Close);
    }
    
    
    /*$select = "SELECT StockInfo.Time_Series_Daily.atr_stock_id, StockInfo.Time_Series_Daily.Timestamp, StockInfo.Time_Series_Daily.Open, 
            StockInfo.Time_Series_Daily.High, StockInfo.Time_Series_Daily.Low, StockInfo.Time_Series_Daily.Close, StockInfo.Technical_Analysis_RSI.RSI 
            FROM StockInfo.Time_Series_Daily INNER JOIN StockInfo.Technical_Analysis_RSI ON StockInfo.Time_Series_Daily.Composite_Key = 
            StockInfo.Technical_Analysis_RSI.Composite_Key WHERE StockInfo.Time_Series_Daily.Timestamp > (SELECT DISTINCT StockInfo.Time_Series_Daily.Timestamp FROM StockInfo.Time_Series_Daily ORDER BY StockInfo.Time_Series_Daily.Timestamp 
            DESC LIMIT 1 offset 100) AND StockInfo.Time_Series_Daily.atr_stock_id IN (SELECT DISTINCT UserCredentials.tbl_stock_subs.atr_stock_id FROM UserCredentials.tbl_stock_subs) 
            order by atr_stock_id ASC, StockInfo.Time_Series_Daily.Timestamp ASC";
    $selectResult = mysqli_query($conn, $select);*/
    
    //$heikin  = array();
    $initial = 100;
    $oldC = 0;
    $oldO = 0;
    
    /*$selectRSI = "SELECT atr_stock_id, Timestamp, RSI FROM StockInfo.Technical_Analysis_RSI WHERE Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Technical_Analysis_RSI ORDER BY Timestamp DESC LIMIT 1 offset 99)
        AND atr_stock_id IN (SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs) order by atr_stock_id ASC, Timestamp ASC";
    $selectRSIResult = mysqli_query($conn, $selectRSI);
    
    $rsi = array();
    
    if($selectRSIResult->num_rows > 0){
        while($row = $selectRSIResult->fetch_assoc()){
            //sell if...
            //echo $row['atr_stock_id'];
            if($row['RSI'] >= 90){
                array_push($rsi, $row['atr_stock_id'], $row['Timestamp'],'Sell');
                //buy if...
            } elseif ($row['RSI'] <= 10) {
                array_push($rsi, $row['atr_stock_id'], $row['Timestamp'],'Buy');
                //else hold...
            } else {
                array_push($rsi, $row['atr_stock_id'], $row['Timestamp'],'Hold');
            }
        }
    }*/
 
    $select = "SELECT atr_stock_id, Timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 100)
        AND atr_stock_id IN (SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs) order by atr_stock_id ASC, Timestamp ASC";
    $selectResult = mysqli_query($conn, $select);
    
    //$heikin  = array();
    $initial = 0;
    $oldC = 0;
    $oldO = 0;
    $lastSymbol = "";
    
    if ($selectResult->num_rows > 0){
        while($row = $selectResult->fetch_assoc()){
            if (($lastSymbol != $row['atr_stock_id'])){
                $oldO = $row['Open'];
                $oldC = $row['Close'];
                $lastSymbol = $row['atr_stock_id'];
                //testing echo
                //echo "INITIAL SYMBOL SKIP#" . $initial . "<br>";
                $initial = $initial +1;
            } else {
                $list = Heikin($row['Open'], $row['High'], $row['Low'], $row['Close'], $oldO, $oldC);
                
                if(($list[0] > $list[3]) && ($oldO > $oldC) && (abs($list[0] - $list[3]) > abs($oldO - $oldC)) && ($list[0] == $list[1])){
                    $insert = "INSERT IGNORE INTO StockInfo.Simulation(Symbol,Timestamp,Close,Final_Decision,Composite_Key) VALUES('" . $row['atr_stock_id'] . "',
                    '" . $row['Timestamp'] ."', '" . $row['Close'] . "', 'Buy','" . $row['atr_stock_id'] .  "_" . $row['Timestamp'] . "')";
                    //array_push($heikin, $row['atr_stock_id'], $row['Timestamp'],'Buy');
                    if ($conn->query($insert) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "<br>Error: " . $insert . "<br>" . $conn->error;
                    }
                    
                } elseif (($list[0] < $list[3]) && ($oldO < $oldC) && (abs($list[0] - $list[3]) > abs($oldO - $oldC)) && ($list[0] == $list[2])) {
                    $insert = "INSERT IGNORE INTO StockInfo.Simulation(Symbol,Timestamp,Close,Final_Decision,Composite_Key) VALUES('" . $row['atr_stock_id'] . "',
                    '" . $row['Timestamp'] ."', '" . $row['Close'] . "', 'Sell', '" . $row['atr_stock_id'] .  "_" . $row['Timestamp'] . "')";
                    //array_push($heikin, $row['atr_stock_id'], $row['Timestamp'],'Sell');
                    if ($conn->query($insert) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "<br>Error: " . $insert . "<br>" . $conn->error;
                    }
                } else {
                        $insert = "INSERT IGNORE INTO StockInfo.Simulation(Symbol,Timestamp,Close,Final_Decision,Composite_Key) VALUES('" . $row['atr_stock_id'] . "',
                        '" . $row['Timestamp'] ."', '" . $row['Close'] . "', 'Hold', '" . $row['atr_stock_id'] .  "_" . $row['Timestamp'] . "')";
                        //array_push($heikin, $row['atr_stock_id'], $row['Timestamp'],'Hold');
                        if ($conn->query($insert) === TRUE){}
                        else{
                            //output mysql error if fail, DEV PURPOSE ONLY
                            //MUST HANDEL ERROR
                            echo "<br>Error: " . $insert . "<br>" . $conn->error;
                        }
                    }
                }
                $oldO = $list[0];
                $oldC = $list[3];
                //testing echo
                //echo "INSERT/UPDATE #" . $initial . "<br>";
                $initial = $initial +1;
                $lastSymbol = $row['atr_stock_id'];
                //the last value for heikin ashi...Buy/sell/hold here
            }
        }
        /*echo count($rsi);
        echo "<br>";
        echo count($heikin);
        echo "<br>";
        echo count($rsi)/3;
        echo "<br>";
        echo count($heikin)/3;
        echo "<br>";
        echo count($rsi)/99;
        echo "<br>";
        echo count($heikin)/99;
        /*for($i = 2; $i < (count($rsi)-1); $i+=3){
            
            if ($rsi[$i] == 'Buy'){
                echo $heikin[$i];
                echo $heikin[$i-1];
                echo $heikin[$i-2];
                echo "<br>";
                echo $rsi[$i];
                echo $rsi[$i-1];
                echo $rsi[$i-2];
                echo "<br> RSI: BUY <BR>";
                $update = "UPDATE StockInfo.Simulation SET Final_Decision = 'Buy' WHERE Symbol='" . $rsi[$i-2] . "' 
                            AND Timestamp ='" . $rsi[$i-1] . "'";
                if ($conn->query($update) === TRUE){}
                else{
                    //output mysql error if fail, DEV PURPOSE ONLY
                    //MUST HANDEL ERROR
                    echo "Error: " . $update . "<br>" . $conn->error;
                }
            } elseif ($rsi[$i] == 'Sell') {
                echo $heikin[$i];
                echo $heikin[$i-1];
                echo $heikin[$i-2];
                echo "<br>";
                echo $rsi[$i];
                echo $rsi[$i-1];
                echo $rsi[$i-2];
                echo "<br> RSI: SELL <BR>";
                $update = "UPDATE StockInfo.Simulation SET Final_Decision = 'Sell' WHERE Symbol='" . $rsi[$i-2] . "' 
                            AND Timestamp ='" . $rsi[$i-1] . "'";
                if ($conn->query($update) === TRUE){}
                else {
                    //output mysql error if fail, DEV PURPOSE ONLY
                    //MUST HANDEL ERROR
                    echo "Error: " . $update . "<br>" . $conn->error;
                }
            } else {
                if ($heikin[$i] == 'Buy'){
                    echo $heikin[$i];
                    echo $heikin[$i-1];
                    echo $heikin[$i-2];
                    echo "<br>";
                    echo "<br>";
                    echo $rsi[$i];
                    echo $rsi[$i-1];
                    echo $rsi[$i-2];
                    echo "<br> Heikin: BUY <BR>";
                    $update = "UPDATE StockInfo.Simulation SET Final_Decision = 'Buy' WHERE Symbol='" . $heikin[$i-2] . "' 
                                AND Timestamp ='" . $heikin[$i-1] . "'";
                    if ($conn->query($update) === TRUE){}
                    else {
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } elseif ($heikin[$i] == 'Sell') {
                    echo $heikin[$i];
                    echo $heikin[$i-1];
                    echo $heikin[$i-2];
                    echo "<br>";
                    echo $rsi[$i];
                    echo $rsi[$i-1];
                    echo $rsi[$i-2];
                    echo "<br> Heikin: SELL <BR>";
                    $update = "UPDATE StockInfo.Simulation SET Final_Decision = 'Sell' WHERE Symbol='" . $heikin[$i-2] . "' 
                                AND Timestamp ='" . $heikin[$i-1] . "'";
                    if ($conn->query($update) === TRUE){}
                    else {
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    echo $heikin[$i];
                    echo $heikin[$i-1];
                    echo $heikin[$i-2];
                    echo "<br>";
                    echo $rsi[$i];
                    echo $rsi[$i-1];
                    echo $rsi[$i-2];
                    echo "<br> RSI: HOLD <BR>";
                    $update = "UPDATE StockInfo.Simulation SET Final_Decision = 'Hold' WHERE Symbol='" . $heikin[$i-2] . "' 
                                AND Timestamp ='" . $heikin[$i-1] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                }
            }
        }*/
        //echo $rsi[1] . "<br>";
        //echo $heikin[1] . "<br>";*/
 }
 
 Simulation();
?>
