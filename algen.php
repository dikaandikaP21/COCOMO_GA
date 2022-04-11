<?php

include 'dataPreprocesor.php';
include_once 'calc-cocomo.php';
include_once 'population.php';
include 'selection.php';
include 'crossover.php';
include 'temp.php';
include 'mutation.php';

class Algen
{
    function runMain()
    {
        $project = (new CocomoNasa93Processor)->putScales();
        $cocomo93 = new Cocomo93;
        $population = new Population;
        $randomPopulation = $population->createPopulation();
        $selection = new Selection;
        $oneCutPoint = new OneCutPoint;
        $temp = new Temp;
        $mutation = new Mutation;

        for ($i = 0; $i < 3; $i++) {
            echo ('project' . $i);
            echo '<br>';

            $SF = $cocomo93->ScaleFactor($project[$i]);
            $EM = $cocomo93->EffortMultipyer($project[$i]);

            //hitung dengan populasi awal
            $populations = $population->populations($randomPopulation, $SF, $project[$i]['kloc'], $EM, $project[$i]['months']);

            //roulete wheel menghasilkan populasi baru
            $newPopulation =   $selection->rouletteWheel($populations);

            //crossover menghasilkan populasi offsprings
            $lengthOfChromosome = (new Individu)->countNumberOfGen();
            $populationOffsprings = $oneCutPoint->crossover($newPopulation, $lengthOfChromosome);

            //hitung cocomo dengan populasi offsprings
            $newPopulationOffspring =  $population->populations($populationOffsprings, $SF, $project[$i]['kloc'], $EM, $project[$i]['months']);

            //gabungkan population(roulette wheel) dengan population offsprings
            $mergePopulation = array_merge($newPopulation, $newPopulationOffspring);
            $populations = $temp->sameKey($mergePopulation);
            sort($populations);
            $populations = array_slice($populations, 0, Parameter::populationSize);

            //populasi di mutasi
            $populationMutated = $mutation->mainMutation($lengthOfChromosome, $populations);

            //hitung kembali dengan cocomo
            $populations = $population->populations($populationMutated, $SF, $project[$i]['kloc'], $EM, $project[$i]['months']);
            $populations = $temp->sameKey($populations);
            sort($populations);


            foreach ($populations as $key => $val) {
                print_r($key);
                print_r($val);
                echo '<br>';
            }
            // print_r($populations);
            echo '<p>';
        }
        return $populations;
    }
}
