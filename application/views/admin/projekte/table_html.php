<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="projekte"><label></label></div>',
    'ID',
    'Datum',
    'Projeknummer ',
    'Kunde',
    'Mieter',
    'AQ ',
    'Mitarbeiter',
    'Fahrzeugliste ', 
    'Aktiviert'
);

$table_data = hooks()->apply_filters('projekte_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'projekte'), [], [
    'data-last-order-identifier' => 'projekte',
    'data-default-order' => get_table_last_order('projekte'),
]);

