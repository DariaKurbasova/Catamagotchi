<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>КОТамагочи</title>
    <link rel="stylesheet" href="indicators.css">
</head>
<body>

<?php
require_once 'Game.php';
session_start();

if (!empty($_SESSION['game'])) {
    $game = $_SESSION['game'];
    var_dump($game);
    echo "<br>";

    if (!empty($game->message)) {
        echo "<br>" . $game->message;
    }
    ?>

    <div class = "container"></div>
    <h1>КОТамагочи</h1>
    <p>Инструкция к игре</p>
    <div class = "actions">
        <div class = "food_actions">
            <div class = "feed_dry">
                <a style="color: darkred;" href="action.php?action=eat_dry">Покормить сухим кормом</a><br>
            </div>
            <div class = "feed_wet">
                <a style="color: darkred;" href="action.php?action=eat_wet">Покормить влажным кормом</a><br>
            </div>
            <div class = "feed_home">
                <a style="color: darkred;" href="action.php?action=eat_home">Покормить домашней едой</a><br><br>
            </div>
        </div>
        <div class = "communication_actions">
            <div class = "stroke">
                <a style="color: darkblue;" href="action.php?action=stroke">Погладить котика</a><br>
            </div>
            <div class = "play_mouse">
                <a style="color: darkblue;" href="action.php?action=play_mouse">Поиграть с мышкой</a><br>
            </div>
            <div class = "play_teaser">
                <a style="color: darkblue;" href="action.php?action=play_teaser">Поиграть с дразнилкой</a><br><br><br>
            </div>
        </div>
    </div>
    <div class = "indicators">
        <div class = "food_satisfaction">
            Сытость: <?= $game->cat->food ?>
            <div class = "indicator food_indicator glow">
                <span style = "width: <?= $game->cat->food ?>%; max-width: 100%;"></span>
            </div>
        </div>
        <div class = "communication_satisfaction">
            Общение: <?= $game->cat->communication ?>
            <div class = "indicator communication_indicator glow">
                <span style = "width: <?= $game->cat->communication ?>%; max-width: 100%;"></span>
            </div>
        </div>
        <div class = "mood">
            Настроение: <?= $game->cat->mood ?>
            <div class = "indicator mood_indicator glow">
                <span style = "width: <?= $game->cat->mood ?>%; max-width: 100%;"></span>
            </div>
        </div>
    </div>
    <br>
    <div class = "restart_game">
        <a style="color: darkgreen;" href="action.php?action=start_game&name=vasya">Начать игру с котиком заново</a><br>
    </div>

    <?php
    unset($game->message);
} else {?>
    <h1>КОТамагочи</h1>
    <p class = "game_description">
        <b>Цель игры</b> благородна - сделать котейку счастливым. Для этого вам придется его кормить, гладить и всячески развлекать.
        Но учтите, что игровой котик совсем как настоящий - такой же привереда. Не все ваши действия придутся ему по душе.
        А впрочем, вы и сами сможете разобраться, что к чему. Придумайте котейке имя и вперед!
    </p>
    <form method="post" action="">
        <label>Имя котика
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