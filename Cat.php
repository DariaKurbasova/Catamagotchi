<?php

class Cat
{
    public $name;
    public $mood = 50;
    public $food = 50;
    public $communication = 50;

    public $mood_change = 0;
    public $food_change = 0;
    public $communication_change = 0;


    CONST EAT_MESSAGE_LIKE = "Ммм, вкуснятина!";
    CONST EAT_MESSAGE_HATE = "Фу, ну и гадость!";
    CONST COMMUNICATE_MESSAGE_LIKE = "Люблю тебя, человек!";
    CONST COMMUNICATE_MESSAGE_HATE = "Отстань от меня!";
    CONST TIRED_OF_IT_MESSAGE = "Может, попробуешь что-нибудь другое?";
    CONST STOP_MESSAGE = "Хватит баловать котика, больше нельзя";


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
    public function check_same_actions ($action) {
        $history = $this->game->action_history;
        if (count($history) >= 3 && $history[count($history)-1] == $history[count($history)-2] && $history[count($history)-1] == $history[count($history)-3]) {
            $this->$action += 10;
            $this->mood_change -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
            return true;
        } else {
            return false;
        }
    }

    // Покормить котика одним из 3 видов корма: сухой, влажный и домашний. Котан привередливый, не все корма любит одинково.
    public function feed ($food_type) {
        $this->food_change += 10;
        $this->game->action_history[] = $food_type;
        if (!$this->check_same_actions("food")) {
            $probability_like = rand(1, 10);

            switch ($food_type) {
                case "dry":
                    if ($probability_like == 10) {
                        $this->mood_change -= 10;
                        $this->game->message = self::EAT_MESSAGE_HATE;
                    } else {
                        $this->mood_change += 5;
                        $this->game->message = self::EAT_MESSAGE_LIKE;
                    }
                    break;
                case "wet":
                    if ($probability_like > 5) {
                        $this->mood_change -= 10;
                        $this->game->message = self::EAT_MESSAGE_HATE;
                    } else {
                        $this->mood_change += 15;
                        $this->game->message = self::EAT_MESSAGE_LIKE;
                    }
                    break;
                case "home":
                    if (array_count_values($this->game->action_history)["home"] < 3) {
                        $this->mood_change += 15;
                        $this->game->message = self::EAT_MESSAGE_LIKE;
                    } else {
                        $this->food_change -= 10;
                        $this->game->message = self::STOP_MESSAGE;
                    }
            }

        }
    }

    // Погладить
    public function stroke () {
        $this->game->action_history[] = "stroke";
        if (!$this->check_same_actions("communication")) {
            $probability_like = rand(1, 10);
            if ($probability_like > 5) {
                $this->mood_change -= 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
            } else {
                $this->mood_change += 20;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
            $this->communication_change += 10;
        }
    }
    // Поиграть с дразнилкой
    public function play_teaser () {
        $this->game->action_history[] = "play_teaser";
        if (!$this->check_same_actions("communication")) {
            $probability_like = rand(1, 10);
            if ($probability_like > 8) {
                $this->mood_change -= 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
            } else {
                $this->mood_change += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
            $this->communication_change += 10;
        }
    }
    // Поиграть с мышкой
    public function play_mouse () {
        $this->game->action_history[] = "play_mouse";
        if (!$this->check_same_actions("communication")) {
            $probability_like = rand(1, 10);
            if ($probability_like > 6) {
                $this->mood_change -= 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
            } else {
                $this->mood_change += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
            $this->communication_change += 10;
        }
    }

    public function fix_limits() {
        $this->fix_limit($this->food);
        $this->fix_limit($this->mood);
        $this->fix_limit($this->communication);
    }

    public function fix_limit(&$value) {
        if ($value > 100) {
            $value = 100;
        } elseif ($value < 0) {
            $value = 0;
        }
    }

    public function run_action($action_type) {
        $this->mood_change = 0;
        $this->food_change = 0;
        $this->communication_change = 0;

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
                $this->play_teaser();
                break;
            case 'play_mouse':
                $this->play_mouse();
                break;
        }

        $this->mood += $this->mood_change;
        $this->food += $this->food_change;
        $this->communication += $this->communication_change;

        $this->fix_limits();
    }
}
