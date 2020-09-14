<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Projekte') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <div style="display: flex">
                            <div><a href="<?php echo admin_url('projekte/projekte'); ?>"
                                    class="btn btn-info mright5 pull-left display-block"><?php echo 'Erstellen'; ?></a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'projekte'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('projekte', $title); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="panel-body ">
                        <div class="row" id="projekte-table">
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

                                    <div class="col-md-3 leads-filter-column">
                                        <?php echo render_select('kunde', $kundes, array('userid', array( 'company')), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Kunde'), array()); ?>
                                    </div>
                                    <div class="col-md-3 leads-filter-column">
                                        <?php echo render_select('mieter', $mieters, array('id', array('vorname', 'nachname', 'strabe_m', 'hausnummer_m')), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Mieter'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('aq', $aqs, array('id', array('strabe', 'hausnummer', 'etage', 'flugel')), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'AQ'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('user',  $staffs, array('staffid', array('firstname', 'lastname')), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Mitarbetter'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('cars', $cars, array('id', array('marke', 'modell')), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Fahzeugliste'), array()); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading"/>
                        </div>
                        <?php echo form_hidden('custom_view'); ?>
                        <div id="export-projekte">
                                <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                                   data-table=".table-projekte"><?php echo _l('Alle löschen'); ?></a>
                            <?php $this->load->view('admin/projekte/table_html'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contact_data"></div>
<?php init_tail(); ?>
<script>
    $(function () {

        var ContractsServerParams = {};
        $.each($('._hidden_inputs._filters input'), function () {
            ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });
        $('.table-projekte tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        // Init the table
        var table_projekte = $('.table-projekte');
        if (table_projekte.length) {
            // Add additional server params $_POST
            var LeadsServerParams = {
                "kunde": "[name='kunde']",
                "mieter": "[name='mieter']",
                "aq": "[name='aq']",
                "user": "[name='user']",
                "cars": "[name='cars']",
            };

            belegunTableServer = leadsTableNotSortable = [];
            var filterArray = [];
            var ContractsServerParams = {};
            $.each($('._hidden_inputs._filters input'), function () {
                ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
            });

            var _table_api = initDataTable(table_projekte, admin_url + 'projekte/table', [0], [0], LeadsServerParams, [1, 'desc'], filterArray);

            $.each(LeadsServerParams, function (i, obj) {
                $('#' + i).on('change', function () {
                    table_projekte.DataTable().ajax.reload()
                        .columns.adjust()
                        .responsive.recalc();
                });
            });
        }

    });
 
</script>
</body>
</html>
