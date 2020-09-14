<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Driver extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('driver_model');
    }


    /* List all contracts */
    public function index()
    {/*
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/

        close_setup_menu();

        $data['title'] = 'Driver';
        $this->load->view('admin/driver/manage', $data);
    }


    public function table($clientid = '')
    {
        $this->app->get_table_data('driver', []);
    }

    /* Edit driver or add new driver */
    public function driver($id = '')
    {
        $data = array();
       // $data['mieters'] = $this->driver_model->get_mieters();

        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->driver_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Driver'));
                    redirect(admin_url('driver/'));
                }
            } else {
                $success = $this->driver_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Driver'));
                }
                redirect(admin_url('Driver'));
            }
        }
        if ($id == '') {
            $title = 'Driver erstellen';
        } else {
            $data['driver'] = $this->driver_model->get($id, [], true);
            $title = 'Driver' . $data['driver']->id;
        }

        $data['title'] = $title;
        $data['bodyclass'] = 'driver';
        $this->load->view('admin/driver/driver', $data);
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
        $response = $this->driver_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Driver'));
        } else {
            set_alert('warning', _l('problem_deleting', 'driver'));
        }
        redirect(admin_url('driver'));

    }


    public function bulk_delete()
    {
        $total_deleted = 0;
        if (isset($_POST['data'])) {
            if (isset($_POST['data'])) {
                $ids = $_POST['data'];
                foreach ($ids as $id) {
                    if ($this->driver_model->delete($id)) {
                        $total_deleted++;
                    }
                }
            }
            if (count($total_deleted) > 0) {
                set_alert('success', _l('deleted', get_menu_option('driver', 'driver')));
            } else {
                set_alert('warning', _l('problem_deleting', 'driver'));
            }
            echo admin_url('driver');
        } else {
            set_alert('warning', _l('problem_deleting', 'driver'));
            echo false;
        }
    }


    /* Change client status / active / inactive */
    public function change_driver_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->driver_model->change_driver_status($id, $status);
        }
    }

}
