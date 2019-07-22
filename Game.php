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
