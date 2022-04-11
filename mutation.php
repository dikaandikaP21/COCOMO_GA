<?php 
class Mutation
{

    function calcGenInPopulations($lengthOfChromosome, $populations)
    {
        return ($lengthOfChromosome * count($populations));
    }

    function calcMutationRate($lengthOfChromosome)
    {
        //return floatval(1 / $lengthOfChromosome);
        return 0.1;
    }

    function calcNumOfMutation($mutationRate, $lengthOfChromosome, $populations)
    {
        return round($mutationRate * $this->calcGenInPopulations($lengthOfChromosome, $populations));
    }

    function convertIndex($indexOfGen)
    {
        if ($indexOfGen == 0) {
            return 'A';
        } else {
            return 'B';
        }
    }

    function mainMutation($lengthOfChromosome, $populations)
    {
        $randomizer = new Randomizer;
        $valueRandomGen = new Individu;

        $mutationRate = $this->calcMutationRate($lengthOfChromosome);
        $numOfMutation = $this->calcNumOfMutation($mutationRate, $lengthOfChromosome, $populations);

        for ($i = 0; $i <= $numOfMutation - 1; $i++) {
            $indexOfIndividu = $randomizer->getRandomIndexOfIndividu(count($populations));

            $indexOfGen = $randomizer->getCutPointIndex($lengthOfChromosome);
            $indexOfGen = $this->convertIndex($indexOfGen);

            $mutatedIndividu = $populations[$indexOfIndividu];

            $valueOfGenIndividu =  $mutatedIndividu[$indexOfGen]; //
            $valueOfGenMutated = $valueRandomGen->createIndividu()[$indexOfGen];

            // print_r('key' . $indexOfIndividu); //
            // print_r($mutatedIndividu); //
            // echo '<br>'; //
            // print_r($indexOfGen . '=' . $valueOfGenIndividu . '-> ' . $valueOfGenMutated); //
            // echo '<br>'; //
            $mutatedIndividu[$indexOfGen] = $valueOfGenMutated;
            // print_r('mutated'); //
            // print_r($mutatedIndividu); //
            // echo '<br>'; //

            $populations[$indexOfIndividu] = $mutatedIndividu;
            // echo '<br>'; //
        }
        return $populations;
    }
}
