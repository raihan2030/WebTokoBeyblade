<?php
require('database.php');

$productsData = $conn->query("SELECT * FROM ITEMS");

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$selected_product = null;

foreach ($productsData as $product) {
    if ($product['item_id'] === $product_id) {
        $selected_product = $product;
        break;
    }
}

if (!$selected_product) {
    echo "<h1>Produk tidak ditemukan!</h1>";
    echo "<a href='index.php'>Kembali ke daftar produk</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($selected_product['name']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/styleProduct.css">
</head>
<body>

<div class="container">
    <h1 id="productName"><?= $selected_product['name']; ?></h1>
    
    <div id="content">
        <?php 
        $image_path = "images/" . htmlspecialchars($selected_product['image_filename']);
        if (file_exists($image_path)) {
            echo "<img src='$image_path' alt='" . htmlspecialchars($selected_product['name']) . "'>";
        } else {
            echo "<p><strong>Gambar tidak ditemukan!</strong></p>";
        }
        ?>

        <div>
            <p id="price"><strong>Harga: </strong><?= 'Rp' . htmlspecialchars(number_format($selected_product['price']), 0, "", ".") . ',00'; ?></p>
            <p id="stock"><strong>Stok: </strong><?= htmlspecialchars($selected_product['stock']); ?></p>
            <p id="desc"><?= htmlspecialchars($selected_product['description']); ?></p>
            <a href="#" id="addToCart">  <i class="fa fa-cart-plus" style="font-size: 25px;" aria-hidden="true"></i> Tambahkan ke Cart</a>
        </div>

    </div>

    <a class="back" href="index.php">Kembali ke daftar produk</a>
</div>

</body>
</html>