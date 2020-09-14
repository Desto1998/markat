<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    '1',
    'id',
    'client',
    'mieter',
    'strabe',
    'nr',
    'plz',
    'ort',
    'etage',
    'datum',
    'fo_arbeit',
    'demontage',
    'e_datum',
];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'dokumente';
$where = [];
$join = [];
$filter = [];


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

//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'dokumente.mieter = ' . db_prefix() . 'mieters.id';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'dokumente.id']);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = '<div class="checkbox multiple_action"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    $row[] = $aRow['id'];
    $subjectOutput = $aRow['client'];
    $subjectOutput .= '<div class="row-options">';
    $subjectOutput .= '<a href="' . admin_url('dokumente/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    $subjectOutput .= '</div>';
    $row[] = $subjectOutput;
    $row[] = $aRow['mieter'];
    $row[] = $aRow['strabe'];
    $row[] = $aRow['nr'];
    $row[] = $aRow['plz'];
    $row[] = $aRow['ort'];
    $row[] = $aRow['etage'];
    $row[] = _d($aRow['datum']);
    $row[] = $aRow['fo_arbeit'];
    $row[] = _d($aRow['demontage']);
    $row[] = _d($aRow['e_datum']);
    $row[] = '<a href="' . admin_url('dokumente/pdf/') . $aRow['id'] . '" class="btn btn-warning">See Pdf</a>';

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

    $row = hooks()->apply_filters('dokumente_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
