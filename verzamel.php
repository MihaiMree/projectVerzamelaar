<?php
include ('assets/config/verzameling.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Pagina</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
<div class="head">
    <h1 class="home">
        Home Pagina
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
</div>
<div class="maintitle">
    <h2>Verzameling
    </h2>
</div>
<div class="container">
    <?php
    try {
        // Create a PDO connection to your MySQL database
        $pdo = new PDO("mysql:host=localhost;dbname=ftp89621", "mihai", "yxt23V9_4");

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Execute a query to fetch data from the "ver_albums" table
        $stmt = $pdo->query("SELECT product_id, naam, beschrijving, image, jaar, artist FROM ver_album");

        // Fetch and display each row as a flip card
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="flip-card">';
            echo '<div class="flip-card-inner">';
            echo '<div class="flip-card-front">';
            echo '<h2>' . $row['naam'] . '</h2>';
            echo '<img src="' . $row['image'] . '" alt="' . $row['naam'] . '">';
            echo '</div>';
            echo '<div class="flip-card-back">';
            echo '<p>Artist: ' . $row['artist'] . '</p>';
            echo '<p>Jaar: ' . $row['jaar'] . '</p>';
            echo '<p>Beschrijving:   ' . $row['beschrijving'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>

<script src="assets/script/script.js"></script>
</body>
</html>
