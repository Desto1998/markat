<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade modal-reminder" id="modal-edit-menu" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php
            $ci = &get_instance();
            $first_segment = $ci->uri->segment(1);
            $first_segments = $ci->uri->segment(2);
            $first_segment = !empty($first_segments) ? $first_segments : $first_segment;

            ?>
            <?php echo form_open('clients/update_menu/', array('id' => 'form-update-menu')); ?>
            <div class="modal-header">
                <button type="button" class="close close-edit-menu-modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo 'Edit Menu'; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo form_hidden('menu_slug', $first_segment) ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name', 'Title', ''); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-reminder-modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
