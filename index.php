<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/style.css">
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
<header>
    <div class = "header_container">
        <h2>Employees</h2>
        <h2>Projects</h2>
    </div>
</header>
<br>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Projects</th>
</tr>


<?php

$sql = "SELECT id, name, project_id FROM employees";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>" . "<td>" . $row["id"] . "</td>" . " <td> " . $row["name"]. "</td>" . "</tr>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>


</table>


</body>
</html>






