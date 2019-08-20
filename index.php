<?php
require_once 'Game.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>КОТамагочи</title>
    <link rel="icon" type="image/png" href="img/Cat-icon.png" />
    <link rel="stylesheet" href="start_page.css">
    <link rel="stylesheet" href="game_page.css">
    <link rel="stylesheet" href="indicators_and_message.css">

    <link href="https://fonts.googleapis.com/css?family=Underdog&display=swap" rel="stylesheet">
</head>
<body>

<?php

if (!empty($_SESSION['game']) && $_SESSION['game'] instanceof Game) {
    $game = $_SESSION['game'];
    /** @var Game $game */

    $cat = $game->cat;

//     echo(count($game->action_history));
//     echo "<br>";

    ?>
    <div class = "game_page">
        <div class = "container">

            <?php if ($game->checkGameEnd()) { ?>
            <div class = "main-header">
                <img class="game_icon" src="img/Cat-icon.png">
                <h1 class = "game_title">КОТамагочи</h1>
                <div class="clearfix"></div>
            </div>

                <p class = "gameover_message"> <?= $game->checkGameEnd() ?> </p>
                <img class = "gameover_image" src="<?= $game->gameover_image ?>">
            <?php } else { ?>

            <div class = "main-header">
                <img class="game_icon" src="img/Cat-icon.png">
                <h1 class = "game_title">КОТамагочи</h1>
                <button class = "show-instruction" style = "color: #070866;" name = "show-instruction">Показать/скрыть инструкцию к игре</button>
                <div class="clearfix"></div>
            </div>

            <div class = "instruction" style = "display: none">
                <h2>Инструкция к игре</h2>
                <p>
                    Цель игры очень проста – вам нужно добиться, чтобы все показатели благополучия котика были не меньше 80.
                    За это котик отплатит вам любовью, и вы заслужите репутацию заботливого хозяина.
                </p>
                <p>
                    Для этого вам нужно будет удовлетворять потребности питомца: кормить его, гладить, играть с ним и выводить на прогулку.
                    Учтите, что после совершения какого-либо действия котику необходимо перезарядить свои желания,
                    поэтому несколько ходов это действие будет доступно только с небольшим штрафом.
                </p>
                <p>
                    Ваши действия могут приниматься котиком благосклонно, а могут быть отвергнуты. Не обижайтесь на любимца за это, он не со зла :)
                    Также повторив одно и то же действие 3 раза, вы рискуете сильно испортить настроение котику.
                </p>
                <p>
                    Что будет, если какой-либо из показателей достигнет отметки 10 и ниже? Не советую вам это проверять.
                    Вам же не хочется испытать чувство вины за плохую заботу о питомце, верно?
                </p>
            </div>

            <div style="display: none;" class = "cat_name">Вашего котика зовут: <?= $cat->name ?></div>
            <div class = "actions">
                <?php if (count($game->action_history) % 5 == 4) { ?>
                    <div class = "sleep action">
                        <a style="text-decoration: none;" href="action.php?action=sleep" class="tooltip">
                            <div class = "action-icon sleep-icon" title="Котик хочет спать!"></div>
                        </a>
                        <p class = "action_title">Котик хочет спать!</p>
                    </div>
                <?php } else { ?>
                <div class = "food_actions">
                    <div class = "feed_dry food_action action">
                        <a style="text-decoration: none;" href="action.php?action=eat_dry" class = "tooltip">
                            <div class = "action-icon dry_food-icon"></div>
                            <div class="reloading" data-reload-max="<?= $cat->max_reloads['eat_dry'] ?>"
                                 data-reload-left="<?= $cat->getReloadLeft('eat_dry') ?>">
                            </div>
                        </a>
                        <p class = "action_title">Покормить сухим кормом</p>
                    </div>
                    <div class = "feed_wet food_action action">
                        <a style="text-decoration: none;" href="action.php?action=eat_wet" class = "tooltip">
                            <div class = "action-icon wet_food-icon" title="Покормить влажным кормом"></div>
                            <div class="reloading" data-reload-max="<?= $cat->max_reloads['eat_wet'] ?>"
                                 data-reload-left="<?= $cat->getReloadLeft('eat_wet') ?>">
                            </div>
                        </a>
                        <p class = "action_title">Покормить влажным кормом</p>
                    </div>
                    <div class = "feed_home food_action action">
                        <a style="text-decoration: none;" href="action.php?action=eat_home" class = "tooltip">
                            <div class = "action-icon home_food-icon" title="Покормить домашней едой"></div>
                        </a>
                        <p class = "action_title">Покормить домашней едой</p>
                    </div>
                </div>
                <div class = "communication_actions">
                    <div class = "stroke communication_action action">
                        <a style="text-decoration: none;" href="action.php?action=stroke" class = "tooltip">
                            <div class = "action-icon stroke-icon" title="Погладить"></div>
                            <div class="reloading" data-reload-max="<?= $cat->max_reloads['stroke'] ?>"
                                 data-reload-left="<?= $cat->getReloadLeft('stroke') ?>">
                            </div>
                            <p class = "action_title"><br>Погладить</p>
                        </a>
                    </div>
                    <div class = "play_mouse communication_action action">
                        <a style="text-decoration: none;" href="action.php?action=play_mouse" class = "tooltip">
                            <div class = "action-icon play_mouse-icon" title="Поиграть с мышкой"></div>
                            <div class="reloading" data-reload-max="<?= $cat->max_reloads['play_mouse'] ?>"
                                 data-reload-left="<?= $cat->getReloadLeft('play_mouse') ?>">
                            </div>
                        </a>
                        <p class = "action_title">Поиграть с мышкой</p>
                    </div>
                    <div class = "play_teaser communication_action action">
                        <a style="text-decoration: none;" href="action.php?action=play_teaser" class = "tooltip">
                            <div class = "action-icon play_teaser-icon" title="Поиграть с дразнилкой"></div>
                            <div class="reloading" data-reload-max="<?= $cat->max_reloads['play_teaser'] ?>"
                                 data-reload-left="<?= $cat->getReloadLeft('play_teaser') ?>">
                            </div>
                        </a>
                        <p class = "action_title">Поиграть с дразнилкой</p>
                    </div>
                    <div class = "walking communication_action action">
                        <a style="text-decoration: none;" href="action.php?action=walking" class = "tooltip">
                            <div class = "action-icon walking-icon" title="Вывести на прогулку"></div>
                            <div class="reloading" data-reload-max="<?= $cat->max_reloads['walking'] ?>"
                                 data-reload-left="<?= $cat->getReloadLeft('walking') ?>">
                            </div>
                        </a>
                        <p class = "action_title">Вывести на прогулку</p>
                    </div>
                </div>
                    <div class="clearfix"></div>
                <?php } ?>
            </div><br>

            <div class = "indicators">
                <div class = "food_satisfaction">
                    <b>Сытость: <?= $cat->food ?></b>
                    <div class = "indicator food_indicator glow">
                        <span style = "width: <?= $cat->food - $cat->food_change ?>%;" data-width="<?= $cat->food ?>"></span>
                    </div>
                </div>
                <div class = "communication_satisfaction">
                    <b>Общение: <?= $cat->communication ?></b>
                    <div class = "indicator communication_indicator glow">
                        <span style = "width: <?= $cat->communication - $cat->communication_change ?>%;" data-width="<?= $cat->communication ?>"></span>
                    </div>
                </div>
                <div class = "energy_satisfaction">
                    <b>Энергия: <?= $cat->energy ?></b>
                    <div class = "indicator energy_indicator glow">
                        <span style = "width: <?= $cat->energy - $cat->energy_change ?>%;" data-width="<?= $cat->energy ?>"></span>
                    </div>
                </div>
                <div class = "mood">
                    <b>Настроение: <?= $cat->mood ?></b>
                    <div class = "indicator mood_indicator glow">
                        <span style = "width: <?= $cat->mood - $cat->mood_change ?>%;" data-width="<?= $cat->mood ?>"></span>
                    </div>
                </div>
            </div>
            <img class = "main_image" src="<?= $game->getImage() ?>">
            <p class="message"><b><?= $game->getMessage() ?></b></p>
            <div class="clearfix"></div>
            <?php } ?>
            <div class = "restart_game" >
                <a style="text-decoration: none; color: #070866;" href="action.php?action=start_game&name=<?= $cat->name ?>">Начать игру с котиком заново</a><br><br>
            </div>
        </div>
    </div>

    <?php
    unset($game->message);
} else { ?>
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

<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
</script>
<script src="script.js"></script>
<script src="arc-drawer.js"></script>

</body>
</html>