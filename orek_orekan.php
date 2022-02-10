<?php
class hidenproject
{
    function hidproject()
    {
        // for ($i = 1; $i <= 93; $i++) {
        //     $project[] = $i;
        // }
        // //  print_r($project);
        // //  $project = $this->processingData();

        $project = [
            [
                'A' => 1,
                'B' => 1,
                'C' => 1
            ],
            [
                'A' => 2,
                'B' => 2,
                'C' => 2
            ],
            [
                'A' => 3,
                'B' => 3,
                'C' => 3
            ],
            [
                'A' => 4,
                'B' => 4,
                'C' => 4
            ],

        ];
        for ($i = 0; $i < 4; $i++) {
            $val[] = $project[$i];
            //    print_r(array($val[$i]));
            unset($project[$i]);

            echo ("Iterasi ke- " . $i);
            print_r($project);
            echo "<p>";
            array_splice($project, $i, 0, array($val[$i]));
        }

        echo "Array Full";
        print_r($project);
    }
}

$hiddenproject = new hidenproject;
$hiddenbyproject = $hiddenproject->hidproject();
