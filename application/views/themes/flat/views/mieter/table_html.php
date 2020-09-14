<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    'ID',
    'Name',
    'Telefon ',
    'Straße ',
    'Nr. ',
    'Etage ',
    'Flügel ',
  //  'Umsetzwohnung',
    'Kundenbetreuer',
    'Aktiviert'
);

$table_data = hooks()->apply_filters('mieter_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'mieter'), [], [
    'data-last-order-identifier' => 'mieter',
    'data-default-order' => get_table_last_order('mieter'),
]);

