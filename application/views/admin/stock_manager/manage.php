<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Stock Manager') ?></span>
                            <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a></h3>

                        <a href="<?php echo admin_url('stock_manager/stock_manager'); ?>"
                           class="btn btn-info mright5 test pull-left display-block">
                            erstellen </a>
                    </div>

                        <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                           data-table=".table-stock_manager"><?php echo _l('Alle l�schen'); ?></a>

                    <div class="panel-body">
                        <?php
                        $table_data = array(
                            // '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="stock_manager"><label></label></div>',
                            // '#',
                            array(
                                'name' => _l('SKU'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-sku')
                            ),
                            array(
                                'name' => 'ID',
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-id')
                            ),
                            array(
                                'name' => _l('Name'),
                                'th_attrs' => array('class' => 'toggleable')
                            ),
                            array(
                                'name' => _l('product_type'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-product_type')
                            ),
                            array(
                                'name' => _l('parent_id'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-parent_id')
                            ),
                             array(
                                'name' => _l('price'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-price')
                            ),
                              array(
                                'name' => _l('Manage stock'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-manage_stock')
                            ),
                               array(
                                'name' => _l('Stock status'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-stock_status')
                            ),
                                array(
                                'name' => _l('Backorders stock'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-backorders')
                            ),
                            array(
                                'name' => _l('Stock'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-stock')
                            ),
                        );
                        render_datatable($table_data, 'stock_manager', [], [
                            'data-last-order-identifier' => 'customers',
                            'data-default-order' => get_table_last_order('stock_manager'),
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
        var table_mieter = $('.table-stock_manager');
         initDataTable('.table-stock_manager', admin_url + 'stock_manager/table', [0], [0], LeadsServerParams, [1, 'desc'], []);
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
