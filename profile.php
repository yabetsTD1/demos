<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? 1; // Replace with actual session logic

// Fetch user details
$result = $conn->query("SELECT name, email, username, profile_pic FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

// Handle profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_pic"])) {
    if ($_FILES["profile_pic"]["error"] == 0) {
        $targetDir = "uploads/";
        $profile_pic = $targetDir . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_pic);

        // Update database
        $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
        $stmt->bind_param("si", $profile_pic, $user_id);
        $stmt->execute();

        // Refresh the page to show the new image
        header("Location: profile.php");
        exit;
    }
}

// Fetch last transactions
$transactions = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        .profile-container {
            max-width: 400px;
            margin: auto;
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .profile-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .transaction-list {
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>User Profile</h2>
    <img src="<?php echo $user['profile_pic']; ?>" alt="Profile Picture">
    <h3><?php echo htmlspecialchars($user['name']); ?></h3>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?></p>

    <h3>Update Profile Picture</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_pic" accept="image/*" required><br>
        <button type="submit">Upload</button>
    </form>
</div>

<div class="transaction-list">
    <h3>Last Transactions</h3>
    <table border="1" width="100%">
        <tr>
            <th>Transaction ID</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php while ($transaction = $transactions->fetch_assoc()): ?>
            <tr>
                <td><?php echo $transaction['id']; ?></td>
                <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                <td><?php echo $transaction['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
