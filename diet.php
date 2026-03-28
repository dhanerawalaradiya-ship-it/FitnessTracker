<?php
$uid = $_SESSION['user_id']; 

if(isset($_POST['add_meal'])) {
    $name = mysqli_real_escape_string($conn, $_POST['meal_name']);
    $cal = $_POST['cals'];
    // Use $uid so the food is "owned" by the right person
    $conn->query("INSERT INTO diet_logs (user_id, item_name, calories, log_date) 
                  VALUES ($uid, '$name', $cal, CURDATE())");
}

// Only show logs for the current user
$logs = $conn->query("SELECT * FROM diet_logs WHERE user_id = $uid ORDER BY id DESC LIMIT 3");
?>
<div class="card">
    <h2>Diet Tracker</h2>
    <form method="POST">
        <input type="text" name="meal_name" placeholder="Meal/Recipe Name" required>
        <input type="number" name="cals" placeholder="Calories" required>
        <button type="submit" name="add_meal">Add to Log</button>
    </form>
    <h3>Recent Nutrition</h3>
    <?php while($row = $logs->fetch_assoc()): ?>
        <div class="log-item">
            <span><?php echo $row['item_name']; ?></span>
            <span><?php echo $row['calories']; ?> kcal</span>
        </div>
    <?php endwhile; ?>
</div>
