<?php 

$conn = mysqli_connect("localhost", "root", "", "db_inventory");

if($conn->connect_error){
    die("Can't Connect To Database : " . $conn->connect_error);
}

?>



