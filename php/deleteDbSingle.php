<?php
include 'connect.php';
 
$id= $_POST['key']; 

// $filename = $_FILES['file']['name'];
 

// formData.append("file", fileupload.files[0]);
// const response = await fetch("php/upload.php", {
// $filename = $_FILES['file']['name'];



$sql = "DELETE FROM abk where id = $id";

if ($conn->query($sql) === TRUE) {
    


	echo "deleted successfully!!" ;
	 } else {
        echo "there was an error" ;
     }

   
$conn->close();

 ?>