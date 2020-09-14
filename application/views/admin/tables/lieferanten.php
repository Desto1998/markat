<?php

defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('lieferanten_model');
$aColumns = [
    '1',
    db_prefix() . 'lieferanten.id as id',
    'company',
    'hausnummer',
    'strabe',
    'zip',
    'email',
    'phonenumber',
    'state',
    'country',
    db_prefix() . 'lieferanten.active',
];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'lieferanten';
$where = [];
$join = [];
$filter = [];

//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'lieferanten.mieter = ' . db_prefix() . 'mieters.id';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'lieferanten.id']);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = '<div class="multiple_action checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    $row[] = $aRow['id'];

    $subjectOutput = '<a href="' . admin_url('lieferanten/lieferanten/' . $aRow['id']) . '">' . $aRow['company'] . '</a>';
    /* if ($aRow['trash'] == 1) {
         $subjectOutput .= '<span class="label label-danger pull-right">' . _l('lieferanten_trash') . '</span>';
     }*/

    $subjectOutput .= '<div class="row-options">';

    // $subjectOutput .= '<a href="' . site_url('lieferanten/' . $aRow['id'] . '/' . $aRow['hash']) . '" target="_blank">' . _l('view') . '</a>' |;

    $subjectOutput .= '  <a href="' . admin_url('lieferanten/lieferanten/' . $aRow['id']) . '">' . _l('edit') . '</a>';

    /*    if (has_permission('lieferanten', '', 'delete')) {*/
    $subjectOutput .= ' | <a href="' . admin_url('lieferanten/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    /* }*/

    $subjectOutput .= '</div>';
    $row[] = $subjectOutput;

    //$row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['company'] . '</a>';

    //  $mieter = '<a href="' . admin_url('mieter/mieter/' . $aRow['mieter_id']) . '">' . $aRow['mieter'] . '</a>';

    $row[] = $aRow['email'];
    $row[] = $aRow['hausnummer'];
    $row[] = $aRow['phonenumber'];

    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" data-switch-url="' . admin_url() . 'lieferanten/change_lieferanten_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow[db_prefix() . 'lieferanten.active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $row[] = $toggleActive;

    //$row[] = $result = data_tables_init($aColumns, $sIndexColumn, 'mieters', array(), $where, [db_prefix() . 'lieferanten.id']);


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

    $row = hooks()->apply_filters('lieferanten_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
