<?php 
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
