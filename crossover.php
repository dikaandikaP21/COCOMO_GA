<?php

include_once 'main.php';
include_once 'randomizer.php';

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
            $parents = $this->hasParents($population);
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
                        $ret[$key] = $parent2['B'];
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

        // $ret = [];
        foreach ($parents as $parent) {

            // echo '<br>';
            // print_r($parent);
            // echo '<br>';
            $cutPointIndex = $randomizer->getCutPointIndex();
            // echo 'Cut:' . $cutPointIndex;
            // echo '<br>';
            // echo 'Parents: <br>';
            // print_r($population[$parent[0]]);
            $parent1 = $population[$parent[0]];
            // echo '<br>';
            // print_r($population[$parent[1]]);
            $parent2 = $population[$parent[1]];
            // echo '<br>';
            // echo 'Offspring:<br>';
            $offspring1 = $this->offspring($parent1, $parent2, $cutPointIndex, 1, $lengthOfChromosome);
            // print_r($offspring1);
            // echo '<br>';
            // echo '<p></p>';
            // $ret[] = $offspring1;

            $population[$parent[0]]['A'] = $offspring1['A'];
            $population[$parent[0]]['B'] = $offspring1['B'];
            $populationOffsprings[] = $population[$parent[0]];
            //  print_r($populationOffsprings);
            // echo '<br>';
        }

        return $populationOffsprings;
    }
}
