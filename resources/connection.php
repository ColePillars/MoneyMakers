 <?php
 
 //Define db variables
 $servername = "localhost";
 $username = "MoneyMakersDev";
 $password = "ConnectionDev12345";
 
 // Create connection
 $conn = new mysqli($servername, $username, $password);
 
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

 ?>
