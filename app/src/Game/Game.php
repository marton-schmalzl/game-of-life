<?php
/**
 * Created by PhpStorm.
 * User: marton
 * Date: 2/3/17
 * Time: 11:24 AM
 */

namespace GameOfLife\Game;

use GameOfLife\Game\Cell;

/**
 * Class Game
 * @package GameOfLife\Game
 */
class Game
{

    /**
     *  minmal neighbour count to keep cell alive
     */
    const KEEP_ALIVE_MIN = 2;
    /**
     * maximum neighbour count to keep cell alive
     */
    const KEEP_ALIVE_MAX = 3;
    /**
     * neighbour count requerid to create a cell
     */
    const CREATION       = 3;

    /**
     * @param $cells Cell[]
     * @return Cell[]
     * Returns the next state of the board
     */
    public static function evolve($cells){
        $maxX=$cells[0]->x;
        $maxY=$cells[0]->y;
        $minX=$cells[0]->x;
        $minY=$cells[0]->y;
        foreach ($cells as $cell){
            if ($cell->x > $maxX) $maxX = $cell->x;
            if ($cell->y > $maxY) $maxY = $cell->y;
            if ($cell->x < $minX) $minX = $cell->x;
            if ($cell->y < $minY) $minY = $cell->y;
        }
        $evolvedCells = [];

        for ($i=$minX-1; $i<=$maxX+1; $i++){
            for ($j=$minY-1; $j<=$maxY+1; $j++){
                $neighbours = self::countNeighbours($cells, $i, $j);
                if (self::getState($cells, $i, $j)){
                    if ($neighbours >= self::KEEP_ALIVE_MIN && $neighbours <= self::KEEP_ALIVE_MAX){
                        $evolvedCells[] = new Cell($i, $j);
                    }
                } else {
                    if ($neighbours == self::CREATION){
                        $evolvedCells[] = new Cell($i, $j);
                    }
                }

            }

        }

        return $evolvedCells;
    }

    /**
     * @param $board Cell[]
     * @param $x integer
     * @param $y integer
     * @return integer
     */
    private static function countNeighbours($board, $x, $y){
        $n = 0;
        if (self::getState($board, $x-1, $y-1)) $n++;
        if (self::getState($board, $x-1, $y))   $n++;
        if (self::getState($board, $x-1, $y+1)) $n++;
        if (self::getState($board, $x,   $y-1)) $n++;
        if (self::getState($board, $x,   $y+1)) $n++;
        if (self::getState($board, $x+1, $y-1)) $n++;
        if (self::getState($board, $x+1, $y))   $n++;
        if (self::getState($board, $x+1, $y+1)) $n++;
        return $n;
    }

    /**
     * @param $cells Cell[]
     * @param $x
     * @param $y
     * @return bool
     */
    private static function getState($cells, $x, $y){
        foreach ($cells as $cell)
            if ($cell->x = $x && $cell->y == $y)
                return true;
        return false;
    }
}