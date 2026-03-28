<?php
// 1. Get the current logged-in ID
$uid = $_SESSION['user_id']; 

// 2. Fetch the workouts for THIS user
$workouts = $conn->query("SELECT * FROM workouts WHERE user_id = $uid");

// 3. Fetch the step goal for the AI Coach logic
$step_query = $conn->query("SELECT step_goal FROM users WHERE id = $uid");
$user_data = $step_query->fetch_assoc(); // We name this $user_data to fix your error
?>

<div class="card">
    <h2>Workouts & AI Coach</h2>
    <div class="ai-coach">
        ✨ <strong>Coach:</strong> 
        <?php 
            // Now $user_data['step_goal'] exists and won't throw a warning
            if($user_data['step_goal'] < 3000) {
                echo "You've been still today. Try a light 15-min walk.";
            } elseif($user_data['step_goal'] < 8000) {
                echo "Good pace! Ready for a 30-min HIIT session?";
            } else {
                echo "Amazing activity! Focus on protein and recovery tonight.";
            }
        ?>
    </div>
    
    <div style="margin-top:15px;">
        <?php if($workouts->num_rows > 0): ?>
            <?php while($w = $workouts->fetch_assoc()): ?>
                <div class="log-item">
                    <strong><?php echo htmlspecialchars($w['workout_name']); ?></strong>
                    <span style="color:#c58b73;"><?php echo $w['duration_mins']; ?>m</span>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="font-size:0.8em; color:#999;">No custom plans yet.</p>
        <?php endif; ?>
    </div>
</div>
