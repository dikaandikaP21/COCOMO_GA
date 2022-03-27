<?php

$populasi = [
    '1' => [
        'A' => '3',
        'B' => 1
    ],
    '2' => [
        'A' => '1',
        'B' => 3
    ],
    '3' => [
        'A' => '6',
        'B' => 2
    ],
];


asort($populasi);

foreach ($populasi as $key => $val) {
    print_r($val);
}
