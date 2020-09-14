<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'inventory_um.id as id',
    'f.id as f_id',
    'f.strabe as f_strabe',
    'f.hausnummer as f_hausnummer',
    'f.etage as f_etage',
    'f.flugel as f_flugel',
    'item_counts',
    't.id as t_id',
    't.strabe as t_strabe',
    't.hausnummer as t_hausnummer',
    't.etage as t_etage',
    't.flugel as t_flugel',
    'items_rest',
    'items_move',
];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'inventory_um';
$where = [];
$join = [
    'JOIN ' . db_prefix() . 'wohnungen as f ON f.id =' . db_prefix() . 'inventory_um.aq_from ',
    'JOIN ' . db_prefix() . 'wohnungen as t ON t.id = ' . db_prefix() . 'inventory_um.aq_to '
];
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

//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'wohnungen.mieter = ' . db_prefix() . 'mieters.id';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'inventory_um.id']);


$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    //  $row[] = '<div class="checkbox multiple_action"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    // $row[] = $aRow['wohnungen_id'];
    //  $row[] = $aRow['strabe'];

    // $row[] = $strabe;

    $subjectOutput = $aRow['id'];

    $subjectOutput .= '<div class="row-options">';
    $subjectOutput .= '<a href="' . admin_url('wohnungen/inventar_um_delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    $subjectOutput .= '</div>';
    $row[] = $subjectOutput;
    $row[] = '<span class="text-danger">' . $aRow['f_id'] . '</span>';
    $row[] = '<a href="' . admin_url('wohnungen/wohnungen/' . $aRow['f_id']) . '"><span class="text-danger">' . $aRow['f_strabe'] . '</span></a>';

    $row[] = $aRow['f_hausnummer'];
    $row[] = $aRow['f_etage'];
    $row[] = $aRow['f_flugel'];
    $row[] = '<span class="text-success">' . $aRow['t_id'] . '</span>';
    $row[] = '<a href="' . admin_url('wohnungen/wohnungen/' . $aRow['t_id']) . '"><span class="text-success">' . $aRow['t_strabe'] . '</span></a>';
    $row[] = $aRow['t_hausnummer'];
    $row[] = $aRow['t_etage'];
    $row[] = $aRow['t_flugel'];
    $row[] = '<div class="text-center bold">' . $aRow['items_move'] . '</div>';

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

    $row = hooks()->apply_filters('wohnungen_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
