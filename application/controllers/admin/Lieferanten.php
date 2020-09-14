<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lieferanten extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lieferanten_model');
    }


    /* List all contracts */
    public function index()
    {/*
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/

        close_setup_menu();

        $data['title'] = 'Lieferanten';
        $this->load->view('admin/lieferanten/manage', $data);
    }


    public function table($clientid = '')
    {
        $this->app->get_table_data('lieferanten', []);
    }

    /* Edit lieferanten or add new lieferanten */
    public function lieferanten($id = '')
    {
        $data = array();
        $data['mieters'] = $this->lieferanten_model->get_mieters();

        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->lieferanten_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Lieferanten'));
                    redirect(admin_url('lieferanten/'));
                }
            } else {
                $success = $this->lieferanten_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Lieferanten'));
                }
                redirect(admin_url('lieferanten'));
            }
        }
        if ($id == '') {
            $title = 'Lieferanten erstellen';
        } else {
            $data['lieferanten'] = $this->lieferanten_model->get($id, [], true);
            $title = 'Lieferanten ' . $data['lieferanten']->id;
        }

        $data['title'] = $title;
        $data['bodyclass'] = 'lieferanten';
        $this->load->view('admin/lieferanten/lieferanten', $data);
    }
 

    /* Delete contract from database */
    public function delete($id)
    {
        /* if (!has_permission('contracts', '', 'delete')) {
             access_denied('contracts');
         }
         if (!$id) {
             redirect(admin_url('contracts'));
         }*/
        $response = $this->lieferanten_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Lieferanten'));
        } else {
            set_alert('warning', _l('problem_deleting', 'lieferanten'));
        }
        redirect(admin_url('lieferanten'));

    }


    public function bulk_delete()
    {
        $total_deleted = 0;
        if (isset($_POST['data'])) {
            if (isset($_POST['data'])) {
                $ids = $_POST['data'];
                foreach ($ids as $id) {
                    if ($this->lieferanten_model->delete($id)) {
                        $total_deleted++;
                    }
                }
            }
            if (count($total_deleted) > 0) {
                set_alert('success', _l('deleted', get_menu_option('lieferanten', 'lieferanten')));
            } else {
                set_alert('warning', _l('problem_deleting', 'lieferanten'));
            }
            echo admin_url('lieferanten');
        } else {
            set_alert('warning', _l('problem_deleting', 'lieferanten'));
            echo false;
        }
    }


    /* Change client status / active / inactive */
    public function change_lieferanten_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->lieferanten_model->change_lieferanten_status($id, $status);
        }
    }

}
