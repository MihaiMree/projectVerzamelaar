<?php
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

try {
    $stmt = $conn->query("SELECT product_id, naam, beschrijving, image, jaar, artist FROM ver_album");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}



