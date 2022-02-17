<?php

class Parameter
{
    const file_name = 'cocomo_nasa93.txt';
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
                        //print_r($key_subproject[$subkey]);          //komponen-komponen dari setiap projek
                        // echo " -> ";
                        // print_r($val[$key_subproject[$subkey]]);  //value dari komponen setiap project
                        // echo " -> ";
                        // print_r($scales[$key_scales[$subkey]]);    //value dari scales

                        $search = $val[$key_subproject[$subkey]];

                        if (key_exists($search, $scales[$key_scales[$subkey]])) {

                            $subkey_scales = $scales[$key_scales[$subkey]];
                            // print_r($project[$key][$key_subproject[$subkey]] . ' -> ' . $subkey_scales[$cari]);
                            $project[$key][$key_subproject[$subkey]] =  $subkey_scales[$search];
                            // unset($subkey_scales[$cari]);
                        }

                        // echo "<p>";
                    }
                }
            }
            // echo '<br>';
        }


        return $project;
    }
}

class Hitung
{

    function __construct($project, $individu)
    {
        $this->project = $project;
        $this->individu = $individu;
    }


    function hidproject()
    {

        for ($i = 0; $i < sizeof($this->project); $i++) {
            //cari perproject
            $val[] = $this->project[$i];

            echo ("Project ke- " . $i . ' ');
            print_r($this->project[$i]);
            unset($this->project[$i]);

            echo "<p>";
            array_splice($this->project, $i, 0, array($val[$i]));
        }
    }

    function ScaleFactor()
    {
        //hitung nilai SF setiap project
        $columSF = [
            "prec",
            "flex",
            "resl",
            "team",
            "pmat"
        ];
        foreach ($this->project as $key => $val) {
            //echo ("E Project ke- " . $key . ' ');
            $sf = 0;
            //hitunf SF
            foreach (array_keys($val) as $subkey => $val_subkey) {

                if ($subkey < sizeof($columSF)) {
                    // echo '<br>';
                    // print_r($val_subkey . '->');
                    // print_r($val[$val_subkey]);

                    $sf +=  $val[$val_subkey];
                }
            }

            // echo "<br>";
            // print_r($sf);
            $SFproject[] = $sf;
            // echo "<p>";
        }
        return $SFproject;
    }

    function EffortMultipyer()
    {
        // Hitung EffortMultipyer setiap project
        $project = $this->project;

        $columEM = ["rely", "data", "cplx", "ruse", "docu", "time", "stor", "pvol", "acap", "pcap", "pcon", "apex", "plex", "ltex", "tool", "site", "sced"];
        $em = 0;

        foreach ($project as $key => $val) {
            echo ('Project-> ' . $key . '');
            foreach (array_keys($val) as $subkey => $val_subkey) {
                echo '<br>';

                // print_r($columEM[$subkey]);


                if ($val_subkey  = $columEM[$subkey]) {
                    print_r($val[$val_subkey]);
                }
            }
            echo '<p>';
        }
    }

    function Effort()
    {
        //Hitung Effort setiap project
        $valueSF_Project = $this->ScaleFactor();
        $individu = $this->individu;
        $project = $this->project;

        foreach ($individu as $key => $val) {
            echo (' Variabel B-> ' . $key);
            // print_r($val[1]);

            foreach ($project as $key_project => $val_project) {

                echo '<br>';
                echo ('Project' . $key_project . ' -> ');
                $effort = $val[1] * 0.01 * $valueSF_Project[$key_project];
                // print_r($effort);


            }
            echo '<p>';
        }
    }
}

class Genetic
{

    function population()
    {
        for ($i = 0; $i < Parameter::populationSize; $i++) {
            $individu[] = [
                mt_rand(0 * 100, 10 * 100) / 100,
                mt_rand(0.3 * 100, 2 * 100) / 100,
            ];
        }
        return $individu;
    }
}


$CocomoNasa93Processor = new CocomoNasa93Processor;
$genetik = new Genetic;

$hitung = new Hitung($CocomoNasa93Processor->putScales(), $genetik->population());
print_r($hitung->EffortMultipyer());

// print_r($genetik->population());
