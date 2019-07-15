<?php

require_once 'Game.php';
session_start();

$game = $_SESSION['game'];
var_dump($game);

if (!empty($game->message)) {
    echo "<br>" . $game->message;
}

unset($game->message);