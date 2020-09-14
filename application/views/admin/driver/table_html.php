<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="driver"><label></label></div>',
    'ID',
    'name',
    'contact',
    //'Nr',
    //'Etage',
    //'Flügel',
    //'Zimmer',
   // 'Schlafplätze',
    //'Möbliert' ,
    'email'
);
$table_data = hooks()->apply_filters('driver_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'driver'), [], [
    'data-last-order-identifier' => 'driver',
    'data-default-order' => get_table_last_order('driver'),
]);

