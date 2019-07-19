<?php

class Cat
{
    public $name;
    public $mood = 50;
    public $food = 50;
    public $communication = 50;

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
        if ($history[count($history)-1] == $history[count($history)-2] && $history[count($history)-1] == $history[count($history)-3]) {
            $this->$action += 10;
            $this->mood -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
            return null;
        } else {
            return 5;
        }
    }

    // Покормить котика одним из 3 видов корма: сухой, влажный и домашний. Котан привередливый, не все корма любит одинково.
    public function feed_dry()
    {
        $history[] = "feed_dry";
        $this->check_same_actions("food");
        if ($this->check_same_actions("food") == 5) {
            $probability_like = rand(1, 10);
            if ($probability_like == 10) {
                $this->mood -= 10;
                $this->game->message = self::EAT_MESSAGE_HATE;
            } else {
                $this->mood += 5;
                $this->game->message = self::EAT_MESSAGE_LIKE;
            }
            $this->food += 10;
        }
    }
    public function feed_wet () {
        $history[] = "feed_wet";
        $this->check_same_actions("food");
        if ($this->check_same_actions("food") == 5) {
            $probability_like = rand(1, 10);
            if ($probability_like > 5) {
                $this->mood -= 10;
                $this->game->message = self::EAT_MESSAGE_HATE;
            } else {
                $this->mood += 15;
                $this->game->message = self::EAT_MESSAGE_LIKE;
            }
            $this->food += 10;
        }
    }
    public function feed_home () {
        $history[] = "feed_home";
        $this->check_same_actions("food");
        if (array_count_values($history)["feed-home"] < 3) {
            if ($this->check_same_actions("food") == 5) {
                $this->mood += 15;
                $this->game->message = self::EAT_MESSAGE_LIKE;
                $this->food += 10;
            }
        } else {
            $this->game->message = self::STOP_MESSAGE;
        }
    }

    // Погладить
    public function stroke () {
        $history[] = "stroke";
        $this->check_same_actions("communication");
        if ($this->check_same_actions("communication") == 5) {
            $probability_like = rand(1, 10);
            if ($probability_like > 5) {
                $this->mood -= 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
            } else {
                $this->mood += 20;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
            $this->communication += 10;
        }
    }
    // Поиграть с дразнилкой
    public function play_teaser () {
        $history[] = "play_teaser";
        $this->check_same_actions("communication");
        if ($this->check_same_actions("communication") == 5) {
            $probability_like = rand(1, 10);
            if ($probability_like > 8) {
                $this->mood -= 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
            } else {
                $this->mood += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
            $this->communication += 10;
        }
    }
    // Поиграть с мышкой
    public function play_mouse () {
        $history[] = "play_teaser";
        $this->check_same_actions("communication");
        if ($this->check_same_actions("communication") == 5) {
            $probability_like = rand(1, 10);
            if ($probability_like > 6) {
                $this->mood -= 10;
                $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
            } else {
                $this->mood += 15;
                $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
            }
            $this->communication += 10;
        }
    }
}
