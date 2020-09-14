<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="lieferanten"><label></label></div>',
    'ID',
    'Belegt?',
    'Straße',
    'Nr',
    'Etage',
    'Flügel',
    'Zimmer',
    'Schlafplätze',
    'Möbliert' ,
    'Aktiv'
);
$table_data = hooks()->apply_filters('lieferanten_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'lieferanten'), [], [
    'data-last-order-identifier' => 'lieferanten',
    'data-default-order' => get_table_last_order('lieferanten'),
]);

