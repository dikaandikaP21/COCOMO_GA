<?php 

class Temp
{
    function sameKey($Population)
    {
        foreach ($Population as $key => $val) {
            $populations[$key] = [
                'fitness' => $val['fitness'],
                'A' => $val['A'],
                'B' => $val['B'],
                'PM' => $val['PM'],
                'month' => $val['month'],
                'totalFitness' => $val['totalFitness'],
                'probability' => $val['probability'],
                'komulatif' => $val['komulatif']
            ];
        }
        return $populations;
    }
}
