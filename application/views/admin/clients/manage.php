<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="_filters _hidden_inputs hidden">
                    <?php
                    echo form_hidden('my_customers');
                    echo form_hidden('requires_registration_confirmation');
                    foreach ($groups as $group) {
                        echo form_hidden('customer_group_' . $group['id']);
                    }
                    foreach ($contract_types as $type) {
                        echo form_hidden('contract_type_' . $type['id']);
                    }
                    foreach ($invoice_statuses as $status) {
                        echo form_hidden('invoices_' . $status);
                    }
                    foreach ($estimate_statuses as $status) {
                        echo form_hidden('estimates_' . $status);
                    }
                    foreach ($project_statuses as $status) {
                        echo form_hidden('projects_' . $status['id']);
                    }
                    foreach ($proposal_statuses as $status) {
                        echo form_hidden('proposals_' . $status);
                    }
                    foreach ($customer_admins as $cadmin) {
                        echo form_hidden('responsible_admin_' . $cadmin['staff_id']);
                    }
                    foreach ($countries as $country) {
                        echo form_hidden('country_' . $country['country_id']);
                    }
                    ?>
                </div>

                <div class="panel_s">
                    <div class="panel-body _buttons"> <!--style="border-bottom: unset !important;"-->

                        <h3><span><?php echo get_menu_option(c_menu(), 'Kunder') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>

                        <div style="display: flex">
                            <div>
                                <?php if (has_permission('customers', '', 'create')) { ?>
                                    <a href="<?php echo admin_url('clients/client'); ?>"
                                       class="btn btn-info mright5 test pull-left display-block">
                                        erstellen </a>
                                    <a href="<?php echo admin_url('clients/import'); ?>"
                                       class="btn bg-orange btn-info pull-left display-block mright5 hidden-xs">
                                        <?php echo _l('Importieren'); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'clients'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('clients', $title); ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel-body"> <!--
                            <div class="btn-group pull-right btn-with-tooltip-group _filter_data" data-toggle="tooltip"
                                 data-title="<?php /*echo _l('filter_by'); */ ?>">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left" style="width:300px;">
                                    <li class="active"><a href="#" data-cview="all"
                                                          onclick="dt_custom_view('','.table-clients',''); return false;"><?php /*echo _l('customers_sort_all'); */ ?></a>
                                    </li>
                                    <?php /*if (get_option('customer_requires_registration_confirmation') == '1' || total_rows(db_prefix() . 'clients', 'registration_confirmed=0') > 0) { */ ?>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#" data-cview="requires_registration_confirmation"
                                               onclick="dt_custom_view('requires_registration_confirmation','.table-clients','requires_registration_confirmation'); return false;">
                                                <?php /*echo _l('customer_requires_registration_confirmation'); */ ?>
                                            </a>
                                        </li>
                                    <?php /*} */ ?>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#" data-cview="my_customers"
                                           onclick="dt_custom_view('my_customers','.table-clients','my_customers'); return false;">
                                            <?php /*echo _l('customers_assigned_to_me'); */ ?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <?php /*if (count($groups) > 0) { */ ?>
                                        <li class="dropdown-submenu pull-left groups">
                                            <a href="#" tabindex="-1"><?php /*echo _l('customer_groups'); */ ?></a>
                                            <ul class="dropdown-menu dropdown-menu-left">
                                                <?php /*foreach ($groups as $group) { */ ?>
                                                    <li><a href="#"
                                                           data-cview="customer_group_<?php /*echo $group['id']; */ ?>"
                                                           onclick="dt_custom_view('customer_group_<?php /*echo $group['id']; */ ?>','.table-clients','customer_group_<?php /*echo $group['id']; */ ?>'); return false;"><?php /*echo $group['name']; */ ?></a>
                                                    </li>
                                                <?php /*} */ ?>
                                            </ul>
                                        </li>
                                        <div class="clearfix"></div>
                                        <li class="divider"></li>
                                    <?php /*} */ ?>
                                    <?php /*if (count($countries) > 1) { */ ?>
                                        <li class="dropdown-submenu pull-left countries">
                                            <a href="#" tabindex="-1"><?php /*echo _l('clients_country'); */ ?></a>
                                            <ul class="dropdown-menu dropdown-menu-left">
                                                <?php /*foreach ($countries as $country) { */ ?>
                                                    <li><a href="#"
                                                           data-cview="country_<?php /*echo $country['country_id']; */ ?>"
                                                           onclick="dt_custom_view('country_<?php /*echo $country['country_id']; */ ?>','.table-clients','country_<?php /*echo $country['country_id']; */ ?>'); return false;"><?php /*echo $country['short_name']; */ ?></a>
                                                    </li>
                                                <?php /*} */ ?>
                                            </ul>
                                        </li>
                                        <div class="clearfix"></div>
                                        <li class="divider"></li>
                                    <?php /*} */ ?>
                                    <li class="dropdown-submenu pull-left invoice">
                                        <a href="#" tabindex="-1"><?php /*echo _l('invoices'); */ ?></a>
                                        <ul class="dropdown-menu dropdown-menu-left">
                                            <?php /*foreach ($invoice_statuses as $status) { */ ?>
                                                <li>
                                                    <a href="#" data-cview="invoices_<?php /*echo $status; */ ?>"
                                                       onclick="dt_custom_view('invoices_<?php /*echo $status; */ ?>','.table-clients','invoices_<?php /*echo $status; */ ?>'); return false;"><?php /*echo _l('customer_have_invoices_by', format_invoice_status($status, '', false)); */ ?></a>
                                                </li>
                                            <?php /*} */ ?>
                                        </ul>
                                    </li>
                                    <div class="clearfix"></div>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu pull-left estimate">
                                        <a href="#" tabindex="-1"><?php /*echo _l('estimates'); */ ?></a>
                                        <ul class="dropdown-menu dropdown-menu-left">
                                            <?php /*foreach ($estimate_statuses as $status) { */ ?>
                                                <li>
                                                    <a href="#" data-cview="estimates_<?php /*echo $status; */ ?>"
                                                       onclick="dt_custom_view('estimates_<?php /*echo $status; */ ?>','.table-clients','estimates_<?php /*echo $status; */ ?>'); return false;">
                                                        <?php /*echo _l('customer_have_estimates_by', format_estimate_status($status, '', false)); */ ?>
                                                    </a>
                                                </li>
                                            <?php /*} */ ?>
                                        </ul>
                                    </li>
                                    <div class="clearfix"></div>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu pull-left project">
                                        <a href="#" tabindex="-1"><?php /*echo _l('projects'); */ ?></a>
                                        <ul class="dropdown-menu dropdown-menu-left">
                                            <?php /*foreach ($project_statuses as $status) { */ ?>
                                                <li>
                                                    <a href="#" data-cview="projects_<?php /*echo $status['id']; */ ?>"
                                                       onclick="dt_custom_view('projects_<?php /*echo $status['id']; */ ?>','.table-clients','projects_<?php /*echo $status['id']; */ ?>'); return false;">
                                                        <?php /*echo _l('customer_have_projects_by', $status['name']); */ ?>
                                                    </a>
                                                </li>
                                            <?php /*} */ ?>
                                        </ul>
                                    </li>
                                    <div class="clearfix"></div>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu pull-left proposal">
                                        <a href="#" tabindex="-1"><?php /*echo _l('proposals'); */ ?></a>
                                        <ul class="dropdown-menu dropdown-menu-left">
                                            <?php /*foreach ($proposal_statuses as $status) { */ ?>
                                                <li>
                                                    <a href="#" data-cview="proposals_<?php /*echo $status; */ ?>"
                                                       onclick="dt_custom_view('proposals_<?php /*echo $status; */ ?>','.table-clients','proposals_<?php /*echo $status; */ ?>'); return false;">
                                                        <?php /*echo _l('customer_have_proposals_by', format_proposal_status($status, '', false)); */ ?>
                                                    </a>
                                                </li>
                                            <?php /*} */ ?>
                                        </ul>
                                    </li>
                                    <div class="clearfix"></div>
                                    <?php /*if (count($contract_types) > 0) { */ ?>
                                        <li class="divider"></li>
                                        <li class="dropdown-submenu pull-left contract_types">
                                            <a href="#" tabindex="-1"><?php /*echo _l('contract_types'); */ ?></a>
                                            <ul class="dropdown-menu dropdown-menu-left">
                                                <?php /*foreach ($contract_types as $type) { */ ?>
                                                    <li>
                                                        <a href="#"
                                                           data-cview="contract_type_<?php /*echo $type['id']; */ ?>"
                                                           onclick="dt_custom_view('contract_type_<?php /*echo $type['id']; */ ?>','.table-clients','contract_type_<?php /*echo $type['id']; */ ?>'); return false;">
                                                            <?php /*echo _l('customer_have_contracts_by_type', $type['name']); */ ?>
                                                        </a>
                                                    </li>
                                                <?php /*} */ ?>
                                            </ul>
                                        </li>
                                    <?php /*} */ ?>
                                    <?php /*if (count($customer_admins) > 0 && (has_permission('customers', '', 'create') || has_permission('customers', '', 'edit'))) { */ ?>
                                        <div class="clearfix"></div>
                                        <li class="divider"></li>
                                        <li class="dropdown-submenu pull-left responsible_admin">
                                            <a href="#" tabindex="-1"><?php /*echo _l('responsible_admin'); */ ?></a>
                                            <ul class="dropdown-menu dropdown-menu-left">
                                                <?php /*foreach ($customer_admins as $cadmin) { */ ?>
                                                    <li>
                                                        <a href="#"
                                                           data-cview="responsible_admin_<?php /*echo $cadmin['staff_id']; */ ?>"
                                                           onclick="dt_custom_view('responsible_admin_<?php /*echo $cadmin['staff_id']; */ ?>','.table-clients','responsible_admin_<?php /*echo $cadmin['staff_id']; */ ?>'); return false;">
                                                            <?php /*echo get_staff_full_name($cadmin['staff_id']); */ ?>
                                                        </a>
                                                    </li>
                                                <?php /*} */ ?>
                                            </ul>
                                        </li>
                                    <?php /*} */ ?>
                                </ul>
                            </div>-->
                            <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                               data-table=".table-clients"><?php echo _l('Alle löschen'); ?></a>
                        <div class="modal fade bulk_actions" id="customers_bulk_action" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php if (has_permission('customers', '', 'delete')) { ?>
                                            <div class="checkbox checkbox-danger">
                                                <input type="checkbox" name="mass_delete" id="mass_delete">
                                                <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
                                            </div>
                                            <hr class="mass_delete_separator"/>
                                        <?php } ?>
                                        <div id="bulk_change">
                                            <?php echo render_select('move_to_groups_customers_bulk[]', $groups, array('id', 'name'), 'customer_groups', '', array('multiple' => true), array(), '', '', false); ?>
                                            <p class="text-danger"><?php echo _l('bulk_action_customers_groups_warning'); ?></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?php echo _l('close'); ?></button>
                                        <a href="#" class="btn btn-info"
                                           onclick="customers_bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                <!--        <div class="checkbox">
                            <input type="checkbox" checked id="exclude_inactive" name="exclude_inactive">
                            <label for="exclude_inactive"><?php /*echo _l('exclude_inactive'); */?></label>
                        </div>-->
                        <div class="clearfix mtop20"></div>
                        <?php
                        $table_data = array();
                        $_table_data = array(
                            '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="clients"><label></label></div>',

                            array(
                                'name' => _l('clients_list_company'),
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-company')
                            ),
                            array(
                                'name' => 'Mitarbeiter',
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-betreuer')
                            ),
                            array(
                                'name' => 'Mieter',
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-meiter')
                            ),
                            array(
                                'name' => 'Email',
                                'th_attrs' => array('class' => 'toggleable', 'id' => 'th-primary-contact-email')
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
                        foreach ($_table_data as $_t) {
                            array_push($table_data, $_t);
                        }

                        $custom_fields = get_custom_fields('customers', array('show_on_table' => 1));
                        foreach ($custom_fields as $field) {
                            array_push($table_data, $field['name']);
                        }

                        $table_data = hooks()->apply_filters('customers_table_columns', $table_data);

                        render_datatable($table_data, 'clients', [], [
                            'data-last-order-identifier' => 'customers',
                            'data-default-order' => get_table_last_order('customers'),
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
        var CustomersServerParams = {};
        $.each($('._hidden_inputs._filters input'), function () {
            CustomersServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });
        CustomersServerParams['exclude_inactive'] = '[name="exclude_inactive"]:checked';

        var tAPI = initDataTable('.table-clients', admin_url + 'clients/table', [0], [0], CustomersServerParams,<?php echo hooks()->apply_filters('customers_table_default_order', json_encode(array(2, 'asc'))); ?>);
        $('input[name="exclude_inactive"]').on('change', function () {
            tAPI.ajax.reload();
        });
    });

    function customers_bulk_action(event) {
        var r = confirm(app.lang.confirm_action_prompt);
        if (r == false) {
            return false;
        } else {
            var mass_delete = $('#mass_delete').prop('checked');
            var ids = [];
            var data = {};
            if (mass_delete == false || typeof (mass_delete) == 'undefined') {
                data.groups = $('select[name="move_to_groups_customers_bulk[]"]').selectpicker('val');
                if (data.groups.length == 0) {
                    data.groups = 'remove_all';
                }
            } else {
                data.mass_delete = true;
            }
            var rows = $('.table-clients').find('tbody tr');
            $.each(rows, function () {
                var checkbox = $($(this).find('td').eq(0)).find('input');
                if (checkbox.prop('checked') == true) {
                    ids.push(checkbox.val());
                }
            });
            data.ids = ids;
            $(event).addClass('disabled');
            setTimeout(function () {
                $.post(admin_url + 'clients/bulk_action', data).done(function () {
                    window.location.reload();
                });
            }, 50);
        }
    }
</script>
</body>
</html>
