<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    '1',
    db_prefix() . 'mieters.id as id',
    'fullname',
    db_prefix() . 'projects.name as project',
    'strabe_m',
    'hausnummer_m',
    'wohnungsnummer',
    'etage',
    'flugel',
    'plz',
    'stadt',
    'telefon_1',
    1,
    '(SELECT count(' . db_prefix() . 'occupations.mieter) FROM ' . db_prefix() . 'occupations WHERE ' . db_prefix() . 'occupations.mieter=' . db_prefix() . 'mieters.id) as occuped',
    db_prefix() . 'mieters.nummer as nummer',
    'fulger_p',
    'umsetzwohnung',
    'betreuer',
    'vorname',
    'nachname',
    db_prefix() . 'mieters.email as email',
    db_prefix() . 'mieters.active as active',
    db_prefix() . 'mieters.updated_at as updated_at',
    db_prefix() . 'occupations.belegt_b as startat'
];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'mieters';
$where = [];
$join = [];
$join[] = 'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'mieters.projektname';
$join[] = 'LEFT JOIN ' . db_prefix() . 'occupations ON ' . db_prefix() . 'occupations.mieter = ' . db_prefix() . 'mieters.id';

$filter = [];

if ($this->ci->input->post('strabe')) {
    array_push($where, 'AND strabe_m ="' . $this->ci->db->escape_str($this->ci->input->post('strabe')) . ' " ');
}

if ($this->ci->input->post('project')) {
    array_push($where, 'AND projektname ="' . $this->ci->db->escape_str($this->ci->input->post('project')) . ' " ');
} else if ($projektname) { // added to filter in Project View screen
    array_push($where, 'AND projektname ="' . $projektname . ' " ');
}


if ($this->ci->input->post('etage')) {
    array_push($where, 'AND etage ="' . $this->ci->db->escape_str($this->ci->input->post('etage')) . ' " ');
}
if ($this->ci->input->post('plz')) {
    array_push($where, 'AND plz ="' . $this->ci->db->escape_str($this->ci->input->post('plz')) . ' " ');
}
if ($this->ci->input->post('etage')) {
    array_push($where, 'AND etage ="' . $this->ci->db->escape_str($this->ci->input->post('etage')) . ' " ');
}

if ($this->ci->input->post('flugel')) {
    array_push($where, 'AND flugel ="' . $this->ci->db->escape_str($this->ci->input->post('flugel')) . ' " ');
}

if ($this->ci->input->post('hausnummer')) {
    array_push($where, 'AND hausnummer_m ="' . $this->ci->db->escape_str($this->ci->input->post('hausnummer')) . ' " ');
}

if ($this->ci->input->post('mobiliert')) {
    array_push($where, 'AND mobiliert ="' . $this->ci->db->escape_str($this->ci->input->post('mobiliert')) . ' " ');
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'mieters.id']);
$rResult = array();
$output = $result['output'];
$rResult1 = $result['rResult'];


/*foreach ($rResult1 as $rR) {
    if ($rR['projektname'] == 'BOR' && has_permission('mieter', '', 'view_bor')) {
        array_push($rResult, $rR);
    } elseif ($rR['projektname'] == 'FER' && has_permission('mieter', '', 'view_fer')) {
        array_push($rResult, $rR);
    } elseif ($rR['projektname'] == 'TOPS' && has_permission('mieter', '', 'view_tops')) {
        array_push($rResult, $rR);
    } elseif ($rR['projektname'] == '') {
        array_push($rResult, $rR);
    }
}*/

foreach ($rResult1 as $aRow) {
    $row = [];
    $row[] = '<div class="multiple_action checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    $row[] = $aRow['id'];
    $subjectOutput = '<a href="' . admin_url('mieter/mieter/' . $aRow['id']) . '">' . $aRow['fullname'] . '</a>';
    $subjectOutput .= '<div class="row-options">';
    $subjectOutput .= '  <a href="' . admin_url('mieter/mieter/' . $aRow['id']) . '">' . _l('edit') . '</a>';

    /*    if (has_permission('mieter', '', 'delete')) {*/
    $subjectOutput .= ' | <a href="' . admin_url('mieter/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    /* }*/

    $subjectOutput .= '</div>';
    $contact = $this->ci->clients_model->get_contact($aRow['betreuer']);
    //var_dump($contact);
    if ($contact)
        $betreur = $contact->firstname . ' ' . $contact->lastname . ' <br><a href="#" onclick="contact(' . $contact->userid . ',' . $contact->id . ');return false;">Profil</a>';
    else
        $betreur = '';

    $row[] = $subjectOutput;

    $row[] = $aRow['project'];
    //$row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['company'] . '</a>';


    //$row[] = $aRow['email'];
    $row[] = $aRow['strabe_m'];
    $row[] = $aRow['hausnummer_m'];
    $row[] = $aRow['wohnungsnummer'];
    //$row[] = $aRow['nummer'];

    $row[] = $aRow['etage'];
    $row[] = $aRow['flugel'];
    $row[] = $aRow['plz'];
    $row[] = $aRow['stadt'];
    $row[] = $aRow['telefon_1'];
    //  $row[] = $aRow['umsetzwohnung'];
    $row[] = $betreur;
//    $occupation = $this->ci->belegungsplan_model->get_occupations(['active' => 1, 'mieter' => $aRow['id']]);
    if ($aRow['occuped'] > 0) {
        $row[] = '<a href="' . admin_url('belegungsplan?startat=' . strtotime($aRow['startat']) . '000&navigator=') . $aRow['id'] . '" style="color: #24a8e0"><span class="fa fa-check fa-2x" style="color: #24a8e0"></span></a>';
    } else {
        $row[] = '<a href="' . admin_url('belegungsplan?ref_m=') . $aRow['id'] . '">Belegt?</a>';
    }
    // Toggle active/inactive customer
    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip"  >
    <input type="checkbox"  data-switch-url="' . admin_url() . 'mieter/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div>';

    $row[] = $toggleActive;
    $row[] = date('Y-m-d H:i:s', $aRow['updated_at']);

    if (!empty($aRow['dateend'])) {
        $_date_end = date('Y-m-d', strtotime($aRow['dateend']));
        if ($_date_end < date('Y-m-d')) {
            $row['DT_RowClass'] = 'alert-danger';
        }
    }

    if (isset($row['DT_RowClass'])) {
        $row['DT_RowClass'] .= ' has-row-options';
    } else {
        $row['DT_RowClass'] = 'has-row-options';
    }

    $row = hooks()->apply_filters('mieter_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
