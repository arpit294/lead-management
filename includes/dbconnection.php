<?php


$conn = mysqli_connect("localhost", "root", "", "lead_manage");
if ($conn) {

    // echo "connected successfully";
} else {
    die("Connection failed: " . mysqli_connect_error());
}

?>



