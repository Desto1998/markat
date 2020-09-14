<?php defined('BASEPATH') or exit('No direct script access allowed');
function resize_image($file, $w, $h, $crop=false) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }

    //Get file extension
    $exploding = explode(".",$file);
    $ext = end($exploding);

    switch($ext){
        case "png":
            $src = imagecreatefrompng($file);
            break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($file);
            break;
        case "gif":
            $src = imagecreatefromgif($file);
            break;
        default:
            $src = imagecreatefromjpeg($file);
            break;
    }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//echo $dst;
    return $dst;
}

//echo resize_image1();
//exit;
$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column  = '';

if (get_option('show_status_on_pdf_ei') == 1) {
    $info_right_column .= '<br /><span style="color:rgb(' . credit_note_status_color_pdf($credit_note->status) . ');text-transform:uppercase;">' . format_credit_note_status($credit_note->status, '', false) . '</span>';
}
// Add logo
$info_left_column .= pdf_logo_url();
// Write top left logo and right column info/text
pdf_multi_row($info_left_column, $info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$pdf->ln(10);


$mieter_info = '';
//Bill to
if (!empty($mieter->fullname) || !empty($mieter->projektname)) {

    $mieter_info = '<div style="color:#424242;">';
    $mieter_info .= $mieter->fullname. ' | ' . $mieter->projektname;
    $mieter_info .= '</div>';
}
if (!empty($mieter->strabe_m) || !empty($mieter->hausnummer_m) || !empty($mieter->wohnungsnummer)) {

    $mieter_info .= '<div style="color:#424242;">';
    $mieter_info .= $mieter->strabe_m. ' | ' . $mieter->hausnummer_m .' | '.$mieter->wohnungsnummer;
    $mieter_info .= '</div>';
}
if (!empty($mieter->etage) || !empty($mieter->flugel)) {

    $mieter_info .= '<div style="color:#424242;">';
    $mieter_info .= $mieter->etage. ' | ' . $mieter->flugel;
    $mieter_info .= '</div>';
}
if (!empty($mieter->plz) || !empty($mieter->stadt)) {

    $mieter_info .= '<div style="color:#424242;">';
    $mieter_info .= $mieter->plz. '|' . $mieter->stadt;
    $mieter_info .= '</div>';
}
$mieter_info .= '</br>';
$pdf->ln(10);

// echo $mieter_info;
// exit;
//$left_info  = $swap == '1' ? $mieter_info : $mieter_info;

pdf_multi_row($left_info, $right_info, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$pdf->Ln(8);
$tbltotal = '';

$tbltotal .= '<table cellpadding="6" style="font-size:' . ($font_size + 4) . 'px">';
$i= 0;
if(!empty($attachments)){
    foreach ($attachments as $attachment) {
        $path = get_upload_path_by_type('mieter') . $attachment['rel_id'] . '/' . $attachment['file_name'];
        // echo $path;
        $resizedFilename = get_upload_path_by_type('mieter') .'resize/'.$attachment['file_name'];
        // echo resize_image($path,100,100);
        // F:\xampp\htdocs\markat\uploads/mieter/15/2._PutzStar_Category_Page_(1).png
        //exit;
        $imgData = resize_image($path, 200, 200, true);
        $quality = 0;

        imagepng($imgData,$resizedFilename,$quality);
        //echo $resizedFilename;
//exit;
        if($i%3 == 0){
            $tbltotal .= '<tr>';
        }
        $tbltotal .= '
        <td align="center" width="33%"><img src="' .$resizedFilename. '"></td>';
        //if(($i%3 == 2 || (count($attachments) == $i)) && ($i != 0)){
        if((($i%3 == 2) || (count($attachments) == ($i+1))) && ($i <> 0))
        {
            $tbltotal .= '</tr>';
        }


        $i++;



    }

}
$tbltotal .= '</table>';
$pdf->writeHTML($mieter_info, true, false, false, false, '');

$pdf->writeHTML($tbltotal, true, false, false, false, '');



if(!empty($attachments)){

    foreach ($attachments as $attachment) {
        $resizedFilename = get_upload_path_by_type('mieter') .'resize/'.$attachment['file_name'];
        if(is_file($resizedFilename)){
            unlink($resizedFilename);

        }
    }
}