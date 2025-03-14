<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Fetch logged-in username
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f3f4f6;
            color: #333;
        }

        header {
            background: linear-gradient(90deg, #4CAF50, #45a049);
            padding: 10px 20px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        header nav ul li {
            display: inline;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        header nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        iframe {
            width: 100%;
            height: 80vh;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1);
        }

        footer p {
            margin: 5px 0;
        }

        footer p:first-child {
            font-weight: bold;
        }

        footer p:last-child {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <nav>
            <ul>
                <li><a href="home.php" target="content-frame">Home</a></li>
                <li><a href="products.php" target="content-frame">Products</a></li>
                <li><a href="about.php" target="content-frame">About Us</a></li>
                <li><a  onclick="logout()">Sign Out</a></li>
            </ul>
        </nav>
    </header>

    <!-- Content Frame -->
    <iframe name="content-frame" src="home.php"></iframe>

    <!-- Footer -->
    <footer>
        <p>Contact: yabetstinsae@gmail.com</p>
        <p>&copy; 2025 HUE-commerce All rights reserved.</p>
    </footer>
    <script>
        function logout(){
            confirm("Do you want to log out");
            window.location.href = "login.php";
        }
    </script>
</body>

</html>
