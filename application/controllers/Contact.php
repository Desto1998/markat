<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends ClientsController
{
    public function index($id, $hash)
    {

        $data['hash']                          = $hash;
        $data['bodyclass']                     = 'viewescontact';

        $this->data($data);
        $this->view('estimatehtml');
        no_index_customers_area();
        $this->layout();
    }
}
