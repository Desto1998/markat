<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    // '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="stock_manager"><label></label></div>',
    'SKU',
    'ID',
    'Name',
    'Product type',
    'Parent Id',
    'Price',
    'Manage stock',
    'Stock status',
    'Backorders' ,
    'Stock'
);
$table_data = hooks()->apply_filters('stock_manager_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'stock_manager'), [], [
    'data-last-order-identifier' => 'stock_manager',
    'data-default-order' => get_table_last_order('stock_manager'),
]);

