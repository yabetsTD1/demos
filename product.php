<?php
session_start();
$user = $_SESSION['user'] ?? ['name' => 'Guest', 'profile_pic' => 'Default.jpg'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['products'])) {
        $_SESSION['products'] = [];
    }
    
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    } else {
        $targetFile = "default_product.jpg";
    }

    if (count($_SESSION['products']) < 20) {
        $_SESSION['products'][] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $targetFile
        ];
    }
}

$products = $_SESSION['products'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        .profile {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .product-form, .product-list {
            max-width: 600px;
            margin: auto;
        }
        .product-list img {
            width: 80px;
            height: 80px;
        }
        .product-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="profile">
    <img src="<?php echo $user['profile_pic']; ?>" alt="Profile Picture">
    <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
</div>

<div class="product-form">
    <h3>Add a Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Product</button>
    </form>
</div>

<div class="product-list">
    <h3>Products</h3>
    <?php foreach ($products as $product): ?>
        <div class="product-item">
            <img src="<?php echo $product['image']; ?>" alt="Product Image">
            <div>
                <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                Price: $<?php echo number_format($product['price'], 2); ?><br>
                Quantity: <?php echo (int) $product['quantity']; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
