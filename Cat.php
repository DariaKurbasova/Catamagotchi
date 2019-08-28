<?php

class Cat
{
    public $name;
    public $mood = 50;
    public $food = 50;
    public $communication = 50;
    public $energy = 50;

    public $mood_change = 0;
    public $food_change = 0;
    public $communication_change = 0;
    public $energy_change = 0;
    public $actionDice;

    public $reloads = [];
    public $max_reloads = [
        'eat_dry' => 5,
        'eat_wet' => 4,
        'stroke' => 3,
        'play_teaser' => 5,
        'play_mouse' => 4,
        'walking' => 5
    ];

    CONST EAT_MESSAGE_LIKE = "Ммм, вкуснятина!";
    CONST EAT_MESSAGE_HATE = "Фу, ну и гадость!";
    CONST COMMUNICATE_MESSAGE_LIKE = "Люблю тебя, человек!";
    CONST COMMUNICATE_MESSAGE_HATE = "Отстань от меня!";
    CONST TIRED_OF_IT_MESSAGE = "Может, попробуешь что-нибудь другое?";
    CONST STOP_MESSAGE = "Хватит баловать котика";
    CONST SLEEP_MESSAGE = "Z-z-z";

    /** @var Game */
    public $game;

    /**
     * Cat constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    // Одни и те же действия быстро наскучат котику. Нужно не больше 3 одинаковых подряд.
    public function checkSameActions ($action) {
        $history = $this->game->action_history;
        if (count($history) >= 3 && $history[count($history)-1] == $history[count($history)-2] && $history[count($history)-1] == $history[count($history)-3]) {
            $this->$action += 10;
            $this->mood_change -= 20;
            $this->energy_change -= 10;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
            return true;
        } else {
            return false;
        }
    }

    // Покормить котика одним из 3 видов корма: сухой, влажный и домашний. Котан привередливый, не все корма любит одинково.
    public function feed ($food_type) {
        if (!$this->checkSameActions("food")) {
            $this->food_change += 10;
            $this->communication_change -= 5;

            if ($food_type == 'home') {
                // Для домашнего корма - особая логика. Считаем кол-во кормлений им за игру
                if (array_count_values($this->game->action_history)["home"] < 3) {
                    $this->mood_change += 15;
                    $this->energy_change += 10;
                    $this->game->message = self::EAT_MESSAGE_LIKE;
                } else {
                    $this->food_change -= 10;
                    $this->game->message = self::STOP_MESSAGE;
                }
            } else {
                if ($food_type == "dry") {
                    // Кормление сухим кормом
                    $this->energy_change += 5;
                    $moodBonus = 5;
                    $moodPenalty = -10;
                    $probabilityLike = !$this->isReloading('eat_dry') ? 9 : 7;
                } else {
                    // Кормление влажным кормом
                    $this->energy_change += 10;
                    $moodBonus = 15;
                    $moodPenalty = -10;
                    $probabilityLike = !$this->isReloading('eat_wet') ? 8 : 4;
                }

                // Сверяем шанс успеха и бросок кубика. Успех 7 из 10 - значит, что бросок [1, 7] - успех, [8, 10] - провал
                if ($this->actionDice <= $probabilityLike) {
                    $this->mood_change += $moodBonus;
                    $this->game->message = self::EAT_MESSAGE_LIKE;
                } else {
                    $this->mood_change += $moodPenalty;
                    $this->game->message = self::EAT_MESSAGE_HATE;
                }
            }
        }
    }

    // Погладить
    public function stroke () {
        if (!$this->checkSameActions("communication")) {
            $this->food_change -= 5;
            $this->communication_change += 10;
            if ($this->getReloadLeft('stroke') != 0) {
                if ($this->actionDice > 5) {
                    $this->mood_change -= 10;
                    $this->energy_change -= 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
                } else {
                    $this->mood_change += 20;
                    $this->energy_change += 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
                }
            } else {
                $this->mood_change += 15;
                $this->energy_change += 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
        }
    }

    // Поиграть с дразнилкой
    public function playTeaser () {
        if (!$this->checkSameActions("communication")) {
            $this->food_change -= 15;
            $this->communication_change += 10;
            if ($this->getReloadLeft('play_teaser') != 0) {
                $this->energy_change -= 20;
                if ($this->actionDice > 8) {
                    $this->mood_change -= 10;
                    $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
                } else {
                    $this->mood_change += 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
                }
            } else {
                $this->mood_change += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
        }
    }

    // Поиграть с мышкой
    public function playMouse () {
        if (!$this->checkSameActions("communication")) {
            $this->food_change -= 10;
            $this->communication_change += 10;
            if ($this->getReloadLeft('play_mouse')) {
                $this->energy_change -= 15;
                if ($this->actionDice > 6) {
                    $this->mood_change -= 10;
                    $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
                } else {
                    $this->mood_change += 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
                }
            } else {
                $this->mood_change += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
        }
    }

    // Вывести котика на прогулку
    public function walking () {
        $this->food_change -= 15;
        if (!$this->checkSameActions("communication")) {
            $this->energy_change -= 25;
            $this->mood_change += 20;
            $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            $this->communication_change += 10;
            // todo Добавить особые условия этому методу
        }
    }

    // Сброс показателей ночью (каждое 4-е действие - сон)
    public function sleep () {
        $this->food_change = -15;
        if ($this->food > 60) {
            $this->food_change -= round(($this->food - 60) / 5);
        }
        if ($this->food > 90) {
            $this->food_change -= round(($this->food - 90) / 5);
        }
        $this->communication_change = -20;
        if ($this->communication > 60) {
            $this->communication_change -= round(($this->communication - 60) / 5);
        }
        if ($this->communication > 90) {
            $this->communication_change -= round(($this->communication - 90) / 5);
        }
        $this->energy_change = 10;
        if ($this->energy <= 60) {
            $this->energy_change += 10;
        }
        $this->mood_change -= 10;
        $this->game->message = self::SLEEP_MESSAGE;
    }

    public function fixLimits() {
        $this->fixLimit($this->food);
        $this->fixLimit($this->mood);
        $this->fixLimit($this->communication);
        $this->fixLimit($this->energy);
    }

    public function fixLimit(&$value) {
        if ($value > 100) {
            $value = 100;
        } elseif ($value < 0) {
            $value = 0;
        }
    }
// Делаем действие "покормить сухим кормом". Записываем его в массив с 1, к остальным имеющимся прибавляем +1.
// Проверяем каждый элемент на максимальную перезарядку. Если он становится равен ей - исключаем его из массива.

    public function countReload($currentAction) {
        // Перезарядка начнётся, если её нет сейчас (и она предусмотрена для этого действия)
        $needTriggerReload = !isset($this->reloads[$currentAction]) && isset($this->max_reloads[$currentAction]);

        // Уменьшаем перезарядку каждого действия на 1. Убираем заряженные
        foreach ($this->reloads as $action => &$turnsLeft) {
            $turnsLeft--;
            if ($turnsLeft <= 0) {
                unset($this->reloads[$action]);
            }
        }

        // Добавляем новое действие с максимальным количеством ходов
        if ($needTriggerReload) {
            $this->reloads[$currentAction] = $this->max_reloads[$currentAction];
        }
    }

    public function runAction($action_type) {
        $this->mood_change = 0;
        $this->food_change = 0;
        $this->communication_change = 0;
        $this->energy_change = 0;

        $this->game->action_history[] = $action_type;

        // Выбираем и запускаем действие
        // В действиях не меняем муд/фуд, а присваиваем _change
        $this->actionDice = rand(1, 10);
        switch ($action_type) {
            case 'eat_dry':
                $this->feed('dry');
                break;
            case 'eat_wet':
                $this->feed('wet');
                break;
            case 'eat_home':
                $this->feed('home');
                break;
            case 'stroke':
                $this->stroke();
                break;
            case 'play_teaser':
                $this->playTeaser();
                break;
            case 'play_mouse':
                $this->playMouse();
                break;
            case 'walking':
                $this->walking();
                break;
            case 'sleep':
                $this->sleep();
                break;
        }

        $this->mood += $this->mood_change;
        $this->food += $this->food_change;
        $this->communication += $this->communication_change;
        $this->energy += $this->energy_change;

        $this->countReload($action_type);
        $this->fixLimits();

        $this->game->checkGameEnd();
    }

    // Сколько ходов заряжается умение
    public function getReloadLeft($type)
    {
        return isset($this->reloads[$type]) ? $this->reloads[$type] : 0;
    }

    public function isReloading($type)
    {
        return $this->getReloadLeft($type) > 0;
    }
}
