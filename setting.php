<?php
session_start();
include 'connect.php';

$user_name = $_SESSION['username'] ?? 1; // Replace with actual session logic
$user_email = $_SESSION['email'];
// Fetch user details
$result = $conn->query("SELECT first_name, last_name, email, profile_pic FROM users WHERE username = 'ab'");
if($result){
    echo "Connected successfule";
}
else{
    echo "Not connected";
}
$user = $result->fetch_assoc();

// Handle profile updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_profile"])) {
        $new_username = $_POST["username"];
        $new_email = $_POST["email"];

        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE username = ?");
        $stmt->bind_param("sss", $new_username, $new_email, $user_name);
        $stmt->execute();
        header("Location: setting.php");
        exit;
    }

    if (isset($_POST["update_password"])) {
        $old_password = $_POST["old_password"];
        $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

        // Check current password
        $password_check = $conn->query("SELECT password FROM users WHERE username = 'ab'");
        $password_data = $password_check->fetch_assoc();

        if (password_verify($old_password, $password_data["password"])) {
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $new_password, $user_name);
            $stmt->execute();
            echo "<p>Password updated successfully!</p>";
        } else {
            echo "<p style='color:red;'>Incorrect old password!</p>";
        }
    }

    if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] == 0) {
        $targetDir = "uploads/";
        $profile_pic = $targetDir . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_pic);

        // Update database
        $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE username = ?");
        $stmt->bind_param("bs", $profile_pic, $user_name);
        $stmt->execute();
        header("Location: setting.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        .settings-container {
            max-width: 400px;
            margin: auto;
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .settings-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        form {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="settings-container">
    <h2>Settings</h2>
    <img src="<?php echo $user['profile_pic']; ?>" alt="Profile Picture">

    <h3>Update Profile</h3>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user_name); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required><br>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <h3>Update Profile Picture</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_pic" accept="image/*" required><br>
        <button type="submit">Upload</button>
    </form>

    <h3>Change Password</h3>
    <form method="POST">
        <input type="password" name="old_password" placeholder="Current Password" required><br>
        <input type="password" name="new_password" placeholder="New Password" required><br>
        <button type="submit" name="update_password">Change Password</button>
    </form>
</div>

</body>
</html>
