<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rb extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mieter_model');
    }

    /* List all contracts */
    public function index()
    {
        close_setup_menu();

        $data['name'] = $this->mieter_model->get_grouped('fullname', true);
        $data['strabe'] = $this->mieter_model->get_grouped('strabe_m', true);
        $data['flugel'] = $this->mieter_model->get_grouped('flugel', true);
        $data['project'] = $this->mieter_model->get_grouped('projektname', true);
        $data['schlaplatze'] = $this->mieter_model->get_grouped('hausnummer_m', true);
        $data['etage'] = $this->mieter_model->get_grouped('etage', true);
        $data['plz'] = $this->mieter_model->get_grouped('plz', true);
        $data['stadt'] = $this->mieter_model->get_grouped('stadt', true);
        $data['title'] = get_menu_option('rb', 'Räumung/Beräumung');
        $mieters = $this->mieter_model->get();
        foreach ($mieters as $mieter) {
            $arrData = [];
            $arrData['beraumung'] = $mieter['beraumung'];
            $arrData['baubeginn'] = $mieter['baubeginn'];
            $arrData['ruckraumung'] = $mieter['ruckraumung'];
            $arrData['bauende'] = $mieter['bauende'];
            $arrData['k_ruckraumung'] = $mieter['k_ruckraumung'];
            $arrData['k_baubeginn'] = $mieter['k_baubeginn'];
            $arrData['fenstereinbau'] = $mieter['fenstereinbau'];

            //   $this->mieter_model->update($arrData, $mieter['id']);
        }

        $this->load->view('admin/rb/manage', $data);
    }


    public function table()
    {
        // var_dump($_POST);
        $this->app->get_table_data('rb', []);
    }

    public function get_ajax($id)
    {
        $data = $this->mieter_model->get_ajax($id);
        echo json_encode($data);
        die();

    }

    public function update_date($id = '', $column = '')
    {
        if ($this->input->post()) {
            $column_lab = $this->input->post('column');
            $column_value = $this->input->post('column_val');
            $mieter_id = $this->input->post('mieter_id');
            $data = [$column_lab => $column_value];
            $success = $this->mieter_model->update($data, $mieter_id);
            echo json_encode(1);
            die();
        } else {
            $data = $this->mieter_model->get('', ['id' => $id])[0];

            $label = '';
            if ($column == 'beraumung') {
                $label = 'Ber&auml;umung';
            } else if ($column == 'baubeginn') {
                $label = 'Baubeginn';
            } else if ($column == 'ruckraumung') {
                $label = 'R&uuml;ckr&auml;umung';
            } else if ($column == 'bauende') {
                $label = 'Bauende';
            }
            ob_start();
            ?>

            <div class="modal fade" id="update_date" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <?= $label ?>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open(admin_url('rb/update_date'), array('id' => 'change-date')); ?>
                            <input type="hidden" value="<?= $id ?>" name="mieter_id" id="mieter_id">
                            <input type="hidden" value="<?= $column ?>" name="column" id="column">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo render_date_input('column_val', $label, _d($data[$column]), array(), array(), '', 'render_date'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">
                                        <button type="submit" id="changedate"
                                                class="btn btn-info"><?php echo _l('submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            ob_end_clean();
            echo json_encode($content);
            die();

        }
    }


    public function clean()
    {
        $this->mieter_model->clean();
        redirect(admin_url('rb'));
    }

    /* Edit rb or add new rb */
    public function rb($id = '')
    {

        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->mieter_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', get_menu_option('rb', 'Räumung/Beräumung')));
                    redirect(admin_url('rb/rb/' . $id));
                }
            } else {
                $success = $this->mieter_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', get_menu_option('rb', 'Räumung/Beräumung')));
                }
                redirect(admin_url('rb'));
            }
        }

        if ($id == '') {
            $title = get_menu_option('rb', 'Räumung/Beräumung') . ' erstellen';
        } else {
            $data = array();
            $data['rb'] = $this->mieter_model->get($id, [], true);

            $title = $data['rb']->fullname;
        }
        $data['title'] = $title;
        $this->load->view('admin/rb/rb', $data);
    }

    public function delete_attach()
    {

        $data = $this->mieter_model->get_rbs(['id' => $_POST['id']])[0];
        $attachment = unserialize($data['attachment']);

        foreach ($attachment as $k => $att) {
            if ($att['file_name'] == $_POST['file_name']) {
                unset($attachment[$k]);
            }
        }
        $data['attachment'] = serialize($attachment);
        $this->mieter_model->update($data, $data['id']);
        echo 1;
    }


    public function import()
    {

        $dbFields = $this->db->list_fields(db_prefix() . 'rbs');

        $this->load->library('import/import_rb', [], 'import');

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
        $this->load->view('admin/rb/import', $data);
    }


    public function import_perform_data()
    {
        if (isset($_POST)) {
            $data = unserialize($_POST['data']);
            unset($_POST['data']);
            $imported = 0;

            foreach ($data as $rowNumber => $row) {
                $insert = [];
                foreach ($_POST as $i => $columFields) {
                    if ($rowNumber == $i) {
                        if ($row[$columFields])
                            $insert[$i] = $row[$columFields];
                        else
                            $insert[$i] = '';
                    }
                }
                if (count($insert) > 0) {
                    $this->mieter_model->add($insert);
                    $imported++;
                }
            }
            if ($imported > 0) {
                set_alert('success', _l('import_total_imported', $imported));
            }
            redirect(admin_url('rb'));
        }
    }

    /* Change client status / active / inactive */
    public function change_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->mieter_model->change_rb_status($id, $status);
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
        $response = $this->mieter_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', get_menu_option('rb', 'Räumung/Beräumung')));
        } else {
            set_alert('warning', _l('problem_deleting', 'rb'));
        }
        redirect(admin_url('rb'));

    }


}
