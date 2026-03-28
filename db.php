<?php
$conn = new mysqli("localhost", "root", "", "FitnessTracker");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
