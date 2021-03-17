<?php

session_start();

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$mysqli = new mysqli($server, $username, $password, $db) or die(mysqli_error($mysqli));

// $mysqli = new mysqli('127.0.0.1', 'root', '', 'crud') or die(mysqli_error($mysqli));

$update = false;
$name = $level = $address = '';


if (isset($_POST['submit'])){

    $name = $_POST['name'];
    $level = $_POST['level'];
    $address = $_POST['gmail'];

    
    $mysqli->query("INSERT INTO data (name, level, address) VALUES('$name', '$level', '$address')") or
    die($mysqli->error);
    
    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    header("location: index.php");
}
$id = 0;
if (isset($_GET['edit'])){
    
    $id = $_GET['edit'];

    $update = true;

    $user_data = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error);


    $row = $user_data->fetch_array();
    $name = $row['name'];
    $level = $row['level'];
    $address = $row['address'];

}

if (isset($_POST['update'])){

    $id = $_POST['id'];
    $name = $_POST['name'];
    $level = $_POST['level'];
    $address = $_POST['gmail'];

    $query = "UPDATE data SET name='$name', level='$level', address='$address' WHERE id='$id'";

    $mysqli->query($query) or
    die($mysqli->error);

	// mysqli_query($con, "UPDATE `data` SET name='$name', level='$level', address='$address' WHERE id=$id");
    
    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "success";

    header("location: index.php"); 
}
 
if (isset($_GET['delete'])){

    $id = $_GET['delete'];

    $mysqli->query("DELETE FROM data WHERE id=$id") or
    die($mysqli->error);

    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";

    header("location: index.php");
}