<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('staff_model');
        $this->load->model('roles_model');
    }

    public function index()
    {
        $data['title'] = get_menu_option('staff', _l('als_staff'));
        $data['staffs'] = $this->staff_model->get($id = '', [], false);
        $data['bodyclass'] = 'viewesstaffs';

        $this->data($data);
        $this->view('staff_list');
        no_index_customers_area();
        $this->layout();
    }

    public function get_role($id)
    {
        return $this->roles_model->get($id);
    }

}
