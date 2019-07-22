<?php

// В этом файле обрабатываются все действия, которые выбирает пользователь
require_once 'Game.php';
session_start();

if (!empty($_GET['action']) || !empty($_SESSION['game'])) {
    $action = $_GET['action'];
    $game = $_SESSION['game'];

    if ($action == 'start_game' && $_GET['name']) {
        // Всё, что нужно для старта игры
        $_SESSION = [];
        $cat = new Cat($_GET['name']);
        $game = new Game($cat);
        $_SESSION['game'] = $game;
    } elseif ($game && $game instanceof Game) {
        // Игра уже создана, можно выполнять с ней действия
        $cat = $game->cat;

        switch ($action) {
            case 'eat_dry':
                $cat->feed('dry');
                break;
            case 'eat_wet':
                $cat->feed('wet');
                break;
            case 'eat_home':
                $cat->feed('home');
                break;
            case 'stroke':
                $cat->stroke();
                break;
            case 'play_teaser':
                $cat->play_teaser();
                break;
            case 'play_mouse':
                $cat->play_mouse();
                break;
        }

    }
}
header("location: /");

