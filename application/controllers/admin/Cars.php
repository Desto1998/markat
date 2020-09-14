<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cars extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['staff_model','cars_model']);

    }


    /* List all contracts */
    public function index()
    {/*
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/

        close_setup_menu();
        $data['title'] = get_menu_option('cars', _l('Fahrzeugliste'));
        $this->load->view('admin/cars/manage', $data);
    }

    public function table($clientid = '')
    {
        $this->app->get_table_data('cars', []);
    }


    /* Edit cars or add new cars */
    public function cars($id = '')
    {
        $data = array();
        $data['users'] = $this->staff_model->get();

        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->cars_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Fahrzeugliste'));
                    redirect(admin_url('cars'));
                }
            } else {
                $success = $this->cars_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Fahrzeugliste'));
                }
                redirect(admin_url('cars'));
            }
        }
        if ($id == '') {
            $title = 'Fahrzeugliste erstellen';
        } else {
            $data['cars'] = $this->cars_model->get($id, [], true);
            $data['cars']->attachments = $this->cars_model->get_attachments($id);

            $title = 'Fahrzeugliste ' . $data['cars']->id;
        }
        $data['title'] = $title;
        $data['bodyclass'] = 'cars';
        $this->load->view('admin/cars/cars', $data);
    }


    /* Delete contract from database */
    public function delete($id)
    {
        if (!has_permission('cars', '', 'delete')) {
            access_denied('cars');
        }
        if (!$id) {
            redirect(admin_url('cars'));
        }
        $response = $this->cars_model->delete([$id]);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Fahrzeugliste'));
        } else {
            // set_alert('warning', _l('Leider können Sie dieses Element nicht löschen, da es mit einem Belegungsplan verknüpft ist'));
        }
        redirect(admin_url('cars'));

    }


    public function bulk_delete()
    {
        if (!has_permission('cars', '', 'delete')) {
            access_denied('cars');
        }
        if (isset($_POST['data'])) {
            $response = $this->cars_model->delete($_POST['data']);
            if ($response == true) {
                set_alert('success', _l('deleted', get_menu_option('cars', 'Fahrzeugliste')));
            } else {
                set_alert('warning', _l('problem_deleting', 'Fahrzeugliste'));
            }
            echo admin_url('cars');
        } else {
            set_alert('warning', _l('problem_deleting', 'Fahrzeugliste'));
            echo false;
        }
    }


    /* Change client status / active / inactive */
    public function change_cars_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->cars_model->change_cars_status($id, $status);
        }
    }
    
    public function ajax_save()
    {
        $a_data = $_POST;

        if (!isset($a_data['id'])) {
            $id = $this->cars_model->add($a_data);
            if ($id) {
                set_alert('success', _l('added_successfully', get_menu_option('mieter', 'Mieter')));
            }
        } else {
            $id = $a_data['id'];
            $success = $this->cars_model->update($a_data, $id);
            if ($success) {
                set_alert('success', _l('updated_successfully', get_menu_option('mieter', 'Mieter')));
            }
        }
        
         
        // Count total files
        if($_FILES){
            $countfiles = count($_FILES['files']['name']);
            for ($i = 0; $i < $countfiles; $i++) {

                if (!empty($_FILES['files']['name'][$i])) {
                    // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                    // Set preference
                    if (!file_exists('uploads/cars/' . $id)) {
                        mkdir('uploads/cars/' . $id, 0777, true);
                    }
                    $config['upload_path'] = 'uploads/cars/' . $id;
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '500000'; // max_size in kb
                    $config['file_name'] = $_FILES['files']['name'][$i];

                    //Load upload library
                    $this->load->library('upload', $config);
                    // File upload
                    if ($this->upload->do_upload('file')) {
                        // Get data about the file
                        $uploadData = $this->upload->data();
                        $this->cars_model->add_attachment($id, $uploadData);
                    }
                }
            }
        }
        echo admin_url('cars');
    }


      public function delete_attach($id)
    {
        $this->cars_model->delete_attachment($id);
        echo 1;
    }


}
