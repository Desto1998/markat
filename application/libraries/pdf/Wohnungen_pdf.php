<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Wohnungen_pdf extends App_pdf
{
    protected $wohnungen;

    public function __construct($aq, $tag = '')
    {

        $wohnungen = hooks()->apply_filters('wohnungen_html_pdf_data', $aq);
        $GLOBALS['wohnungen_pdf'] = $aq;

        parent::__construct();

        if (!class_exists('wohnungen_model', false)) {
            $this->ci->load->model('wohnungen_model');
        }

        $this->tag = $tag;
        $this->wohnungen = $aq;
        $pdf_title = $aq->strabe . ' - ' . $aq->hausnummer . ' - ' . $aq->etage . ' - ' . $aq->flugel;
        $this->SetTitle($pdf_title);
    }


    public function prepare()
    {
        //  $this->with_number_to_word($this->wohnungen->clientid);

        $this->set_view_vars([
            'wohnungen_number' => $this->wohnungen->id,
            'wohnungen' => $this->wohnungen,
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'wohnungen';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/my_wohnungenpdf.php';
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/wohnungen_pdf.php';

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

        return $actualPath;
    }
}
