<?php

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
