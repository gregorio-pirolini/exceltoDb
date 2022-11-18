<?php

include 'connect.php';

$sql = "select * from abk";
$return=[];
$return['error']=0;
$result =  $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $return['error']=0;
$arr=[];
$arr["id"]=$row["id"];
$arr["kurz"]=$row["kurz"];
$arr["lang"]=$row["lang"];
$arr["meaning"]=$row["meaning"];
array_push($return,$arr);
}
  } else {
    $return['error']=1;
  }



   echo json_encode($return);
//   echo '<pre>';
//   print_r($return);
//   echo '</pre>';
$conn->close();

 ?>