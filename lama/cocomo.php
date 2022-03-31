<?php

use Fitness as GlobalFitness;
use Population as GlobalPopulation;

class Parameter
{
    const file_name = '../cocomo_nasa93.txt';
    const mr = 0.01;
    const populationSize = 30;
    const cr = 0.9;
}

class CocomoNasa93Processor
{
    public function processingData()
    {
        $raw_dataset = file(Parameter::file_name);
        foreach ($raw_dataset as $val) {
            $data[] = explode(",", $val);
        }
        //  print_r($data);
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


class Individu
{
    function createIndividu()
    {
        return [
            'A' => mt_rand(0 * 100, 10 * 100) / 100,
            'B' => mt_rand(0.3 * 100, 2 * 100) / 100
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
        $individu = new Individu;
        for ($i = 0; $i < Parameter::populationSize; $i++) {
            $population[$i] = $individu->createIndividu();
        }

        return $population;
    }
}

class COCOMO
{

    function __construct($project, $population)
    {
        $this->project = $project;
        $this->population = $population;
    }


    // function hidproject()
    // {
    //     for ($i = 0; $i < sizeof($this->project); $i++) {
    //         $val[] = $this->project[$i];

    //         echo ("Project ke- " . $i . ' ');
    //         print_r($this->project[$i]);
    //         unset($this->project[$i]);
    //         echo "<p>";
    //         array_splice($this->project, $i, 0, array($val[$i]));
    //     }
    // }

    function ScaleFactor()
    {
        $columSF = ["prec", "flex", "resl", "team", "pmat"];

        foreach ($this->project as $key => $val) {
            foreach (array_keys($val) as $subkey => $val_subkey) {
                if ($subkey < sizeof($columSF)) {
                    $sf[$subkey] =  $val[$val_subkey];
                }
            }
            $ScaleFactor[$key] = $sf;
        }
        return $ScaleFactor;
    }

    function EffortMultipyer()
    {
        $project = $this->project;
        $columEM = ["rely", "data", "cplx", "ruse", "docu", "time", "stor", "pvol", "acap", "pcap", "pcon", "apex", "plex", "ltex", "tool", "site", "sced"];

        foreach ($project as $key => $val) {
            foreach (array_keys($val) as $subkey => $val_subkey) {
                if ($subkey < 17) {
                    if ($val_subkey  = $columEM[$subkey]) {
                        $em[$subkey] = $val[$val_subkey];
                    }
                }
            }
            $array_EM[$key] = $em;
        }
        return $array_EM;
    }

    function scaleEffortExponent($B, $scale_factors)
    {
        return floatval($B)  + 0.01 * array_sum($scale_factors);
    }

    function estimating($A, $size, $E, $effort_multipliers)
    {
        return floatval($A)  * pow($size, $E) * array_product($effort_multipliers);
    }
    function PersonMounth()
    {
        $ScaleFactor = $this->ScaleFactor();
        $EffortMultiplyer = $this->EffortMultipyer();
        $population = $this->population;
        $project = $this->project;

        foreach ($project as $key => $val) {

            //  for ($i = 0; $i <= 10; $i++) {

            foreach ($population as $key_population => $val_population) {
                $E = $this->scaleEffortExponent($val_population['B'], $ScaleFactor[$key]);
                $PM = $this->estimating($val_population['A'], $val['kloc'], $E, $EffortMultiplyer[$key]);
                $individu[$key_population] = [
                    'A' => $val_population['A'],
                    'B' => $val_population['B'],
                    'PM' => $PM,
                    'months' => $val['months'],
                ];
            }
            $POP[$key] = $individu;
            // }

        }
        return  $POP;
    }
}

class Fitnesss
{
    function __construct($population)
    {
        $this->population = $population;
    }
    function RelativeError($estimasiPM, $actualPM)
    {
        return abs($estimasiPM - $actualPM);
    }

    function sumFitnessvalue($fitnessValue)
    {
        return floatval(array_sum($fitnessValue));
    }


    function fitnessEvaluation()
    {
        // mengihitung nilai fitness setiap individu dan menjumlahkan (total) nilai fitness pada setiap individu di setiap project

        foreach ($this->population as $key => $val) {

            foreach ($val as $key_individu => $val_individu) {

                $fitnessIndividu[$key_individu] = [
                    'fitness' => $this->RelativeError(floatval($val_individu['PM']), floatval($val_individu['months'])),
                    'A' => $val_individu['A'],
                    'B' => $val_individu['B'],
                    'PM' => $val_individu['PM'],
                    'months' => $val_individu['months'],
                ];


                $fitnessValue[$key_individu] = $fitnessIndividu[$key_individu]['fitness'];
            }

            $fitness_project[$key] = $fitnessValue;
            $fitnessTotal[$key] = $this->sumFitnessvalue($fitness_project[$key]);

            $fitnessEvaluation[$key] = [
                'populasi' =>  $fitnessIndividu,
                'totalFitness' => $fitnessTotal
            ];
        }
        return $fitnessEvaluation;
    }

    function countProbability($fitness, $total)
    {
        return floatval($fitness / $total);
    }

    function probability()
    {
        foreach ($this->fitnessEvaluation() as $key => $val) {
            //  print_r('Project ' . $key . ' ');

            foreach ($val['populasi'] as $key_individu => $val_individu) {
                //  echo '<br>';

                $probabilityIndividu[$key_individu] = [
                    'probability' => $this->countProbability(floatval($val_individu['fitness']), floatval($val['totalFitness'][$key])),
                    'A' => $val_individu['A'],
                    'B' => $val_individu['B'],
                    'PM' => $val_individu['PM'],
                    'months' => $val_individu['months'],
                    'fitness' => $val_individu['fitness'],
                    'totalFitess' => $val['totalFitness'][$key]
                ];

                //  print_r($probabilityIndividu[$key_individu]);
            }
            $populasi[$key] = $probabilityIndividu;
            // asort($probabilityIndividu);

            // echo '<p>';
        }


        return $populasi;
    }

    function comulativeProbability()
    {
        foreach ($this->probability() as  $key => $val) {
            print_r('Project ' . $key . ' ');
            $temp = 0;
            foreach ($val as $key_individu => $val_individu) {
                echo '<br>';
                if ($key_individu == 0) {
                    $temp = abs($val_individu['probability'] + 0);
                    $probabilityKomulatif[$key_individu] = [
                        'komulatif' =>   $temp,
                        'probability' => $val_individu['probability'],
                        'A' => $val_individu['A'],
                        'B' => $val_individu['B'],
                        'PM' => $val_individu['PM'],
                        'months' => $val_individu['months'],
                        'fitness' => $val_individu['fitness'],
                        'totalFitess' => $val_individu['totalFitess'],
                    ];
                } else {
                    $temp += abs($val_individu['probability']);
                    $probabilityKomulatif[$key_individu] = [
                        'komulatif' => $temp,
                        'probability' => $val_individu['probability'],
                        'A' => $val_individu['A'],
                        'B' => $val_individu['B'],
                        'PM' => $val_individu['PM'],
                        'months' => $val_individu['months'],
                        'fitness' => $val_individu['fitness'],
                        'totalFitess' => $val_individu['totalFitess'],
                    ];
                    // $roulete = [
                    //     $probabilityKomulatif[$key_individu]['komullatif']
                    // ];
                }

                print_r($probabilityKomulatif[$key_individu]);
            }
            // ---asort($probabilityKomulatif);
            $populasi[$key] = $probabilityKomulatif;
            echo '<p>';
        }
        // return $populasi;
    }
}

class Selection
{
    function __construct($populasi)
    {
        $this->populasi = $populasi;
    }
    function randomZeroToOne()
    {
        for ($i = 0; $i < 30; $i++) {
            $r[$i] = (float) rand() / (float) getrandmax();
        }
        return $r;
    }

    function rouletteWheel()
    {
        $population = $this->populasi;
        $r =  $this->randomZeroToOne();

        for ($i = 0; $i > 30; $i++) {
            print_r($population[0][$i]);
            echo '<br>';
        }


        for ($i = 0; $i < 1; $i++) { //perulangan project
            print_r('project ' . $i);

            echo '<br>';
            for ($j = 0; $j < 30; $j++) {  //perulangan bilangan acak random

                print_r($j . '->');
                print_r($r[$j]);
                echo '<br>';
                for ($k = 0; $k < 30; $k++) { //perulangan kromosom

                    if ($k > 30) {
                        if ($r[$j] > $population[$i][$k - 1]['komulatif'] && $r[$j] < $population[$i][$k]['komulatif']) {
                            $rouletWhile = [
                                // $population[$i][$k]['komulatif']
                                $k
                            ];
                        }
                    }
                    if ($r[$j] > $population[$i][$k]['komulatif'] && $r[$j] < $population[$i][$k + 1]['komulatif']) {
                        $rouletWhile = [
                            // $population[$i][$k + 1]['komulatif']
                            $k
                        ];
                    }
                }

                echo '<br>';
                // echo 'routeWhile : ';
                print_r($rouletWhile);
                echo '<p>';
            }

            echo '<p>';
        }


        // foreach ($this->populasi as $key => $val) {
        //     print_r('Project ' . $key);

        //     foreach ($val as $key_individu => $val_individu) {
        //         echo '<br>';
        //         print_r('c ' . $key_individu . '->');
        //         print_r($val[$key_individu]);

        //         if($r[$key_individu] > $val[$key_individu]['komulatif'] && $r[$key_individu]){

        //         }
        //     }
        //     echo '<p>';
        // }
    }
}



$CocomoNasa93Processor = new CocomoNasa93Processor;

$population = (new Population())->createPopulation();

$cocomo = (new COCOMO($CocomoNasa93Processor->putScales(), $population))->PersonMounth();
// print_r($cocomo->PersonMounth());

$fitness = new Fitnesss($cocomo);
print_r($fitness->comulativeProbability());

// $rouletwhile = (new Selection($fitness->comulativeProbability()));
// print_r($rouletwhile->rouletteWheel());
