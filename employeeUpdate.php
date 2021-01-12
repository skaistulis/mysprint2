<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUDapp</title>
    <link rel="stylesheet" type="text/css" href="./css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
<?php
//-----------------------------------------------------------project update------------------------------------------------------------
require_once "connection.php";

//kai norime updeitint
if (isset($_GET['id'])) {
    $id =  $_GET['id'];
    $sql = "SELECT * FROM employees WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    //kai updeitinam
    if (isset($_POST['update'])) {
        if ($_POST['name'] != ''){
            $name = $_POST['name'];
            $projects = $_POST['project_id'];
            $sql = "UPDATE employees SET name='$name', project_id='$projects' WHERE id='$id'";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            header("location:./?path=Employees");
            die();
        } else {
            echo '<h3>Employee name can not be empty!</h3>';
        }
    }
}
?>
<div class="updateDiv">
    <h4>Update Employee data</h4>
    <form method="POST" class="formDiv">
        <label for="name">Update name:</label>
        <input required type="text" id="name" name="name" value="<?php echo $row['name'] ?>" >
        <label for="project_id">Choose the project:</label>
        <select id="project_id" name="project_id">
            <option value='' disabled selected style='display:none;'>Projects:</option>
            <?php
            $sql = "SELECT projects.project_id, projects.project_name FROM projects";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                   echo '<option value="' . $row['project_id'] . '">' . $row['project_name'] . '</option>';
                }
            } 
            ?>
        </select>
        <input type="submit" name="update" value="Update" class="nice_btn"> 
    </form>
</div>
</body>
</html>