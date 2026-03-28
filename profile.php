<?php
$uid = $_SESSION['user_id']; 

if(isset($_POST['update_steps'])) {
    $steps = $_POST['step_count'];
    $conn->query("UPDATE users SET step_goal = '$steps' WHERE id = $uid");
}
$user_query = $conn->query("SELECT * FROM users WHERE id = $uid");
$user = $user_query->fetch_assoc();
?>
<div class="card">
    <h2>Profile & Steps</h2>
    <p>User: <strong><?php echo $user['username']; ?></strong></p>
    <p>Current Weight: <?php echo $user['weight']; ?>kg</p>
    <div class="ai-coach">
        👣 Today's Steps: <strong><?php echo $user['step_goal']; ?></strong> / 10,000
    </div>
    <form method="POST">
        <input type="number" name="step_count" placeholder="Update Steps">
        <button type="submit" name="update_steps">Sync Steps</button>
    </form>
</div>
