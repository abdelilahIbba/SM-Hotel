<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=smhotel', 'root', '');
    $conn = $pdo;
} catch (PDOException $e) {
    echo "<p>Erreur: " . $e->getMessage();
    die();
}
