<?php
//--------------------------------------------------------------------connection--------------------------------------------------------------- 
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "mysprint2";

    $conn = mysqli_connect($servername, $username, $password, $dbname); 

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>