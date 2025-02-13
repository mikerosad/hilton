<form action="register_process.php" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Create Account</button>
</form>

<?php
//php -S localhost:8000
//connect to database, SQlite, sqlite3 /Users/tonyrosado/Hilton/database.db
//$db = new PDO('sqlite: /Users/tonyrosado/Hilton/database.db');
//echo "SQLite is working!";
/* first table for account creation
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
);
*/ 

$dbPath = '/Users/tonyrosado/Hilton/database.db';
$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//only for command line use not live server, if live server then switch to POST to be compatible, find out in class
echo "Enter username: ";
$username = trim(fgets(STDIN));

echo "Enter email: ";
$email = trim(fgets(STDIN));

echo "Enter password: ";
$password = trim(fgets(STDIN));

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);

    echo "Account successfully created!\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>










