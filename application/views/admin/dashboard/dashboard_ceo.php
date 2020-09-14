<?php
$total = ''; ?>
<div class="row">
    <div class="col-md-4">
        <?php
        $title = get_menu_option('clients', _l('als_clients'));
        ?>
        <div class="row">
            <div class="col-md-12">
                <h4 class="no-margin"><?= $title . ': <b>' . $total . '</b>' ?></h4>
                <br>
            </div>
        </div>
        <div class="row mbot15">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?= widget_status_stats('clients', $title); ?>
                        <div class="text-center"><a
                                    href="<?= admin_url('clients') ?>">Alle <?= $title ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php
        $title = get_menu_option('mieter', _l('Kundenbetreuer'));
        ?>
        <div class="row">
            <div class="col-md-12">
                <h4 class="no-margin"><?= $title . ': <b>' . $total . '</b>' ?></h4>
                <br>
            </div>
        </div>
        <div class="row mbot15">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?= widget_status_stats('mieters', $title); ?>
                        <div class="text-center"><a
                                    href="<?= admin_url('mieters') ?>">Alle <?= $title ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php
        $title = get_menu_option('wohnungen', _l('Kundenbetreuer'));
        ?>
        <div class="row">
            <div class="col-md-12">
                <h4 class="no-margin"><?= $title . ': <b>' . $total . '</b>' ?></h4>
                <br>
            </div>
        </div>
        <div class="row mbot15">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?= widget_status_stats('wohnungen', $title); ?>
                        <div class="text-center"><a
                                    href="<?= admin_url('wohnungen') ?>">Alle <?= $title ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php
        $title = get_menu_option('belegungsplan', _l('belegungsplan'));
        ?>
        <div class="row">
            <div class="col-md-12">
                <h4 class="no-margin"><?= $title . ': <b>' . $total . '</b>' ?></h4>
                <br>
            </div>
        </div>
        <div class="row mbot15">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?= widget_status_stats('occupations', $title); ?>
                        <div class="text-center"><a
                                    href="<?= admin_url('belegungsplan') ?>">Alle <?= $title ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php
        $title = get_menu_option('tasks', _l('Aufgabenplaner '));
        ?>
        <div class="row">
            <div class="col-md-12">
                <h4 class="no-margin"><?= $title . ': <b>' . $total . '</b>' ?></h4>
                <br>
            </div>
        </div>
        <div class="row mbot15">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?= widget_status_stats_projeckt('tasks', $title); ?>
                        <div class="text-center"><a
                                    href="<?= admin_url('tasks') ?>">Alle <?= $title ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>