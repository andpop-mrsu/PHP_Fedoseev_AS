<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Арифметическая прогрессия</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="container">

<?php

require '../vendor/autoload.php';

use kabyfed\Progression\Controller;
use kabyfed\Progression\View;
use kabyfed\Progression\Database;

$view = new View();
$db = new Database('../db/games.db');
$controller = new Controller($view, $db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_name'])) {
    $_SESSION['player_name'] = $_POST['player_name'];
    $controller->startGame();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_answer'])) {
    $controller->checkAnswer($_SESSION['player_name'], (int)$_POST['user_answer']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'history') {
    $controller->showGameHistory();
} else {
    $controller->showStartScreen();
}

?>

</body>
</html>