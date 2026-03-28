<?php
include 'config/db.php';

$error = "";
$success = "";

// Only run the logic IF the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    
    // Use the null coalescing operator (??) to prevent "Undefined Index" warnings
    $username = mysqli_real_escape_string($conn, $_POST['user'] ?? '');
    $pass = $_POST['pass'] ?? '';
    $conf_pass = $_POST['conf_pass'] ?? '';
    $age = (int)($_POST['age'] ?? 0);
    $weight = (float)($_POST['weight'] ?? 0);
    $height = (float)($_POST['height'] ?? 0);

    // 1. Check if username already exists
    $userCheck = $conn->query("SELECT id FROM users WHERE username = '$username'");
    
    // 2. Security Pattern (8+ chars, 1 Upper, 1 Number, 1 Special)
    $pattern = '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/';

    if ($userCheck->num_rows > 0) {
        $error = "Username already taken. Please choose another.";
    } elseif ($pass !== $conf_pass) {
        $error = "Passwords do not match!";
    } elseif (!preg_match($pattern, $pass)) {
        $error = "Password must be 8+ chars with 1 Uppercase, 1 Number, and 1 Special Character.";
    } else {
        // Rules passed - Securely hash the password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, password, age, weight, height, step_goal) 
                VALUES ('$username', '$hashed_pass', $age, $weight, $height, 0)";

        if ($conn->query($sql) === TRUE) {
            $success = "Account created! <a href='login.php' style='color:#c58b73;'>Login here</a>";
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Join | Fitness Tracker</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="card">
        <h2 style="text-align:center;">🌿 Fitness Tracker</h2>
        <p style="color:#8ca38a; text-align:center; margin-bottom:20px; font-size:0.9em;">Create your secure wellness profile</p>

        <form method="POST" action="signup.php">
            <input type="text" name="user" placeholder="Username" required>
            
            <input type="password" name="pass" placeholder="Password" required>
            <input type="password" name="conf_pass" placeholder="Confirm Password" required>
            
            <div style="font-size:0.75em; color:#8ca38a; margin:5px 0 10px 5px; line-height:1.4;">
                • 8+ Chars • 1 Uppercase • 1 Number • 1 Special Char
            </div>

            <div style="display:flex; gap:10px;">
                <input type="number" name="age" placeholder="Age" style="width:50%;" required>
                <input type="number" name="weight" placeholder="Kg" style="width:50%;" required>
            </div>
            <input type="number" name="height" placeholder="Height (cm)" required>
            
            <button type="submit" name="signup">Create Account</button>
        </form>

        <?php if($error): ?>
            <div class="error-msg" style="color:#c58b73; font-size:0.85em; margin-top:15px; text-align:center; background:#fdf2f0; padding:10px; border-radius:10px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="success-msg" style="color:#5d6d5e; font-size:0.85em; margin-top:15px; text-align:center; background:#f0f4f0; padding:10px; border-radius:10px;">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <p style="margin-top:20px; font-size:0.85em; text-align:center;">
            Already a member? <a href="login.php">Login here</a>
        </p>
    </div>
</body>
</html>
