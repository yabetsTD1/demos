<?php
// Start PHP session
session_start();
include 'connect.php';

$error = ""; // Initialize an error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $_SESSION['username'] = $username;
    $password = $_POST['password'];

    // Check if the user exists in the database
    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);

    if ($stmt->fetch()) {
        // Verify the password
        if (password_verify($password, $hashedPassword)) {
           
            // Successful login
            header("Location: index.php");
            exit();
        } else {
            // Password incorrect
            $error = "Incorrect password!";
        }
    } else {
        // User not found
        $error = "Username does not exist!";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <!-- Display Error Message -->
        <?php if (!empty($error)) : ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <p>don't have an account? <a href="signup.php">register now</a></p>
        </form>
    </div>
</body>
</html>
