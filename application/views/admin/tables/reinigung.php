<?php

defined('BASEPATH') or exit('No direct script access allowed');
$this->ci->load->model('mieter_model');
$base_currency = get_base_currency();

$aColumns = [
    '1',
    db_prefix() . 'occupations.id as id',
    db_prefix() . 'wohnungen.strabe as strabe',
    db_prefix() . 'wohnungen.hausnummer as hausnummer',
    db_prefix() . 'wohnungen.etage as etage',
    db_prefix() . 'wohnungen.flugel as flugel',
    db_prefix() . 'wohnungen.zimmer as zimmer',
    db_prefix() . 'wohnungen.schlaplatze as schlaplatze',
    db_prefix() . 'wohnungen.mobiliert as mobiliert',
    db_prefix() . 'occupations.belegt_v as belegt_v',
    db_prefix() . 'occupations.belegt_b as belegt_b',
    db_prefix() . 'wohnungen.belegt as belegt',
    db_prefix() . 'occupations.mieter_name as mieter_name',
    db_prefix() . 'occupations.active as active',
    db_prefix() . 'wohnungen.id as wohnungen',
    db_prefix() . 'occupations.mieter as mieter_id',
    db_prefix() . 'occupations.reason as reason',
    db_prefix() . 'occupations.reinigung_dt as reinigung_dt',
];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'occupations';
$where = [];
$filter = [];
$join = [];


if ($this->ci->input->post('strabe')) {
    array_push($where, 'AND ' . db_prefix() . 'wohnungen.strabe ="' . $this->ci->db->escape_str($this->ci->input->post('strabe')) . ' " ');
}

if ($this->ci->input->post('hausnummer')) {
    array_push($where, 'AND ' . db_prefix() . 'wohnungen.hausnummer ="' . $this->ci->db->escape_str($this->ci->input->post('hausnummer')) . ' " ');
}
if ($this->ci->input->post('flugel')) {
    array_push($where, 'AND ' . db_prefix() . 'wohnungen.flugel ="' . $this->ci->db->escape_str($this->ci->input->post('flugel')) . ' " ');
}

if ($this->ci->input->post('etage')) {
    array_push($where, 'AND ' . db_prefix() . 'wohnungen.etage ="' . $this->ci->db->escape_str($this->ci->input->post('etage')) . ' " ');
}


if ($this->ci->input->post('schlaplatze')) {
    array_push($where, 'AND ' . db_prefix() . 'wohnungen.schlaplatze ="' . $this->ci->db->escape_str($this->ci->input->post('schlaplatze')) . ' " ');
}

if ($this->ci->input->post('mobiliert')) {
    array_push($where, 'AND ' . db_prefix() . 'wohnungen.mobiliert ="' . $this->ci->db->escape_str($this->ci->input->post('mobiliert')) . ' " ');
}

if (!empty($this->ci->input->post('belegt_b'))) {
    $belegt_be = $this->ci->input->post('belegt_b');
}
if (!empty($this->ci->input->post('belegt_v'))) {
    $belegt_ve = $this->ci->input->post('belegt_v');
}

$join[] = 'LEFT JOIN ' . db_prefix() . 'wohnungen ON ' . db_prefix() . 'wohnungen.id = ' . db_prefix() . 'occupations.wohnungen';
//$join[] = 'LEFT JOIN ' . db_prefix() . 'mieters ON ' . db_prefix() . 'mieters.id = ' . db_prefix() . 'occupations.mieter';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'occupations.id']);

$output = $result['output'];
$rResult = $result['rResult'];


foreach ($rResult as $a => $aRow) {
    $row = [];
    $row[] = '<div class="checkbox multiple_action"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    /*
      if ($this->ci->input->post('belegt')) {
            $val = $this->ci->db->escape_str($this->ci->input->post('belegt')) == 'Nein' ? 1 : 0;
            $date = date_create($aRow['belegt_v']);
            $belegt_v = date_format($date, 'd.m.Y');
            $date = date_create($aRow['belegt_b']);
            $belegt_b = date_format($date, 'd.m.Y');
            $noww = date('d.m.Y');
    if ($val==1){}
    if ($val==0){}
            if ($belegt_v < $noww && $noww > $belegt_v) {

            } else {

            }
        }*/
    /*    $bv = strtotime($aRow['belegt_v']);
        //  var_dump($bv , $bv_);
        if (time() < $bv)
            continue;*/

    if ($belegt_be) {
        $bb = strtotime($aRow['belegt_b']);
        $bb_ = strtotime($belegt_be);
        if ($bb > $bb_)
            continue;
    }

    $row[] = $a + 1;

    // $row[] = $aRow['wohnungen_id'];
    //  $row[] = $aRow['strabe'];


    $date = date_create($aRow['belegt_v']);
    $belegt_v = date_format($date, 'd.m.Y');
    $date = date_create($aRow['belegt_b']);
    $belegt_b = date_format($date, 'd.m.Y');
    $noww = date('d.m.Y');

    if ($belegt_v < $noww && $noww > $belegt_v) {

        $strabe = '<i class="green-dd proint"></i>';
    } else {
        $strabe = '<i class="red-dd proint"></i>';
    }

    // $row[] = $strabe;

    $subjectOutput = '<a href="' . admin_url('wohnungen/wohnungen/' . $aRow['wohnungen']) . '">' . $aRow['strabe'] . '</a>';

    $subjectOutput .= '<div class="row-options-calendar"><a href="#" data-toggle="modal" data-target="#calendarmx' . $aRow['id'] . '">';
    $subjectOutput .= '  <div class="selcet">Kalender</div></a>';

    $subjectOutput .= '</div>';
    $row[] = $subjectOutput;

    //$row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['company'] . '</a>';
    if ($aRow['mieter_id'] != 0) {
        $_mieter = $this->ci->mieter_model->get($aRow['mieter_id']);
        $mieter = '<a href="' . admin_url('mieter/mieter/' . $aRow['mieter_id']) . '">' . $aRow['mieter_name'] . '</a>';
    } else {
        $mieter = '<i>' . $aRow['reason'] . '</i>';
    }

    $row[] = $aRow['hausnummer'];
    $row[] = $aRow['etage'];
    $row[] = $aRow['flugel'];
    $row[] = $aRow['zimmer'];
    $row[] = $aRow['schlaplatze'];
    $row[] = $aRow['mobiliert'] == 1 ? 'Ja' : 'Nein';
//    $row[] = $belegt_v;
//    $row[] = $belegt_b;
    $datediff = strtotime($belegt_b) - strtotime($belegt_v);
    $restage = round($datediff / (60 * 60 * 24));

    // $row[] = $restage.'  Tage';
    $row[] = $mieter;

//    $reinigungstermin = '<div class="col-md-12">';
//
//    $reinigungstermin .= render_date_input('belegt_v', '', );
//    $reinigungstermin .= '</div>';
    $reinigung_dt = (!empty($aRow['reinigung_dt']) ? $aRow['reinigung_dt'] : '' );
    $reinigungstermin = "<input data-id='" . $aRow['id'] . "' type='date' id='reinigungstermin_". $aRow['id'] .
                "' onchange='javascript:reinigungDateChange(" . $aRow['id'] . ",this);' value='". $reinigung_dt . "' >";
//    $reinigungstermin .= '<div class="input-group-addon"><i class="fa fa-calendar calendar-icon"></i></div>';
    $row[] = $reinigungstermin;

    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" data-switch-url="' . admin_url() . 'belegungsplan/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $aRow['id'] . '" data-id="' . $aRow['id'] . '" ' . ($aRow['active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $aRow['id'] . '"></label>
    </div> <a href="#" class="belegungsplan" data-id="' . $aRow['id'] . '">Bearbeiten</a>  <a href="' . admin_url('belegungsplan/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';

    $row[] = $toggleActive;
    //$row[] = $result = data_tables_init($aColumns, $sIndexColumn, 'mieters', array(), $where, [db_prefix() . 'wohnungen.id']);


    /*    // Custom fields add values
        foreach ($customFieldsColumns as $customFieldColumn) {
            $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
        }*/

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

    $row = hooks()->apply_filters('wohnungen_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
