<?php


class Parameter
{
    const file_name = 'cocomo_nasa93.txt';
    const mr = 0.01;
    const populationSize = 30;
    const CR = 0.8;
}

class Main
{
    function runMain()
    {
        $algen = new Algen;
        $population = new Population;
        $randomPopulation = $population->createPopulation();

        $i = 1;
        while ($i <= 3) {

            $lastPopulation = $algen->runAlgen($randomPopulation);
            $selectedIndividu[$i] = $lastPopulation[0];
            $randomPopulation =  $lastPopulation;

            print_r($selectedIndividu[$i]);
            echo '<p>';

            $i++;
        }
    }
}
