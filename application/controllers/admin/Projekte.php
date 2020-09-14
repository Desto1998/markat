<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Projekte extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('projekte_model');
        $this->load->model(['wohnungen_model', 'mieter_model', 'staff_model', 'cars_model', 'clients_model']);
    }


    /* List all contracts */
    public function index()
    {
        close_setup_menu();


        $data['mieters'] = $this->projekte_model->mieters();
        $data['cars'] = $this->projekte_model->cars();
        $data['kundes'] = $this->projekte_model->kundes();
        $data['aqs'] = $this->projekte_model->aqs();
        $data['mieter'] = $this->projekte_model->mieters();
        $data['staffs'] = $this->projekte_model->users();
        $data['title'] = get_menu_option('projekte', 'Projekte');
        $this->load->view('admin/projekte/manage', $data);
    }


    public function table()
    {
        $this->app->get_table_data('projekte', []);
    }

    public function get_ajax($id)
    {
        $data = $this->projekte_model->get_ajax($id);
        echo json_encode($data);
        die();

    }


    public function clean()
    {
        $this->projekte_model->clean();
        redirect(admin_url('projekte'));
    }

    /* Edit projekte or add new projekte */
    public function projekte($id = '')
    {

        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->projekte_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', get_menu_option('projekte', 'Projekte')));
                    redirect(admin_url('projekte'));
                }
            } else {
                $success = $this->projekte_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', get_menu_option('projekte', 'Projekte')));
                }
                redirect(admin_url('projekte'));
            }
        }

        if ($id == '') {
            $title = get_menu_option('projekte', 'projekte') . ' erstellen';
        } else {
            $data = array();
            $data['projekte'] = $this->projekte_model->get($id, [], true);
            $data['projekte']->attachments = $this->projekte_model->get_attachments($id);

            $title = $data['projekte']->nachname . ' ' . $data['projekte']->vorname;
        }
        $data['title'] = $title;

        $data['clients'] = $this->clients_model->get();
        $data['staffs'] = $this->staff_model->get();
        $data['aqs'] = $this->wohnungen_model->get();
        $data['mieters'] = $this->mieter_model->get();
        $data['cars'] = $this->cars_model->get();
        $this->load->view('admin/projekte/projekte', $data);

    }

    public function delete_attach($id)
    {

        $this->projekte_model->delete_attachment($id);
        echo 1;
    }


    public function import()
    {

        $dbFields = $this->db->list_fields(db_prefix() . 'projektes');

        $this->load->library('import/import_projekte', [], 'import');

        $this->import->setDatabaseFields($dbFields);

        if ($this->input->post()
            && isset($_FILES['file_excel']['name']) && $_FILES['file_excel']['name'] != '') {
            $data_a = $this->import->setSimulation($this->input->post('simulate'))
                ->setTemporaryFileLocation($_FILES['file_excel']['tmp_name'])
                ->setFilename($_FILES['file_excel']['name'])
                ->perform();


        }


        $data['title'] = _l('import');
        $data['data_a'] = $data_a;
        $data['bodyclass'] = 'dynamic-create-groups';
        $this->load->view('admin/projekte/import', $data);
    }


    public function import_perform_data()
    {
        if (isset($_POST)) {
            $data = unserialize($_POST['data']);
            unset($_POST['data']);
            $Posted = $_POST;
            $imported = 0;
            foreach ($data as $rowNumber => $row) {
                $insert = [];
                foreach ($Posted as $i => $columFields) {
                    if (isset($row[$columFields]) && !empty($row[$columFields]))
                        $insert[$i] = $row[$columFields];
                    else
                        $insert[$i] = '';
                }
                if (count($insert) > 0) {
                    if ($this->projekte_model->is_duplicate(['fullname' => $insert['fullname'], 'vorname' => $insert['vorname'], 'nachname' => $insert['nachname']]))
                        continue;
                    $this->projekte_model->add($insert);
                    $imported++;
                }
            }
            if ($imported > 0) {
                set_alert('success', _l('import_total_imported', $imported));
            }
            redirect(admin_url('projekte'));
        }
    }

    /* Change client status / active / inactive */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->projekte_model->change_projekte_status($id, $status);
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
        $response = $this->projekte_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', get_menu_option('projekte', 'projekte')));
        } else {
            set_alert('warning', _l('problem_deleting', 'projekte'));
        }
        redirect(admin_url('projekte'));

    }


    public function bulk_delete()
    {
        $total_deleted = 0;
        if (isset($_POST['data'])) {
            if (isset($_POST['data'])) {
                $ids = $_POST['data'];
                foreach ($ids as $id) {
                    if ($this->projekte_model->delete($id)) {
                        $total_deleted++;
                    }
                }
            }
            if (count($total_deleted) > 0) {
                set_alert('success', _l('deleted', get_menu_option('projekte', 'projekte')));
            } else {
                set_alert('warning', _l('problem_deleting', 'projekte'));
            }
            echo admin_url('projekte');
        } else {
            set_alert('warning', _l('problem_deleting', 'projekte'));
            echo false;
        }
    }


}
