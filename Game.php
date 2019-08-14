<?php

require_once 'Cat.php';

class Game
{
    /** @var Cat */
    public $cat;

    public $difficulty;

    /** @var string */
    public $message;

    public $action_history = [];

    public $orange_cat_images = [
        'dry' => 'img/orange_dry.jpg',
        'wet' => 'img/orange_wet.jpg',
        'home' => 'img/orange_home.jpg',
        'stroke' => 'img/orange_stroke.jpg',
        'play_teaser' => 'img/orange_teaser.png',
        'play_mouse' => 'img/orange_mouse.jpg',
        'walking' => 'img/orange_walking.png',
        'sleep' => 'img/orange_sleep.jpg'
    ];

    public function getImage () {
        return $this->orange_cat_images [$this->action_history[count($this->action_history)-1]];
    }

    /**
     * Game constructor.
     * @param Cat $cat
     */
    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
        $cat->game = $this;
    }

}
