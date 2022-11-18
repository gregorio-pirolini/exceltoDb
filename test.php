<?php
$conn = new mysqli("localhost", "root", "password", "dictee_magique");
// $conn = new mysqli("rdbms.strato.de", "U1210398", "dictee_magique2", "DB1210398");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  

/* change character set to utf8 */
if (!$conn->set_charset("utf8")) {
     $conn->error;
} else {
     $conn->character_set_name() ;
     echo 'all good!';
}