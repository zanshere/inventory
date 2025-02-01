<?php 

$conn = mysqli_connect("DB_HOST", "DB_USER", "DB_PASSWROD", "DB_NAME");

if($conn->connect_error){
    die("Can't Connect To Database : " . $conn->connect_error);
}

?>