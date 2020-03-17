<?php

require_once __DIR__ . '/vendor/autoload.php';

$html = file_getk_contents('exemplo.html');
$nome = time();
h
$mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
$mpdf->WriteHTML($html);
$mpdf->Output($nome, "I");

