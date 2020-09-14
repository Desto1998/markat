<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="col-md-12 ">
    <div class="fc-toolbar fc-header-toolbar">
        <div class="fc-center"><h2>Mitarbeiter</h2></div>
    </div>

    <div class="fc-view-container" id='employee_list' >
        <?php

            foreach($staffs as $employee){
                echo "<div class=' fc-event-container fc-content fc-tile fc-toolbar buttonlike menu-text width:80%' id='emp_".$employee['staffid']."' data-set='".$employee['staffid']."' draggable='true' ondragstart='dragStart(event)' > 
                    <span> ".$employee['full_name']."</span>
                    <span class='closebox' onclick='closebox(event)'>x</span>
                    
                    </div>";
                //print_r($employes);
            }


        ?>
    </div>
</div>

<style>
.buttonlike{
    padding: 5px;
    color: #FFF;
    border: 0px solid #999;
    background-color: #2196f3;
    font-size:12px;
    margin: 6px 0px;
    cursor:move;
}
.buttondragged{
    padding: 5px;
    color: #fff;
    border: 0px solid #999;
    background-color: #2196f3;
    border-radius: 2px;
    margin: 6px 10px;
    font-size:12px;
    position: relative;
    z-index: 50;
}
.closebox {
    float: right;
    font-size: 16px;
    font-weight: 700;
    line-height: 1;
    color: #8e0202;
    text-shadow: 0 1px 0 #fff;
    opacity: .2;
    cursor: pointer;

}
.closebox:hover {
    float: right;
    font-size: 16px;
    font-weight: 700;
    line-height: 1;
    color: #8e0202;
    text-shadow: 0 1px 0 #fff;
    opacity: .7;
}

.fc-row .fc-bg, .fc-content-skeleton {
    z-index: auto !important;
}
</style>
