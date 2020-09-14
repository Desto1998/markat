<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wohnungen extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('wohnungen_model');
        $this->load->model('belegungsplan_model');
    }


    /* List all contracts */
    public function index()
    {/*
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/

        close_setup_menu();
        add_calendar_book_assets();
        $data['title'] = get_menu_option('wohnungen', _l('AQ'));
        $data['aqs'] = $this->wohnungen_model->get();
        $data['hausnummer'] = $this->wohnungen_model->get_grouped('hausnummer');
        $data['project'] = $this->wohnungen_model->get_projekte();
        $data['strabe'] = $this->wohnungen_model->get_grouped('strabe');
        $data['wohnungsnummer'] = $this->wohnungen_model->get_grouped('wohnungsnumme');
        $data['flugel'] = $this->wohnungen_model->get_grouped('flugel');
        $data['schlaplatze'] = $this->wohnungen_model->get_grouped('schlaplatze');
        $data['mobiliert'] = $this->wohnungen_model->get_grouped('mobiliert');
        $data['etage'] = $this->wohnungen_model->get_grouped('etage');
        $this->load->view('admin/wohnungen/manage', $data);
    }


    public function table($clientid = '')
    {
        $this->app->get_table_data('wohnungen', []);
    }

    public function render_inventory($clientid = '')
    {
        $this->app->get_table_data('inventar_um', []);
    }


    /* Edit wohnungen or add new wohnungen */
    public function wohnungen($id = '')
    {
        $this->load->model('misc_model');

        $data = array();
        $data['mieters'] = $this->wohnungen_model->get_mieters();

        if ($this->input->post()) {

            if ($id == '') {
                $id = $this->wohnungen_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Wohnungen'));
                    redirect(admin_url('wohnungen'));
                }
            } else {
                $success = $this->wohnungen_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Wohnungen'));
                }
                redirect(admin_url('wohnungen'));
            }
        }

        if ($id == '') {
            $title = 'Wohnungen erstellen';
        } else {
            $data['wohnungen'] = $this->wohnungen_model->get($id, [], true);
            $title = 'Wohnungen ' . $data['wohnungen']->id;
        }
        $this->load->model('mieter_model');
        $data['title'] = $title;
        $data['bodyclass'] = 'wohnungen';
        $data['mieters'] = $this->mieter_model->get_mieters(['active' => 1]);
        $data['projects'] = $this->misc_model->get_project();
        $data['inventarlistes'] = $this->wohnungen_model->get_inventarliste();
        $this->load->view('admin/wohnungen/wohnungen', $data);
    }


    // inventarlistes
    /* Manage wohnungen inventarlistes */
    public function inventarlistes()
    {
        $data['inventarlistes'] = $this->wohnungen_model->get_inventarliste();
        $data['title'] = get_menu_option('inventarlistes', _l('Inventar'));
        $this->load->view('admin/wohnungen/manage_inventarliste', $data);
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


    public function table1($id)
    {
///            print_r($this->input->get());
        $filters = [];
        $demoSource = [];
        $aq = $this->wohnungen_model->get($id);
        if ($aq) {
            $tmpdata['name'] = $aq->strabe;
            $tmpdata['desc'] = $aq->hausnummer;
            $tmpdata['etage'] = $aq->etage;
            $tmpdata['fluge'] = $aq->flugel;
            $belegungsplan = $this->belegungsplan_model->get_occupations(array('wohnungen' => $aq->id));
            $tmpdata['values'] = [];
            if (!empty($belegungsplan)) {
                foreach ($belegungsplan as $b) {
                    $mieter = $this->mieter_model->get($b['mieter']);
                    $projektnv = (empty($mieter->projektname)) ? ' ' : ' (' . $mieter->projektname . ')';
                    $values['label'] = $b['mieter_name'] . $projektnv;
                    $values['id_mieter'] = (int)$b['mieter'];
                    $values['id'] = (int)$b['id'];
                    $values['from'] = time_to_sql_datedv(strtotime($b['belegt_v']));
                    $values['to'] = time_to_sql_datedv(strtotime($b['belegt_b']));
                    $dd = rand(1, 14);
                    $values['customClass'] = "aze" . $dd;
                    $tmpdata['values'][] = $values;

                    //breack day set on gantt
                    $b_mi = $b['break_days'];
                    $enddate = $b['belegt_b'];

                    $i = 0;
                    $progress_day = $enddate;
                    if ($b_mi > 0) {
                        $initdate = 0;
                        while ($i < $b_mi) {
                            $progress_day = date('Y-m-d', strtotime($progress_day . ' +1 day'));
                            $day_of_week_prog = date('w', strtotime($progress_day));

                            if ($day_of_week_prog == 0 || $day_of_week_prog == 6) {
                                continue;
                            } else {
                                if ($i == 0)
                                    $initdate = $progress_day;
                                $values['label'] = '';
                                $values['id_mieter'] = 0;
                                $values['id'] = 0;
                                $progress_dayl = date('Y-m-d', strtotime($progress_day . ' +1 day'));
                                $values['from'] = to_sql_datedv($progress_dayl);
                                $values['to'] = to_sql_datedv($progress_dayl);
                                $values['customClass'] = "ganttbreack";
                                $tmpdata['values'][] = $values;

                                $i++;
                            }

                        }

                    }

                }
                $demoSource[] = $tmpdata;
            }
        }

        echo json_encode($demoSource);
        die();
    }


    public function get_inventar_ajax($id)
    {
        $inventar = $this->wohnungen_model->getSingleInventer($id);
        if ($inventar) {
            echo json_encode($inventar);
        }
        die();
    }


    public function import_inventar()
    {
        $dbFields = $this->db->list_fields(db_prefix() . 'inventarliste');
        $this->load->library('import/import_inventar', [], 'import');
        $this->import->setDatabaseFields($dbFields);
        if ($this->input->post()
            && isset($_FILES['file_txt']['name']) && $_FILES['file_txt']['name'] != '') {
            $this->import->setSimulation($this->input->post('simulate'))
                ->setTemporaryFileLocation($_FILES['file_txt']['tmp_name'])
                ->setFilename($_FILES['file_txt']['name'])
                ->perform();


            $data['total_rows_post'] = $this->import->totalRows();

            if (!$this->import->isSimulation()) {
                set_alert('success', _l('import_total_imported', $this->import->totalImported()));

            }
        }

        $data['title'] = _l('import');
        $data['bodyclass'] = 'dynamic-create-groups';
        $this->load->view('admin/wohnungen/import', $data);
    }


    /* Delete wohnungen inventarliste */
    public function delete_inventarliste($id)
    {
        if (!$id) {
            redirect(admin_url('wohnungen/inventarlistes'));
        }
        $response = $this->wohnungen_model->delete_inventarliste($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('inventarliste')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('inventarliste')));
        }
        redirect(admin_url('wohnungen/inventarlistes'));
    }

    public function blk_delete_inventarlistes()
    {
        if (isset($_POST['data'])) {
            foreach ($_POST['data'] as $d) {
                $response = $this->delete_inventarliste->delete($d);
                if ($response == true) {
                    set_alert('success', _l('deleted', get_menu_option('inventarliste', 'inventarliste')));
                } else {
                    set_alert('warning', _l('problem_deleting', 'inventarliste'));
                }
            }
        } else {
            echo false;
        }
        redirect(admin_url('wohnungen/inventarlistes'));
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
        $response = $this->wohnungen_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Wohnungen'));
        } else {
            set_alert('warning', _l('Leider können Sie dieses Element nicht löschen, da es mit einem Belegungsplan verknüpft ist'));
        }
        redirect(admin_url('wohnungen'));

    }


    public function inventar_um_delete($id)
    {
        $response = $this->wohnungen_model->delete_um($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Wohnungen'));
        } else {
            set_alert('warning', _l('Leider können Sie dieses Element nicht löschen, da es mit einem Belegungsplan verknüpft ist'));
        }
        redirect(admin_url('wohnungen/move_inventory'));
    }


    public function move_inventory()
    {

        close_setup_menu();
        add_calendar_book_assets();
        $data['title'] = get_menu_option('move_inventory', _l('Inventar-Umzugsliste'));
        $data['aqs'] = $this->wohnungen_model->get();
        $this->load->view('admin/inventar-um/manage', $data);
    }

    public function move($id = '')
    {

        if (isset($_POST)) {
            if ($_POST['aq_from'] == $_POST['aq_to']) {
                set_alert('warning', _l('problem_deleting', 'Inventar-Umzugsliste'));
            } else {
                $success = $this->wohnungen_model->move($_POST);
                if ($success) {
                    set_alert('success', _l('moved', ''));
                } else {

                    redirect(admin_url('wohnungen/move_inventory'));
                }
            }
        }
        redirect(admin_url('wohnungen/move_inventory'));
    }

    public function list_invantories($id)
    {
        if (!$id)
            return;
        $aqs = $this->wohnungen_model->get_wohnungens();
        $aq = $this->wohnungen_model->get($id, true);
        if (count($aq->inventer > 0)) {
            $inventory = $aq->inventer;
            ob_start(); ?>
            <div class="col-md-12 bold">
                <div class="col-md-4">
                    Now available: <span id="availSelected">0</span>
                </div>
                <div class="col-md-5">
                    Selected to Move: <span id="moveledSelected">0</span>
                </div>
                <div class="col-md-3">
                    Rest: <span id="restItem">0</span>
                </div>
            </div>
            <br>
            <div class="form-check">
                <div class="col-md-12">
                    <input type="checkbox" name="selectall"
                           class="form-check-input checkinventar_all"
                           value=""
                           id="checkinventar_all">
                    <label class="form-check-label"
                           for="checkinventar">Select all</label>
                </div>
            </div>
            <?php
            foreach ($inventory as $k => $inv) {
                $inventoryy = $this->wohnungen_model->get_inventarliste($inv['inventar_id']);
                ?>
                <div class="form-check dieldkf col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="move[inventory][<?= $inventoryy->id ?>][]"
                                   class="form-check-input checkinventar"
                                   value="<?= $inv['id'] ?>"
                                   id="inventory-<?= $inv['id'] ?>">
                            <label class="form-check-label"
                                   for="inventory-<?= $inv['id'] ?>"><?= $inventoryy->name ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8" style="padding-right: 8px !important;">
                            <?php echo render_input('move[qty][' . $inventoryy->id . '][]', '', '', 'number', array('min' => 1, 'max' => $inv['qty']), [], '', 'qtyfiels'); ?>
                        </div>
                        <div class="col-md-4 relative" style="padding-left: 0 !important;">
                            <div class="max-value">
                                /<?= $inv['qty']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            $content = ob_get_clean();
            ob_end_clean();
        }
        $options = '<option></option>';
        foreach ($aqs as $q) {
            if ($q['id'] == $id)
                continue;
            $options .= '<option value="' . $q['id'] . '">' . $q['strabe'] . ' ' . $q['hausnummer'] . ' ' . $q['etage'] . ' ' . $q['flugel'] . '</option>';
        }
        $adata = array('items' => $content, 'aqs' => $options);
        echo json_encode($adata);
        die();
    }


    public function bulk_delete()
    {
        if (isset($_POST['data'])) {
            foreach ($_POST['data'] as $d) {
                $response = $this->wohnungen_model->delete($d);
                if ($response == true) {
                    set_alert('success', _l('deleted', get_menu_option('wohnungen', 'AQ')));
                } else {
                    set_alert('warning', _l('problem_deleting', 'AQ'));
                }
            }
        } else {
            echo false;
        }
    }


    /* Generates invoice PDF and senting to email of $send_to_email = true is passed */
    public function pdf($id)
    {
        if (!$id) {
            redirect(admin_url('wohnungen'));
        }

        $wohnungen = $this->wohnungen_model->get($id);
        try {
            $pdf = wohnungen_pdf($wohnungen);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            if (strpos($message, 'Unable to get the size of the image') !== false) {
                show_pdf_unable_to_get_image_size_error();
            }
            die;
        }

        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output(mb_strtoupper(slug_it('$invoice_number')) . '.pdf', $type);
    }


    /* Change client status / active / inactive */
    public function change_wohnungen_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->wohnungen_model->change_wohnungen_status($id, $status);
        }
    }

}
