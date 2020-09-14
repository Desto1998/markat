<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-files">
    <div class="panel-body">
        <h4 class="no-margin section-text"><span><?php echo get_menu_option(c_c_menu(), _l('Inventar')) ?> </span> <a
                    id="edit-menu" href="#"><i class="fa fa-pencil"></i></a></h4>
    </div>

    <div class="panel-body _buttons">
        <a href="#" onclick="new_inventarliste(); return false;"
           class="btn btn-info pull-left display-block"><?php echo _l('Erstellen'); ?></a>
    </div>
</div>

<div class="panel_s">
    <div class="panel-body">
        <?php if (count($inventarlistes) > 0) { ?>
            <table class="table dt-table scroll-responsive" data-order-col="1" data-order-type="asc">
                <thead>
                <th><?php echo _l('id'); ?></th>
                <th><?php echo _l('name'); ?></th>
                <th><?php echo _l('options'); ?></th>
                </thead>
                <tbody>
                <?php foreach ($inventarlistes as $inventarliste) { ?>
                    <tr>
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
                            <a href="<?php echo base_url('wohnungen/delete_inventarliste/' . $inventarliste['id']); ?>"
                               class="btn btn-danger btn-icon _delete"><i style="color: white" class="fa fa-remove"></i></a>
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
<div class="modal fade" id="inventarliste" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(base_url('wohnungen/inventarliste')); ?>
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