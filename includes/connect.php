<?php 

$conn = mysqli_connect("DB_NAME", "DB_USER", "DB_PASS", "YOUR_DB");

if($conn->connect_error){
    die("Can't Connect To Database : " . $conn->connect_error);
}

?>



