<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Belegungsplan extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('wohnungen_model');
        $this->load->model('mieter_model');
        $this->load->model('belegungsplan_model');
        if (!is_client_logged_in()) {
            redirect(base_url());
        }

    }


    /* List all contracts */
    public function index()
    {/*
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/

        $data['title'] = get_menu_option('belegungsplan', _l('Belegungsplan'));
        $data['occupations'] = $this->belegungsplan_model->get_my_occupations();
        $data['strabe'] = $this->wohnungen_model->get_grouped('strabe');
        $data['flugel'] = $this->wohnungen_model->get_grouped('flugel');
        $data['schlaplatze'] = $this->wohnungen_model->get_grouped('schlaplatze');
        $data['mobiliert'] = $this->wohnungen_model->get_grouped('mobiliert');
        $data['etage'] = $this->wohnungen_model->get_grouped('etage');
        add_calendar_book_assets('customers-area-default', false);
        $this->data($data);
        $this->view('belegungsplan/belegungsplan');
        $this->layout();
    }


    public function table($clientid = '')
    {
        $this->app->get_table_data('belegungsplan', []);
    }


    public function load_free_aq($start = null, $end = null)
    {
        $aqs = $this->wohnungen_model->get_wohnungens();
        $belegungsplan = $this->belegungsplan_model->get_occupations();
        foreach ($aqs as $k => $aq) {
            foreach ($belegungsplan as $b) {
                if ($b['wohnungen'] === $aq['id']) {
                    $bv = date("Y-m-d", strtotime($b['belegt_v']));
                    $bb = date("Y-m-d", strtotime($b['belegt_b']));
                    $vbv = date("Y-m-d", strtotime($start));
                    $vbb = date("Y-m-d", strtotime($end));
                    if ($vbv > $bb || $vbb < $bv) {
                    } else {
                        unset($aqs[$k]);
                    }
                }
            }
        }

        $options = '<option value=""></option>';
        foreach ($aqs as $d) {
            $options .= '<option value="' . $d['id'] . '">' . $d['strabe'] . ' ' . $d['hausnummer'] . ' ' . $d['etage'] . ' ' . $d['flugel'] . ' </option>';
        }
        echo json_encode($options);
        die();
    }

    public function assign($id = '')
    {
        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->belegungsplan_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Belegungsplan'));
                    redirect(base_url('belegungsplan'));
                }
            } else {

                $success = $this->belegungsplan_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Belegungsplan'));
                }
                redirect(base_url('belegungsplan'));
            }
        }
    }


    /* Change client status / active / inactive */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->belegungsplan_model->change_status($id, $status);
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
        $response = $this->belegungsplan_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Wohnungen'));
        } else {
            set_alert('warning', _l('problem_deleting', 'wohnungen'));
        }
        redirect(admin_url('belegungsplan'));

    }


}
