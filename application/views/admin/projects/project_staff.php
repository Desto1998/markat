<?php defined('BASEPATH') or exit('No direct script access allowed');
$table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="staff"><label></label></div>',
    'Vorname',
    'Nachname',
    'Rolle',
    'Email',
    'Telefonnummer',
    _l('staff_dt_last_Login'),
    _l('staff_dt_active'),
);

$custom_fields = get_custom_fields('staff', array('show_on_table' => 1));
foreach ($custom_fields as $field) {
    array_push($table_data, $field['name']);
}
render_datatable($table_data, 'staff');