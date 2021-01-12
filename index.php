<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>CRUDapp</title>
</head>
<body>

<header>
    <div class = "header_container">
        <h2><a href="./?path=Employees">Employees</a></h2>
        <h2><a href="./?path=Projects">Projects</a></h2>
    </div>
</header>
<br>
<?php
    require_once "connection.php"; // Using database connection file here
    $path = $_GET['path'];
// ------------------------------------------------------------------delete buttons--------------------------------------------------------------
    //delete employee
    if(isset($_GET['action']) and $_GET['action'] == 'deleteEmployee'){
        $sql = 'DELETE FROM employees WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
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
        $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        header("location:./?path=Projects");
        die();
    }
//-----------------------------------------------------------------add new employee/project logic------------------------------------------------
//add new employee
    if(isset($_POST['firstname'])){
        if ($_POST['firstname'] != ''){
            $firstname = $_POST['firstname'];
            echo $firstname;
            $sql = 'INSERT INTO employees (name) VALUES (?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $firstname);
            $stmt->execute();
            $stmt->close();
            mysqli_close($conn);
            header("location:./?path=Employees");
            die(); 
        } else echo '<h3>Employee name can not be empty!</h3>'; 
    }

//add new project 
    if(isset($_POST['projectname'])){
        if ($_POST['projectname'] != ''){
            $projectname = $_POST['projectname'];
            $sql = 'INSERT INTO projects (project_name) VALUES (?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $projectname);
            $stmt->execute();
            $stmt->close();
            mysqli_close($conn);
            header("location:./?path=Projects");
            die();  
        } else echo '<h3>Project name can not be empty!</h3>'; 
    }
//------------------------------------------------------------------------tables-----------------------------------------------------------------
    //employees table----------------
    if($path == 'Employees') {
       ?>
       <!----------- add new employee form-------------------->
        <form action="" method="POST" class="addForm">
        <input type="text" name="firstname" id="firstname" placeholder="Employee name" Required>
        <input type="submit" name="submit" value="Add new employee">
        </form><br>
        <!------------------form ends-------------------------->
        <?php
        $sql = "SELECT id, name, project_name FROM employees
                LEFT JOIN projects ON employees.project_id = projects.project_id
                ORDER BY id";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) { //if in employees tbl is more than one result, then:
            echo "<table><tr><th>ID</th><th>Name</th><th>Project</th><th>Actions</th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['project_name'] . '</td>
                    <td class="actions">' . '<a href="?action=deleteEmployee&id=' . $row['id'] . '"><button>Delete</button></a>';
                ?>
                <form action='employeeUpdate.php?name="<?php echo $row['id']; ?>"' method="get">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="submit" name="submit" value="Update">
                </form>
            <?php
            } 
        } else echo "No results";
        mysqli_close($conn);

    //project table------------------------
    } else if ($path == 'Projects') {
        ?>
        <!-- ------- add new project form---------------------->
        <form action="" method="POST" class="addForm">
        <input type="text" name="projectname" id="projectname" placeholder="Project name" Required>
        <input type="submit" name="submit" value="Add new project">
        </form><br>
        <!-- ---------------form ends-------------------------->
        <?php 
        $sql = "SELECT group_concat(employees.name SEPARATOR ', ') AS 'Employees', projects.project_name, projects.project_id 
                FROM projects 
                LEFT JOIN employees ON employees.project_id = projects.project_id
                GROUP BY project_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<table><tr><th>ID</th><th>Project</th><th>Employees</th><th>Actions</th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
               echo '<tr><td>' . $row['project_id'] . '</td>
                    <td>' . $row['project_name'] . '</td>
                    <td>' . $row['Employees'] . '</td>
                    <td>' . '<div class="actions"><a href="?action=deleteProject&id=' . $row['project_id'] . '"><button>Delete</button></a>'; 
                ?>
                    <form action='projectUpdate.php?name="<?php echo $row['id']; ?>"' method="GET">
                        <input type="hidden" name="project_id" value="<?php echo $row['project_id']; ?>">
                        <input type="submit" name="submit" value="Update">
                    </form></div></td></tr>
                <?php
            }
        } else echo "No results";
        mysqli_close($conn);  
    }
    ?>
</table>
</body>
</html>






