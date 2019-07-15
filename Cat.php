<?php

class Cat
{
    public $name;
    public $mood = 50;
    public $food = 50;

    CONST EAT_MESSAGE = "Котик очень рад! :)";


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

    public function feed()
    {
        $this->mood += 3;
        $this->food += 10;
        $this->game->message = self::EAT_MESSAGE;
    }

}
