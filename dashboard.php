<?php
session_start();
include('db.php');

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
//logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome to Your Dashboard, <?php echo $_SESSION["user"]; ?>!</h1> 
        <nav>
            <a href="index.php">Home</a>
            <a href="?logout=true">Logout</a> 
        </nav>
    </header>

    <main>
        <p>Welcome to Hilton! Here you can book and view your rooms eventually...</p>
    </main>
</body>
</html>
