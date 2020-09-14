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
$projektname = ($project->id ? $project->id : -1);
render_datatable($table_data,'project_mieter',
    array(),
    array(
        'id'=>'table-project-mieter',
        'data-url'=>admin_url('mieter/table/'.$projektname),
        'data-last-order-identifier' => 'mieter',
        'data-default-order'         => get_table_last_order('mieter'),
    ));
