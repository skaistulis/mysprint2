<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "mysprint2";

    $conn = mysqli_connect($servername, $username, $password, $dbname); // Create connection

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully<br>";
?>

<table>
    


</table>


<?php

$sql = "SELECT id, name, project_id FROM employees";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>





</body>
</html>






