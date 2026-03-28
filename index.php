<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>CampusSync Fitness</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1 style="text-align:center; font-family:'Lora'; color:#5d6d5e;">CampusSync Fitness Dashboard</h1>
    <div class="dashboard-grid">
        <?php include 'modules/profile.php'; ?>
        <?php include 'modules/diet.php'; ?>
        <?php include 'modules/workout.php'; ?>
    </div>
</body>
</html>
