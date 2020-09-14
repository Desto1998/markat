<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="visualisierung"><label></label></div>',
    'ID',
    'Straße',
    'Kalender',
    'Nr',
    'Etage',
    'Flügel',
    'Wohnungs-Nr.',
    'Belagt.',
    //'Zimmer',
  //  'Schlafplätze',
  //  'Möbliert' ,
//    'Inventar' ,
    'Projekt' ,
    'Aktiv'
);

$table_data = hooks()->apply_filters('visualisierung_table_columns', $table_data);
render_datatable($table_data, (isset($class) ? $class : 'visualisierung'), [], [
    'data-last-order-identifier' => 'wohnungen',
    'data-default-order' => get_table_last_order('wohnungen'),
]);

