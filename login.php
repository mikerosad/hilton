<?php
session_start();
//xampp database connection
include('db.php');
//attempt at errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
//see if user already logged in
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit();
}
//login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    //use database to check if the input was already given and put into the database
    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        
        //verify
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user"] = $username;
            $_SESSION["email"] = $email;
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "No user found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hilton Login</title>
</head>
<body>
    <header>
        <h1>Login to Your Account</h1>
        <nav>
            <a href="register.php">Create account</a>
        </nav>
    </header>

    <main>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
    </main>
</body>
</html>
