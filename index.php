<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Название документа</title>

</head>
<body>

<?php
require_once 'Game.php';
session_start();

if (!empty($_SESSION['game'])) {
    $game = $_SESSION['game'];
    var_dump($game);
    echo "<br>";

    echo "<br>" . "Сытость: " . $game->cat->food;
    echo "<br>" . "Общение: " . $game->cat->communication;
    echo "<br>" . "Настроение: " . $game->cat->mood;

    if (!empty($game->message)) {
        echo "<br>" . $game->message;
    }
    ?>

    <br><br>
    <a style="color: darkred;" href="action.php?action=eat_dry">Покормить сухим кормом</a><br>
    <a style="color: darkred;" href="action.php?action=eat_wet">Покормить влажным кормом</a><br>
    <a style="color: darkred;" href="action.php?action=eat_home">Покормить домашней едой</a><br><br>
    <a style="color: darkblue;" href="action.php?action=stroke">Погладить котика</a><br>
    <a style="color: darkblue;" href="action.php?action=play_mouse">Поиграть с мышкой</a><br>
    <a style="color: darkblue;" href="action.php?action=play_teaser">Поиграть с дразнилкой</a><br><br><br>
    <a style="color: darkgreen;" href="action.php?action=start_game&name=vasya">Начать игру с котиком заново</a><br>

    <?php
    unset($game->message);
} else {?>
    <form method="post" action="">
        <label>Придумайте имя котика
            <input class = "cat-name-text" type="text" name="cat_name">
        </label>
        <input id = "cat-name-button" type="submit" value="Сохранить имя">
    </form><br>
    <?php if (!empty($_POST['cat_name'])) {?>
    <a id = "start-game-button" style="color: darkgreen;" href="action.php?action=start_game&name=
    <?=$_POST['cat_name']?>">Начать игру</a><br>
    <?php } ?>
    </body>
    </html>
<?php }