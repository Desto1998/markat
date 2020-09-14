<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'projekte.id',
    'datum',
    db_prefix() . 'projekte.nummer as nummer',
    db_prefix() . 'clients.company as kunde',
    db_prefix() . 'mieters.vorname as vorname',
    db_prefix() . 'mieters.nachname as nachname',
    db_prefix() . 'wohnungen.strabe as strabe',
    db_prefix() . 'wohnungen.hausnummer as hausnummer',
    db_prefix() . 'wohnungen.etage as etage',
    db_prefix() . 'wohnungen.flugel as flugel',
    db_prefix() . 'staff.firstname as firstname',
    db_prefix() . 'staff.lastname as lastname',
    db_prefix() . 'cars.marke as marke',
    db_prefix() . 'cars.modell as modell',
    db_prefix() . 'projekte.active as active'
];


$sIndexColumn = 'id';
$sTable = db_prefix() . 'projekte';

$where = [];
$join = [];
$join[] = 'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = ' . db_prefix() . 'projekte.kunde';
$join[] = 'LEFT JOIN ' . db_prefix() . 'wohnungen ON ' . db_prefix() . 'wohnungen.id = ' . db_prefix() . 'projekte.aq';
$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'mieters.id = ' . db_prefix() . 'projekte.mieter';
$join[] = 'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'projekte.user';
$join[] = 'LEFT JOIN ' . db_prefix() . 'cars ON ' . db_prefix() . 'cars.id = ' . db_prefix() . 'projekte.cars';
$filter = [];

if ($this->ci->input->post('kunde')) {
    array_push($where, 'AND  '.db_prefix() . 'projekte.kunde ="' . $this->ci->db->escape_str($this->ci->input->post('kunde')) . ' " ');
}

if ($this->ci->input->post('mieter')) {
    array_push($where, 'AND  '.db_prefix() . 'projekte.mieter  ="' . $this->ci->db->escape_str($this->ci->input->post('mieter')) . ' " ');
}


if ($this->ci->input->post('aq')) {
    array_push($where, 'AND  '.db_prefix() . 'projekte.aq ="' . $this->ci->db->escape_str($this->ci->input->post('aq')) . ' " ');
}

if ($this->ci->input->post('user')) {
    array_push($where, 'AND '.db_prefix() . 'projekte.user ="' . $this->ci->db->escape_str($this->ci->input->post('user')) . ' " ');
}

if ($this->ci->input->post('cars')) {
    array_push($where, 'AND '.db_prefix() . 'projekte.cars ="' . $this->ci->db->escape_str($this->ci->input->post('cars')) . ' " ');
}


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'projekte.id']);

$output = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];

    $row[] = '<div class="checkbox multiple_action"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    $row[] = $aRow['id'];

    // $row[] = $aRow['projekte_id'];
    //  $row[] = $aRow['strabe'];


    $subjectOutput = '<a href="' . admin_url('projekte/projekte/' . $aRow['id']) . '">' . $aRow['datum'] . '</a>';
    /* if ($aRow['trash'] == 1) {
         $subjectOutput .= '<span class="label label-danger pull-right">' . _l('projekte_trash') . '</span>';
     }*/

    $subjectOutput .= '<div class="row-options">';

    // $subjectOutput .= '<a href="' . site_url('projekte/' . $aRow['id'] . '/' . $aRow['hash']) . '" target="_blank">' . _l('view') . '</a>' |;

    $subjectOutput .= '  <a href="' . admin_url('projekte/projekte/' . $aRow['id']) . '">' . _l('edit') . '</a>';

    /*    if (has_permission('projekte', '', 'delete')) {*/
    $subjectOutput .= ' | <a href="' . admin_url('projekte/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    /* }*/

    $row[] = $subjectOutput;

    //$row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['company'] . '</a>';


    $row[] = $aRow['nummer'];
    $row[] = $aRow['kunde'];
    $row[] = $aRow['vorname'] . ' ' . $aRow['nachname'];
    $row[] = $aRow['strabe'] . ' ' . $aRow['hausnummer'] . ' ' . $aRow['etage'] . ' ' . $aRow['flugel'];
    $row[] = $aRow['firstname'] . ' ' . $aRow['lastname'];
    $row[] = $aRow['marke'] . ' ' . $aRow['modell'];
    // Toggle active/inactive customer
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip"  >
    <input type="checkbox"  data-switch-url="' . admin_url() . 'projekte/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';
    $row[] = $toggleActive;
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

    $row = hooks()->apply_filters('projekte_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
