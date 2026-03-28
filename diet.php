<?php
if(isset($_POST['add_meal'])) {
    $name = $_POST['meal_name'];
    $cal = $_POST['cals'];
    $conn->query("INSERT INTO diet_logs (user_id, item_name, calories, log_date) VALUES (1, '$name', '$cal', CURDATE())");
}
$logs = $conn->query("SELECT * FROM diet_logs WHERE user_id = 1 ORDER BY id DESC LIMIT 3");
?>
<div class="card">
    <h2>Diet & Recipes</h2>
    <form method="POST">
        <input type="text" name="meal_name" placeholder="Recipe Name">
        <input type="number" name="cals" placeholder="Calories">
        <button type="submit" name="add_meal">Log Nourishment</button>
    </form>
    <h3>Recent Logs</h3>
    <?php while($row = $logs->fetch_assoc()): ?>
        <div class="log-item"><span><?php echo $row['item_name']; ?></span> <span><?php echo $row['calories']; ?> kcal</span></div>
    <?php endwhile; ?>
</div>
