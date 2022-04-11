<?php 

class Fitness
{
    function RelativeError($estimasiPM, $actualPM)
    {
        return abs($estimasiPM - $actualPM);
    }

    function sumFitnessvalue($fitnessValue)
    {
        return floatval(array_sum($fitnessValue));
    }

    function Probability($fitness, $total)
    {
        return floatval($fitness / $total);
    }

    function Komulatif($key, $probability, $komulatif)
    {
        if ($key == 0) {
            $komulatif = abs($probability + 0);
        } else {
            $komulatif += abs($probability);
        }
        return $komulatif;
    }
}
