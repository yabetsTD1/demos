<?php
session_start();
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
