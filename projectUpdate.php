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
//-----------------------------------------------------------project update--------------------------------------------------------------- 
require_once "connection.php";

// kai norim updateinti
if (isset($_GET['project_id'])) {
    $id =  $_GET['project_id'];
    $sql = "SELECT * FROM projects WHERE project_id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    //kai updeitinam
    if (isset($_POST['update'])) {
        if ($_POST['name'] != ''){
            $name = $_POST['name'];
            $sql = "UPDATE projects SET project_name='$name' WHERE project_id='$id'";
            mysqli_query($conn,$sql);
            mysqli_close($conn);
            header("location:./?path=Projects");
            die();
        } else {
            echo '<h3>Project name can not be empty!</h3>';
        }
    }
}
?>
<div class="updateDiv">
    <h4>UPDATE PROJECT NAME</h4>
    <form method="POST" class="formDiv">
        <input required type="text" name="name" value="<?php echo $row['project_name'] ?>">
        <input type="submit" name="update" value="Update">
    </form>   
</div>
