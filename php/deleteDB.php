<?php
 
include 'connect.php';
 
$sql = "DELETE FROM abk";

if ($conn->query($sql) === TRUE) {
   $sql2 = "ALTER TABLE abk AUTO_INCREMENT = 0";
   $conn->query($sql2);


	echo "All deleted successfully!!" ;
	 } else {
        echo "there was an error" ;
     }

   
$conn->close();

 ?>