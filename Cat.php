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
            $probability_like = rand(1, 10);

            switch ($food_type) {
                case "dry":
                    $this->energy_change += 5;
                    if ($this->getReloadLeft('eat_dry') != 0) {
                        if ($probability_like == 10) {
                            $this->mood_change -= 10;
                            $this->game->message = self::EAT_MESSAGE_HATE;
                        } else {
                            $this->mood_change += 5;
                            $this->game->message = self::EAT_MESSAGE_LIKE;
                        }
                    } else {
                        $this->mood_change += 5;
                        $this->game->message = self::EAT_MESSAGE_LIKE;
                    }

                    break;
                case "wet":
                    $this->energy_change += 10;
                    if ($this->getReloadLeft('eat_wet') != 0) {
                        if ($probability_like > 5) {
                            $this->mood_change -= 10;
                            $this->game->message = self::EAT_MESSAGE_HATE;
                        } else {
                            $this->mood_change += 15;
                            $this->game->message = self::EAT_MESSAGE_LIKE;
                        }
                    } else {
                        $this->mood_change += 10;
                        $this->game->message = self::EAT_MESSAGE_LIKE;
                    }
                    break;
                case "home":
                    if (array_count_values($this->game->action_history)["home"] < 3) {
                        $this->mood_change += 15;
                        $this->energy_change += 10;
                        $this->game->message = self::EAT_MESSAGE_LIKE;
                    } else {
                        $this->food_change -= 10;
                        $this->game->message = self::STOP_MESSAGE;
                    }
            }
        }
        $this->game->action_history[] = $food_type;
    }

    // Погладить
    public function stroke () {
        if (!$this->checkSameActions("communication")) {
            $this->food_change -= 5;
            if ($this->getReloadLeft('stroke') != 0) {
                $probability_like = rand(1, 10);
                if ($probability_like > 5) {
                    $this->mood_change -= 10;
                    $this->energy_change -= 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
                } else {
                    $this->mood_change += 20;
                    $this->energy_change += 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
                }
                $this->communication_change += 10;
            } else {
                $this->mood_change += 15;
                $this->energy_change += 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
        }
        $this->game->action_history[] = "stroke";
    }
    // Поиграть с дразнилкой
    public function playTeaser () {
        if (!$this->checkSameActions("communication")) {
            $this->food_change -= 15;
            if ($this->getReloadLeft('play_teaser') != 0) {
                $this->energy_change -= 20;
                $probability_like = rand(1, 10);
                if ($probability_like > 8) {
                    $this->mood_change -= 10;
                    $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
                } else {
                    $this->mood_change += 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
                }
                $this->communication_change += 10;
            } else {
                $this->mood_change += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
        }
        $this->game->action_history[] = "play_teaser";
    }
    // Поиграть с мышкой
    public function playMouse () {
        if (!$this->checkSameActions("communication")) {
            $this->food_change -= 10;
            if ($this->getReloadLeft('play_mouse')) {
                $this->energy_change -= 15;
                $probability_like = rand(1, 10);
                if ($probability_like > 6) {
                    $this->mood_change -= 10;
                    $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
                } else {
                    $this->mood_change += 15;
                    $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
                }
                $this->communication_change += 10;
            } else {
                $this->mood_change += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
        }
        $this->game->action_history[] = "play_mouse";
    }
    // Вывести котика на прогулку
    public function walking () {
        $this->food_change -= 15;
        $this->game->action_history[] = "walking";
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
        $this->game->action_history[] = "sleep";
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

    public function countReload($action) {
        if (empty($this->reloads[$action])) {
            $this->reloads[$action] = 0;
        }
        foreach ($this->reloads as $reload => $left) {
            if ($left < $this->max_reloads[$reload]) {
                $this->reloads[$reload]++;
            }
            if ($left == $this->max_reloads[$reload]) {
                unset($this->reloads[$reload]);
            }
        }
    }

    public function runAction($action_type) {
        $this->countReload($action_type);

        $this->mood_change = 0;
        $this->food_change = 0;
        $this->communication_change = 0;
        $this->energy_change = 0;

        // Выбираем и запускаем действие
        // В действиях не меняем муд/фуд, а присваиваем _change
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

        $this->fixLimits();
    }

    // Сколько ходов заряжается умение (возможно, нам нужнее
    public function getReloadLeft($type)
    {
        if (isset($this->reloads[$type])) {
            return $this->max_reloads[$type] - $this->reloads[$type]; 
        } else {
            return 0;
        }
    }
}
