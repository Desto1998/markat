<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="cars"><label></label></div>',
    'ID',
    'Marke',
    'Modell',
    'Kennzeichen',
    'Baujahr',
    'Kilometer',
    'Mitarbeiter',
    'Aktiv'
);

$table_data = hooks()->apply_filters('cars_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'cars'), [], [
    'data-last-order-identifier' => 'cars',
    'data-default-order' => get_table_last_order('cars'),
]);

