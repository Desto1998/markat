<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Firma extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('firma_model');
    }


    /* List all contracts */
    public function index()
    {
        if ($this->input->post()) {
            $logo_uploaded     = (handle_company_logo_upload() ? true : false);
            update_option('f_company', $_POST['company']);
            update_option('f_vorname', $_POST['vorname']);
            update_option('f_nachname', $_POST['nachname']);
            update_option('f_strabe', $_POST['strabe']);
            update_option('f_hausnummer', $_POST['hausnummer']);
            update_option('f_zip', $_POST['zip']);
            update_option('f_city', $_POST['city']);
            update_option('f_email', $_POST['email']);
            update_option('f_phonenumber_1', $_POST['phonenumber_1']);
            update_option('f_mobil', $_POST['mobil']);
            update_option('f_website', $_POST['website']);
            update_option('f_firm_id', $_POST['firm_id']);
            set_alert('success', _l('updated_successfully', 'Lieferanten'));
            redirect(admin_url('firma'));
        }
        
        close_setup_menu();
        $data['title'] = 'MEINE FIRMA';
        $this->load->view('admin/firma/firma', $data);
    }


    public function table($clientid = '')
    {
        $this->app->get_table_data('firma', []);
    }


    /* Edit firma or add new firma */
    public function firma($id = '')
    {
        $data = array();
        $data['mieters'] = $this->firma_model->get_mieters();

        if ($this->input->post()) {
            update_option('f_company', $_POST['company']);
            update_option('f_vorname', $_POST['vorname']);
            update_option('f_nachname', $_POST['nachname']);
            $logo_uploaded     = (handle_company_logo_upload() ? true : false);
            update_option('f_strabe', $_POST['strabe']);
            update_option('f_hausnummer', $_POST['hausnummer']);
            update_option('f_zip', $_POST['zip']);
            update_option('f_city', $_POST['city']);
            update_option('f_email', $_POST['email']);
            update_option('f_phonenumber_1', $_POST['phonenumber_1']);
            update_option('f_mobil', $_POST['mobil']);
            update_option('f_website', $_POST['website']);
            update_option('f_firm_id', $_POST['firm_id']);
            set_alert('success', _l('updated_successfully', 'Lieferanten'));
            redirect(admin_url('firma'));
        }
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
        $response = $this->firma_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Lieferanten'));
        } else {
            set_alert('warning', _l('problem_deleting', 'firma'));
        }
        redirect(admin_url('firma'));

    }


    /* Change client status / active / inactive */
    public function change_firma_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->firma_model->change_firma_status($id, $status);
        }
    }

}
