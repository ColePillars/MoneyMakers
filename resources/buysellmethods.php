<?php
//This page will hold the functions to the statistical methods that will determine
//whether to buy, sell,  or hold
session_start();
include('connection.php');

function Two_Period_RSI(){
    //session_start();
    include('connection.php');
    $selectRSI = "SELECT atr_stock_id, Timestamp, RSI FROM StockInfo.Technical_Analysis_RSI WHERE Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Technical_Analysis_RSI ORDER BY Timestamp DESC LIMIT 1 offset 1) 
        AND atr_stock_id IN (SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs) order by atr_stock_id ASC, Timestamp ASC";
    $selectRSIResult = mysqli_query($conn, $selectRSI);
    
    if($selectRSIResult->num_rows > 0){
        while($row = $selectRSIResult->fetch_assoc()){
            //sell if...
            if($row['RSI'] >= 90){
                $check = "SELECT Two_Period_RSI FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                $checkResult = mysqli_query($conn, $check);
                if ($checkResult->num_rows > 0){
                    //echo $row['atr_stock_id'] . " UPDATE SELL<br>";
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Two_Period_RSI = 'Sell' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    //echo $row['atr_stock_id'] . " INSERT SELL<br>";
                    $insert = "INSERT IGNORE INTO StockInfo.Buy_Sell_Hold(Symbol,Two_Period_RSI) VALUES('" . $row['atr_stock_id'] . "','Sell')";
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
                    //echo $row['atr_stock_id'] . " UPDATE BUY<br>";
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Two_Period_RSI = 'Buy' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    //echo $row['atr_stock_id'] . " INSERT BUY<br>";
                    $insert = "INSERT IGNORE INTO StockInfo.Buy_Sell_Hold(Symbol,Two_Period_RSI) VALUES('" . $row['atr_stock_id'] . "','Buy')";
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
                    //echo $row['atr_stock_id'] . " UPDATE HOLD<br>";
                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Two_Period_RSI = 'Hold' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                    if ($conn->query($update) === TRUE){}
                    else{
                        //output mysql error if fail, DEV PURPOSE ONLY
                        //MUST HANDEL ERROR
                        echo "Error: " . $update . "<br>" . $conn->error;
                    }
                } else {
                    //echo $row['atr_stock_id'] . " INSERT HOLD<br>";
                    $insert = "INSERT IGNORE INTO StockInfo.Buy_Sell_Hold(Symbol,Two_Period_RSI) VALUES('" . $row['atr_stock_id'] . "','Hold')";
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
    //session_start();
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

function Narrow_range(){
    include ('connection.php');
    /*$select = "SELECT atr_stock_id, Timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 8)
    AND atr_stock_id IN (SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs) order by atr_stock_id ASC, Timestamp ASC";
    */
    $select = "SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs order by atr_stock_id ASC";
    $skip = 0;
    $high = 0.0;
    $low = 0.0;
    $prevHigh = 0.0;
    $prevLow = 0.0;
    //echo $skip%7 . "<br>";
    $sevenDays = array(0,1,2,3,4,5,6);
    //echo $sevenDays[0]. "<br>";
    //echo $sevenDays[5];
    $selectResult = mysqli_query($conn, $select);
    if ($selectResult->num_rows > 0){
        while($stock = $selectResult->fetch_assoc()){
            $selectValues = "SELECT atr_stock_id, Timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE atr_stock_id = '" . $stock['atr_stock_id'] . "' AND Timestamp > (SELECT DISTINCT
         Timestamp FROM StockInfo.Time_Series_Daily WHERE atr_stock_id = '" . $stock['atr_stock_id'] . "' ORDER BY Timestamp DESC LIMIT 1 offset 8) order by  Timestamp ASC";
            $selectResultValues = mysqli_query($conn, $selectValues);
            if ($selectResultValues->num_rows > 0){
                while($row = $selectResultValues->fetch_assoc()){
                    $high = $row['High'];
                    $low = $row['Low'];
                    if (($skip%8) != 7){
                        $high = $row['High'];
                        $low = $row['Low'];
                        $sevenDays[$skip%8] = abs($high - $low);
                        if ($skip%8 == 5){
                            $prevLow = $low;
                            $prevHigh = $high;
                        }
                        //echo $row['atr_stock_id'] . " Skip= " . $skip%8 . " " . $row['High'] . " " . $row['Low'] . " " .$sevenDays[$skip%8] . "<br>";
                        $skip++;
                    } else {
                        
                        if (($sevenDays[6] < $sevenDays[0]) && ($sevenDays[6] < $sevenDays[1]) && ($sevenDays[6] < $sevenDays[2]) && ($sevenDays[6] < $sevenDays[3]) && ($sevenDays[6] < $sevenDays[4]) && ($sevenDays[6] < $sevenDays[5])){
                            if ($row['Close'] > $high){
                                $check = "SELECT Narrow_Range FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                                $checkResult = mysqli_query($conn, $check);
                                if ($checkResult->num_rows > 0){
                                    $update = "UPDATE StockInfo.Buy_Sell_Hold SET Narrow_Range = 'Buy' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                                    if ($conn->query($update) === TRUE){}
                                    else{
                                        //output mysql error if fail, DEV PURPOSE ONLY
                                        //MUST HANDEL ERROR
                                        echo "Error: " . $update . "<br>" . $conn->error;
                                    }
                                } else {
                                    $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Narrow_Range) VALUES('" . $row['atr_stock_id'] . "','Buy')";
                                    if ($conn->query($insert) === TRUE){}
                                    else{
                                        //output mysql error if fail, DEV PURPOSE ONLY
                                        //MUST HANDEL ERROR
                                        echo "Error: " . $insert . "<br>" . $conn->error;
                                    }
                                }
                                //echo $row['atr_stock_id'] . " " . $sevenDays[6] . " Is < : " . $sevenDays[0] . ", " . $sevenDays[1] . ", " . $sevenDays[2] . ", " . $sevenDays[3] . ", " . $sevenDays[4] . ", " . $sevenDays[5];
                                //echo "<br>";
                            } elseif (($high < $prevHigh) && ($low > $prevLow)){ /* additional parethasis here */
                                if (($row['High'] > $low) && ($low > $row['Low'])){
                                    //sell
                                    $check = "SELECT Narrow_Range FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                                    $checkResult = mysqli_query($conn, $check);
                                    if ($checkResult->num_rows > 0){
                                        $update = "UPDATE StockInfo.Buy_Sell_Hold SET Narrow_Range = 'Sell' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                                        if ($conn->query($update) === TRUE){}
                                        else{
                                            //output mysql error if fail, DEV PURPOSE ONLY
                                            //MUST HANDEL ERROR
                                            echo "Error: " . $update . "<br>" . $conn->error;
                                        }
                                    } else {
                                        $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Narrow_Range) VALUES('" . $row['atr_stock_id'] . "','Sell')";
                                        if ($conn->query($insert) === TRUE){}
                                        else{
                                            //output mysql error if fail, DEV PURPOSE ONLY
                                            //MUST HANDEL ERROR
                                            echo "Error: " . $insert . "<br>" . $conn->error;
                                        }
                                    }
                                }
                            }
                        } else {
                            $check = "SELECT Narrow_Range FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" . $row['atr_stock_id'] . "'";
                            $checkResult = mysqli_query($conn, $check);
                            if ($checkResult->num_rows > 0){
                                $update = "UPDATE StockInfo.Buy_Sell_Hold SET Narrow_Range = 'Hold' WHERE Symbol='" . $row['atr_stock_id'] . "'";
                                if ($conn->query($update) === TRUE){}
                                else{
                                    //output mysql error if fail, DEV PURPOSE ONLY
                                    //MUST HANDEL ERROR
                                    echo "Error: " . $update . "<br>" . $conn->error;
                                }
                            } else {
                                $insert = "INSERT INTO StockInfo.Buy_Sell_Hold(Symbol,Narrow_Range) VALUES('" . $row['atr_stock_id'] . "','Hold')";
                                if ($conn->query($insert) === TRUE){}
                                else{
                                    //output mysql error if fail, DEV PURPOSE ONLY
                                    //MUST HANDEL ERROR
                                    echo "Error: " . $insert . "<br>" . $conn->error;
                                }
                            }
                            //echo $row['atr_stock_id'] . " " . $sevenDays[6] . " IS NOT: " . $sevenDays[0] . ", " . $sevenDays[1] . ", " . $sevenDays[2] . ", " . $sevenDays[3] . ", " . $sevenDays[4] . ", " . $sevenDays[5];
                            //echo "<br>";
                        }
                        //echo $row['atr_stock_id'] . " ";
                        //echo $skip%8;
                        //echo "END OF DOING STUFF <br>";
                        $skip++;
                }
            }
            }
           
        }
    }
}

function Final_Decision(){
    //session_start();
    include('connection.php');
    
    $selectFinal = "SELECT DISTINCT Symbol,Two_Period_RSI,Heikin_Ashi,Narrow_Range FROM StockInfo.Buy_Sell_Hold";
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
    //session_start();
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
 }
 
 function Sim($stock){
     include('connection.php');
     
     function Heikin($O, $H, $L, $C, $oldO, $oldC){
         $HA_Close = ($O + $H + $L + $C)/4;
         $HA_Open = ($oldC + $oldO)/2;
         $HA_Low = min($L, $HA_Open, $HA_Close);
         $HA_High = max($H, $HA_Open, $HA_Close);
         return array($HA_Open, $HA_High, $HA_Low, $HA_Close);
     }
     
     $select = "SELECT StockInfo.Time_Series_Daily.atr_stock_id, StockInfo.Time_Series_Daily.Timestamp, StockInfo.Time_Series_Daily.Open,
     StockInfo.Time_Series_Daily.High, StockInfo.Time_Series_Daily.Low, StockInfo.Time_Series_Daily.Close, StockInfo.Technical_Analysis_RSI.RSI, StockInfo.Time_Series_Daily.Composite_Key
     FROM StockInfo.Time_Series_Daily INNER JOIN StockInfo.Technical_Analysis_RSI ON StockInfo.Time_Series_Daily.Composite_Key =
     StockInfo.Technical_Analysis_RSI.Composite_Key WHERE StockInfo.Time_Series_Daily.atr_stock_id = '" . $stock . "' AND StockInfo.Time_Series_Daily.Timestamp > (SELECT DISTINCT StockInfo.Time_Series_Daily.Timestamp FROM StockInfo.Time_Series_Daily 
     WHERE atr_stock_id = '" . $stock . "' ORDER BY StockInfo.Time_Series_Daily.Timestamp
         DESC LIMIT 1 offset 100) order by StockInfo.Time_Series_Daily.Timestamp ASC"; 
     $selectResult = mysqli_query($conn, $select);
     
     $counter = 0;
     $oldC = 0.0;
     $oldO = 0.0;
     $high = 0.0;
     $low = 0.0;
     $arrayHigh = array();
     $arrayLow = array();
     $FD = '';
     
     if ($selectResult->num_rows > 0){
         while($row = $selectResult->fetch_assoc()){
             //skip first 7 for 
             if ($counter < 7){
                 $oldO = $row['Open'];
                 $oldC = $row['Close'];
                 $high = $row['High'];
                 $low = $row['Low'];
                 array_push($arrayHigh, $high);
                 array_push($arrayLow, $low);
                 //echo $counter . "<br>";
                 //echo $row['Timestamp'] . "<br>";
             } else {
                 $list = Heikin($row['Open'], $row['High'], $row['Low'], $row['Close'], $oldO, $oldC);
                 
                 $one = abs($arrayHigh[$counter-7] - $arrayLow[$counter-7]);
                 $two = abs($arrayHigh[$counter-6] - $arrayLow[$counter-6]);
                 $three = abs($arrayHigh[$counter-5] - $arrayLow[$counter-5]);
                 $four = abs($arrayHigh[$counter-4] - $arrayLow[$counter-4]);
                 $five = abs($arrayHigh[$counter-3] - $arrayLow[$counter-3]);
                 $six = abs($arrayHigh[$counter-2] - $arrayLow[$counter-2]);
                 $seven = abs($arrayHigh[$counter-1] - $arrayLow[$counter-1]);
                 
                 //echo $arrayHigh[$counter] . "<br>";
                 //echo $arrayLow[$counter] . "<br>";
                 //echo $high . "  OK " . $low . "<br>";
                 //echo $one . "  WHAT " . $two . "<br>";
                 if($row['RSI'] > 85){
                     $FD = 'Sell';
                 } elseif ($row['RSI'] < 15){
                     $FD = 'Buy';
                 } else {
                     if(($seven < $six) && ($seven < $five) && ($seven < $four) && ($seven < $three) && ($seven < $two) && ($seven < $one)){
                         if($row['Close'] > $arrayHigh[$counter-1]){
                             $FD = 'Buy';
                         } elseif (($arrayHigh[$counter-1] < $arrayHigh[$counter-2]) && ($arrayLow[$counter-1] > $arrayLow[$counter-2])) {
                             if (($row['High'] > $arrayLow[$counter-1]) && ($arrayLow[$counter-1] > $row['Low'])){
                                 $FD = 'Sell';
                             }
                         }
                     } else {
                         if (($list[0] > $list[3]) && ($oldO > $oldC) && (abs($list[0] - $list[3]) > abs($oldO - $oldC)) && ($list[0] == $list[1])){
                             $FD = 'Buy';
                         } elseif (($list[0] < $list[3]) && ($oldO < $oldC) && (abs($list[0] - $list[3]) > abs($oldO - $oldC)) && ($list[0] == $list[2])){
                             $FD = 'Sell';
                         } else {
                             $FD = 'Hold';
                         }
                     }
                 }
                 
                 $oldO = $row['Open'];
                 $oldC = $row['Low'];
                 array_push($arrayHigh, $row['High']);
                 array_push($arrayLow, $row['Low']);
                 
                 $insert = "INSERT IGNORE INTO StockInfo.Simulation(Symbol,Timestamp,Close,Final_Decision,Composite_Key) VALUES('" . $row['atr_stock_id'] . "',
                    '" . $row['Timestamp'] ."', '" . $row['Close'] . "', '" . $FD . "' , '" . $row['atr_stock_id'] .  "_" . $row['Timestamp'] . "')";
                 if ($conn->query($insert) === TRUE){}
                 else{
                     //output mysql error if fail, DEV PURPOSE ONLY
                     //MUST HANDEL ERROR
                     echo "<br>Error: " . $insert . "<br>" . $conn->error;
                 }
             }
             $counter++;
             
         }
         
     }
 }
 Two_Period_RSI();
 Heikin_Ashi();
 Narrow_Range();
 Final_Decision();
 //Simulation();
 $stocks = array();
 $sim = "SELECT DISTINCT atr_stock_id FROM UserCredentials.tbl_stock_subs order by atr_stock_id ASC";
 $simResult = mysqli_query($conn, $sim);
 if ($simResult->num_rows > 0){
     while($subStock = $simResult->fetch_assoc()){
         echo $subStock['atr_stock_id'] . "<br>";
         array_push($stock,(string)$subStock['atr_stock_id']);
         //Sim($subStock['atr_stock_id']);
     }
 }
 
 //foreach($stocks as &$stock){
   //  Sim()
 //}
 
 //Sim('AA');
 //Sim('AAN');
 //Sim('ABBV');
 //Sim('ABM');
 //Sim('ACC');
 //Sim('ACCO');
 //Sim('ACH');
 //Sim('ACN');
 //Sim('ACP');
 //Sim('ADC');
 //Sim('ADNT');
 //Sim('ADX');
 //Sim('AED');
 //Sim('AEE');
 //Sim('AEG');
 //Sim('AEK');
 //Sim('AEM');
 //Sim('AEP');
 //Sim('AER');
 //Sim('AGC');
 //Sim('AGN');
 //Sim('AGS');
 //Sim('AGX');
 //Sim('AHP');
 //Sim('AHT');
 //Sim('AIF');
 
 //Sim('AIR');
 //Sim('AJG');
 //Sim('AJX');
 //Sim('AJXA');
 //Sim('ALEX');
 //Sim('ALK');
 //Sim('ALL');
 //Sim('ALLY');
 //Sim('AMN');
 //Sim('AMP');
 //('AN');
 //Sim('ANET');
 //Sim('APA');
 //Sim('ASH');
 //Sim('ATEN');
 //Sim('BA');
 //Sim('BAC');
 //Sim('BB');
 //Sim('BLK');
 
 //Sim('BXMT');
 //Sim('CHS');
 //Sim('CLDR');
 //Sim('CRD.A');
 //Sim('DDD');
 //Sim('EFC');
 //Sim('F');
 //Sim('FIT');
 //Sim('GJH');
 //Sim('GJP');
 //Sim('HGH');
 //Sim('HPE');
 //Sim('JKS');
 //Sim('JONE');
 //Sim('MYN');
 //Sim('ORCL');
 //Sim('OXM');
 //Sim('RHT');
 //Sim('SBS');
 //Sim('SPGI');
 //Sim('TWTR');
 //Sim('VMW');
 //Sim('WBAI');
 //Sim('WUBA');
 //Sim('XYL');
 //Sim('ZOES');
 //Sim('ZX');
 Sim('ZYME');
 
 
 
 
 
 
?>
