<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body ">
                        <div class="_buttons">
                            <h3><span><?php echo get_menu_option(c_menu(), 'Inventar') ?></span>
                                <?php if (has_permission('menu', '', 'edit')):
                                    ?>
                                    <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                                <?php endif; ?></h3>

                            <a href="#" onclick="new_inventarliste(); return false;"
                               class="btn btn-info pull-left display-block"><?php echo _l('Erstellen'); ?></a>
                            <a style="margin-left: 10px" href="<?= admin_url('wohnungen/import_inventar')?>"
                               class="btn btn-info pull-left bg-orange display-block"><?php echo _l('Import'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading"/>
                        <?php if (count($inventarlistes) > 0) { ?>
                                <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="delete_inventar"
                                   data-table=".table-invetar"><?php echo _l('Alle l�schen'); ?></a>
                            <table class="table dt-table table-invetar scroll-responsive" data-order-col="1" data-order-type="asc">
                                <thead>
                                <th style="width: 30px"><span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="invetar"><label></label></div>  </th sty>
                                <th><?php echo _l('id'); ?></th>
                                <th><?php echo _l('name'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                                </thead>
                                <tbody>
                                <?php foreach ($inventarlistes as $inventarliste) { ?>
                                    <tr>
                                        <td><div class="multiple_action checkbox"><input type="checkbox" value="<?php echo $inventarliste['id']; ?>"><label></label></div></td>
                                        <td><?php echo $inventarliste['id']; ?></td>
                                        <td><a href="#"
                                               onclick="edit_inventarliste(this,<?php echo $inventarliste['id']; ?>); return false"
                                               data-name="<?php echo $inventarliste['name']; ?>"><?php echo $inventarliste['name']; ?></a><br/>
                                        </td>
                                        <td>
                                            <a href="#"
                                               onclick="edit_inventarliste(this,<?php echo $inventarliste['id']; ?>); return false"
                                               data-name="<?php echo $inventarliste['name']; ?>"
                                               class="btn btn-default btn-icon"><i
                                                        class="fa fa-pencil-square-o"></i></a>
                                            <a href="<?php echo admin_url('wohnungen/delete_inventarliste/' . $inventarliste['id']); ?>"
                                               class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p class="no-margin"><?php echo _l('No Inventarliste'); ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="inventarliste" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('wohnungen/inventarliste')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('Edit'); ?></span>
                    <span class="add-title"><?php echo _l('Add'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <?php echo render_input('name', 'Name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php init_tail(); ?>
<script>
    $(function () {
        appValidateForm($('form'), {name: 'required'}, manage_wohnungen_inventarlistes);
        $('#inventarliste').on('hidden.bs.modal', function (event) {
            $('#additional').html('');
            $('#inventarliste input[name="name"]').val('');
            $('.add-title').removeClass('hide');
            $('.edit-title').removeClass('hide');
        });
    });
    $('#delete_inventar').click(function (e) {
        e.preventDefault();
        var model = $(this).data('table').split('-')[1];
        var post_arr = [];
        // Get checked checkboxes
        $('.multiple_action input[type=checkbox]').each(function () {
            if ($(this).is(":checked")) {
                post_arr.push($(this).val());
            }
        });
        if (post_arr < 1) {
            alert(message_no_select);
            return;
        }
        if (confirm_delete()) {
            $.post(admin_url + 'wohnungen/blk_delete_inventarlistes', {data: post_arr}).done(function (response) {
                window.location.href = response
            });
        }
        return false;
    })

    function manage_wohnungen_inventarlistes(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function (response) {
            window.location.reload();
        });
        return false;
    }

    function new_inventarliste() {
        $('#inventarliste').modal('show');
        $('.edit-title').addClass('hide');
    }

    function edit_inventarliste(invoker, id) {
        var name = $(invoker).data('name');
        $('#additional').append(hidden_input('id', id));
        $('#inventarliste input[name="name"]').val(name);
        $('#inventarliste').modal('show');
        $('.add-title').addClass('hide');
    }
</script>
</body>
</html>
