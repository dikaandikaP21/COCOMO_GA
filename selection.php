<?php

require_once 'main.php';
require_once 'randomizer.php';


class Selection
{
    function rouletteWheel($cromosoms)
    {
        for ($i = 0; $i < Parameter::populationSize; $i++) {
            $r = (new Randomizer())->randomZeroToOne();
            foreach ($cromosoms as $key => $val) {
                if ($r <= $val['komulatif']) {
                    // echo '<br>';
                    // print_r($r . ' <= ' . $val['komulatif'] . ' = ' . $key);
                    $key;
                    break;
                }
            }
            $newPopulations[$i] = $cromosoms[$key];
        }
        return ($newPopulations);
    }
}
