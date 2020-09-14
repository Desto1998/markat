<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/php_image_magician.php');

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
if ($task_tag == 'full') {
    $tblhtml = '<br><br><h2 style="text-align: center">Dokumentation</h2><br>';
} else {
    $tblhtml = '<br><br><h2 style="text-align: center">Detail ' . get_menu_option('tasks', _l('Tasks')) . '</h2><br>';
}
$tblhtml .= '<table cellspacing="2px">
 <tr>
 <th style="width: 50%"><strong>Mieter :</strong> ' . $task->mieter . '</th>
 <th style="text-align: right"><strong>Datum:</strong>  ' . date("d.m.Y") . '</th>
</tr>
 </table>';
$tblhtml .= '<table cellspacing="2px"> 
<tr><th colspan="3"><strong>Betreff</strong></th> </tr>  
<tr><td colspan="3">' . $task->name . '</td></tr> 
<tr><th colspan="3"><strong>Description</strong></th> </tr>  
<tr><th colspan="3">' . $task->description . '</th> </tr>  
<tr><th><strong>Startdatum</strong></th> <th></th> <th><strong>Enddatum </strong></th> </tr>  
<tr><td>' . date('d.m.Y', strtotime($task->startdate)) . '</td> <td></td><td>' . date('d.m.Y', strtotime($task->duedate)) . '</td> </tr>';
if ($task_tag !== 'full') {
    $tblhtml .= '<tr><td colspan="3"><strong>Checklistpoints</strong></td></tr>';
    foreach ($task->checklist_items as $k => $ac):
        $check = $ac['finished'] ? 'check-cp.png' : 'no-check-cp.png';
        $tblhtml .= '<tr><td colspan="3"><br><span><img width="21px" src="assets/images/' . $check . '"/> </span> ' . $ac['description'] . '</td></tr>';
    endforeach;
} else {
    $tblhtml .= '<tr><th colspan="3"><br><strong>Dokumentation before:</strong></th></tr>';
    $maxcols = 3;
    $i = 0;
    foreach ($task->comments as $comment) {
        $comment['content'] = str_replace('[task_attachment]', '', $comment['content']);
        if ($comment['moment'] == 0 && !empty($comment['content'])) {
            $tblhtml .= '<tr><td colspan="3">' . $comment['content'] . '</td></tr>';
        }
    }
    $tblhtml .= '<tr>';
    foreach ($task->comments as $comment) {
        if ($comment['moment'] == 0 && count($comment['attachments']) > 0) {
            foreach ($comment['attachments'] as $attachment) {
                if ($i == $maxcols) {
                    $i = 0;
                    $tblhtml .= "</tr><tr>";
                }
                $relPath = get_upload_path_by_type('task') . $attachment['rel_id'] . '/';
                $fullPath = $relPath . $attachment['file_name'];
                $fname = pathinfo($fullPath, PATHINFO_FILENAME);
                $fext = pathinfo($fullPath, PATHINFO_EXTENSION);
                $thumbPath = $relPath . $fname . '_thumb.' . $fext;
                $tblhtml .= '<td style="padding: 20px; width: 33.33%"><img width="300" height="300" src="' . $thumbPath . '"/> </td>';
                $i++;
            }

        }
    }
    //Add empty <td>'s to even up the amount of cells in a row:
    while ($i <= $maxcols) {
        $tblhtml .= "<td>&nbsp;</td>";
        $i++;
    }
    $tblhtml .= '</tr></table>';


    $pdf->writeHTML($tblhtml, true, false, false, false, '');

    $pdf->AddPage();
    $tblhtml = '<table cellspacing="2px"> ';
    $tblhtml .= '<tr><th colspan="3"><strong>Dokumentation after:</strong></th></tr>';
    $i = 0;
    $maxcols = 3;
    foreach ($task->comments as $comment) {
        $comment['content'] = str_replace('[task_attachment]', '', $comment['content']);
        if ($comment['moment'] == 1 && !empty($comment['content'])) {
            $tblhtml .= '<tr><td colspan="3">' . $comment['content'] . '</td></tr>';
        }
    }
    $tblhtml .= '<tr>';
    foreach ($task->comments as $comment) {
        if ($comment['moment'] == 1 && count($comment['attachments']) > 0) {
            foreach ($comment['attachments'] as $attachment) {
                if ($i == $maxcols) {
                    $i = 0;
                    $tblhtml .= "</tr><tr>";
                }
                $relPath = get_upload_path_by_type('task') . $attachment['rel_id'] . '/';
                $fullPath = $relPath . $attachment['file_name'];
                $fname = pathinfo($fullPath, PATHINFO_FILENAME);
                $fext = pathinfo($fullPath, PATHINFO_EXTENSION);
                $thumbPath = $relPath . $fname . '_thumb.' . $fext;
                $tblhtml .= '<td style="padding: 20px; width: 33.33%"><img width="300" height="300" src="' . $thumbPath . '"/> </td>';
                $i++;
            }


        }
    } //Add empty <td>'s to even up the amount of cells in a row:
    while ($i <= $maxcols) {
        $tblhtml .= "<td>&nbsp;</td>";
        $i++;
    }
    $tblhtml .= '</tr>';
}
$staff = get_staff();

if (!empty($staff->signature)) {
    $data = base64_decode($staff->signature);
    $file = STAFF_PROFILE_IMAGES_FOLDER . uniqid() . '.png';
    $success = file_put_contents($file, $data);

    $tblhtml .= '<p style="text-align: right"><img src="' . $file . '"></p>';
}

$tblhtml .= '  
</table><style> 
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}
</style>';
$pdf->writeHTML($tblhtml, true, false, false, false, '');

function boolVald($bool)
{
    return $bool == -1 ? 'Nein' : 'Ja';
}