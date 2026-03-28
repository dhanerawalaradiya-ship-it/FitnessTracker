<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'config/db.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fitness Tracker</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div style="max-width:1200px; margin:auto;">
        <a href="logout.php" style="float:right; color:#c58b73; text-decoration:none; font-weight:bold;">Logout</a>
        <h1 style="font-family:'Lora'; color:#5d6d5e;">Dashboard</h1>
        
        <div class="dashboard-grid">
            <?php include 'modules/profile.php'; ?>
            <?php include 'modules/diet.php'; ?>
            <?php include 'modules/workout.php'; ?>
        </div>
    </div>
</body>
</html>
