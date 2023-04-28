<?php
try {
    // Connexion à la base de données
    $dsn = 'mysql:host=localhost:3306;dbname=archilog;charset=utf8mb4';
    $dbuser = 'admin';
    $dbpassword = 'admin';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $pdo = new PDO($dsn, $dbuser, $dbpassword, $options);
} catch (PDOException $e) {
    die('erreur : ' . $e);
}
