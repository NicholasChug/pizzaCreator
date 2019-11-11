<?php 
// Connect to the database
    $conn = mysqli_connect('localhost', 'nick', 'nick1234', 'ninja_pizza');

    // Check the connection
    if (!$conn) {
        echo 'Connection Error' . mysqli_connect_error();
    }

?>