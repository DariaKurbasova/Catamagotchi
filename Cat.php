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
        $history = $this->game->action_history;
        $history[] = "feed_dry";
        if ($history[count($history)-2]=="feed_dry" && $history[count($history)-3]=="feed_dry") {
            $this->food += 10;
            $this->mood -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
        } else {
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
        $history = $this->game->action_history;
        $history[] = "feed_wet";
        if ($history[count($history)-2]=="feed_dry" && $history[count($history)-3]=="feed_dry") {
            $this->food += 10;
            $this->mood -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
        } else {
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
        $history = $this->game->action_history;
        $history[] = "feed_home";
        if ($history[count($history)-2]=="feed_dry" && $history[count($history)-3]=="feed_dry") {
            $this->food += 10;
            $this->mood -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
        } else {
            $this->mood += 15;
            $this->game->message = self::EAT_MESSAGE_LIKE;
            $this->food += 10;
        }
    }

    // Погладить
    public function stroke () {
        $history = $this->game->action_history;
        $history[] = "stroke";
        if ($history[count($history)-2]=="feed_dry" && $history[count($history)-3]=="feed_dry") {
            $this->communication += 10;
            $this->mood -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
        } else {
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
        $history = $this->game->action_history;
        $history[] = "play_teaser";
        if ($history[count($history)-2]=="feed_dry" && $history[count($history)-3]=="feed_dry") {
            $this->communication += 10;
            $this->mood -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
        } else {
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
        $history = $this->game->action_history;
        $history[] = "play_teaser";
        if ($history[count($history)-2]=="feed_dry" && $history[count($history)-3]=="feed_dry") {
            $this->communication += 10;
            $this->mood -= 20;
            $this->game->message = self::TIRED_OF_IT_MESSAGE;
        } else {
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
