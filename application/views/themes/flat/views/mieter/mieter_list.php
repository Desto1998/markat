<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-files">
    <div class="panel-body">
        <h4 class="no-margin section-text"><span><?php echo get_menu_option(c_c_menu(), 'Mieter') ?></span>
            <?php if (has_permission('menu', '', 'edit')):
                ?>
                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
            <?php endif; ?></h4>
    </div>

    <div class="panel-body _buttons">
        <a href="<?php echo base_url('mieter/mieter'); ?>"
           class="btn btn-info mright5 pull-left display-block"><?php echo 'Erstellen'; ?></a>

    </div>
</div>

<div class="panel_s">
    <div class="panel-body">
        <table class="table dt-table dt-table table-mieters" data-order-col="2" data-order-type="desc">
            <thead>
            <tr>
                <th class="th-project-name"><?php echo _l('ID'); ?></th>
                <th class="th-project-start-date"><?php echo _l('Name'); ?></th>
                <th class="th-project-deadline"><?php echo _l('Telefon'); ?></th>
                <th class="th-project-billing-type"><?php echo _l('Straße '); ?></th>
                <th><?php echo _l('Nr. '); ?></th>
                <th><?php echo _l('Etage '); ?></th>
                <th><?php echo _l('Flügel  '); ?></th>
                <th><?php echo _l('Aktiviert '); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($mieters as $mieter) { ?>
                <tr>
                    <td><?php echo $mieter['id']; ?></td>
                    <?php

                    $subjectOutput = '<a href="' . base_url('mieter/mieter/' . $mieter['id']) . '">' . $mieter['fullname'] . '</a>';
                    /* if ($mieter['trash'] == 1) {
                         $subjectOutput .= '<span class="label label-danger pull-right">' . _l('mieter_trash') . '</span>';
                     }*/

                    $subjectOutput .= '<div class="row-options">';

                    // $subjectOutput .= '<a href="' . site_url('mieter/' . $mieter['id'] . '/' . $mieter['hash']) . '" target="_blank">' . _l('view') . '</a>' |;

                    $subjectOutput .= '  <a href="' . base_url('mieter/mieter/' . $mieter['id']) . '">' . _l('edit') . '</a>';

                    /*    if (has_permission('mieter', '', 'delete')) {*/
                    $subjectOutput .= ' | <a href="' . base_url('mieter/delete/' . $mieter['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    /* }*/

                    $subjectOutput .= '</div>';
                    ?>
                    <td><?php echo $subjectOutput; ?></td>
                    <td><?php echo $mieter['telefon_1']; ?></td>
                    <td><?php echo $mieter['strabe_p']; ?></td>
                    <td><?php echo $mieter['nr_p']; ?></td>
                    <td><?php echo $mieter['etage_p']; ?></td>
                    <td><?php echo $mieter['fulger_p']; ?></td>
                    <?php
                    $toggleActive = '<div class="onoffswitch" data-toggle="tooltip"  >
    <input type="checkbox"  data-switch-url="' . admin_url() . 'mieter/change_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $mieter['id'] . '" data-id="' . $mieter['id'] . '" ' . ($mieter['active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $mieter['id'] . '"></label>
    </div>';
                    ?>
                    <td><?php echo $toggleActive ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>
