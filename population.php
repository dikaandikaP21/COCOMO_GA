<?php

// include 'main.php';
include 'individu.php';
// include 'calc-cocomo.php';
include 'fitness.php';

class Population
{
    function createPopulation()
    {
        $individu = (new Individu);
        for ($i = 0; $i < Parameter::populationSize; $i++) {
            $population[$i] = $individu->createIndividu();
        }

        return $population;
    }

    function populations($population, $SF, $kloc, $EM, $month)
    {

        $fitness = new Fitness;
        $cocomo93 = new Cocomo93;
        //menjumlahkan fitness
        foreach ($population as $key => $val) {
            $PM = $cocomo93->estimatingEffort($val, $SF, $kloc, $EM);
            $fitnessValue[$key] =   $fitness->RelativeError(floatval($PM), floatval($month));
        }
        $totalFitness = $fitness->sumFitnessvalue($fitnessValue);

        //perhitungan ke populasi 
        $komulatif = 0;
        foreach ($population as $key => $val) {
            // print_r($key . ' ');
            $PM = $cocomo93->estimatingEffort($val, $SF, $kloc, $EM);
            $fitnessVal = $fitness->RelativeError(floatval($PM), floatval($month));
            $probability = $fitness->Probability($fitness->RelativeError(floatval($PM), floatval($month)), $totalFitness);
            $komulatif = $fitness->Komulatif($key, $probability, $komulatif);

            $cromosome[$key] = [
                'komulatif' => $komulatif,
                'probability' => $probability,
                'A' => $val['A'],
                'B' => $val['B'],
                'PM' => $PM,
                'month' => $month,
                'fitness' => $fitnessVal,
                'totalFitness' => $totalFitness,
            ];
            // print_r($cromosome[$key]);
            // echo '<br>';
        }
        return $cromosome;
    }
}
