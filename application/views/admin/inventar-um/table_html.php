<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
   // '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="wohnungen"><label></label></div>',
    'ID',
    'AQ-ID',
    'Straße',
    'Nr',
    'Etage',
    'Flügel',
    'AQ-ID',
    'Straße',
    'Nr',
    'Etage',
    'Flügel',
    'Inventar moved'
);

render_datatable($table_data, (isset($class) ? $class : 'inventar-um'), [], [
    'data-last-order-identifier' => 'inventar-um',
    'data-default-order' => get_table_last_order('inventar-um'),
]);

