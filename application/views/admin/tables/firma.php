<?php

defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('firma_model');
$aColumns = [
    db_prefix() . 'firma.id as id',
    'company',
    'hausnummer',
    'strabe',
    'zip',
    'email',
    'phonenumber',
    'state',
    db_prefix() . 'firma.active',
];


$sIndexColumn = 'id';
$sTable = db_prefix() . 'firma';
$where = [];
$join = [];
$filter = [];

//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'firma.mieter = ' . db_prefix() . 'mieters.id';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'firma.id']);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];

    // $row[] = $aRow['firma_id'];
    //  $row[] = $aRow['strabe'];


    $subjectOutput = '<a href="' . admin_url('firma/firma/' . $aRow['id']) . '">' . $aRow['company'] . '</a>';
    /* if ($aRow['trash'] == 1) {
         $subjectOutput .= '<span class="label label-danger pull-right">' . _l('firma_trash') . '</span>';
     }*/

    $subjectOutput .= '<div class="row-options">';

    // $subjectOutput .= '<a href="' . site_url('firma/' . $aRow['id'] . '/' . $aRow['hash']) . '" target="_blank">' . _l('view') . '</a>' |;

    $subjectOutput .= '  <a href="' . admin_url('firma/firma/' . $aRow['id']) . '">' . _l('edit') . '</a>';

    /*    if (has_permission('firma', '', 'delete')) {*/
    $subjectOutput .= ' | <a href="' . admin_url('firma/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    /* }*/

    $subjectOutput .= '</div>';
    $row[] = $subjectOutput;

    //$row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['company'] . '</a>';

    //  $mieter = '<a href="' . admin_url('mieter/mieter/' . $aRow['mieter_id']) . '">' . $aRow['mieter'] . '</a>';

    $row[] = $aRow['email'];
    $row[] = $aRow['hausnummer'];
    $row[] = $aRow['phonenumber'];

    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" data-switch-url="' . admin_url() . 'firma/change_firma_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow[db_prefix() . 'firma.active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $row[] = $toggleActive;

    //$row[] = $result = data_tables_init($aColumns, $sIndexColumn, 'mieters', array(), $where, [db_prefix() . 'firma.id']);


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

    $row = hooks()->apply_filters('firma_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
