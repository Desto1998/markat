<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons"> <!--style="border-bottom: unset !important;"-->
                        <h3><span><?php echo get_menu_option(c_menu(), 'Fahrzeugliste') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <div style="display: flex">
                            <a href="<?php echo admin_url('cars/cars'); ?>"
                               class="btn btn-info pull-left display-block"><?php echo 'Erstellen'; ?></a>
                        </div>
                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'cars'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('cars', $title); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                            <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                               data-table=".table-cars"><?php echo _l('Alle löschen'); ?></a>
                        <?php $this->load->view('admin/cars/table_html'); ?>
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

        initDataTable('.table-cars', admin_url + 'cars/table', [0], [0], ContractsServerParams,<?php echo hooks()->apply_filters('contracts_table_default_order', json_encode(array(1, 'desc'))); ?>);

    });

</script>
</body>
</html>
