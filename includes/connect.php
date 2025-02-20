<?php 

$conn = mysqli_connect("DB_HOST", "DB_USER", "DB_PASS", "YOUR_DATABASE");

if($conn->connect_error){
    die("Can't Connect To Database : " . $conn->connect_error);
}

?>
