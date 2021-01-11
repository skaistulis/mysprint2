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
//--------------------------------------------------------------------connection--------------------------------------------------------------- 
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "mysprint2";

    $conn = mysqli_connect($servername, $username, $password, $dbname); 

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully<br>";
?>
<header>
    <div class = "header_container">
        <h2><a href="./?path=Employees">Employees</a></h2>
        <h2><a href="./?path=Projects">Projects</a></h2>
    </div>
</header>
<br>
<?php
    $path = $_GET['path'];
// ------------------------------------------------------------------delete buttons--------------------------------------------------------------
    //delete employee
    if(isset($_GET['action']) and $_GET['action'] == 'deleteEmployee'){
        $sql = 'DELETE FROM employees WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $res = $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        header("location:./?path=Employees");
        die();
    }
    //delete project
    if(isset($_GET['action']) and $_GET['action'] == 'deleteProject'){
        $sql = 'DELETE FROM projects WHERE project_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $res = $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        header("location:./?path=Projects");
        die();
    }
//------------------------------------------------------------------------tables-----------------------------------------------------------------
    //employees table
    if($path == 'Employees') {
        $sql = "SELECT id, name, project_name FROM employees
                LEFT JOIN projects ON employees.project_id = projects.project_id";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) { //if in employees tbl is more than one result, then:
            echo "<table><tr><th>ID</th><th>Name</th><th>Projects</th><th>Actions</th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['project_id'] . '</td>
                    <td>' . '<a href="?action=deleteEmployee&id=' . $row['id'] . '"><button>delete</button></a><button>modify</button></td></tr>';
            } 
        } else echo "No results";
        mysqli_close($conn);

    //project table
    } else if ($path == 'Projects') {
        $sql = "SELECT group_concat(employees.name SEPARATOR ', ') AS 'Employees working on project', projects.project_id, projects.project_name 
                FROM projects 
                LEFT JOIN employees ON employees.project_id = projects.project_id
                GROUP BY project_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<table><tr><th>ID</th><th>Project</th><th>Employees working on project</th><th>Actions</th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
               echo '<tr><td>' . $row['project_id'] . '</td>
                    <td>' . $row['project_name'] . '</td>
                    <td>' . $row['Employees working on project'] . '</td>
                    <td>' . '<a href="?action=deleteProject&id=' . $row['project_id'] . '"><button>delete</button></a><button>modify</button></td></tr>';
                }
        } else echo "No results";
        mysqli_close($conn);  
    }
?>


</table>


</body>
</html>






