<style>
    .linksBox{
        border: 2px solid #ddd;
        float: left;
        margin: 1% 5%;
        padding: 2%;
        min-height: 60px;
        font-size: 18px;
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
</style>
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

            $("#visualTable .hideRow").css('display','none');
            if($(this).is(":checked")){
                $("#visualTable .hideRow").css('display','table-row');
            }

        });

    });
</script>