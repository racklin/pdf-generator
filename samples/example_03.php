<?php

require '../vendor/autoload.php';

use Racklin\PdfGenerator\PdfGenerator;

$pdf = new PdfGenerator();


$pdf->generate('example_03.json', ["name"=>"rack", "cname"=>"阿土伯"], '/tmp/example_03.pdf', 'F');
