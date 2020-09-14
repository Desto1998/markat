<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons"> <!--style="border-bottom: unset !important;"-->
                        <h3><span><?php echo get_menu_option(c_menu(), 'Dokumente') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <hr class="hr-panel-heading"/>

                        <div id="export-dokumente">
                            <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                               data-table=".table-dokumente"><?php echo _l('Alle löschen'); ?></a>
                            <?php

                            $table_data = array(
                                '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="dokumente"><label></label></div>',
                                'ID',
                                'Kunder',
                                'Mieter',
                                'Beladestelle Straße',
                                'Nr',
                                'PLZ',
                                'ORT',
                                'Etage',
                                'Datum',
                                'Folgende Arbeit',
                                'Demontage',
                                'Datum',
                                'Action'
                            );

                            render_datatable($table_data, (isset($class) ? $class : 'dokumente'), [], [
                                'data-last-order-identifier' => 'dokumente',
                                'data-default-order' => get_table_last_order('dokumente'),
                            ]);

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function () {
        var ContractsServerParams = {};
        $.each($('._hidden_inputs._filters input'), function () {
            ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });
        $('.table-dokumente tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        // Init the table
        var table_dokumente = $('.table-dokumente');
        if (table_dokumente.length) {
            // Add additional server params $_POST
            var LeadsServerParams = {
                "kunde": "[name='kunde']",
                "mieter": "[name='mieter']",
                "aq": "[name='aq']",
                "user": "[name='user']",
                "cars": "[name='cars']",
            };

            var filterArray = [];
            var ContractsServerParams = {};
            $.each($('._hidden_inputs._filters input'), function () {
                ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
            });

            var _table_api = initDataTable(table_dokumente, admin_url + 'dokumente/table', [0], [0], LeadsServerParams, [1, 'desc'], filterArray);

            $.each(LeadsServerParams, function (i, obj) {
                $('#' + i).on('change', function () {
                    table_dokumente.DataTable().ajax.reload()
                        .columns.adjust()
                        .responsive.recalc();
                });
            });
        }
    });
</script>
</div>
</html>
