<?php
session_start();
// require("includes/pdo.inc.php");

if (!isset($_SESSION['id'])) {
    header("Location: pages/login.php");
    exit;
} else if (isset($_SESSION['id'])) {
    header("Location: pages/home.php");
    exit;
}
