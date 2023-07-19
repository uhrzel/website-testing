<?php
include "conn.php";

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];

$query = "UPDATE login SET username = '$username', password = '$password' WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
