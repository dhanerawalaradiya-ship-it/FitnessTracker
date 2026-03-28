<?php
$workouts = $conn->query("SELECT * FROM workouts WHERE user_id = 1");
$step_check = $conn->query("SELECT step_goal FROM users WHERE id = 1")->fetch_assoc();
?>
<div class="card">
    <h2>Workout Plans</h2>
    <div class="ai-coach">
        ✨ <strong>AI Coach:</strong> 
        <?php echo ($step_check['step_goal'] > 8000) ? "High activity detected! Focus on recovery and stretching." : "Let's get moving! A 20min HIIT session is recommended."; ?>
    </div>
    <div style="margin-top:20px;">
        <?php while($w = $workouts->fetch_assoc()): ?>
            <div class="log-item">
                <strong><?php echo $w['workout_name']; ?></strong>
                <span style="color:#c58b73;"><?php echo $w['duration_mins']; ?> mins</span>
            </div>
        <?php endwhile; ?>
    </div>
</div>
