<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <table class="table dt-table dt-table table-mieters" data-order-col="2" data-order-type="desc">
            <thead>
            <tr>
                <th class="th-project-name"><?php echo _l('ID'); ?></th>
                <th><?php echo _l('Vorname '); ?></th>
                <th><?php echo _l('Nachname '); ?></th>
                <th><?php echo _l('Role  '); ?></th>
                <th><?php echo _l('Email '); ?></th>
                <th><?php echo _l('Telefonnummer '); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($staffs as $staff) {
                if ($staff['role'] != 0):
                    $role = $this->roles_model->get($staff['role']);
                    ?>
                    <tr>
                        <td><?php echo $staff['staffid']; ?></td>
                        <td><?php echo $staff['firstname']; ?></td>
                        <td><?php echo $staff['lastname']; ?></td>
                        <td><?php echo $role ? $role->name : '' ?></td>
                        <td><?php echo $staff['email']; ?></td>
                        <td><?php echo $staff['phonenumber']; ?></td>
                    </tr>
                <?php endif;
            } ?>
            </tbody>
        </table>
    </div>
</div>
