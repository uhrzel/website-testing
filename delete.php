<?php
include "conn.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM login WHERE id = ?"); // Prepare the statement
$stmt->bind_param("s", $id); // "s" means the database expects a string

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]); // Return success status
} else {
    echo json_encode(["status" => "error"]); // Return error status
}
