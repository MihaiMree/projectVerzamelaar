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

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {

} else {
    $cart = $_SESSION['cart'];
    $totalPrice = 0;
    $productDetails = array();

    foreach ($cart as $product_id) {
        $stmt = $conn->prepare("SELECT product_id, naam, prijs, image FROM ver_album WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $productDetails[] = $product;
        $totalPrice += $product['prijs'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
        // Bestelling opslaan
        $aantal_albums = count($productDetails);
        $insertOrderQuery = "INSERT INTO ver_bestelling (aantal_albums, total_price) VALUES (?, ?)";
        $stmt = $conn->prepare($insertOrderQuery);
        $stmt->execute([$aantal_albums, $totalPrice]);


        $_SESSION['cart'] = array();
        echo "<p>Bedankt voor uw aankoop!</p>";
    }
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

<h1 class="maintitle">Winkelwagen</h1>
<div class="cart">
    <?php if (!empty($productDetails)) { ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
            </tr>
            <?php foreach ($productDetails as $product) { ?>
                <tr>
                    <td><img class="cart-img" src="<?php echo $product['image']; ?>" alt="<?php echo $product['naam']; ?>"></td>
                    <td><?php echo $product['naam']; ?></td>
                    <td>$<?php echo $product['prijs']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>$<?php echo $totalPrice; ?></strong></td>
            </tr>
        </table>
        <form method="post">
            <input type="submit" name="checkout" value="Checkout">
        </form>
    <?php } ?>
</div>


<script src="assets/script/script.js"></script>
</body>
</html>
