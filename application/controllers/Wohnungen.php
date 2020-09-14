<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wohnungen extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('wohnungen_model');
    }

    public function index()
    {
        if (!is_client_logged_in()) {
            redirect(base_url());
        }

        // $wohnungen = $this->Wohnungen_model->get_betreuer_by(get_contact_user_id());

        $data['title'] =  get_menu_option('wohnungen', _l('AQ'));
        $data['wohnungens'] = $this->wohnungen_model->get();
        $data['bodyclass'] = 'vieweswohnungens';

        $this->data($data);
        $this->view('wohnungen/wohnungen_list');
        no_index_customers_area();
        $this->layout();
    }


    /* Edit wohnungen or add new wohnungen */
    public function wohnungen($id = '')
    {
        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->wohnungen_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', get_menu_option('wohnungen', _l('AQ'))));
                    redirect(base_url('wohnungen'));
                }
            } else {

                $success = $this->wohnungen_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', get_menu_option('wohnungen', _l('AQ'))));
                }
                redirect(base_url('wohnungen'));
            }
        }
        if ($id == '') {
            $title = get_menu_option('wohnungen', _l('AQ')).' erstellen';
        } else {
            $data = array();
            $data['wohnungen'] = $this->wohnungen_model->get($id, [], true);
            $title = $data['wohnungen']->nachname . ' ' . $data['wohnungen']->vorname;
        }
        $this->load->model('wohnungen_model');

        $data['title'] = $title;
        $data['inventarlistes'] = $this->wohnungen_model->get_inventarliste();


        /*        $data['strabe'] = $this->wohnungen_model->get_grouped('strabe');
                $data['flugel'] = $this->wohnungen_model->get_grouped('flugel');
                $data['schlaplatze'] = $this->wohnungen_model->get_grouped('schlaplatze');
                $data['mobiliert'] = $this->wohnungen_model->get_grouped('mobiliert');
                $data['etage'] = $this->wohnungen_model->get_grouped('etage');*/

        /*   $data['betreuers'] = $this->clients_model->get_contacts();*/
        $this->data($data);
        $this->view('wohnungen/wohnungen');
        no_index_customers_area();
        $this->layout();
    }


    // inventarlistes
    /* Manage wohnungen inventarlistes */
    public function inventarlistes()
    {
        $data['inventarlistes'] = $this->wohnungen_model->get_inventarliste();
        $data['title'] = get_menu_option('inventarlistes', _l('Inventar'));
        $this->data($data);
        $this->view('wohnungen/manage_inventarliste');
        no_index_customers_area();
        $this->layout();
    }

    /* Add or update wohnungen inventarlistes */
    public function inventarliste()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if (!$this->input->post('id')) {
                $inline = isset($data['inline']);
                if (isset($data['inline'])) {
                    unset($data['inline']);
                }
                $id = $this->wohnungen_model->add_inventarliste($data);

                if (!$inline) {
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('inventarliste')));
                    }
                } else {
                    echo json_encode(['success' => $id ? true : false, 'id' => $id]);
                }
            } else {
                $id = $data['id'];
                unset($data['id']);
                $success = $this->wohnungen_model->update_inventarliste($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('inventarliste')));
                }
            }
        }
    }

    /* Delete wohnungen inventarliste */
    public function delete_inventarliste($id)
    {
        if (!$id) {
            redirect(base_url('wohnungen/inventarlistes'));
        }
        $response = $this->wohnungen_model->delete_inventarliste($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('inventarliste')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('inventarliste')));
        }
        redirect(base_url('wohnungen/inventarlistes'));
    }


}
