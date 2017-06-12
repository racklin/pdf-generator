<?php

require '../vendor/autoload.php';

use Racklin\PdfGenerator\PdfGenerator;

$pdf = new PdfGenerator();


$pdf->generate('example_01.json', ["name"=>"rack", "cname"=>"阿土伯"], '/tmp/example_01.pdf', 'F');
