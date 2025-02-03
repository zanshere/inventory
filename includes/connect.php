<?php 

$conn = mysqli_connect("localhost", "root", "", "dashboard");

if($conn->connect_error){
    die("Can't Connect To Database : " . $conn->connect_error);
}

?>
