<?php
session_start();
include 'config/db.php';

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $password = $_POST['pass'];

    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    
    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        
        // Verify the hashed password
        if (password_verify($password, $user_data['password'])) {
            $_SESSION['user_id'] = $user_data['id']; 
            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | Fitness Tracker</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh; background:#f4f1ea;">
    <div class="card" style="width:350px; text-align:center;">
        <h2 style="font-family:'Lora'; color:#5d6d5e;">Welcome Back</h2>
        <p style="color:#8ca38a; margin-bottom:20px;">Log in to your tracker</p>

        <form method="POST">
            <input type="text" name="user" placeholder="Username" required>
            <input type="password" name="pass" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <?php if($error) echo "<p style='color:#c58b73; font-size:0.9em; margin-top:15px;'>$error</p>"; ?>

        <p style="margin-top:25px; font-size:0.85em;">
            New to the tracker? <a href="signup.php" style="color:#c58b73;">Create Profile</a>
        </p>
    </div>
</body>
</html>
