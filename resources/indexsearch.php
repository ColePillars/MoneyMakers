<?php 
session_start();
include ('../resources/connection.php');

if(!empty($_GET['search'])){
    
    $search = $_GET['search'];
    //$sql = "SELECT Name, LEVENSHTEIN(Name,'" . $search . "') AS distance
    //FROM StockInfo.Stock_Stock_Symbol_Index WHERE Name LIKE '%" . $search . "%' 
    //ORDER BY distance DESC";
    $sql = "SELECT Symbol, Name FROM StockInfo.Stock_Symbol_Index WHERE Name LIKE '%" . $search . "%'";
    $sqlResult = mysqli_query($conn, $sql);
    
    if($sqlResult->num_rows > 0){
        //echo "<table style='left: 63px; width: 548px; height: 200px; display: block;'><tbody>";
        while($row = $sqlResult->fetch_assoc()){
            $lev = similar_text($search, $row['Name']);
            //echo "<a>" . $lev . "</a><br>";
            //if($lev > 1){
                echo "<a href='../pages/stockpage.php?Symbol=" . $row['Symbol'] . "'>" . $row['Name'] . " (" . $row['Symbol'] . ")<br></a>";
             //}
        }
        //echo "</tbody></table>";
    }
}


?>