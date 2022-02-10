<?php
class hiddenproject
{
    function hiddbyproject()
    {
        for ($i = 1; $i <= 93; $i++) {
            $project[] = $i;
        }
        //  print_r($project);
        //  $project = $this->processingData();

        for ($i = 0; $i < 93; $i++) {
            $val = $project[$i];
            //print_r($val);
            unset($project[$i]);
            // $project =  array_shift($project[$i]);
            // $hidd[$i] = $project;
            echo ("Iterasi ke- " . $i);
            print_r($project);
            echo "<p>";
            array_splice($project, $i, 0, $val);
            // array_push($project, $val);
        }

        echo "Array Full";
        print_r($project);
    }
}

$hiddenproject = new hiddenproject;
$hiddenbyproject = $hiddenproject->hiddbyproject();
