<?php

class AreaChecker{

    public static function isInArea($x, $y, $r){
        if ($x < 0 && $y > 0 )
            return (pow($x,2) + pow($y, 2)) <= pow($r/2, 2);
        if ($x < 0 && $y < 0)
            return (abs($x) + abs($y)) <= $r/2;
        if ($x > 0 && $y < 0)
            return $x <= $r && abs($y) <= $r;
        
        return false;
    }

}
?>