<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-files">
    <div class="panel-body">
        <h4 class="no-margin section-text"><span><?php echo get_menu_option('wohnungen', _l('AQ')) ?> </span>  <?php if (has_permission('menu', '', 'edit')):
                ?>
                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
            <?php endif; ?></h4>
    </div>

    <div class="panel-body _buttons">
        <a href="<?php echo base_url('wohnungen/wohnungen'); ?>"
           class="btn btn-info mright5 pull-left display-block"><?php echo 'Erstellen'; ?></a>
    </div>
</div>

<div class="panel_s">
    <div class="panel-body">
        <table class="table dt-table dt-table table-wohnungen" data-order-col="2" data-order-type="desc">
            <thead>
            <tr>
                <th class="th-project-name"><?php echo _l('ID'); ?></th>
                <th class="th-project-start-date"><?php echo _l('Belegt?'); ?></th>
                <th class="th-project-deadline"><?php echo _l('Straße'); ?></th>
                <th class="th-project-billing-type"><?php echo _l('Nr '); ?></th>
                <th><?php echo _l('Etage '); ?></th>
                <th><?php echo _l('Flügel  '); ?></th>
                <th><?php echo _l('Zimmer '); ?></th>
                <th><?php echo _l('Schlafplätze '); ?></th>
                <th><?php echo _l('Möbliert '); ?></th>
                <th><?php echo _l('Aktiv '); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($wohnungens as $wohnungen) { ?>
                <tr>
                    <td><?php echo $wohnungen['id']; ?></td>
                    <?php

                  //  $subjectOutput = '<a href="' . base_url('mieter/mieter/' . $wohnungen['id']) . '">' . $wohnungen['fullname'] . '</a>';
                    /* if ($wohnungen['trash'] == 1) {
                         $subjectOutput .= '<span class="label label-danger pull-right">' . _l('mieter_trash') . '</span>';
                     }*/

                    $subjectOutput  = '<div class="row-options">';

                    // $subjectOutput .= '<a href="' . site_url('mieter/' . $wohnungen['id'] . '/' . $wohnungen['hash']) . '" target="_blank">' . _l('view') . '</a>' |;

                    $subjectOutput .= '  <a href="' . base_url('mieter/mieter/' . $wohnungen['id']) . '">' . _l('edit') . '</a>';

                    /*    if (has_permission('mieter', '', 'delete')) {*/
                    $subjectOutput .= ' | <a href="' . base_url('mieter/delete/' . $wohnungen['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    /* }*/

                    $subjectOutput .= '</div>';

                    if ($this->wohnungen_model->is_occuped($wohnungen['id'])) {
                        $strabe = '<i class="green-dd proint"></i>';
                    } else {
                        $strabe = '<i class="red-dd proint"></i>';
                    }
                    ?>
                    <td><?= $strabe; ?></td>
                    <td><?php echo $wohnungen['strabe']; ?></td>
                    <td><?php echo $wohnungen['hausnummer']; ?></td>
                    <td><?php echo $wohnungen['etage']; ?></td>
                    <td><?php echo $wohnungen['flugel']; ?></td>
                    <td><?php echo $wohnungen['zimmer']; ?></td>
                    <td><?php echo $wohnungen['schlaplatze']; ?></td>
                    <td><?php echo $wohnungen['mobiliert'] == 1 ? 'Ja' : 'Nein'; ?></td>
                    <td><?php $toggleActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" data-switch-url="' . admin_url() . 'wohnungen/change_wohnungen_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $wohnungen['id'] . '" data-id="' . $wohnungen['id'] . '" ' . ($wohnungen['active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $wohnungen['id'] . '"></label>
    </div>';
                        echo $toggleActive ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>
