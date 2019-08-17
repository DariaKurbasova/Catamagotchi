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

    public $gameover_images = [
        'hunger' => 'img/orange_hunger.jpg',
        'loneliness' => 'img/orange_loneliness.jpg',
        'fatigue' => 'img/orange_fatigue.jpg',
        'boredom' => 'img/orange_boredom.jpg',
        'happiness' => 'img/orange_happiness.jpg'
    ];
    public $gameover_image;

    /**
     * Game constructor.
     * @param Cat $cat
     */

    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
        $cat->game = $this;
    }

    public function getImage () {
        if (!empty($this->action_history)) {
            return $this->orange_cat_images [$this->action_history[count($this->action_history) - 1]];
        } else {
            return 'img/orange_main.jpg';
        }
    }

    public function getMessage () {
        if (empty($this->action_history)) {
            $this->message = "Давай, развлекай меня!";
        }
        return $this->message;
    }

    public function checkGameEnd () {
        if ($this->cat->food <= 10) {
            $this->gameover_image = $this->gameover_images['hunger'];
            return "Вы плохой хозяин, вам нельзя доверить заботу о котике! <br> К сожалению, ваш питомец умер от голода.";
        } elseif ($this->cat->communication <= 10) {
            $this->gameover_image = $this->gameover_images['loneliness'];
            return "Вы плохой хозяин, вам нельзя доверить заботу о котике! <br> Ваш питомец впал в глубокую депрессию от одиночества.";
        } elseif ($this->cat->energy <= 10) {
            $this->gameover_image = $this->gameover_images['fatigue'];
            return "Вы плохой хозяин, вам нельзя доверить заботу о котике! <br> Совсем замучили бедное животное.";
        } elseif ($this->cat->mood <= 10) {
            $this->gameover_image = $this->gameover_images['boredom'];
            return "Вы плохой хозяин, вам нельзя доверить заботу о котике! <br> Питомцу стало скучно с вами, и он убежал искать других хозяев.";
        } elseif ($this->cat->food >= 80 && $this->cat->communication >= 80 && $this->cat->energy >= 80 && $this->cat->mood >= 80) {
            $this->gameover_image = $this->gameover_images['happiness'];
            return "Вы отлично справились с заботой о питомце, котик вас очень любит!";
        } else {
            return false;
        }
    }

}
