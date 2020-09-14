<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    'ID',
    'Name',
    'Projekt',
    'Straße ',
    'Nr.',
    'PLZ',
    'Stadt',
    'Beräumung',
    'Arbeitsschein',
    'Baubeginn',
    'Rückräumung',
    'Arbeitsschein',
    'Bauende',
    'Aktiviert'
);
render_datatable($table_data, (isset($class) ? $class : 'rb'), [], [
    'data-last-order-identifier' => 'rb',
    'data-default-order' => get_table_last_order('rb'),
]);

