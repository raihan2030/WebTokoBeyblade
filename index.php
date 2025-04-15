<?php
session_start();
require('database.php');

$productsData = $conn->query("SELECT * FROM ITEMS");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beyblade Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div id="header">
        <div id="judul">Beyblade Shop</div>
        <div id="logReg" style="gap: <?=(isset($_SESSION["logged_in_user"])) ? '20px' : '0' ?>;">
            <?php if (isset($_SESSION["logged_in_user"])): ?>
                <p>Welcome, <?= htmlspecialchars($_SESSION["logged_in_user"]["username"]); ?>!</p>
                <a href="logout.php" id="logoutButton" class="logRegButton">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            <?php else: ?>
                <a href="register.php" id="regButton" class="logRegButton">
                    <i class="fa fa-user-plus"></i> Register
                </a>
                <a href="login.php" id="logButton" class="logRegButton">
                    <i class="fa fa-sign-in"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div id="content">
        <h1>Daftar Produk</h1>
        <div class="product-grid">
            <?php foreach ($productsData as $product) : ?>
                <div class="product">
                    <img src="images/<?= htmlspecialchars($product['image_filename']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <h3><?= htmlspecialchars($product['name']); ?></h3>
                    <p><strong><?= 'Rp' . htmlspecialchars(number_format($product['price']), 0, "", ".") . ',00'; ?></strong></p>
                    <a href="product.php?id=<?= htmlspecialchars($product['item_id']); ?>">Lihat Detail</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="footer">
        <p>&copy; Made by: Muhammad Raihan & Muhammad Firas</p>
    </div>
</body>
</html>
