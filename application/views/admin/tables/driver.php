<?php

defined('BASEPATH') or exit('No direct script access allowed');


$aColumns = [
    '1',
    db_prefix() . 'driver.id as id',
    'name',
    'contact',
    'email'

];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'driver';
$where = [];
$join = [];
$filter = [];

//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'driver.mieter = ' . db_prefix() . 'mieters.id';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'driver.id']);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = '<div class="multiple_action checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    $row[] = $aRow['id'];

    $subjectOutput = '<a href="' . admin_url('driver/driver/' . $aRow['id']) . '">' . $aRow['name'] . '</a>';
    /* if ($aRow['trash'] == 1) {
         $subjectOutput .= '<span class="label label-danger pull-right">' . _l('driver_trash') . '</span>';
     }*/

    $subjectOutput .= '<div class="row-options">';

    // $subjectOutput .= '<a href="' . site_url('driver/' . $aRow['id'] . '/' . $aRow['hash']) . '" target="_blank">' . _l('view') . '</a>' |;

    $subjectOutput .= '  <a href="' . admin_url('driver/driver/' . $aRow['id']) . '">' . _l('edit') . '</a>';

    /*    if (has_permission('driver', '', 'delete')) {*/
    $subjectOutput .= ' | <a href="' . admin_url('driver/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    /* }*/

    $subjectOutput .= '</div>';
    $row[] = $subjectOutput;

    //$row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['company'] . '</a>';

    //  $mieter = '<a href="' . admin_url('mieter/mieter/' . $aRow['mieter_id']) . '">' . $aRow['mieter'] . '</a>';

   // $row[] = $aRow['name'];
    $row[] = $aRow['contact'];
    $row[] = $aRow['email'];





    //$row[] = $result = data_tables_init($aColumns, $sIndexColumn, 'mieters', array(), $where, [db_prefix() . 'driver.id']);


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

    $row = hooks()->apply_filters('driver_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
