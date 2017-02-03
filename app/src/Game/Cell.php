<?php
namespace GameOfLife\Game;
/**
 * Class Cell
 * @package GameOfLife\Game
 *
 * Holds a live cells coordinates
 */
class Cell implements \JsonSerializable
{
    /**
     * @var integer
     */
    public $x;
    /**
     * @var integer
     */
    public $y;

    /**
     * Cell constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        $this->x = (int)$x;
        $this->y = (int)$y;
    }

    function jsonSerialize()
    {
        return ['x'=>$this->x, 'y'=>$this->y];
    }
}