<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stock_manager extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('stock_manager_model');
    }


    /* List all contracts */
    public function index()
    {/*
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/

        close_setup_menu();

        $data['title'] = 'Stock Manager';
        $this->load->view('admin/stock_manager/manage', $data);
    }


    public function table($clientid = '')
    {
        // echo 'hhhh';
        // exit;
        $this->app->get_table_data('stock_manager', []);
    }

    /* Edit lieferanten or add new lieferanten */
    public function stock_manager($id = '')
    {
        $data = array();

        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->stock_manager_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Stock'));
                    redirect(admin_url('stock_manager/'));
                }
            } else {
                $success = $this->stock_manager_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Stock'));
                }
                redirect(admin_url('stock_manager'));
            }
        }
        if ($id == '') {
            $title = 'Stock Manager';
        } else {
            $data['stock_manager'] = $this->stock_manager_model->get($id, [], true);
            $title = 'Stock ' . $data['stock_manager']->id;
        }

        $data['title'] = $title;
        $data['bodyclass'] = 'stock_manager';
        $this->load->view('admin/stock_manager/add_edit_stock', $data);
    }
 

}
