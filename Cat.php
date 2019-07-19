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

    // Покормить котика одним из 3 видов корма: сухой, влажный и домашний. Котан привередливый, не все корма любит одинково.
    public function feed_dry()
    {
        $probability_like = rand(1, 10);
        if ($probability_like == 10) {
            $this->mood -= 10;
            $this->game->message = self::EAT_MESSAGE_HATE;
        } else {
            $this->mood += 5;
            $this->game->message = self::EAT_MESSAGE_LIKE;
        }
        $this->food += 10;
        $this->game->action_history[] = "feed_dry";
    }
    public function feed_wet () {
        $probability_like = rand(1, 10);
        if ($probability_like > 5) {
            $this->mood -= 10;
            $this->game->message = self::EAT_MESSAGE_HATE;
        } else {
            $this->mood += 15;
            $this->game->message = self::EAT_MESSAGE_LIKE;
        }
        $this->food += 10;
        $this->game->action_history[] = "feed_wet";
    }
    public function feed_home () {
        $this->mood += 15;
        $this->game->message = self::EAT_MESSAGE_LIKE;
        $this->food += 10;
        $this->game->action_history[] = "feed_home";
    }

    // Погладить
    public function stroke () {
        $probability_like = rand(1, 10);
        if ($probability_like > 5) {
            $this->mood -= 10;
            $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
        } else {
            $this->mood += 20;
            $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
        }
        $this->communication += 10;
        $this->game->action_history[] = "stroke";
    }
    // Поиграть с дразнилкой
    public function play_teaser () {
        $probability_like = rand(1, 10);
        if ($probability_like > 8) {
            $this->mood -= 10;
            $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
        } else {
            $this->mood += 15;
            $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
        }
        $this->communication += 10;
        $this->game->action_history[] = "play_teaser";
    }
    // Поиграть с мышкой
    public function play_mouse () {
        $probability_like = rand(1, 10);
        if ($probability_like > 6) {
            $this->mood -= 10;
            $this->game->message = self::COMMUNICATE_MESSAGE_HATE;
        } else {
            $this->mood += 15;
            $this->game->message = self::COMMUNICATE_MESSAGE_LIKE;
        }
        $this->communication += 10;
        $this->game->action_history[] = "play_teaser";
    }
}
