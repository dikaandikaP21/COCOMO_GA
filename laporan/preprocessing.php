<?php
class Parameter
{
    const file_name = 'cocomo_nasa93.txt';
}
class CocomoNasa93Processor
{
    public function processingData()
    {
        $raw_dataset = file(Parameter::file_name);
        foreach ($raw_dataset as $val) {
            $data[] = explode(",", $val);
            // print_r('project' . ' = ' . $val);
            // echo '<br>';
        }
        foreach ($raw_dataset as $key => $val) {
            $data[] = explode(",", $val);
            print_r('project' . $key . ' = ' . $val);
            echo '<br>';
        }

        $columnIndexes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25];
        $columns = ['prec', 'flex', 'resl', 'team', 'pmat', 'rely', 'data', 'cplx', 'ruse', 'docu', 'time', 'stor', 'pvol', 'acap', 'pcap', 'pcon', 'apex', 'plex', 'ltex', 'tool', 'site', 'sced', 'kloc', 'actualEffort', 'defects', 'months'];
        foreach ($data as $key => $val) {
            foreach (array_keys($val) as $subkey) {
                if ($subkey == $columnIndexes[$subkey]) {
                    echo '<br>';
                    print_r($subkey . '==' . $columnIndexes[$subkey]);
                    echo '<br>';
                    print_r($data[$key][$subkey]);
                    $data[$key][$columns[$subkey]] = $data[$key][$subkey];
                    unset($data[$key][$subkey]);
                }
            }
        }
        //  return $data;
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

        foreach ($project as $key => $val) {   // perulangan projek
            foreach (array_keys($val) as $subkey => $subval) {  //perulangan atribut

                if ($subkey < sizeof($scales)) {   //index atribute harus kurang dari 17 (karena tidak ada mon, actual Ef, kloc, defecth)
                    $key_subproject = array_keys($val); //key_subprojek berisi atribute cocomo
                    $key_scales = array_keys($scales);  //key_scales berisi atribute cocomo
                    if ($key_subproject[$subkey] == $key_scales[$subkey]) {   // jika atribut perprojek sama dengan key dari getScales maka
                        $search = $val[$key_subproject[$subkey]];  // ambil value dari atribut projek disimpan ke variabel search
                        if (key_exists($search, $scales[$key_scales[$subkey]])) {   // memeriksa array getScales dengan key yang ditentukan yaitu value dari atribut projek
                            $subkey_scales = $scales[$key_scales[$subkey]];  //ambil value dari sub indeks dari getScales
                            $project[$key][$key_subproject[$subkey]] =  $subkey_scales[$search]; //replace value dari atribut projek dengan value dari sub indeks getScales
                        }
                    }
                }
            }
        }
        return $project;
    }
    public function tampilProcessingData()
    {
        $data = $this->processingData();
        foreach ($data as $key => $val) {
            print_r('project ' . $key . ' <br>');
            print_r($val);
            echo '<p>';
        }
    }
    public function tampilPutScales()
    {
        $data = $this->putScales();
        foreach ($data as $key => $val) {
            print_r('project ' . $key . ' <br>');
            print_r($val);
            echo '<p>';
        }
    }
}



$preprocessing = new CocomoNasa93Processor;
print_r($preprocessing->processingData());
// print_r($preprocessing->tampilPutScales());
// print_r($preprocessing->tampilProcessingData());
// print_r($preprocessing->processingData());
