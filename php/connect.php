<?php
$conn = new mysqli("localhost", "root", "password", "abkürzungen");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  

 
