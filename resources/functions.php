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
    
    
    
    
    
    
    
    
  
    
    //Search all fiels for the substring and dump results to table,
    //Possibly also include number of results per page
    // or have a scrollable tabel instead of a page
    
   // $SearchString ='Ford';
    
    
    $SearchSQL = "
    SELECT *
    FROM StockInfo.Stock_Symbol_Index
    WHERE Symbol LIKE '%" . $SearchString . "%'
    OR NAME LIKE '%" . $SearchString . "%'
    OR Sector LIKE '%" . $SearchString . "%'
    OR Industry LIKE '%" . $SearchString . "%'";

    //echo $SearchSQL;

    
    $EvenCounter = 1;
    
    
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



Function FetchLastTenDaysChart($StockSymbol){
 
    // include connections page
    include('connection.php');

    
    $ShowLastTenSQL = "SELECT atr_Stock_id, timestamp, Open, High, Low, Close FROM StockInfo.Time_Series_Daily WHERE Timestamp > (SELECT DISTINCT Timestamp FROM StockInfo.Time_Series_Daily ORDER BY Timestamp DESC LIMIT 1 offset 11) AND atr_Stock_id = '" . $StockSymbol . "' order by atr_stock_id ASC, Timestamp DESC";
        
        $SkipCounter = 0;
    
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
                
                if ($SkipCounter <> 0) {
                $Difference = round($row['Close'] - $PreviousClose,2);
                $PDifference = round((($Difference / $PreviousClose) * 100),2) . "%";
                   echo "
            <tr>
           
            <td>"  . substr($row['timestamp'], 0, 10) . "</td>
            <td>"  . $row['Close'] . "</td>
            <td>"  . $Difference .  "</td>
<td>"  . $PDifference .  "</td>
            </tr>";
                    

                   
                    $PreviousClose = $row['Close'];
              }else{
                    
                  
                    
                   $PreviousClose = $row['Close'];
                }
                
             
               
                $SkipCounter = $SkipCounter  +1;
              
            }
            
            echo "
      </tbody>
       </table>
        ";
                 
        }  
        else{
            
            echo $conn->error;
            
        }
        
        
        
        
   
        
}



?>