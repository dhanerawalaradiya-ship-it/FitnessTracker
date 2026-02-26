<?php
session_start();

/* DATABASE CONNECTION */
$conn = new mysqli("localhost","root","","fitness_tracker");
if($conn->connect_error){
    die("Connection Failed");
}

/* REGISTER */
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $goal = $_POST['goal'];

    $conn->query("INSERT INTO users (name,email,password,fitness_goal,calorie_goal,steps_goal,height,weight)
                  VALUES ('$name','$email','$password','$goal',2000,8000,0,0)");
}

/* LOGIN */
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
    }
}

/* LOGOUT */
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: profile_module.php");
}

/* UPDATE PROFILE */
if(isset($_POST['update'])){
    $id = $_SESSION['user_id'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $calorie = $_POST['calorie_goal'];
    $steps = $_POST['steps_goal'];

    $conn->query("UPDATE users SET height='$height', weight='$weight',
                  calorie_goal='$calorie', steps_goal='$steps'
                  WHERE id=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile Module</title>
<style>
body {
    background:#FFF8ED;
    font-family: Arial;
    text-align:center;
}
.card {
    background:#F5E6D3;
    padding:20px;
    margin:20px auto;
    width:320px;
    border-radius:15px;
    box-shadow:0px 4px 8px rgba(0,0,0,0.1);
}
input, select {
    padding:8px;
    margin:5px;
    width:90%;
}
button {
    background:#2F5D50;
    color:white;
    padding:10px;
    border:none;
    border-radius:20px;
    cursor:pointer;
}
a { text-decoration:none; color:#2F5D50; }
</style>
</head>
<body>

<h2>🌿 Fitness Profile Module</h2>

<?php if(!isset($_SESSION['user_id'])) { ?>

<!-- REGISTER -->
<div class="card">
<h3>Register</h3>
<form method="POST">
<input type="text" name="name" placeholder="Name" required><br>
<input type="email" name="email" placeholder="Email" required><br>
<input type="password" name="password" placeholder="Password" required><br>

<select name="goal">
<option>Weight Loss</option>
<option>Muscle Gain</option>
<option>Maintain Fitness</option>
</select><br>

<button name="register">Register</button>
</form>
</div>

<!-- LOGIN -->
<div class="card">
<h3>Login</h3>
<form method="POST">
<input type="email" name="email" placeholder="Email" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button name="login">Login</button>
</form>
</div>

<?php } else {

$id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

/* BMI Calculation */
$bmi = 0;
if($user['height'] > 0){
    $bmi = $user['weight'] / (($user['height']/100) * ($user['height']/100));
}
?>

<!-- PROFILE VIEW -->
<div class="card">
<h3>My Profile 🌿</h3>
<p><b>Name:</b> <?php echo $user['name']; ?></p>
<p><b>Email:</b> <?php echo $user['email']; ?></p>
<p><b>Goal:</b> <?php echo $user['fitness_goal']; ?></p>
<p><b>Calorie Goal:</b> <?php echo $user['calorie_goal']; ?></p>
<p><b>Steps Goal:</b> <?php echo $user['steps_goal']; ?></p>
<p><b>BMI:</b> <?php echo round($bmi,2); ?></p>
</div>

<!-- EDIT PROFILE -->
<div class="card">
<h3>Update Profile</h3>
<form method="POST">
<input type="number" name="height" placeholder="Height (cm)" required><br>
<input type="number" name="weight" placeholder="Weight (kg)" required><br>
<input type="number" name="calorie_goal" placeholder="Daily Calorie Goal" required><br>
<input type="number" name="steps_goal" placeholder="Daily Steps Goal" required><br>
<button name="update">Update</button>
</form>
</div>

<div class="card">
<a href="?logout=true">Logout</a>
</div>

<?php } ?>

</body>
</html>
