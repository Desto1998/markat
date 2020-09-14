<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/pdf-lib/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class Template_pdf
{
    protected $templates;
    protected $table;

    public function __construct($template, $tag = '')
    {
        $this->templates = $template;
        $this->preparetable($template->json_data);
        try {
            ob_start();
            include $this->file_path();
            $content = ob_get_clean();
            /*
                        $html2pdf = new Html2Pdf('P', 'A4', 'de',
                            $unicode = true,
                            $encoding = 'UTF-8',
                          $margins = array(20, 10, 20, 14));*/
            $html2pdf = new Html2Pdf('P', 'A4', 'de',
                $unicode = true,
                $encoding = 'UTF-8',
                $margins = array(5, 5, 5, 4));
            $html2pdf->setDefaultFont('Arial');
            // $html2pdf->setModeDebug();
            $html2pdf->writeHTML($content);
            $html2pdf->output('dokumente.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

    function preparetable($jsqon)
    {
        if ($jsqon)
            $this->table = unserialize($jsqon);
    }

    function srapdata($x, $y)
    {
        if (!$this->table)
            return '';
        $x = $this->table['x' . $x][$y];
        return $x;
    }

    public function prepare()
    {
    }

    protected function type()
    {
        return 'template';
    }

    protected function file_path()
    {
        $template_pdf = 'template_pdf_2';
        return APPPATH . 'views/themes/' . active_clients_theme() . '/views/' . $template_pdf . '.php';
    }
}
