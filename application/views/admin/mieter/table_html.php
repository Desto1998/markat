<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="mieter"><label></label></div>',
    'ID',
    'Name',
    'Projekt ',
    'Straße ',
    'Nr. ',
    'Wohnungsnummer',
    'Etage ',
    'Flügel ',
    'PLZ ',
    'Stadt ',
    'Telefon ',
    'Kundenbetreuer',
    'Belegt?',
    'Aktiviert'
);

$table_data = hooks()->apply_filters('mieter_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'mieter'), [], [
    'data-last-order-identifier' => 'mieter',
    'data-default-order' => get_table_last_order('mieter'),
]);

