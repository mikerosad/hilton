<?php
session_start();
include('db.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Email is already taken. Please choose another one.";
    } else {
        //hash attempt yt
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //new user yt
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "Account created successfully! <a href='login.php'>Login here</a>";
        } else {
            $error_message = "Error creating account: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Your Hilton Account</title>
</head>
<body>
    <header>
        <h1>Create a New Account</h1>
        <nav>
            <a href="login.php">Already have an account? Login here</a>
        </nav>
    </header>

    <main>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Register</button>
        </form>

        <?php if (isset($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>

        <?php if (isset($success_message)) { ?>
            <p style="color: green;"><?php echo $success_message; ?></p>
        <?php } ?>
    </main>
</body>
</html>
