<?php

namespace Racklin\PdfGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class PdfGenerator
 *
 * @package Racklin\PdfGenerator\Facades
 */
class PdfGenerator extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pdfgen';
    }
}
