<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Meine Firma') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>

                        <a href="<?php echo admin_url('firma/firma'); ?>"
                           class="btn btn-info mright5 test pull-left display-block">
                            erstellen </a>
                    </div>

                    <div class="panel-body">
                        <?php
                        $table_data = array(
                            '#',
                            array(
                                'name' => _l('clients_list_company'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-company')
                            ),
                            array(
                                'name' => 'Email',
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-primary-contact-email')
                            ),
                            array(
                                'name' => _l('Hausnummer'),
                                'th_attrs' => array('class' => 'toggleable')
                            ),
                            array(
                                'name' => _l('clients_list_phone'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-phone')
                            ),
                            array(
                                'name' => _l('customer_active'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-active')
                            )
                        );
                        render_datatable($table_data, 'firma', [], [
                            'data-last-order-identifier' => 'customers',
                            'data-default-order' => get_table_last_order('firma'),
                        ]);
                        ?>
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
        $('.table-mieter tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        initDataTable('.table-firma', admin_url + 'firma/table', undefined, undefined, ContractsServerParams,<?php echo hooks()->apply_filters('contracts_table_default_order', json_encode(array(0, 'desc'))); ?>);

    });

</script>
</body>
</html>
