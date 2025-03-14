<?php
session_start();
?>
<?php
// signup.php: Signup functionality
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $_SESSION["username"] = $username;
    $_SESSION['email'] = $email;

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (first_name, last_name,phone, username, email, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fname, $lname, $phone, $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Signup successful!";
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js" defer></script>
</head>

<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form id="signupForm" action="signup.php" method="post">
            <!-- First Name -->
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" required>
            </div>
            <!-- Last Name -->
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" required>
            </div>
            <!-- Phone -->
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" required>
            </div>
            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit">Sign Up</button>
            </div>
        </form>
    </div>
</body>

</html>