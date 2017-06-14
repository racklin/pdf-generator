<?php

namespace Racklin\PdfGenerator;

/**
 * Class PdfGenerator
 *
 * @package Racklin\PdfGenerator
 */
class PdfGenerator
{

    protected $stEngine = null;

    public function __construct()
    {
        $this->stEngine = new \StringTemplate\Engine;

    }


    /**
     * Generate PDF
     *
     * @param $template
     * @param $data
     * @param $name
     * @param $desc 'I' , 'D' , 'F', 'FI' , 'FD'
     */
    public function generate($template, $data, $name = '', $desc = 'I') {

        $templateDir = dirname($template);

        $settings = json_decode(file_get_contents($template), true);
        $tcpdf = $this->initTCPDF($settings);

        foreach ($settings['pages'] as $page) {
            $tcpdf->AddPage();

            // set bacground image
            if (!empty($page['background'])) {
                $img_file = $templateDir . DIRECTORY_SEPARATOR . $page['background'];
                // get the current page break margin
                $bMargin = $tcpdf->getBreakMargin();
                // get current auto-page-break mode
                $auto_page_break = $tcpdf->getAutoPageBreak();
                // disable auto-page-break
                $tcpdf->SetAutoPageBreak(false, 0);
                // set bacground image
                $tcpdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                // restore auto-page-break status
                $tcpdf->SetAutoPageBreak($auto_page_break, $bMargin);
                // set the starting point for the page content
                $tcpdf->setPageMark();

            }

            foreach($page['data'] as $d) {
                if (!empty($d['font']) && !empty($d['font-size'])) {
                    $tcpdf->SetFont($d['font'], '', $d['font-size'], '', true);
                }

                // text
                if (!empty($d['text'])) {
                    $txt = $this->stEngine->render($d['text'], $data);
                    $lines = explode("\n", $txt);

                    $offsetY = ceil($d['font-size']/2.834 ?: 4);
                    $y = (int) $d['y'];

                    foreach ($lines as $line) {
                        $tcpdf->Text($d['x'], $y, $line);
                        $y += $offsetY;
                    }
                }

                // image
                if (!empty($d['image'])) {
                    $img = $this->stEngine->render($d['image'], $data);

                    $tcpdf->Image($img, $d['x'], $d['y'], $d['w']?:0, $d['h']?:0, '', '', '', false, 300, '', false, false, 0);
                }

                // html
                if (!empty($d['html'])) {
                    $html = $this->stEngine->render($d['html'], $data);
                    $html = str_replace("\n", "<br/>", $html);
                    $tcpdf->writeHTMLCell($d['w']?:0, $d['h']?:0, $d['x'], $d['y'], $html);
                }

            }
        }

        $tcpdf->Output($name, $desc);


    }


    protected  function initTCPDF($settings) {


        $tcpdf = new BaseTCPDF( ($settings['info']['page_orientation'] ?: 'P'), ($settings['info']['page_units'] ?: 'mm'), ($settings['info']['page_format'] ?: 'A4'), true, 'UTF-8', false);

        // set document information
        $tcpdf->SetCreator(PDF_CREATOR);
        $tcpdf->SetAuthor($settings['info']['author']);
        $tcpdf->SetTitle($settings['info']['title']);
        $tcpdf->SetSubject($settings['info']['subject']);
        $tcpdf->SetKeywords($settings['info']['keywords']);

        // set default header data
        //$tcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);

        // set header and footer fonts
        //$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $tcpdf->SetMargins($settings['info']['left-margin'], $settings['info']['top-margin'], $settings['info']['right-margin']);
        $tcpdf->SetHeaderMargin(0);
        $tcpdf->SetFooterMargin(0);

        //set auto page breaks
        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set default font subsetting mode
        $tcpdf->setFontSubsetting(true);

        return $tcpdf;
    }

}
