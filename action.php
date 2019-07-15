<?php

// В этом файле обрабатываются все действия, которые выбирает пользователь
require_once 'Game.php';
session_start();

$action = $_GET['action'];
$game = $_SESSION['game'];

if ($action == 'start_game' && $_GET['name']) {
    // Всё, что нужно для старта игры
    $_SESSION = [];
    $cat  = new Cat($_GET['name']);
    $game = new Game($cat);
    $_SESSION['game'] = $game;
} elseif ($game && $game instanceof Game) {
    // Игра уже создана, можно выполнять с ней действия
    $cat = $game->cat;
    if ($action == 'feed') {
        // Кормим котика
        $cat->feed();
    }
}

header("location: /");

// include 'index.php';
