<?php

require '../vendor/autoload.php';

use Racklin\PdfGenerator\PdfGenerator;

$pdf = new PdfGenerator();


$pdf->generate('example_02.json', ["name"=>"rack", "cname"=>"阿土伯"], '/tmp/example_02.pdf', 'F');
