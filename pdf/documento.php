<?php

require_once __DIR__ . '/vendor/autoload.php';

$html = trim ($_GET["html"] );

$pagina = base64_decode($html);
$nome = time();

$mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
$mpdf->WriteHTML($pagina);
$mpdf->Output($nome, "I");

