<?php
$conn = new mysqli("localhost", "root", "rads2007", "FitnessTracker");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
