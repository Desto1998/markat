<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reinigung extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('wohnungen_model');
        $this->load->model('mieter_model');
        $this->load->model('belegungsplan_model');
    }


    /* List all contracts */
    public function index()
    {
        close_setup_menu();
        $data['title'] = get_menu_option(c_menu(), 'Belegungsplan');
        $data['occupations'] = $this->belegungsplan_model->get_occupations();
        $data['strabe'] = $this->belegungsplan_model->get_grouped('strabe');
        $data['flugel'] = $this->belegungsplan_model->get_grouped('flugel');
        $data['schlaplatze'] = $this->belegungsplan_model->get_grouped('schlaplatze');
        $data['hausnummer'] = $this->belegungsplan_model->get_grouped('hausnummer');
        $data['mobiliert'] = $this->belegungsplan_model->get_grouped('mobiliert');
        $data['etage'] = $this->belegungsplan_model->get_grouped('etage');
        add_calendar_book_assets();
        $this->load->view('admin/belegungsplan/reinigung', $data);
    }


    public function table($clientid = '')
    {
        $this->app->get_table_data('reinigung', []);
    }

    public function get($id)
    {
        $response = $this->belegungsplan_model->get($id);
        echo json_encode($response);
        die();
    }


    /* Change client status / active / inactive */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->belegungsplan_model->change_status($id, $status);
        }
    }

    /* Change reinigung_dt */
    public function ajax_change_reinigung() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post("id", true);
            $reinigung_dt = $this->input->post("reinigung_dt", true);

            $this->belegungsplan_model->change_reinigung_date($id, $reinigung_dt);
            echo json_encode([
                'success' => true,
                'msg' => _l('Reinigungstermin Updated'),
            ]);
            die;
        }
    }
}
