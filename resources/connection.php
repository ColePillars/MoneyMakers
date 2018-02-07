 <?php
 
 //Define db variables
 $DBservername = "localhost";
 $DBusername = "MoneyMakersDev";
 $DBpassword = "ConnectionDev12345";
 
 // Create connection
 $conn = new mysqli($DBservername, $DBusername, $DBpassword);
 
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

 ?>
