<?php
session_start();
$hostname = 'localhost';
$username = 'mihai';
$password = 'yxt23V9_4';
$database = 'ftp89621';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // Initialize the cart as an empty array
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (!in_array($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_id; // Add the product to the cart
    }
}

try {
    $stmt = $conn->query("SELECT product_id, naam, image, prijs FROM ver_album");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellen</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
<div class="head">
    <h1 class="home">
        Bestellen
    </h1>

    <a href="home.html">
        <div class="homeP">
            <p>
                Home Pagina
            </p>
        </div>
    </a>

    <a href="verzamel.php">
        <div class="verzam">
            <p>
                Verzameling
            </p>
        </div>
    </a>

    <a href="bestel.php">
        <div class="bestel">
            <p>
                Bestellen
            </p>
        </div>
    </a>
    <a href="cart.php" class="s-cart">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16"> <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/> </svg>
    </a>
</div>
<h1 class="maintitle">Bestellen</h1>
<div class="products">
    <?php foreach ($products as $product) { ?>
        <div class="product">
            <h2><?php echo $product['naam']; ?></h2>
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['naam']; ?>">

            <p>Prijs: $<?php echo $product['prijs']; ?></p>
            <form method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="submit" name="add_to_cart" value="Toevoegen aan Winkelwagen">
            </form>
        </div>
    <?php } ?>
</div>
<a href="cart.php">
    <div class="plaats">
        <p>Winkelwagen Bekijken</p> <!-- Corrected "Belijken" to "Bekijken" -->
    </div>
</a>
<script src="assets/script/script.js"></script>
</body>
</html>
