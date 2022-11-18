<?php
// echo 'hello';
/* Get the name of the uploaded file */
$filename = $_FILES['file']['name'];

/* Choose where to save the uploaded file */
$location = "upload/".$filename;
 
/* Save the uploaded file to the local filesystem */
if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) { 

  $text='this was a succes Greg! 成功 seikō'; 
} else { 
  $text='this was a Failure Greg! 不成功';   
}

$answer['text']=$text;
$answer ['location']=$location;




echo json_encode($answer);
?>