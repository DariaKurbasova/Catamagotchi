<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>КОТамагочи</title>
    <link rel="icon" type="image/png" href="img/Cat-icon.png" />
    <link rel="stylesheet" href="start_page.css">
    <link rel="stylesheet" href="game_page.css">
    <link rel="stylesheet" href="indicators.css">
</head>
<body>
<?php
require_once 'Game.php';
session_start();

if (!empty($_SESSION['game']) && $_SESSION['game'] instanceof Game) {
    $game = $_SESSION['game'];
    /** @var Game $game */

    $cat = $game->cat;

     var_dump($game);
     echo "<br>";

    if (!empty($game->message)) {
        echo "<br>" . $game->message;
    }
    ?>
    <div class = "game_page">
        <div class = "container">
            <div class = "main-header">
                <img class="game_icon" src="img/Cat-icon.png">
                <h1 class = "game_title">КОТамагочи</h1>
                <div class="clearfix"></div>
            </div>
            <p style="display: none;" class = "instruction">Инструкция к игре</p>
            <div class = "cat_name">Вашего котика зовут: <?= $cat->name ?></div>
            <br>
            <div class = "actions">
                <?php if (count($game->action_history) % 4 == 3) { ?>
                    <div class = "feed_dry">
                        <a style="color: darkred; font-weight: bold;" href="action.php?action=sleep">Котик хочет спать!</a><br><br>
                    </div>
                <?php } else { ?>
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
                        <a style="color: darkblue;" href="action.php?action=play_teaser">Поиграть с дразнилкой</a><br>
                    </div>
                    <div class = "walking">
                        <a style="color: darkblue;" href="action.php?action=walking">Вывести на прогулку</a><br><br><br>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class = "indicators">
                <div class = "food_satisfaction">
                    Сытость: <?= $cat->food ?>
                    <div class = "indicator food_indicator glow">
                        <span style = "width: <?= $cat->food - $cat->food_change ?>%;" data-width="<?= $cat->food ?>"></span>
                    </div>
                </div>
                <div class = "communication_satisfaction">
                    Общение: <?= $game->cat->communication ?>
                    <div class = "indicator communication_indicator glow">
                        <span style = "width: <?= $cat->communication - $cat->communication_change ?>%;" data-width="<?= $cat->communication ?>"></span>
                    </div>
                </div>
                <div class = "energy_satisfaction">
                    Энергия: <?= $game->cat->energy ?>
                    <div class = "indicator energy_indicator glow">
                        <span style = "width: <?= $cat->communication - $cat->communication_change ?>%;" data-width="<?= $cat->energy ?>"></span>
                    </div>
                </div>
                <div class = "mood">
                    Настроение: <?= $game->cat->mood ?>
                    <div class = "indicator mood_indicator glow">
                        <span style = "width: <?= $cat->mood - $cat->mood_change ?>%;" data-width="<?= $cat->mood ?>"></span>
                    </div>
                </div>
            </div>
            <br>
            <div class = "restart_game">
                <a style="color: darkgreen;" href="action.php?action=start_game&name=<?= $cat->name ?>">Начать игру с котиком заново</a><br><br>
            </div>
        </div>
    </div>

    <?php
    unset($game->message);
} else {?>
    <div class = "start_page">
        <div class = "container">
            <div class = "main-header">
                <img class="game_icon" src="img/Cat-icon.png">
                <h1 class = "game_title">КОТамагочи</h1>
                <div class="clearfix"></div>
            </div>
            <p class = "game_description">
                <b style="font-size: 25px;">Цель игры</b> благородна — сделать котейку счастливым. Для этого вам придется его кормить, гладить и всячески развлекать.
                Но учтите, что игровой котик совсем как настоящий — такой же привереда. Не все ваши действия придутся ему по душе.
                А впрочем, вы и сами сможете разобраться, что к чему. <b>Придумайте котейке имя и вперед!</b>
            </p>
<!--    <form method="post" action="">-->
<!--        <label>Имя котика-->
<!--            <input class = "cat-name-text" type="text" name="cat_name">-->
<!--        </label>-->
<!--        <input id = "cat-name-button" type="submit" value="Сохранить имя">-->
<!--    </form><br>-->
<!--    --><?php //if (!empty($_POST['cat_name'])) {?>
<!--    <a id = "start-game-button" style="color: darkgreen;" href="action.php?action=start_game&name=-->
<!--    --><?//=$_POST['cat_name']?><!--">Начать игру</a><br>-->
<!--    --><?php //} ?>
            <form class = "start_game_form" method="get" action="action.php?action=start_game">
                <input type = "hidden" name="action" value="start_game">
                <label>Имя котика
                    <input class = "cat_name_text" type="text" name="name">
                </label>
                <input class = "start_game_button" type = "submit" value = "Начать игру">
            </form><br>
            <img class = "start_image" src="img/two_cats.jpg">
        </div>
    </div>
<?php } ?>

<script src="script.js"></script>

</body>
</html>