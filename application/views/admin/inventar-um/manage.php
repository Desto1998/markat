<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons"> <!--style="border-bottom: unset !important;"-->
                        <h3><span><?php echo get_menu_option('inventarlistes_un', _l('Inventar-Umzugsliste')); ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <div style="display: flex">
                            <a href="#" id="act-mouvement"
                               class="btn btn-info pull-left display-block"><?php echo 'Erstellen'; ?></a>
                        </div>
                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'inventory_um'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('inventory_um', $title); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body ">
                        <div class="row hide" id="mieter-table">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="bold"><?php echo _l('filter_by'); ?></p>
                                    </div>
                                </div>
                                <div class="row"><!--
                                        <div class="col-md-2 leads-filter-column">
                                            <?php
                                    /*                                        $belegt = array(array('id' => '0', 'value' => 'Nein'), array('id' => '1', 'value' => 'Ja'));
                                                                            echo render_select('belegt', $belegt, array('value', 'value'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Belegt?'), array()); */ ?>
                                        </div>-->

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('project', $project, array('project', 'project'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Project'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('strabe', $strabe, array('strabe', 'strabe'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Straße'), array()); ?>
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

                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading"/>
                        </div>
                        <!--    <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                               data-table=".table-inventar-um"><?php /*echo _l('Alle löschen'); */ ?></a>-->
                        <?php $this->load->view('admin/inventar-um/table_html'); ?>

                        <div class="modal fade" id="mouvement" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">
                                            <span>Move </span><?php echo get_menu_option('inventar', _l('inventar')); ?>
                                        </h4>
                                    </div>

                                    <div class="modal-body">
                                        <?php echo form_open(admin_url('wohnungen/move/'), array('id' => 'inventar-form')); ?>
                                        <input type="hidden" value="0" name="inventar_id" id="inventar_id">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                echo render_select('aq_from', $aqs, array('id', array('strabe', 'hausnummer', 'etage', 'flugel')), 'Start AQ', '', array('required' => true)); ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="inventars" class="row">

                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                echo render_select('aq_to', array(), array('id', array('strabe', 'hausnummer', 'etage', 'flugel')), 'Ende AQ', '', array('required' => true)); ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button type="submit"
                                                            class="btn btn-info"><?php echo _l('submit'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .max-value {
        font-size: 27px;
        right: 48px;
        bottom: 0;
        top: 0;
    }
</style>
<?php init_tail(); ?>

<script>
    $(function () {
        $('#act-mouvement').click(function (e) {
            e.preventDefault();
            $('#inventars').html('');
            $("#aq_from, #aq_to").val('default');
            $("#aq_from, #aq_to").selectpicker("refresh");
            $('#mouvement').modal('show');
        })

        $("#inventar-form").on("change", ".checkinventar_all", function (e) {
            $val = this.checked;
            var avaibleQty = 0, movedQty = 0;
            $(this).parents('#inventars').find('.dieldkf').each(function () {
                //$(this).find(".qtyfiels").prop('required', $val);
                $maxqty = $(this).find(".qtyfiels").attr('max');
                $(this).find(".qtyfiels").val($maxqty);
                /* $(this).find(".checkinventar").prop('checked', $val);*/
                avaibleQty += parseInt($maxqty);
                movedQty += parseInt($(this).find(".qtyfiels").val());
                if (avaibleQty) {
                    $('#availSelected').html(avaibleQty);
                    $('#restItem').html(avaibleQty);
                }
                if (movedQty) {
                    $('#moveledSelected').html(movedQty);
                    $('#restItem').html(avaibleQty - movedQty);
                }
            });

        });

        $("#inventar-form").on("change", ".qtyfiels", function (e) {
            $val = this.checked;
            var avaibleQty = 0, movedQty = 0;
            $(this).parents('#inventars').find('.dieldkf').each(function () {
                $maxqty = $(this).find(".qtyfiels").attr('max');
                avaibleQty += parseInt($maxqty);
                movedQty += parseInt($(this).find(".qtyfiels").val());
                if (avaibleQty) {
                    $('#availSelected').html(avaibleQty);
                    $('#restItem').html(avaibleQty);
                }
                if (movedQty) {
                    $('#moveledSelected').html(movedQty);
                    $('#restItem').html(avaibleQty - movedQty);
                }
            });

        });


        $("#inventar-form").on("change", ".checkinventar", function (e) {
            var parents = $(this).parents('.form-check');
            parents.find(".qtyfiels").prop('required', this.checked);
        });

        $('#aq_from').change(function () {
            $.ajax({
                type: 'GET',
                url: admin_url + 'wohnungen/list_invantories/' + this.value,
                success: function (inventars) {
                    inventars = JSON.parse(inventars);
                    $('#inventars').html(inventars.items);
                    $('#aq_to').html(inventars.aqs);
                    $(".qtyfiels").trigger('change');
                    $('#aq_to').selectpicker('refresh');
                }
            });

        })

        appValidateForm($('#inventar-form'), {aq_from: 'required', aq_to: 'required'});
        var ContractsServerParams = {};
        $.each($('._hidden_inputs._filters input'), function () {
            ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });


        initDataTable('.table-inventar-um', admin_url + 'wohnungen/render_inventory', [0], [0], ContractsServerParams,<?php echo hooks()->apply_filters('contracts_table_default_order', json_encode(array(0, 'desc'))); ?>);


    })
    ;

</script>

</body>
</html>
