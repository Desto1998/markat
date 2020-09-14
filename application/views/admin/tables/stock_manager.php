<?php

defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('stock_manager_model');
$aColumns = [
    // '1',
    // db_prefix() . 'stock_manager.id as id',
    'sku',
    'id',
    'name',
    'product_type',
    'parent_id',
    'price',
    'manage_stock',
    'stock_status',
    'backorders',
    'stock',
];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'stock_manager';
$where = [];
$join = [];
$filter = [];

//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'cars.mieter = ' . db_prefix() . 'mieters.id';

// echo 'ggg';
// exit;
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);
 // echo 'gjjjjgg';
 // exit;
$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    // $row[] = '<div class="checkbox multiple_action"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
   // $row[] = $aRow['id'];

    // $row[] = $aRow['cars_id'];
    //  $row[] = $aRow['strabe'];

    $subjectOutput = '<a href="' . admin_url('stock_manager/stock_manager/' . $aRow['id']) . '">' . $aRow['marke'] . '</a>';

    $subjectOutput .= '<div class="row-options">';

    // $subjectOutput .= '<a href="' . site_url('cars/' . $aRow['id'] . '/' . $aRow['hash']) . '" target="_blank">' . _l('view') . '</a>' |;

   // $subjectOutput .= '  <a href="' . admin_url('stock_manager/stock_manager/' . $aRow['id']) . '">' . _l('edit') . '</a>';

    /*    if (has_permission('cars', '', 'delete')) {*/
    //$subjectOutput .= ' | <a href="' . admin_url('stock_manager/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    /* }*/

    $subjectOutput .= '</div>';
    //$row[] = $subjectOutput;
    $row[] = $aRow['sku'];
    $row[] = $aRow['id'];
    $row[] = $aRow['name'];
    $row[] = $aRow['product_type'];
    $row[] = $aRow['parent_id'];
     $row[] = $aRow['price'];
    $row[] = $aRow['manage_stock'];
    $row[] = $aRow['stock_status'];
    $row[] = $aRow['backorders'];
    $row[] = $aRow['stock'];
    // $toggleActive = '<div class="onoffswitch" data-toggle="tooltip">
    // <input type="checkbox" data-switch-url="' . admin_url() . 'cars/change_cars_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow[db_prefix() . 'cars.active'] == 1 ? 'checked' : '') . '>
    // <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    // </div>';

    // $row[] = $toggleActive;
    //$row[] = $result = data_tables_init($aColumns, $sIndexColumn, 'mieters', array(), $where, [db_prefix() . 'cars.id']);


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

    $row = hooks()->apply_filters('stock_manager_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
