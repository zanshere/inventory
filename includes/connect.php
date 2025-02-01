<?php 

$conn = mysqli_connect("DB_HOST", "DB_USER", "DB_PASSWORD", "DB_NAME");

if($conn->connect_error){
    die("Can't Connect To Database : " . $conn->connect_error);
}

?>