<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="belegungsplan"><label></label></div>',
    'ID',
 //   'Frei?',
    'Straße',
    'Nr',
    'Etage',
    'Flügel',
    'Zimmer',
    'Schlafplätze',
    'Möbliert' ,
    'Belegt von',
    'Mieter',
    'Projekt',
    'Aktiv'
);


render_datatable($table_data, (isset($class) ? $class : 'belegungsplan'), [], [
    'data-last-order-identifier' => 'belegungsplan',
    'data-default-order' => get_table_last_order('belegungsplan'),
]);

