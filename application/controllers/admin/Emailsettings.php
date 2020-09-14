<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Emailsettings extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }


    /* List all contracts */
    public function index()
    {
        close_setup_menu();

        $data['title'] = get_menu_option('emailsettings', 'Email Settings');
        $this->load->view('admin/emailsettings/emailsettings', $data);
    }


    public function table()
    {
        $this->app->get_table_data('emailoptions', []);
    }


}
