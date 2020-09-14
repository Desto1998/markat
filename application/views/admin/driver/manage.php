<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Driver') ?></span>
                            <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a></h3>

                        <a href="<?php echo admin_url('driver/driver'); ?>"
                           class="btn btn-info mright5 test pull-left display-block">
                            erstellen </a>
                    </div>

                    <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                       data-table=".table-driver"><?php echo _l('Alle l�schen'); ?></a>

                    <div class="panel-body">
                        <?php
                        $table_data = array(
                            '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="Driver"><label></label></div>',
                            '#',
                            array(
                                'name' => _l('Name'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-name')
                            ),
                            array(
                                'name' => _l('Contact'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-primary-contact-email')
                            ),
                            'Email'
                        );
                        render_datatable($table_data, 'driver', [], [
                            'data-last-order-identifier' => 'driver',
                            'data-default-order' => get_table_last_order('driver'),
                        ]);
                        ?>                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
<script>
    $(function () {
        var LeadsServerParams = {
            "kunde": "[name='kunde']",
            "mieter": "[name='mieter']",
            "aq": "[name='aq']",
            "user": "[name='user']",
            "cars": "[name='cars']"
        };
        $('.table-mieter tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });
        var table_mieter = $('.table-driver');
        initDataTable('.table-driver', admin_url + 'driver/table', [0], [0], LeadsServerParams, [1, 'desc'], []);
        $.each(LeadsServerParams, function (i, obj) {
            $('#' + i).on('change', function () {
                table_mieter.DataTable().ajax.reload()
                    .columns.adjust()
                    .responsive.recalc();
            });
        });
    });


</script>
</body>
</html>
