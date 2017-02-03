<?php
/**
 * Created by PhpStorm.
 * User: marton
 * Date: 2/3/17
 * Time: 4:46 PM
 */

namespace GameOfLife\Game;


class Parser
{
    public static function read($file){
        try{
            $result=[];
            $fileInfo = new \SplFileInfo($file);
            $handle = $fileInfo->openFile("r");
            $handle->fgets(); //skip first line
            if ($handle){
                $row = 0;
                $col = 0;
                while ((!$handle->eof()) !== false) {
                    $buffer = $handle->fgets();
                    $prefix = substr($buffer, 0, 2);
                    switch ($prefix){
                        case "#R":
                        case "#D":
                            break;
                        case "#P":
                            $cleaned = str_replace("#P", "", $prefix);
                            $parts = explode(" ", $cleaned);
                            $row = $parts[0];
                            $col = $parts[1];
                            break;
                        default:
                            $currentCol = $col;
                            for ($i = 0; $i< strlen($buffer); $i++){
                                switch ($buffer[$i]){
                                    case ".":
                                        break;
                                    case "*":
                                        $result[] = new Cell($row, $currentCol);
                                        break;
                                }
                                $currentCol++;
                            }
                            $row++;

                    }
                }
            }

            return $result;

        } catch (\Exception $e){
            return [];
        }
    }

}