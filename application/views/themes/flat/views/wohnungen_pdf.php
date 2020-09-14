<?php

defined('BASEPATH') or exit('No direct script access allowed');

$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column = '';

// Add logo
$info_left_column .= pdf_logo_url();

// Write top left logo and right column info/text
pdf_multi_row($info_left_column, $info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$pdf->ln(10);

$organization_info = '<div style="color:#424242;">';

$organization_info .= format_organization_info();

$organization_info .= '</div>';


pdf_multi_row($organization_info, '', $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);
$austattung = isset($wohnungen) && $wohnungen->austattung ? $wohnungen->austattung : '';

$austattung = $wohnungen->inventer;
$wohnungenOj = new Wohnungen_model();

$tblhtml = '<br><br><h3 style="text-align: center">Detail ' . get_menu_option('wohnungen', _l('Aq')) . '</h3><br><table border="1" style="width: 100%; margin-top: 20px"> 
<tr><th><strong>Projekt</strong></th> <th><strong>Ort</strong></th> <th><strong>Plz</strong></th> </tr>  
<tr><td>' . $wohnungen->project . '</td> <td>' . $wohnungen->ort . '</td> <td>' . $wohnungen->plz . '</td> </tr> 
<tr><th><strong>Straße</strong></th> <th><strong>Hausnummer</strong></th> <th><strong>Etage</strong></th> </tr>  
<tr><td>' . $wohnungen->strabe . '</td> <td>' . $wohnungen->hausnummer . '</td> <td>' . $wohnungen->etage . '</td> </tr> 
<tr><th><strong>Flügel</strong></th> <th><strong>Zimmer</strong></th> <th><strong>Schlafplätze</strong></th> </tr>  
<tr><td>' . $wohnungen->flugel . '</td> <td>' . $wohnungen->zimmer . '</td> <td>' . $wohnungen->zimmer . '</td> </tr>  
<tr><th><strong>Möbliert</strong></th> <th><strong>Tierhaltung</strong></th> <th><strong>Balkon</strong></th> </tr>  
<tr><td>' . boolVald($wohnungen->mobiliert) . '</td> <td>' . boolVald($wohnungen->tierhaltung) . '</td> <td>' . boolVald($wohnungen->balkon) . '</td> </tr>  </table>';
$tblhtml.='<h3>' . get_menu_option('inventarlistes', _l('Inventar')) . '</h3> 
<table border="1" style="width: 100%;">
<tr><th>N°</th><th>Qty</th><th>' . get_menu_option('inventarlistes', _l('Inventar')) . '</th><th>Einheit</th><th>Moved?</th></tr>
 ';
$i = 1;
foreach ($austattung as $k => $ac):

    if ($ac['is_deleted'] == 0) {
        $allData = get_move($wohnungen, $ac['inventar_id']);
        $sumArray = 0;
        if ($allData)
            foreach ($allData as $k => $subArray) {
                $sumArray += $subArray['qty'];
            }
        $moved = $sumArray > 0 ? "Ja" : "Nein";
        if ($sumArray < $ac['qty']) {
            $qty = (int)$ac['qty'] - $sumArray;
            $inventar = $wohnungenOj->get_inventar($ac['inventar_id']);
            $tblhtml .= '<tr><td>' . $i . '</td><td>' . $qty . '</td><td>' . $inventar->name . '</td><td>' . $inventar->qubik . '</td><td>' . $moved . '</td></tr>';

            $i++;
        }

    }
endforeach;
$tblhtml .= '
</table> <style>
table th,
table td {
  padding: 10px !important; 
}

</style>';
$pdf->writeHTML($tblhtml, true, false, false, false, '');

function boolVald($bool)
{
    return $bool == -1 ? 'Nein' : 'Ja';
}