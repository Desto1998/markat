<?php

defined('BASEPATH') or exit('No direct script access allowed');

$table_data = [
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="tasks"><label></label></div>',
    _l('the_number_sign'),
    _l('tasks_dt_name'),
    _l('task_status'),
    _l('tasks_dt_datestart'),
    [
        'name'     => _l('task_duedate'),
        'th_attrs' => ['class' => 'duedate'],
    ],
    _l('Mieter'),
    _l('task_assigned'),
    _l('Aufgaben'),
    _l('Erledigt'),
    _l('Projekt'),
    _l('tasks_list_priority'),
];

$custom_fields = get_custom_fields('tasks', [
    'show_on_table' => 1,
]);

foreach ($custom_fields as $field) {
    array_push($table_data, $field['name']);
}

$table_data = hooks()->apply_filters('tasks_table_columns', $table_data);

render_datatable($table_data, 'tasks', [], [
    'data-last-order-identifier' => 'tasks',
    'data-default-order'         => get_table_last_order('tasks'),
]);
