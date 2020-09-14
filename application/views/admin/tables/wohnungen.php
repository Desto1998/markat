<?php

defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('wohnungen_model');
$this->ci->load->model('belegungsplan_model');
$aColumns = [
    '1',
    db_prefix() . 'wohnungen.id as id', 1,1,
    'strabe',
    'hausnummer',
    'etage',
    'flugel',
    'wohnungsnumme',
    'zimmer',
    'schlaplatze',
    'mobiliert',
    '(SELECT count(' . db_prefix() . 'wohnungen_inventar.aq_id) FROM ' . db_prefix() . 'wohnungen_inventar WHERE ' . db_prefix() . 'wohnungen_inventar.aq_id=' . db_prefix() . 'wohnungen.id) as austattung',
    'project',
    db_prefix() . 'wohnungen.active',
];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'wohnungen';
$where = [];
$join = [];
$filter = [];

if ($this->ci->input->post('belegt')) {
    $val = $this->ci->db->escape_str($this->ci->input->post('belegt')) == 'Nein' ? 1 : 0;
    array_push($where, 'AND belegt =' . $val);
}


if ($this->ci->input->post('strabe')) {
    array_push($where, 'AND strabe ="' . $this->ci->db->escape_str($this->ci->input->post('strabe')) . ' " ');
}

if ($this->ci->input->post('project')) {
    array_push($where, 'AND project ="' . $this->ci->db->escape_str($this->ci->input->post('project')) . ' " ');
}

if ($this->ci->input->post('hausnummer')) {
    array_push($where, 'AND hausnummer ="' . $this->ci->db->escape_str($this->ci->input->post('hausnummer')) . ' " ');
}


if ($this->ci->input->post('etage')) {
    array_push($where, 'AND etage ="' . $this->ci->db->escape_str($this->ci->input->post('etage')) . ' " ');
}

if ($this->ci->input->post('flugel')) {
    array_push($where, 'AND flugel ="' . $this->ci->db->escape_str($this->ci->input->post('flugel')) . ' " ');
}

if ($this->ci->input->post('schlaplatze')) {
    array_push($where, 'AND schlaplatze ="' . $this->ci->db->escape_str($this->ci->input->post('schlaplatze')) . ' " ');
}

if ($this->ci->input->post('mobiliert')) {
    array_push($where, 'AND mobiliert ="' . $this->ci->db->escape_str($this->ci->input->post('mobiliert')) . ' " ');
}

if ($this->ci->input->post('wohnungsnumme')) {
    array_push($where, 'AND wohnungsnumme ="' . $this->ci->db->escape_str($this->ci->input->post('wohnungsnumme')) . ' " ');
}

//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'wohnungen.mieter = ' . db_prefix() . 'mieters.id';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'wohnungen.id']);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = '<div class="checkbox multiple_action"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    $row[] = $aRow['id'];
    // $row[] = $aRow['wohnungen_id'];
    //  $row[] = $aRow['strabe'];

    $strabe = '<i class="red-dd proint"></i>';

    if ($this->ci->wohnungen_model->is_occuped($aRow['id'])) {
        $strabe = '<i class="green-dd proint"></i>';
    }
    // $row[] = $strabe;


    $calendar = '<div class="row-options-calendar"><a href="#" data-toggle="modal" data-target="#calendarmx' . $aRow['id'] . '">';
    $calendar .= '  <div class="selcet">Kalender</div></a>';
    $row[] = $calendar;

    $occupation = $this->ci->belegungsplan_model->get_occupations(array('wohnungen' => $aRow['id']));
    $class = $occupation ? ' enabled' : ' disabled';
    $gantchart = '<div class="row-options-gantchart '.$class.'"><a href="#"  data-id="' . $aRow['id'] . '" data-target="#gantmgre51">';
    $gantchart .= '  <div class="selcet">Gant Chart</div></a>';
    $row[] = $gantchart;

    $options = '<a href="' . admin_url('wohnungen/wohnungen/' . $aRow['id']) . '">' . $aRow['strabe'] . '</a>';
    $options .= '<div class="row-options">';
    $options .= '  <a href="' . admin_url('wohnungen/wohnungen/' . $aRow['id']) . '">' . _l('edit') . '</a>';

    /*    if (has_permission('wohnungen', '', 'delete')) {*/
    $options .= ' | <a href="' . admin_url('wohnungen/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    $options .= ' | <a href="' . admin_url('wohnungen/pdf/' . $aRow['id']) . '/?output_type=I">PDF</a>';
    /* }*/
    $options .= '</div>';
    $row[] = $options;

    //$row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['company'] . '</a>';

    //  $mieter = '<a href="' . admin_url('mieter/mieter/' . $aRow['mieter_id']) . '">' . $aRow['mieter'] . '</a>';
    $row[] = $aRow['hausnummer'];
    $row[] = $aRow['etage'];
    $row[] = $aRow['flugel'];
    $row[] = $aRow['wohnungsnumme'];
    $row[] = $aRow['zimmer'];
    $row[] = $aRow['schlaplatze'];
    $row[] = $aRow['mobiliert'] == 1 ? 'Ja' : 'Nein';
    $row[] = $aRow['austattung'];
    $row[] = $aRow['project'];
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" data-switch-url="' . admin_url() . 'wohnungen/change_wohnungen_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow[db_prefix() . 'wohnungen.active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $row[] = $toggleActive;
    //$row[] = $result = data_tables_init($aColumns, $sIndexColumn, 'mieters', array(), $where, [db_prefix() . 'wohnungen.id']);


    /*    // Custom fields add values
        foreach ($customFieldsColumns as $customFieldColumn) {
            $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
        }*/

    if (!empty($aRow['dateend'])) {
        $_date_end = date('Y-m-d', strtotime($aRow['dateend']));
        if ($_date_end < date('Y-m-d')) {
            $row['DT_RowClass'] = 'alert-danger';
        }
    }

    if (isset($row['DT_RowClass'])) {
        $row['DT_RowClass'] .= ' has-row-options';
    } else {
        $row['DT_RowClass'] = 'has-row-options';
    }


    $output['aaData'][] = $row;
}
