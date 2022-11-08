<?php


class Parameter
{
    const file_name = 'cocomo_nasa93.txt';
    const mr = 0.01;
    const populationSize = 30;
    const CR = 0.8;
}

class CocomoNasa93Processor
{
    public function processingData()
    {
        $raw_dataset = file(Parameter::file_name);
        foreach ($raw_dataset as $val) {
            $data[] = explode(",", $val);
        }

        $columnIndexes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25];
        $columns = ['prec', 'flex', 'resl', 'team', 'pmat', 'rely', 'data', 'cplx', 'ruse', 'docu', 'time', 'stor', 'pvol', 'acap', 'pcap', 'pcon', 'apex', 'plex', 'ltex', 'tool', 'site', 'sced', 'kloc', 'actualEffort', 'defects', 'months'];
        foreach ($data as $key => $val) {
            foreach (array_keys($val) as $subkey) {
                if ($subkey == $columnIndexes[$subkey]) {
                    $data[$key][$columns[$subkey]] = $data[$key][$subkey];
                    unset($data[$key][$subkey]);
                }
            }
        }
        return $data;
    }

    function getScales()
    {
        return array(
            "prec" => array("vl" => 6.2, "l" => 4.96, "n" => 3.72, "h" => 2.48, "vh" => 1.24, "eh" => 0),
            "flex" => array("vl" => 5.07, "l" => 4.05, "n" => 3.04, "h" => 2.03, "vh" => 1.01, "eh" => 0),
            "resl" => array("vl" => 7.07, "l" => 5.65, "n" => 4.24, "h" => 2.83, "vh" => 1.41, "eh" => 0),
            "team" => array("vl" => 5.48, "l" => 4.38, "n" => 3.29, "h" => 2.19, "vh" => 1.10, "eh" => 0),
            "pmat" => array("vl" => 7.80, "l" => 6.24, "n" => 4.68, "h" => 3.12, "vh" => 1.56, "eh" => 0),
            "rely" => array("vl" => 0.82, "l" => 0.92, "n" => 1.00, "h" => 1.10, "vh" => 1.26, "eh" => ''),
            "data" => array("vl" => '', "l" => 0.90, "n" => 1.00, "h" => 1.14, "vh" => 1.28, "eh" => ''),
            "cplx" => array("vl" => 0.73, "l" => 0.87, "n" => 1.00, "h" => 1.17, "vh" => 1.34, "eh" => 1.74),
            "ruse" => array("vl" => '', "l" => 0.95, "n" => 1.00, "h" => 1.07, "vh" => 1.15, "eh" => 1.24),
            "docu" => array("vl" => 0.81, "l" => 0.91, "n" => 1.00, "h" => 1.11, "vh" => 1.23, "eh" => ''),
            "time" => array("vl" => '', "l" => '', "n" => 1.00, "h" => 1.11, "vh" => 1.29, "eh" => 1.63),
            "stor" => array("vl" => '', "l" => '', "n" => 1.00, "h" => 1.05, "vh" => 1.17, "eh" => 1.46),
            "pvol" => array("vl" => '', "l" => 0.87, "n" => 1.00, "h" => 1.15, "vh" => 1.30, "eh" => ''),
            "acap" => array("vl" => 1.42, "l" => 1.19, "n" => 1.00, "h" => 0.85, "vh" => 0.71, "eh" => ''),
            "pcap" => array("vl" => 1.34, "l" => 1.15, "n" => 1.00, "h" => 0.88, "vh" => 0.76, "eh" => ''),
            "pcon" => array("vl" => 1.29, "l" => 1.12, "n" => 1.00, "h" => 0.90, "vh" => 0.81, "eh" => ''),
            "apex" => array("vl" => 1.22, "l" => 1.10, "n" => 1.00, "h" => 0.88, "vh" => 0.81, "eh" => ''),
            "plex" => array("vl" => 1.19, "l" => 1.09, "n" => 1.00, "h" => 0.91, "vh" => 0.85, "eh" => ''),
            "ltex" => array("vl" => 1.20, "l" => 1.09, "n" => 1.00, "h" => 0.91, "vh" => 0.84, "eh" => ''),
            "tool" => array("vl" => 1.17, "l" => 1.09, "n" => 1.00, "h" => 0.90, "vh" => 0.78, "eh" => ''),
            "site" => array("vl" => 1.22, "l" => 1.09, "n" => 1.00, "h" => 0.93, "vh" => 0.86, "eh" => 0.80),
            "sced" => array("vl" => 1.43, "l" => 1.14, "n" => 1.00, "h" => 1.00, "vh" => 1.00, "eh" => '')
        );
    }
    function putScales()
    {
        $project = $this->processingData();
        $scales = $this->getScales();

        foreach ($project as $key => $val) {
            foreach (array_keys($val) as $subkey => $subval) {
                if ($subkey < sizeof($scales)) {
                    $key_subproject = array_keys($val);
                    $key_scales = array_keys($scales);
                    if ($key_subproject[$subkey] == $key_scales[$subkey]) {
                        $search = $val[$key_subproject[$subkey]];
                        if (key_exists($search, $scales[$key_scales[$subkey]])) {
                            $subkey_scales = $scales[$key_scales[$subkey]];
                            $project[$key][$key_subproject[$subkey]] =  $subkey_scales[$search];
                        }
                    }
                }
            }
        }
        return $project;
    }
}

class Cocomo93
{

    function ScaleFactor($project)
    {
        $columSF = ["prec", "flex", "resl", "team", "pmat"];

        foreach (array_keys($project) as $key => $val) {
            if ($key < count($columSF)) {
                $SF[$val] = $project[$val];
            }
        }
        return $SF;
    }
    function EffortMultipyer($project)
    {

        $columEM = ["rely", "data", "cplx", "ruse", "docu", "time", "stor", "pvol", "acap", "pcap", "pcon", "apex", "plex", "ltex", "tool", "site", "sced"];

        foreach (array_keys($project) as $key => $val) {
            if ($key < 17) {
                if ($val = $columEM[$key]) {
                    $EM[$val] = $project[$val];
                }
            }
        }
        return $EM;
    }


    function estimatingEffort($variabel, $SF, $kloc, $effortMultipliers)
    {
        $scaleEffortExponent = floatval($variabel['B']) + 0.01 * array_sum($SF);
        return floatval($variabel['A']) * pow($kloc, $scaleEffortExponent) * array_product($effortMultipliers);
    }
}

class Individu
{
    function createIndividu()
    {
        return [
            'A' => mt_rand(0 * 100, 10 * 100) / 100,
            'B' => mt_rand(0.3 * 100, 2 * 100) / 100,

        ];
    }

    function countNumberOfGen()
    {
        return count($this->createIndividu());
    }
}

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

    function populations($population, $SF, $kloc, $EM, $actualEffort, $month)
    {

        $fitness = new Fitness;
        $cocomo93 = new Cocomo93;
        //menjumlahkan fitness
        foreach ($population as $key => $val) {
            $PM = $cocomo93->estimatingEffort($val, $SF, $kloc, $EM);
            $fitnessValue[$key] =   $fitness->RelativeError(floatval($PM), floatval($actualEffort));
        }
        $totalFitness = $fitness->sumFitnessvalue($fitnessValue);

        //perhitungan ke populasi 
        $komulatif = 0;
        foreach ($population as $key => $val) {
            // print_r($key . ' ');
            $PM = $cocomo93->estimatingEffort($val, $SF, $kloc, $EM);
            $fitnessVal = $fitness->RelativeError(floatval($PM), floatval($actualEffort));
            $probability = $fitness->Probability($fitness->RelativeError(floatval($PM), floatval($actualEffort)), $totalFitness);
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

class Randomizer
{
    function randomZeroToOne()
    {
        return (float) rand() / (float) getrandmax();
    }
    function getCutPointIndex()
    {
        $lengthOfGen = (new Individu)->countNumberOfGen();

        return rand(0, $lengthOfGen - 1);
    }
    function getRandomIndexOfIndividu($popSize)
    {
        return rand(0, $popSize - 1);
    }
}

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

class Select
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

class CrossoverGenerator
{
    function hasParents($population)
    {
        for ($i = 0; $i <= count($population) - 1; $i++) {
            $randomZeroToOne = (new Randomizer)->randomZeroToOne();
            if ($randomZeroToOne < Parameter::CR) {
                $parents[$i] = $randomZeroToOne;
            }
        }
        return $parents;
    }

    function generateCrossover($population)
    {
        $ret = [];
        $count = 0;
        $parents = $this->hasParents($population);

        while ($count < 1 && count($parents) === 0) {
            // $parents = $this->hasParents($population);
            if (count($parents) > 0) {
                break;
            }
            $count = 0;
        }

        foreach (array_keys($parents) as $key) {
            $keys[] = $key;
        }

        foreach ($keys as $key => $val) {
            foreach ($keys as $subval) {
                if ($val !== $subval) {
                    $ret[] = [$val, $subval];
                }
            }
            array_shift($keys);
        }

        return $ret;
    }
}


class OneCutPoint
{
    function isMaxIndex($cutPointIndex, $lengthOfChromosome)
    {
        if ($cutPointIndex === $lengthOfChromosome - 1) {
            return TRUE;
        }
    }


    function offspring($parent1, $parent2, $cutPointIndex, $offspring, $lengthOfChromosome)
    {
        $ret = [];

        if ($offspring === 1) {
            if ($this->isMaxIndex($cutPointIndex, $lengthOfChromosome)) {
                $ret['A'] = $parent1['A'];
                foreach ($parent2 as $key => $val) {
                    if ($key = 'B') {
                        $ret[$key] =  $parent2['B'];
                    }
                }
            } else {
                foreach ($parent2 as $key => $val) {
                    if ($key = 'A') {
                        $ret[$key] = $parent2['A'];
                    }
                }
                $ret['B'] = $parent1['B'];
            }
        }

        return $ret;
    }

    function crossover($population, $lengthOfChromosome)
    {
        $randomizer = new Randomizer;
        $crossoverGenerator = new CrossoverGenerator;
        $parents = $crossoverGenerator->generateCrossover($population);

        //    $ret = [];
        foreach ($parents as $parent) {

            echo '<br>';
            print_r('Index Parent : ');
            print_r($parent);
            echo '<br>';
            $cutPointIndex = $randomizer->getCutPointIndex();
            echo 'Cut:' . $cutPointIndex;
            echo '<br>';
            echo 'Parents: <br>';
            print_r($population[$parent[0]]);
            $parent1 = $population[$parent[0]];
            echo '<br>';
            print_r($population[$parent[1]]);
            $parent2 = $population[$parent[1]];
            echo '<br>';
            echo 'Offspring:<br>';
            $offspring1 = $this->offspring($parent1, $parent2, $cutPointIndex, 1, $lengthOfChromosome);
            print_r($offspring1);
            echo '<br>';
            echo '<p></p>';
            // $ret[] = $offspring1;

            $population[$parent[0]]['A'] = $offspring1['A'];
            $population[$parent[0]]['B'] = $offspring1['B'];
            $populationOffsprings[] = $population[$parent[0]];
            // print_r($populationOffsprings);
            // echo '<br>';

        }

        // return $populationOffsprings;
    }
}
function main()
{
    $project = (new CocomoNasa93Processor)->putScales();
    $cocomo93 = new Cocomo93;
    $population = new Population;
    $randomPopulation = $population->createPopulation();
    $selection = new Select;
    $hasparent = new CrossoverGenerator;
    $oneCutPoint = new OneCutPoint;

    $j = 0;
    while ($j < 93) {
        print_r("<br>" . 'project' . $j . "<br>");
        $SF = $cocomo93->ScaleFactor($project[$j]);
        $EM = $cocomo93->EffortMultipyer($project[$j]);


        //hitung dengan populasi awal
        $populations = $population->populations($randomPopulation, $SF, $project[$j]['kloc'], $EM,  $project[$j]['actualEffort'], $project[$j]['months']);

        //roulete wheel menghasilkan populasi baru
        $newPopulation =   $selection->rouletteWheel($populations);

        //crossover menghasilkan populasi offsprings
        $lengthOfChromosome = (new Individu)->countNumberOfGen();

        $parents = $oneCutPoint->crossover($newPopulation, $lengthOfChromosome);


        $j++;
    }
}

$t = main();
print_r($t);
