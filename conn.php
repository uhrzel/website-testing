<?php


// Create connection
$conn = new mysqli("localhost", "root", "arzelzolina10", "website-testing");

// Check connection
if ($conn->connect_error) {
    die("connection error");
}
