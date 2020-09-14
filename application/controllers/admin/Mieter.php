<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mieter extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mieter_model');
        $this->load->model('wohnungen_model');

    }


    /* List all contracts */
    public function index()
    {

        close_setup_menu();
        $data['plz'] = $this->mieter_model->get_grouped('plz');
        $data['stadt'] = $this->mieter_model->get_grouped('stadt');
        $data['strabe'] = $this->mieter_model->get_grouped('strabe_m');
        $data['flugel'] = $this->mieter_model->get_grouped('flugel');
        $data['hausnummer'] = $this->mieter_model->get_grouped('hausnummer_m');
        $data['wohnungsnummer'] = $this->mieter_model->get_grouped('wohnungsnummer');
        $data['etage'] = $this->mieter_model->get_grouped('etage');
        $data['project'] = $this->mieter_model->get_projekte();
        $data['title'] = get_menu_option('mieter', 'Mieter');
        $this->load->view('admin/mieter/manage', $data);
    }


    public function table($projektname = '')
    {
        $this->app->get_table_data('mieters', ['projektname' => $projektname]);
    }

    public function get_ajax($id)
    {
        $data = $this->mieter_model->get_ajax($id);
        echo json_encode($data);
        die();

    }


    public function clean()
    {
        $this->mieter_model->clean();
        redirect(admin_url('mieter'));
    }

    /* Edit mieter or add new mieter */
    public function mieter($id = '')
    {

        $this->load->model('misc_model');
        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->mieter_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', get_menu_option('mieter', 'Mieter')));
                    redirect(admin_url('mieter'));
                }
            } else {
                $success = $this->mieter_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', get_menu_option('mieter', 'Mieter')));
                }
                redirect(admin_url('mieter'));
            }
        }

        if ($id == '') {
            $title = get_menu_option('mieter', 'Mieter') . ' erstellen';
        } else {
            $data = array();
            $data['mieter'] = $this->mieter_model->get($id, [], true);
            $data['mieter']->attachments = $this->mieter_model->get_attachments($id);

            $title = $data['mieter']->nachname . ' ' . $data['mieter']->vorname;
        }
        $data['title'] = $title;
        $data['inventarlistes'] = $this->wohnungen_model->get_inventarliste();
        $data['strabe'] = $this->wohnungen_model->get_grouped('strabe');
        $data['flugel'] = $this->wohnungen_model->get_grouped('flugel');
        $data['schlaplatze'] = $this->wohnungen_model->get_grouped('schlaplatze');
        $data['mobiliert'] = $this->wohnungen_model->get_grouped('mobiliert');
        $data['etage'] = $this->wohnungen_model->get_grouped('etage');

        $data['projects'] = $this->misc_model->get_project();
        $data['betreuers'] = $this->clients_model->get_contacts();
        //$data['bodyclass'] = 'contract';
        $this->load->view('admin/mieter/mieter', $data);
    }

    public function delete_attach($id)
    {

        $this->mieter_model->delete_attachment($id);
        echo 1;
    }

    public function ajax_save()
    {
        $a_data = $_POST;

        if (!isset($a_data['id'])) {
            $id = $this->mieter_model->add($a_data);
            if ($id) {
                set_alert('success', _l('added_successfully', get_menu_option('mieter', 'Mieter')));
            }
        } else {
            $id = $a_data['id'];
            $success = $this->mieter_model->update($a_data, $id);
            if ($success) {
                set_alert('success', _l('updated_successfully', get_menu_option('mieter', 'Mieter')));
            }
        }
        // Count total files
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
                if (!file_exists('uploads/mieter/' . $id)) {
                    mkdir('uploads/mieter/' . $id, 0777, true);
                }
                $config['upload_path'] = 'uploads/mieter/' . $id;
                $config['allowed_types'] = '*';
                $config['max_size'] = '500000'; // max_size in kb
                $config['file_name'] = $_FILES['files']['name'][$i];

                //Load upload library
                $this->load->library('upload', $config);
                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $this->mieter_model->add_attachment($id, $uploadData);
                }
            }
        }
        echo admin_url('mieter');
    }

    public function import()
    {

        $dbFields = $this->db->list_fields(db_prefix() . 'mieters');

        $this->load->library('import/import_mieter', [], 'import');

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
        $this->load->view('admin/mieter/import', $data);
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
                    if ($this->mieter_model->is_duplicate(['fullname' => $insert['fullname'], 'vorname' => $insert['vorname'], 'nachname' => $insert['nachname']]))
                        continue;
                    $this->mieter_model->add($insert);
                    $imported++;
                }
            }
            if ($imported > 0) {
                set_alert('success', _l('import_total_imported', $imported));
            }
            redirect(admin_url('mieter'));
        }
    }

    /* Change client status / active / inactive */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->mieter_model->change_mieter_status($id, $status);
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
        $response = $this->mieter_model->delete([$id]);
        if ($response == true) {
            set_alert('success', _l('deleted', get_menu_option('mieter', 'Mieter')));
        } else {
            set_alert('warning', _l('problem_deleting', 'mieter'));
        }
        redirect(admin_url('mieter'));

    }


    public function bulk_delete()
    {
        if (isset($_POST['data'])) {
            $response = $this->mieter_model->delete($_POST['data']);
            if ($response == true) {
                set_alert('success', _l('deleted', get_menu_option('mieter', 'Mieter')));
            } else {
                set_alert('warning', _l('problem_deleting', 'mieter'));
            }
            echo admin_url('mieter');
        } else {
            echo false;
        }
    }
     function makePdf($id){
        $attachments = $this->mieter_model->get_attachments($id);
        $mieter = $this->mieter_model->get($id, [], true);
            // echo '<pre>'; print_r($mieter);
            // exit;
            try {
                $pdf = mieter_pdf($id,'',$attachments,$mieter);
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }

            $pdf_name = 'mieter-attachment';
            
            // echo 'jjj';
            // exit;
            $pdf->Output(mb_strtoupper(slug_it($pdf_name), 'UTF-8') . '.pdf', 'D');
            die();
        //}
    }
}
