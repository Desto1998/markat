<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style>
    .linksBox{
        border: 2px solid #ddd;
        float: left;
        margin: 1% 2%;
        padding: 2%;
        min-height: 60px;
        font-size: 12px;
        text-align:center;
    }
    .linksBox:nth-of-type(1n+1) {
        clear: both;
    }
    #visualTable .hideRow{
        display:none;
    }
    .oddData, .evenData{
        float:left;
        width:50%;
    }
    #visualTable tr th{
        width:23%;
    }
    #visualTable tr th:first-child{
        width: 5%;
    }
</style>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons"> <!--style="border-bottom: unset !important;"-->
                        <h3><span><?php echo get_menu_option(c_menu(), 'AQ') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <div style="display: flex">
                            <a href="<?php echo admin_url('wohnungen/wohnungen'); ?>"
                               class="btn btn-info pull-left display-block"><?php echo 'Erstellen'; ?></a>
                        </div>
                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'wohnungen'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('wohnungen', $title); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body ">
                        <div class="row" id="mieter-table">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="bold"><?php echo _l('filter_by'); ?></p>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('project', $project, array('project', 'project'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Projekt'), array()); ?>
                                    </div>
                                </div>
                                <div class="row"><!--
                                        <div class="col-md-2 leads-filter-column">
                                            <?php
                                    /*                                        $belegt = array(array('id' => '0', 'value' => 'Nein'), array('id' => '1', 'value' => 'Ja'));
                                                                            echo render_select('belegt', $belegt, array('value', 'value'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Belegt?'), array()); */ ?>
                                        </div>-->

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('strabe', $strabe, array('strabe', 'strabe'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Straße'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('hausnummer', $hausnummer, array('hausnummer', 'hausnummer'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Nr.'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('etage', $etage, array('etage', 'etage'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Etage'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('flugel', $flugel, array('flugel', 'flugel'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Flügel'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('schlaplatze', $schlaplatze, array('schlaplatze', 'schlaplatze'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Schlafplätze'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php
                                        $data = array(array('id' => -1, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                                        echo render_select('mobiliert', $data, array('id', 'value'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Möbliert'), array()); ?>
                                    </div>

                                    <div class="col-md-2 leads-filter-column">
                                        <?php
                                        $data = array(array('id' => -1, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                                        echo render_select('strabeCount', $data, array('id', 'value'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'strabeCount'), array()); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading"/>
                        </div>
                            <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                               data-table=".table-visualisierung"><?php echo _l('Alle löschen'); ?></a>
                        <?php $this->load->view('admin/visualisierung/table_html'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

    <div class="modal fade" id="visualDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                                <input type="checkbox" name="chkRows"  id="chkRows"> Show Rows
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                            <table class="table table-striped" id="visualTable">
                                    <thead>
                                        <tr>
                                            <th>Etage</th>
                                            <th>Links</th>
                                            <th>Mitte/Links</th>
                                            <th>Mitte</th>
                                            <th>Mitte/Rechts</th>
                                            <th>Rechts</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    console.log('222');
        $(document).on("click",".visualisierungs",function(e){
            e.preventDefault();
            $id = $(this).data('id');
            $links = ['UG','EG','1. OG','2. OG','3. OG','4. OG','5. OG','6. OG','7. OG','8. OG','9. OG','10. OG'];
            $tablheader = ['Links','Mitte/Links','Mitte','Mitte/Rechts','Rechts'];
            $tableData = "";

             $.ajax({url: "<?php echo admin_url('Visualisierung/getVisualById') ?>?id="+$id, 
                success: function(result){
                $jsonEven = jQuery.parseJSON(result).even;
                $jsonOdd = jQuery.parseJSON(result).odd;
                if($jsonEven.length!=0){
                  $("#visualDetail .modal-title").html($jsonEven[0]['strabe']+' '+$jsonEven[0]['hausnummer'])
                }
                if($jsonOdd.length!=0){
                  $("#visualDetail .modal-title").html($jsonOdd[0]['strabe']+' '+$jsonOdd[0]['hausnummer'])
                }
//                console.log($jsonParse.data.length);
                for($i=$links.length - 1;$i>=0;$i--){

                    $tableInner = "";
                    // find match data  - links - column
                    $ishide = 1;
                    for($k=0; $k<=5;$k++){



                        $tmpdata = "<div class='oddData'>";
                        $isData = false;
                       $.each($jsonOdd, function(i, v) {
                            if (v.flugel == $tablheader[$k] && v.etage==$links[$i]) {
                                $tmpdata+="<div class='linksBox'> Whg.-Nr. <br/>"+v.wohnungsnumme+"</div>";
                                $isData = true;
                            }
                        });
                        $tmpdata+= "</div><div class='evenData'>";



                       $.each($jsonEven, function(i, v) {
                            if (v.flugel == $tablheader[$k] && v.etage==$links[$i]) {
                                $tmpdata+="<div class='linksBox'> Whg.-Nr. <br/>"+v.wohnungsnumme+"</div>";
                                $isData = true;
                            }
                        });
                        $tmpdata+= "</div>";


                       if($isData){
                        $ishide = 0;
                        $tableInner += "<td>"+$tmpdata+"</td>";
                       }else{
                        $tableInner += "<td></td>";
                       }

                    }
                    $classname= "";
                    if($ishide ==1){
                    $classname= "hideRow";

                    }

                    $tableData+="<tr class='"+$classname+"'><td style='vertical-align:bottom'>"+$links[$i]+"</td>";
                    $tableData+=$tableInner;
                    $tableData+="</tr>";


                }

                $("#visualTable tbody").html($tableData);
                $('#visualDetail').modal('toggle');    

              }});
             $("#chkRows").change(function(){
                console.log();

                    $("#visualTable .hideRow").css('display','none');
                   if($(this).is(":checked")){
                    $("#visualTable .hideRow").css('display','table-row');
                   }

             });

        });
</script>
</body>
</html>
