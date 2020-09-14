<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mieter extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
    }

        public function index()
    {
        if (!is_client_logged_in()) {
            redirect(base_url());
        }
        $this->load->model('Mieter_model');

        $mieters = $this->Mieter_model->get();

        $data['title'] =  get_menu_option('mieter', _l('Mieter'));
        $data['mieters'] = $mieters;
        $data['bodyclass'] = 'viewesmieters';

        $this->data($data);
        $this->view('mieter/mieter_list');
        no_index_customers_area();
        $this->layout();
    }

    /* Edit mieter or add new mieter */
    public function mieter($id = '')
    {
        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->mieter_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Mieter'));
                    redirect(base_url('mieter/mieter/' . $id));
                }
            } else {

                $success = $this->mieter_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Mieter'));
                }
                redirect(base_url('mieter/mieter/' . $id));
            }
        }
        if ($id == '') {
            $title =  get_menu_option('mieter', _l('Mieter')).' erstellen';
        } else {
            $data = array();
            $data['mieter'] = $this->mieter_model->get($id, [], true);
            $title = $data['mieter']->nachname . ' ' . $data['mieter']->vorname;
        }
        $this->load->model('wohnungen_model');

        $data['title'] = $title;

        $data['strabe'] = $this->wohnungen_model->get_grouped('strabe');
        $data['flugel'] = $this->wohnungen_model->get_grouped('flugel');
        $data['schlaplatze'] = $this->wohnungen_model->get_grouped('schlaplatze');
        $data['mobiliert'] = $this->wohnungen_model->get_grouped('mobiliert');
        $data['etage'] = $this->wohnungen_model->get_grouped('etage');

        $data['betreuers'] = $this->clients_model->get_contacts();
        $this->data($data);
        $this->view('mieter/mieter');
        no_index_customers_area();
        $this->layout();
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
        $response = $this->mieter_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Mieter'));
        } else {
            set_alert('warning', _l('problem_deleting', 'mieter'));
        }
        redirect(base_url('mieter'));

    }

}
