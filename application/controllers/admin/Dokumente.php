<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dokumente extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dokument_model');
    }

    /* List all contracts */
    public function index()
    {
        close_setup_menu();

        $data['title'] = get_menu_option('dokumente', 'Dokumente');
        $this->load->view('admin/dokumente/manage', $data);
    }

    public function table()
    {
        $this->app->get_table_data('dokument', []);
    }


    public function ajax_create_doc()
    {
        if (isset($_POST)) {
            $result = $this->dokument_model->add($_POST);
            if (!$result) {

            } else {
                set_alert('success', _l('added_successfully', 'Fahrzeugliste'));
            }
        }
    }

    /* Delete contract from database */
    public function delete($id)
    {
        if (!$id) {
            redirect(admin_url('dokumente'));
        }
        $response = $this->dokument_model->delete([$id]);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Dokumente'));
        } else {
            // set_alert('warning', _l('Leider können Sie dieses Element nicht löschen, da es mit einem Belegungsplan verknüpft ist'));
        }
        redirect(admin_url('dokumente'));

    }

    public function bulk_delete()
    {
        if (isset($_POST['data'])) {
            $response = $this->dokument_model->delete($_POST['data']);
            if ($response == true) {
                set_alert('success', _l('deleted', get_menu_option('dokumente', 'Dokumente')));
            } else {
                set_alert('warning', _l('problem_deleting', 'Dokumente'));
            }
            echo admin_url('dokumente');
        } else {
            set_alert('warning', _l('problem_deleting', 'Dokumente'));
            echo false;
        }
    }

    public function pdf($id)
    {
        if (!$id) {
            redirect(admin_url('dokumente'));
        }

        $wohnungen = $this->dokument_model->get($id);
        try {
            $pdf = template_pdf($wohnungen);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            if (strpos($message, 'Unable to get the size of the image') !== false) {
                show_pdf_unable_to_get_image_size_error();
            }
            die;
        }
    }

}
